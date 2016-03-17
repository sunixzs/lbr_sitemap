<?php

namespace LBR\LbrSitemap\Domain\Model;

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
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;
	
	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * navTitle
	 *
	 * @var string
	 */
	protected $navTitle;
	
	/**
	 * Returns the navTitle
	 *
	 * @return string $title
	 */
	public function getNavTitle() {
		return $this->navTitle;
	}
	
	/**
	 * navHide
	 *
	 * @var boolean
	 */
	protected $navHide = false;
	
	/**
	 * Returns the boolean state of navHide
	 *
	 * @return boolean $navHide
	 */
	public function getNavHide() {
		return $this->navHide;
	}
	
	/**
	 * Returns the boolean state of navHide
	 *
	 * @return boolean $navHide
	 */
	public function isNavHide() {
		return $this->getNavHide ();
	}
	
	/**
	 * hideinxml
	 *
	 * @var boolean
	 */
	protected $hideinxml = false;
	
	/**
	 * Returns the boolean state of hideinxml
	 *
	 * @return boolean $hideinxml
	 */
	public function getHideinxml() {
		return $this->hideinxml;
	}
	
	/**
	 * Returns the boolean state of hideinxml
	 *
	 * @return boolean $hideinxml
	 */
	public function isHideinxml() {
		return $this->getHideinxml ();
	}
	
	/**
	 * subtitle
	 *
	 * @var string
	 */
	protected $subtitle;
	
	/**
	 * Returns the subtitle
	 *
	 * @return string $subtitle
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}
	
	/**
	 * changefreq
	 *
	 * @var string
	 */
	protected $changefreq;
	
	/**
	 * Returns the changefreq
	 *
	 * @return string $changefreq
	 */
	public function getChangefreq() {
		return $this->changefreq;
	}
	
	/**
	 * priority
	 *
	 * @var string
	 */
	protected $priority;
	
	/**
	 * Returns the priority
	 *
	 * @return string $priority
	 */
	public function getPriority() {
		return $this->priority;
	}
	
	/**
	 * tstamp
	 *
	 * @var \DateTime
	 */
	protected $tstamp;
	
	/**
	 * Returns the tstamp
	 *
	 * @return \DateTime $tstamp
	 */
	public function getTstamp() {
		return $this->tstamp;
	}
	
	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;
	
	/**
	 * Returns the txLbrsitemapDescription
	 *
	 * @return string $txLbrsitemapDescription
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image = NULL;
	
	/**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage() {
		return $this->image;
	}
	
	/**
	 * sorting
	 *
	 * @var integer
	 */
	protected $sorting;
	
	/**
	 * Returns the sorting
	 *
	 * @return integer $sorting
	 */
	public function getSorting() {
		return $this->sorting;
	}
	
	/**
	 * doktype
	 *
	 * 1 = Standard
	 * 2 = Erweitert
	 * 3 = Externe URL
	 * 4 = Shortcut
	 * 5 = Nicht im Menü
	 * 6 = Backend Benutzer Bereich
	 * 7 = Mount Seite
	 * 199 = Abstand
	 * 254 = Sysordner
	 * 255 = Recycler
	 *
	 * @var integer
	 */
	protected $doktype;
	
	/**
	 * Returns the doktype
	 *
	 * @return integer $doktype
	 */
	public function getDoktype() {
		return $this->doktype;
	}
	
	/**
	 * shortcutMode
	 *
	 * 0 = Verweis auf Seite
	 * 1 = Erste Unterseite
	 *
	 * @var integer
	 */
	protected $shortcutMode;
	
	/**
	 * Returns the shortcutMode
	 *
	 * @return integer $shortcutMode
	 */
	public function getShortcutMode() {
		return $this->shortcutMode;
	}
	
	/**
	 * shortcut
	 *
	 * Seite, auf die verwiesen werden soll.
	 *
	 * @var integer
	 */
	protected $shortcut;
	
	/**
	 * Returns the shortcut
	 *
	 * @return integer $shortcut
	 */
	public function getShortcut() {
		return $this->shortcut;
	}
	
	/**
	 * Returns the shortcutPid
	 *
	 * @return integer
	 */
	public function getShortcutPid() {
		if ($this->getDoktype () != 4) {
			return 0;
		}
		
		if ($this->getShortcutMode () == 0) {
			return $this->getShortcut ();
		}
		
		if ($this->getShortcutMode () == 1) {
			// $pageRepository = new \LBR\LbrSitemap\Domain\Repository\PageRepository ();
			$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance ( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
			$pageRepository = $objectManager->get ( 'LBR\\LbrSitemap\\Domain\\Repository\\PageRepository' );
			$firstSubPage = $pageRepository->findFirstSubPage ( $this );
			return ($firstSubPage) ? $firstSubPage->getUid () : 0;
		}
		
		return 0;
	}
	
	/**
	 * url
	 *
	 * @var string
	 */
	protected $url;
	
	/**
	 * Returns the url
	 *
	 * @return string $url
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 * Checks, if the pageType is 3 (External URL)
	 *
	 * @return string URL or ""
	 */
	public function getExternalLink() {
		if ($this->getDoktype () != 3) {
			return "";
		}
		
		if ($this->getUrl ()) {
			return $this->getUrl ();
		}
		
		return "";
	}
	
	/**
	 * target
	 *
	 * @var string
	 */
	protected $target;
	
	/**
	 * Returns the target
	 *
	 * @return string $target
	 */
	public function getTarget() {
		return $this->target;
	}
	
	/**
	 * urltype
	 *
	 * 0 = Auto
	 * 1 = http://
	 * 4 = https://
	 * 2 = ftp://
	 * 3 = mailto:
	 *
	 * @var integer
	 */
	protected $urltype;
	
	/**
	 * Returns the urltype
	 *
	 * @return integer $urltype
	 */
	public function getUrltype() {
		return $this->urltype;
	}
	
	/**
	 * urltypeArray
	 *
	 * @var array
	 */
	protected $urltypeArray = array (
			0 => '',
			1 => 'http://',
			2 => 'ftp://',
			3 => 'mailto:',
			4 => 'https://' 
	);
	
	/**
	 * Returns the externalLink-Protocol
	 *
	 * @return string
	 */
	public function getUrlProtocol() {
		return $this->urltypeArray[ $this->getUrltype () ];
	}
	
	/**
	 * abstract
	 *
	 * @var string
	 */
	protected $abstract;
	
	/**
	 * Returns the abstract
	 *
	 * @return string $abstract
	 */
	public function getAbstract() {
		return $this->abstract;
	}
}
?>