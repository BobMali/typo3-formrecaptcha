<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\Validation;

use JsonException;
use Neusta\Formrecaptcha\Exception\MissingKeyException;
use Neusta\Formrecaptcha\Service\ConfigurationService;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use function json_decode;

class RecaptchaValidator extends AbstractValidator
{
    /**
     * Validate the captcha value from the request and add an error if not valid
     *
     * @param mixed $value The value
     * @throws JsonException
     * @throws MissingKeyException
     */
    public function isValid($value): void
    {
        $response = $this->validateReCaptcha();

        if (empty($response) || $response['success'] === false) {
            foreach ($response['error-codes'] as $errorCode) {
                $this->addError(
                    $this->translateErrorMessage(
                        'error_formrecaptcha_' . $errorCode,
                        'formrecaptcha'
                    ),
                    1566209403
                );
            }
        }
    }

    /**
     * @return array
     * @throws JsonException
     * @throws MissingKeyException
     */
    public function validateReCaptcha(): array
    {
        $reCaptchaFormFieldValue = GeneralUtility::_GP('g-recaptcha-response');

        $configurationService = ConfigurationService::getInstance();
        $url = HttpUtility::buildUrl(
            [
                'host'  => $configurationService::getVerificationServer(),
                'query' => \http_build_query(
                    [
                        'secret'   => $configurationService::getPrivateKey(),
                        'response' => $reCaptchaFormFieldValue,
                        'remoteip' => GeneralUtility::getIndpEnv('REMOTE_ADDR')
                    ]
                )
            ]
        );

        $requestService = GeneralUtility::makeInstance(RequestFactory::class);
        $response = $requestService->request($url, 'POST');

        return json_decode(
            $response->getBody()
                ->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
