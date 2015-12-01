<?php
if (! defined ( 'TYPO3_MODE' )) {
	die ( 'Access denied.' );
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin ( 'LBR.' . $_EXTKEY, 'Pi1', array (
		'Sitemap' => 'show' 
), array () );

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin ( 'LBR.' . $_EXTKEY, 'Pi2', array (
		'Overview' => 'show' 
), array () );

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin ( 'LBR.' . $_EXTKEY, 'Pi3', array (
		'Sitemap' => 'xml' 
), array () );
