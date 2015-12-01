<?php

namespace LBR\LbrSitemap\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Marcel Briefs <marcel.briefs@lbrmedia.de>, LBRmedia
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package lbr_sitemap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OverviewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * pageRepository
	 *
	 * @var \LBR\LbrSitemap\Domain\Repository\PageRepository
	 * @inject
	 */
	protected $pageRepository;
	
	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		// define some variables
		$recursive = (( integer ) $this->settings[ 'recursive' ] < 10) ? ( integer ) $this->settings[ 'recursive' ] : 10;
		
		// try to get all root-page-uids
		if ($this->settings[ 'pages' ]) {
			$rootpageUids = \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $this->settings[ 'pages' ] );
		} else {
			$rootpageUids = array (
					$GLOBALS[ 'TSFE' ]->id 
			);
		}
		
		switch ($this->settings[ 'layout' ]) {
			case "overview_from_directory" :
			case "overview_from_directory_small" :
				$queryGenerator = $this->objectManager->get ( 'TYPO3\\CMS\\Core\\Database\\QueryGenerator' );
				$pagesArr = array ();
				$i = 0;
				foreach ( $rootpageUids as $rootpageUid ) {
					$pageUidStr = $queryGenerator->getTreeList ( $rootpageUid, $recursive, 0, " doktype IN (1,2,3,4)" );
					if ($pageUidStr) {
						$pagesArr = array_merge ( $pagesArr, \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $pageUidStr ) );
					}
					
					// remove rootpageUid
					foreach ( array_keys ( $pagesArr, $rootpageUid, false ) as $key ) {
						unset ( $pagesArr[ $key ] );
					}
				}
				
				// find the pages
				$pages = $this->pageRepository->findByUidArray ( array_unique ( $pagesArr ), "sorting" );
				$this->view->assign ( "pages", $pages );
				$this->view->assign ( "current", $GLOBALS[ 'TSFE' ]->id );
				return $this->view->render ();
				break;
		}
		
		return "";
	}
}
?>