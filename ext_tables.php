<?php
if (! defined ( 'TYPO3_MODE' )) {
	die ( 'Access denied.' );
}

/*
 * Plugin 1
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ( $_EXTKEY, 'Pi1', 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pi1' );

// Flexform for Pi1
$pluginSignature = str_replace ( '_', '', $_EXTKEY ) . '_' . pi1;
$TCA[ 'tt_content' ][ 'types' ][ 'list' ][ 'subtypes_addlist' ][ $pluginSignature ] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue ( $pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' . pi1 . '.xml' );

/*
 * Plugin 2
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ( $_EXTKEY, 'Pi2', 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pi2' );

// Flexform for Pi2
$pluginSignature = str_replace ( '_', '', $_EXTKEY ) . '_' . pi2;
$TCA[ 'tt_content' ][ 'types' ][ 'list' ][ 'subtypes_addlist' ][ $pluginSignature ] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue ( $pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' . pi2 . '.xml' );

// Page-TypoScript
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig ( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/pageTSconfig.txt">' );

// Static TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile ( $_EXTKEY, 'Configuration/TypoScript', 'LBR Sitemap' );

