<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\Validation;

use Neusta\Formrecaptcha\Service\ConfigurationService;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class RecaptchaValidator extends AbstractValidator
{
    public const VERIFY_SERVER = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Validate the captcha value from the request and add an error if not valid
     *
     * @param mixed $value The value
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
     */
    public function validateReCaptcha(): array
    {
        $reCaptchaFormFieldValue = GeneralUtility::_GP('g-recaptcha-response');

        $configurationService = ConfigurationService::getInstance()::initialize();
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

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
