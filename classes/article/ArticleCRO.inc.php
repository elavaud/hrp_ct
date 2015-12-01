<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleCRO.inc.php
 *
 *
 * @brief ArticleCRO class.
 */

define('CRO_NATIONAL', 0);
define('CRO_INTERNATIONAL', 1);

class ArticleCRO extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleCRO() {
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
	 * Get the name of the cro.
	 * @return string
	 */
	function getName() {
		return $this->getData('name');
	}
	/**
	 * Set the name of the cro.
	 * @param $name string
	 */
	function setName($name) {
		return $this->setData('name', $name);
	}

        
        /**
	 * Get if this is an international cro.
	 * @return int
	 */
	function getInternational() {
		return $this->getData('international');
	}
	/**
	 * Set if this is an international cro.
	 * @param $international int
	 */
	function setInternational($international) {
		return $this->setData('international', $international);
	}
        /**
	 * Get if CRO is international full text.
	 * @return string
	 */
	function getCROInternationalText() {
                $international = $this->getInternational();
                if ($international == CRO_NATIONAL) {
                    $journal =& Request::getJournal();
                    $coveredArea = $journal->getLocalizedSetting('location');               
                    return $coveredArea;
                } else {
                    return Locale::translate('institution.international');
                }
	}
        
        
        /**
	 * Get cro location.
	 * @return string
	 */
	function getCROLocation() {
		return $this->getData('location');
	} 
        /**
	 * Get CRO location full text.
	 * @return string
	 */
	function getCROLocationText() {
                $international = $this->getInternational();
                $location = $this->getCROLocation(); 
                $returner = (string) '';
                if ($international == CRO_NATIONAL) {
                    $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
                    $extraField =& $extraFieldDAO->getExtraField($location);
                    if (isset($extraField)){$returner = $extraField->getLocalizedExtraFieldName();}
                    else {$returner = '-';}
                } elseif ($international == CRO_INTERNATIONAL) {
                    $countryDAO =& DAORegistry::getDAO('CountryDAO');
                    $returner = $countryDAO->getCountry($location);
                }
                return $returner;            
	}
	/**
	 * Set CRO location.
	 * @param $location string
	 */
	function setCROLocation($location) {
		return $this->setData('location', $location);
	}
        
        
        /**
	 * Get city of the cro.
	 * @return string
	 */
	function getCity() {
		return $this->getData('city');
	}
	/**
	 * Set city of the cro.
	 * @param $city string
	 */
	function setCity($city) {
		return $this->setData('city', $city);
	}


        /**
	 * Get address of the cro.
	 * @return string
	 */
	function getAddress() {
		return $this->getData('address');
	}
	/**
	 * Set address of the cro.
	 * @param $address string
	 */
	function setAddress($address) {
		return $this->setData('address', $address);
	}
        
        
        /**
	 * Get primary phone number of the cro.
	 * @return string
	 */
	function getPrimaryPhone() {
		return $this->getData('primaryPhone');
	}
	/**
	 * Set primary phone number of the cro.
	 * @param $primaryPhone string
	 */
	function setPrimaryPhone($primaryPhone) {
		return $this->setData('primaryPhone', $primaryPhone);
	}
        
        
        /**
	 * Get secondary phone number of the cro.
	 * @return string
	 */
	function getSecondaryPhone() {
		return $this->getData('secondaryPhone');
	}
	/**
	 * Set secondary phone number of the cro.
	 * @param $secondaryPhone string
	 */
	function setSecondaryPhone($secondaryPhone) {
		return $this->setData('secondaryPhone', $secondaryPhone);
	}
        
        
        /**
	 * Get fax number of the cro.
	 * @return string
	 */
	function getFax() {
		return $this->getData('fax');
	}
	/**
	 * Set fax number of the cro.
	 * @param $fax string
	 */
	function setFax($fax) {
		return $this->setData('fax', $fax);
	}
        
        
        /**
	 * Get email of the cro.
	 * @return string
	 */
	function getEmail() {
		return $this->getData('email');
	}
	/**
	 * Set email of the cro.
	 * @param $email string
	 */
	function setEmail($email) {
		return $this->setData('email', $email);
	}        
}
?>
