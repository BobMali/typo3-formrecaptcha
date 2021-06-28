<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\ViewHelpers\Forms;

use Neusta\Formrecaptcha\Service\ConfigurationService;
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

    /**
     * @return string
     */
    public function render(): string
    {
        $configurationService = ConfigurationService::getInstance()::initialize();
        $this->templateVariableContainer->add('rc_pubkey', $configurationService::getPublicKey());

        return $this->includeScript($configurationService::getReCaptchaFormValidationScript())
            . '<script src="' . $configurationService::getApiScript() . '" async defer></script>';
    }

    private function includeScript(string $scriptFilename): string
    {
        return !empty($scriptFilename) ? '<script src="' . $scriptFilename . '"></script>' : '';
    }
}
