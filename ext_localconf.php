<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

if (!defined('TYPO3')) {
    die('Access denied.');
}
(static function (string $extensionKey): void {

    // TypoScript Constants
    ExtensionManagementUtility::addTypoScriptConstants(
        '<INCLUDE_TYPOSCRIPT:source="FILE:EXT:' . $extensionKey . '/Configuration/TypoScript/constants.typoscript">'
    );
    // TypoScript Setup
    ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT:source="FILE:EXT:' . $extensionKey . '/Configuration/TypoScript/setup.typoscript">'
    );

    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    $iconRegistry->registerIcon(
        'recaptcha',
        SvgIconProvider::class,
        [
            'source' => 'EXT:formrecaptcha/Resources/Public/Icons/recaptcha.svg'
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['frc'] = ['Neusta\\Formrecaptcha\\ViewHelpers'];
})('formrecaptcha');
