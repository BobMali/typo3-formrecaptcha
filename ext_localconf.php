<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
(static function (string $extensionKey): void {

    // TypoScript Setup
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT:source="FILE:EXT:' . $extensionKey . '/Configuration/TypoScript/setup.typoscript">'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'recaptcha',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:formrecaptcha/Resources/Public/Icons/recaptcha.svg'
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['frc'] = ['Neusta\\Formrecaptcha\\ViewHelpers'];
})('formrecaptcha');
