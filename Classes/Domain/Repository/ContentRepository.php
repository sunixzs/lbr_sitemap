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
class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	/**
	 * Returns the latest content on $page
	 *
	 * @param \LBR\LbrSitemap\Domain\Model\Page $page
	 * @return \LBR\LbrSitemap\Domain\Model\Content
	 */
	public function findOneLatest($page) {
		$query = $this->createQuery ();
		$query->getQuerySettings ()->setRespectStoragePage ( false );
		$query->matching ( $query->equals ( "pid", $page->getUid () ) );
		$query->setOrderings ( array (
				"tstamp" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING 
		) );
		return $query->execute ()->getFirst ();
	}
}
?>