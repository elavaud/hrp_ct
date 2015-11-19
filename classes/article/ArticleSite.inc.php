<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleSite.inc.php
 *
 *
 * @brief ArticleSite class.
 */

class ArticleSite extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleSite() {
            parent::DataObject();
	}

	
        /**
	 * Get article id.
	 * @return int
	 */
	function getArticleId() {
		return $this->getData('articleId');
	}
	/**
	 * Set article id.
	 * @param $articleId int
	 */
	function setArticleId($articleId) {
		return $this->setData('articleId', $articleId);
	}
        
        
        /**
	 * Get the ID of the site.
	 * @return int
	 */
	function getSiteId() {
		return $this->getData('siteId');
	}
	/**
	 * Set the ID of the site.
	 * @param $siteId int
	 */
	function setSiteId($siteId) {
		return $this->setData('siteId', $siteId);
	}

        
        /**
	 * Get approving authority of the site.
	 * @return string
	 */
	function getAuthority() {
		return $this->getData('approvingAuthority');
	}
	/**
	 * Set approving authority of the site.
	 * @param $approvingAuthority string
	 */
	function setAuthority($approvingAuthority) {
		return $this->setData('approvingAuthority', $approvingAuthority);
	}
        
        
        /**
	 * Get primary phone number of the site.
	 * @return string
	 */
	function getPrimaryPhone() {
		return $this->getData('primaryPhone');
	}
	/**
	 * Set primary phone number of the site.
	 * @param $primaryPhone string
	 */
	function setPrimaryPhone($primaryPhone) {
		return $this->setData('primaryPhone', $primaryPhone);
	}
        
        
        /**
	 * Get secondary phone number of the site.
	 * @return string
	 */
	function getSecondaryPhone() {
		return $this->getData('secondaryPhone');
	}
	/**
	 * Set secondary phone number of the site.
	 * @param $secondaryPhone string
	 */
	function setSecondaryPhone($secondaryPhone) {
		return $this->setData('secondaryPhone', $secondaryPhone);
	}
        
        
        /**
	 * Get fax number of the site.
	 * @return string
	 */
	function getFax() {
		return $this->getData('fax');
	}
	/**
	 * Set fax number of the site.
	 * @param $fax string
	 */
	function setFax($fax) {
		return $this->setData('fax', $fax);
	}
        
        
        /**
	 * Get email of the site.
	 * @return string
	 */
	function getEmail() {
		return $this->getData('email');
	}
	/**
	 * Set email of the site.
	 * @param $email string
	 */
	function setEmail($email) {
		return $this->setData('email', $email);
	}
        
        
        /**
	 * Get number of subjects for this site.
	 * @return int
	 */
	function getSubjectsNumber() {
		return $this->getData('subjectsNumber');
	}
	/**
	 * Set fax number of the site.
	 * @param $subjectsNumber int
	 */
	function setSubjectsNumber($subjectsNumber) {
		return $this->setData('subjectsNumber', $subjectsNumber);
	}
}
?>
