<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleContact.inc.php
 *
 *
 * @brief article contact class.
 */


class ArticleContact extends DataObject {
            
	/**
	 * Constructor.
	 */
	function ArticleContact() {
            parent::DataObject();
	}

        
	/**
	 * Set article id.
	 * @param $articleId int
	 */
	function setArticleId($articleId) {
		return $this->setData('articleId', $articleId);
	}    
	/**
	 * Get article id.
	 * @return int
	 */
	function getArticleId() {
		return $this->getData('articleId');
	}
        
        
        /**
	 * Set public queries name.
	 * @param $pqName string
	 */
	function setPQName($pqName) {
		return $this->setData('pqName', $pqName);
	}    
	/**
	 * Get public queries name.
	 * @return string
	 */
	function getPQName() {
		return $this->getData('pqName');
	}
        
        
        /**
	 * Set public queries affiliation.
	 * @param $pqAffiliation string
	 */
	function setPQAffiliation($pqAffiliation) {
		return $this->setData('pqAffiliation', $pqAffiliation);
	}    
	/**
	 * Get public queries affiliation.
	 * @return string
	 */
	function getPQAffiliation() {
		return $this->getData('pqAffiliation');
	}

        
        /**
	 * Set public queries address.
	 * @param $pqAddress text
	 */
	function setPQAddress($pqAddress) {
		return $this->setData('pqAddress', $pqAddress);
	}    
	/**
	 * Get public queries address.
	 * @return text
	 */
	function getPQAddress() {
		return $this->getData('pqAddress');
	}

        
        /**
	 * Set public queries country.
	 * @param $pqCountry string
	 */
	function setPQCountry($pqCountry) {
		return $this->setData('pqCountry', $pqCountry);
	}    
	/**
	 * Get public queries country.
	 * @return string
	 */
	function getPQCountry() {
		return $this->getData('pqCountry');
	}

        
        /**
	 * Set public queries phone.
	 * @param $pqPhone string
	 */
	function setPQPhone($pqPhone) {
		return $this->setData('pqPhone', $pqPhone);
	}    
	/**
	 * Get public queries phone.
	 * @return string
	 */
	function getPQPhone() {
		return $this->getData('pqPhone');
	}

        
        /**
	 * Set public queries fax.
	 * @param $pqFax string
	 */
	function setPQFax($pqFax) {
		return $this->setData('pqFax', $pqFax);
	}    
	/**
	 * Get public queries fax.
	 * @return string
	 */
	function getPQFax() {
		return $this->getData('pqFax');
	}

        
        /**
	 * Set public queries email.
	 * @param $pqEmail string
	 */
	function setPQEmail($pqEmail) {
		return $this->setData('pqEmail', $pqEmail);
	}    
	/**
	 * Get public queries email.
	 * @return string
	 */
	function getPQEmail() {
		return $this->getData('pqEmail');
	}


        /**
	 * Set scientific queries name.
	 * @param $sqName string
	 */
	function setSQName($sqName) {
		return $this->setData('sqName', $sqName);
	}    
	/**
	 * Get scientific queries name.
	 * @return string
	 */
	function getSQName() {
		return $this->getData('sqName');
	}
        
        
        /**
	 * Set scientific queries affiliation.
	 * @param $sqAffiliation string
	 */
	function setSQAffiliation($sqAffiliation) {
		return $this->setData('sqAffiliation', $sqAffiliation);
	}    
	/**
	 * Get scientific queries affiliation.
	 * @return string
	 */
	function getSQAffiliation() {
		return $this->getData('sqAffiliation');
	}

        
        /**
	 * Set scientific queries address.
	 * @param $sqAddress text
	 */
	function setSQAddress($sqAddress) {
		return $this->setData('sqAddress', $sqAddress);
	}    
	/**
	 * Get scientific queries address.
	 * @return text
	 */
	function getSQAddress() {
		return $this->getData('sqAddress');
	}

        
        /**
	 * Set scientific queries country.
	 * @param $sqCountry string
	 */
	function setSQCountry($sqCountry) {
		return $this->setData('sqCountry', $sqCountry);
	}    
	/**
	 * Get scientific queries country.
	 * @return string
	 */
	function getSQCountry() {
		return $this->getData('sqCountry');
	}

        
        /**
	 * Set scientific queries phone.
	 * @param $sqPhone string
	 */
	function setSQPhone($sqPhone) {
		return $this->setData('sqPhone', $sqPhone);
	}    
	/**
	 * Get scientific queries phone.
	 * @return string
	 */
	function getSQPhone() {
		return $this->getData('sqPhone');
	}

        
        /**
	 * Set scientific queries fax.
	 * @param $sqFax string
	 */
	function setSQFax($sqFax) {
		return $this->setData('sqFax', $sqFax);
	}    
	/**
	 * Get scientific queries fax.
	 * @return string
	 */
	function getSQFax() {
		return $this->getData('sqFax');
	}

        
        /**
	 * Set scientific queries email.
	 * @param $sqEmail string
	 */
	function setSQEmail($sqEmail) {
		return $this->setData('sqEmail', $sqEmail);
	}    
	/**
	 * Get scientific queries email.
	 * @return string
	 */
	function getSQEmail() {
		return $this->getData('sqEmail');
	}
        
        
        
}
?>
