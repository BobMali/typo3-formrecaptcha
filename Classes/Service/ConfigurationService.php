<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\Service;

use Neusta\Formrecaptcha\Exception\MissingKeyException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use const DIRECTORY_SEPARATOR;

/**
 * Class ConfigurationService
 *
 * @package Neusta\Formrecaptcha\Service
 */
class ConfigurationService
{
    private static ?ConfigurationService $_instance = null;
    private static ?array $settings = null;

    public static function getInstance(): ConfigurationService
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function initialize(): ConfigurationService
    {
        if (self::$settings === null) {
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
            self::$settings = $configurationManager->getConfiguration(
                ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
                'formrecaptcha'
            );
        }

        return self::$_instance;
    }

    /**
     * @return string
     * @throws MissingKeyException
     */
    public static function getPublicKey(): string
    {
        $publicKey = !empty(self::$settings['publicKey'])
            ? self::$settings['publicKey']
            : \getenv('GOOGLE_RECAPTCHA_PUBLIC_KEY');

        if (empty($publicKey)) {
            throw new MissingKeyException(
                'Google reCAPTCHA public key not defined',
                1566304358
            );
        }

        return $publicKey;
    }

    /**
     * @return string
     * @throws MissingKeyException
     */
    public static function getPrivateKey(): string
    {
        $privateKey = !empty(self::$settings['privateKey'])
            ? self::$settings['privateKey']
            : \getenv('GOOGLE_RECAPTCHA_PRIVATE_KEY');

        if (empty($privateKey)) {
            throw new MissingKeyException(
                'Google reCAPTCHA private key not defined',
                1566304359
            );
        }

        return $privateKey;
    }

    /**
     * @return string
     * @throws MissingKeyException
     */
    public static function getVerificationServer(): string
    {
        $verificationServer = !empty(self::$settings['verificationServer'])
            ? self::$settings['verificationServer']
            : \getenv('GOOGLE_RECAPTCHA_VERIFICATION_SERVER');

        if (empty($verificationServer)) {
            throw new MissingKeyException(
                'Google reCAPTCHA verification server address key not defined',
                1566304360
            );
        }

        return $verificationServer;
    }

    /**
     * @return string
     * @throws MissingKeyException
     */
    public static function getApiScript(): string
    {
        $apiScript = !empty(self::$settings['apiScript'])
            ? self::$settings['apiScript']
            : \getenv('GOOGLE_RECAPTCHA_API_SCRIPT');
        if (empty($apiScript)) {
            throw new MissingKeyException(
                'Google reCAPTCHA api script not defined',
                1566304361
            );
        }

        return $apiScript;
    }

    /**
     * @return string
     */
    public static function getReCaptchaFormValidationScript(): string
    {
        if ((bool)(self::$settings['validateReCaptchaCheckbox'] ?? false) === false) {
            return '';
        }

        $absolute = (bool)(self::$settings['formValidationScript']['absolute'] ?? false);

        $uri = self::$settings['formValidationScript']['_typoScriptNodeValue'] ?? '';
        $uri = GeneralUtility::getFileAbsFileName($uri);

        $pathSiteLength = \strlen(Environment::getPublicPath() . '/');
        $uri = DIRECTORY_SEPARATOR . \substr($uri, $pathSiteLength);

        if ($absolute === true) {
            $uri = GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . $uri;
        }

        return $uri;
    }

    public static function reset(): void
    {
        self::$_instance = null;
        self::$settings = null;
    }
}
