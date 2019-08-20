<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\Validation;

use Neusta\Formrecaptcha\Exception\MissingKeyException;
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
            $this->addError(
                $this->translateErrorMessage(
                    'error_recaptcha_' . $response['error'],
                    'formrecaptcha'
                ),
                1566209403
            );
        }

    }

    /**
     * @return array
     */
    public function validateReCaptcha(): array
    {
        $reCaptchaFormFieldValue = GeneralUtility::_GP('g-recaptcha-response');

        $url = HttpUtility::buildUrl(
            [
                'host'  => self::VERIFY_SERVER,
                'query' => \http_build_query(
                    [
                        'secret'   => $this->getReCaptchaPrivateKey(),
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

    /**
     * @throws MissingKeyException
     */
    private function getReCaptchaPrivateKey(): string
    {
        $publicKey = \getenv('GOOGLE_RECAPTCHA_PRIVATE_KEY');
        if (empty($publicKey)) {
            throw new MissingKeyException(
                'Google reCAPTCHA private key not defined',
                1566304359
            );
        }
        return $publicKey;
    }
}
