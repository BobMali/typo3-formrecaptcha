<?php
declare(strict_types=1);

namespace Neusta\Formrecaptcha\ViewHelpers\Forms;

use Neusta\Formrecaptcha\Service\ConfigurationService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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

        GeneralUtility::makeInstance(PageRenderer::class)->addJsFooterLibrary(
            'recaptchaapi',
            $configurationService::getApiScript(),
            'text/javascript',
            false,
            false,
            '',
            true,
            '|',
            true,
            '',
            true
        );

        return '<div class="g-recaptcha" data-sitekey="' . $configurationService::getPublicKey() . '"></div>';
    }
}
