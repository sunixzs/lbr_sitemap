<?php
if (! defined ( 'TYPO3_MODE' )) {
	die ( 'Access denied.' );
}

$tempColumns = array (
		'tx_lbrsitemap_description' => array (
				'exclude' => 1,
				'label' => 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.description',
				'config' => array (
						'type' => 'text',
						'cols' => 40,
						'rows' => 15,
						'eval' => 'trim',
						'wizards' => array (
								'RTE' => array (
										'notNewRecords' => 1,
										'RTEonly' => 1,
										'type' => 'script',
										'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
										'icon' => 'wizard_rte2.gif',
										'module' => array (
												'name' => 'wizard_rte' 
										) 
								) 
						) 
				),
				'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]' 
		),
		'tx_lbrsitemap_image' => array (
				'exclude' => 1,
				'label' => 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.image',
				'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig ( 'tx_lbrsitemap_image', array (
						'maxitems' => 1 
				), $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'GFX' ][ 'imagefile_ext' ] ) 
		),
		'tx_lbrsitemap_changefreq' => array (
				'exclude' => 1,
				'label' => 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq',
				'config' => array (
						'type' => 'select',
						'renderType' => 'selectSingle',
						'items' => array (
								array (
										'',
										'' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.always',
										'always' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.hourly',
										'hourly' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.daily',
										'daily' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.weekly',
										'weekly' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.monthly',
										'monthly' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.yearly',
										'yearly' 
								),
								array (
										'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.changefreq.never',
										'never' 
								) 
						),
						'size' => 1,
						'maxitems' => 1,
						'default' => '' 
				) 
		),
		'tx_lbrsitemap_priority' => array (
				'exclude' => 1,
				'label' => 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.priority',
				'config' => array (
						'type' => 'select',
						'renderType' => 'selectSingle',
						'items' => array (
								array (
										'',
										'' 
								),
								array (
										'100%',
										'1.0' 
								),
								array (
										'90%',
										'0.9' 
								),
								array (
										'80%',
										'0.8' 
								),
								array (
										'70%',
										'0.7' 
								),
								array (
										'60%',
										'0.6' 
								),
								array (
										'50%',
										'0.5' 
								),
								array (
										'40%',
										'0.4' 
								),
								array (
										'30%',
										'0.3' 
								),
								array (
										'20%',
										'0.2' 
								),
								array (
										'10%',
										'0.1' 
								),
								array (
										'0%',
										'0.0' 
								) 
						),
						'size' => 1,
						'maxitems' => 1,
						'default' => '' 
				) 
		),
		
		'tx_lbrsitemap_hideinxml' => array (
				'exclude' => 1,
				'label' => 'LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.hideinxml',
				'config' => array (
						'type' => 'check' 
				) 
		),
		
		'tstamp' => array (
				'label' => 'Timestamp',
				'config' => array (
						'type' => 'input',
						'eval' => 'datetime' 
				) 
		) 
);

$GLOBALS[ 'TCA' ][ 'pages_language_overlay' ][ 'palettes' ][ 'lbrsitemap_sitemapxml' ][ 'showitem' ] = 'tx_lbrsitemap_hideinxml, tx_lbrsitemap_changefreq, tx_lbrsitemap_priority';
$GLOBALS[ 'TCA' ][ 'pages_language_overlay' ][ 'palettes' ][ 'lbrsitemap_content' ][ 'showitem' ] = 'tx_lbrsitemap_description, --linebreak--, tx_lbrsitemap_image';

// ... add to pages_language_overlay
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns ( 'pages_language_overlay', $tempColumns );
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes ( "pages_language_overlay", 
		"--div--;LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.div.sitemap,
		--palette--;LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.palette.lbrsitemap_sitemapxml;lbrsitemap_sitemapxml,
		--palette--;LLL:EXT:lbr_sitemap/Resources/Private/Language/locallang_db.xlf:pages.palette.lbrsitemap_content;lbrsitemap_content", "", "" );

// add columnes for translation
$GLOBALS[ 'TCA' ][ 'pages_language_overlay' ][ 'interface' ][ 'showRecordFieldList' ] .= ', tx_lbrsitemap_changefreq, tx_lbrsitemap_priority, tx_lbrsitemap_description, tx_lbrsitemap_image, tx_lbrsitemap_hideinxml';



