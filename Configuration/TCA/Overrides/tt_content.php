<?php
if (! defined ( 'TYPO3_MODE' )) {
	die ( 'Access denied.' );
}

$tempColumns = array (
		'tstamp' => array (
				'label' => 'Timestamp',
				'config' => array (
						'type' => 'input',
						'eval' => 'datetime' 
				) 
		) 
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns ( 'tt_content', $tempColumns );
