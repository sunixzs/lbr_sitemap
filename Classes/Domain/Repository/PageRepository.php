<?php

namespace LBR\LbrSitemap\Domain\Repository;

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
 * @package lbr_sitemap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	/**
	 * Returns the first page containing in $page
	 *
	 * @param \LBR\LbrSitemap\Domain\Model\Page $page
	 * @return \LBR\LbrSitemap\Domain\Model\Page
	 */
	public function findFirstSubPage($page) {
		$query = $this->createQuery ();
		$query->getQuerySettings ()->setRespectStoragePage ( false );
		$query->matching ( $query->equals ( "pid", $page->getUid () ) );
		$query->setOrderings ( array (
				"sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING 
		) );
		return $query->execute ()->getFirst ();
	}
	
	/**
	 * Returns all pages in $page
	 *
	 * @param \LBR\LbrSitemap\Domain\Model\Page $page
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResult<\LBR\LbrSitemap\Domain\Model\Page>
	 */
	public function findSubPages($page) {
		$query = $this->createQuery ();
		$query->getQuerySettings ()->setRespectStoragePage ( false );
		$query->matching ( $query->equals ( "pid", $page->getUid () ) );
		$query->setOrderings ( array (
				"sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING 
		) );
		return $query->execute ();
	}
	
	/**
	 * Returns all pages in $page
	 *
	 * @param string $uidList
	 * @param string $order
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResult<\LBR\LbrSitemap\Domain\Model\Page>
	 * @deprecated Use $this->findByUidArray() instead
	 */
	public function findByUidList($uidList, $order = "title") {
		return $this->findByUidArray ( \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode ( ",", $uidList ), $order );
	}
	
	/**
	 * Returns all pages in $page
	 *
	 * @param array $uidArray
	 * @param string $order
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResult<\LBR\LbrSitemap\Domain\Model\Page>
	 */
	public function findByUidArray($uidArray, $order = "") {
		$query = $this->createQuery ();
		$query->getQuerySettings ()->setRespectStoragePage ( false );
		$query->matching ( $query->in ( "uid", $uidArray ) );
		if ($order) {
			$query->setOrderings ( array (
					$order => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING 
			) );
		}
		return $query->execute ();
	}
	
	/**
	 * Returns all objects of this repository ordered by dtstart
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResult<\LBR\LbrSitemap\Domain\Model\Page>
	 */
	public function findAll() {
		$query = $this->createQuery ();
		// $query->getQuerySettings()->setRespectStoragePage( false );
		$query->setOrderings ( array (
				"sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING 
		) );
		return $query->execute ();
	}
}
?>