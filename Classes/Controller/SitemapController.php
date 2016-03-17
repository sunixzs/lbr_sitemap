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
class SitemapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * pageRepository
	 *
	 * @var \LBR\LbrSitemap\Domain\Repository\PageRepository
	 * @inject
	 */
	protected $pageRepository;
	
	/**
	 * contentRepository
	 *
	 * @var \LBR\LbrSitemap\Domain\Repository\ContentRepository
	 * @inject
	 */
	protected $contentRepository;
	
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
		
		// switch between Tree and Index
		switch ($this->settings[ 'layout' ]) {
			case "search" :
				$this->view->assign ( "data", $this->configurationManager->getContentObject ()->data );
				return $this->view->render ();
				break;
			case "tree" :
			case "tree_with_abstract" :
			case "tree_from_directory" :
			case "tree_from_directory_with_abstract" :
				// get classes to transform TypoScript and render contentObject
				$typoScriptService = $this->objectManager->get ( 'TYPO3\\CMS\\Extbase\\Service\\TypoScriptService' );
				$contentObjectRenderer = $this->objectManager->get ( 'TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer' );
				
				// get TypoScript from settings
				$typoScript = $typoScriptService->convertPlainArrayToTypoScriptArray ( $this->settings[ $this->settings[ 'layout' ] ] );
				
				// expand TypoScript with requested tree-levels
				$i = 1;
				while ( $i < $recursive ) {
					$i ++;
					$typoScript[ $i ] = $typoScript[ '1' ];
					$typoScript[ $i . "." ] = $typoScript[ '1.' ];
				}
				
				// render the navigation
				$typoScript[ 'special.' ][ 'value' ] = implode ( ",", $rootpageUids );
				
				if (trim ( $this->settings[ 'cssClass' ] )) {
					return '<div class="' . trim ( $this->settings[ 'cssClass' ] ) . '">' . $contentObjectRenderer->getContentObject ( $typoScript[ '_typoScriptNodeValue' ] )->render ( $typoScript ) . '</div>';
				} else {
					return $contentObjectRenderer->getContentObject ( $typoScript[ '_typoScriptNodeValue' ] )->render ( $typoScript );
				}
				break;
			case "index" :
			case "index_with_abstract" :
				// get classes to transform TypoScript, render contentObject and get the treelist
				$typoScriptService = $this->objectManager->get ( 'TYPO3\\CMS\\Extbase\\Service\\TypoScriptService' );
				$contentObjectRenderer = $this->objectManager->get ( 'TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer' );
				$queryGenerator = $this->objectManager->get ( 'TYPO3\\CMS\\Core\\Database\\QueryGenerator' );
				$currentContentObject = $this->configurationManager->getContentObject ()->data;
				
				// find all relevant pageUids
				$pagesArr = array ();
				foreach ( $rootpageUids as $rootpageUid ) {
					$pagesUidStr = $queryGenerator->getTreeList ( $rootpageUid, $recursive, 0, " doktype IN (1,2,3,4) AND nav_hide = 0" );
					if ($pagesUidStr) {
						$pagesArr = array_merge ( $pagesArr, \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $pagesUidStr ) );
					}
				}
				
				// find the pages
				$pages = $this->pageRepository->findByUidArray ( array_unique ( $pagesArr ), "title" );
				
				// loop the pages to get the right order
				$indexArr = array ();
				foreach ( $pages as $page ) {
					// $firstChar = strtoupper ( mb_substr ( $page->getTitle (), 0, 1, 'utf-8' ) );
					$firstChar = strtoupper ( mb_substr ( $page->getNavTitle () ? $page->getNavTitle () : $page->getTitle (), 0, 1, 'utf-8' ) );
					$indexArr[ $firstChar ][] = $page->getUid ();
				}
				
				// sort array again (list was sorted by title with lower- and uppercase first-letters. Also maybe we are in a translation)
				ksort ( $indexArr );
				
				// build one big TypoScript and let the engine render the rest
				$typoScript = $typoScriptService->convertPlainArrayToTypoScriptArray ( $this->settings[ $this->settings[ 'layout' ] ] );
				
				$i = 1;
				$linkArr = array ();
				foreach ( $indexArr as $char => $uidArr ) {
					$i ++;
					$index = $currentContentObject[ 'uid' ] . "_" . $i;
					$linkArr[ $index ] = $char;
					$typoScript[ $i ] = $typoScript[ "1" ];
					$typoScript[ $i . "." ] = $typoScript[ "1." ];
					$typoScript[ $i . "." ][ 'wrap' ] = str_replace ( array (
							"###INDEX###",
							"###CHAR###" 
					), array (
							$index,
							$char 
					), $typoScript[ "1." ][ "wrap" ] );
					$typoScript[ $i . "." ][ "special." ][ "value" ] = implode ( ",", $uidArr );
				}
				unset ( $typoScript[ "1" ] );
				unset ( $typoScript[ "1." ] );
				
				// build content...
				// ... the index-navigation
				$content = '<nav class="lbr-sitemap-index ' . trim ( $this->settings[ 'cssClass' ] ) . '"><ul class="lbr-sitemap-chars">';
				$uriBuilder = $this->controllerContext->getUriBuilder ();
				$uriBuilder->reset ();
				foreach ( $linkArr as $index => $char ) {
					$uriBuilder->setSection ( "char_" . $index );
					$uri = $uriBuilder->build ();
					$content .= '<li><a href="' . $uri . '">' . $char . '</a></li>';
				}
				$content .= '</ul>';
				
				// ... the lists
				$content .= $contentObjectRenderer->getContentObject ( $typoScript[ '_typoScriptNodeValue' ] )->render ( $typoScript );
				$content .= '</nav>';
				return $content;
				break;
		}
		
		return "";
	}
	
	/**
	 * action xml
	 * @throws \Exception
	 * @return string XML
	 */
	public function xmlAction() {
		if (isset ( $this->settings[ 'rootpageUids' ] ) === FALSE || is_array ( $this->settings[ 'rootpageUids' ] ) === FALSE) {
			throw new \Exception ( "You have to define settings.rootpageUids with the keys uid and depth!", 1458210595 );
		}
		
		$dokTypes = \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $this->settings[ 'dokTypes' ] );
		if (! count ( $dokTypes )) {
			throw new \Exception ( "You have to define settings.dokTypes! (almost: 1,2)", 1458210596 );
		}
		
		// define some variables
		$uriBuilder = $this->controllerContext->getUriBuilder ();
		$queryGenerator = $this->objectManager->get ( 'TYPO3\\CMS\\Core\\Database\\QueryGenerator' );
		
		// find the pages
		$pagesArr = array ();
		$i = 0;
		foreach ( $this->settings[ 'rootpageUids' ] as $rootpageConfiguration ) {
			if (isset ( $rootpageConfiguration[ 'uid' ] ) && isset ( $rootpageConfiguration[ 'depth' ] )) {
				$pagesUidStr = $queryGenerator->getTreeList ( ( integer ) $rootpageConfiguration[ 'uid' ], ( integer ) $rootpageConfiguration[ 'depth' ], 0, 
						" doktype IN (" . implode ( ",", $dokTypes ) . ")" );
				if ($pagesUidStr) {
					$pagesArr = array_merge ( $pagesArr, \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $pagesUidStr ) );
				}
			}
		}
		
		// find the pages
		$pages = $this->pageRepository->findByUidArray ( array_unique ( $pagesArr ) );
		
		// build xml
		$builtUris = [ ];
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ( $pages as $page ) {
			if ($page->isNavHide () || $page->isHideinxml () || $page->getDoktype () == 4) {
				continue;
			}
			
			$xml .= '<url>';
			
			// location
			$uriBuilder->reset ();
			$uriBuilder->setAbsoluteUriScheme ( true );
			$uriBuilder->setTargetPageUid ( $page->getUid () );
			
			$uri = $uriBuilder->build ();
			if (in_array ( $uri, $builtUris )) {
				continue;
			}
			$builtUris[] = $uri;
			
			$xml .= '<loc>' . htmlentities ( $uri, ENT_XML1, "UTF-8" ) . '</loc>';
			
			// lastmod
			$latestContentElement = $this->contentRepository->findOneLatest ( $page );
			if ($latestContentElement && $latestContentElement->getTstamp ()) {
				$xml .= '<lastmod>' . $latestContentElement->getTstamp ()->format ( "c" ) . '</lastmod>';
			} else if ($page->getTstamp ()) {
				$xml .= '<lastmod>' . $page->getTstamp ()->format ( "c" ) . '</lastmod>';
			}
			unset ( $latestContentElement );
			
			// changefreq
			if ($page->getChangefreq ()) {
				$xml .= '<changefreq>' . $page->getChangefreq () . '</changefreq>';
			}
			
			// priority
			if ($page->getPriority ()) {
				$xml .= '<priority>' . $page->getPriority () . '</priority>';
			}
			
			$xml .= '</url>';
		}
		
		$xml .= '</urlset>';
		
		$xml .= '<!-- count: ' . count ( $builtUris ) . ' URI -->';
		return $xml;
	}
}
?>