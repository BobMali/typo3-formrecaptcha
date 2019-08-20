<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\ViewHelpers\Forms;

use Neusta\Formrecaptcha\Exception\MissingKeyException;
use TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class ReCaptchaViewHelper
 *
 * @package Neusta\Formrecaptcha\ViewHelpers\Forms
 */
class ReCaptchaViewHelper extends AbstractFormFieldViewHelper
{
    use CompileWithRenderStatic;

    public const API_SERVER = 'https://www.google.com/recaptcha/api.js';

    /**
     * @return string
     */
    public function render(): string
    {
        $name = $this->getName();

        $this->registerFieldNameForFormTokenGeneration($name);

        $this->templateVariableContainer->add('name', $name);
        $this->templateVariableContainer->add('rc_pubkey', $this->getReCaptchaPublicKey());

        return '<script src="' . self::API_SERVER . '" async defer></script>';
    }

    /**
     * @return string
     * @throws MissingKeyException
     */
    private function getReCaptchaPublicKey(): string
    {
        $publicKey = \getenv('GOOGLE_RECAPTCHA_PUBLIC_KEY');
        if (empty($publicKey)) {
            throw new MissingKeyException(
                'Google reCAPTCHA public key not defined',
                1566304358
            );
        }
        return $publicKey;
    }

}
