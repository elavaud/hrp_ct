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
	
        var $investigators;
        
        var $removedInvestigators;
    
	/**
	 * Constructor.
	 */
	function ArticleSite() {
            parent::DataObject();
            $this->investigators = array();
            $this->removedInvestigators = array();
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
	 * Get the ID of the ERC.
	 * @return int
	 */
	function getERCId() {
		return $this->getData('ercId');
	}
	/**
	 * Set the ID of the ERC.
	 * @param $ercId int
	 */
	function setERCId($ercId) {
		return $this->setData('ercId', $ercId);
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
        
        
        /**
	 * Add an investigator.
	 * @param $investigator Author
	 */
	function addInvestigator($investigator) {
                $found = false;
                $i = 0;
                $investigators = $this->investigators;
                foreach ($this->investigators as $iKey => $iValue) {
                    if ($investigator->getId() != null && $investigator->getId() == $iValue->getId()){
                        $investigators[$iKey] = $iValue;
                        $found = true;
                    }
                    $i++;
                }
                if (!$found) {
                    $investigators[$i] = $investigator;
                }
                $this->investigators = $investigators;
	}
        /**
	 * Remove an investigator.
	 * @param $investigatorId ID of the investigator to remove
	 * @return boolean investigator was removed
	 */
	function removeInvestigator($investigatorId) {
                $found = false;
                $i = 0;
		if ($investigatorId != 0) {
                    $investigators = $this->investigators;
                    foreach ($this->investigators as $investigator) {
                        if ($investigator->getId() == $investigatorId) {
                            array_push($this->removedInvestigators, $investigatorId);
                            $found = true;
                        }
                        else {
                            $investigators[$i] = $investigator;
                            $i++;
                        }       
                    }
                    $this->investigators = $investigators;
		}
		return $found;
	}
	/**
	 * Get all investigators for this site.
	 * @return array Author
	 */
	function &getInvestigators() {
		return $this->investigators;
	}
        /**
	 * Get investigator by ID for this site.
	 * @return object Author
	 */
	function &getInvestigator($id) {
                foreach ($this->investigators as $investigator) {
                    if ($investigator->getId() == $id) {
                        return $investigator;
                    }
                }
		return null;
	}
        /**
	 * Get primary investigator for this site.
	 * @return object Author
	 */
	function &getPrimaryInvestigator() {
                foreach ($this->investigators as $investigator) {
                    if ($investigator->getPrimaryContact() == true) {
                        return $investigator;
                    }
                }
		return null;
	}
        /**
	 * Get the IDs of all investigators removed from this site.
	 * @return array int
	 */
	function &getRemovedInvestigators() {
		return $this->removedInvestigators;
	}
        /**
	 * Set investigators for this site.
	 * @param $investigators array Author
	 */
	function setInvestigators($investigators) {
		return $this->investigators = $investigators;
	}

        
        /**
	 * Get the trial site object for this article site.
	 * @return object TrialSite
	 */
	function &getTrialSiteObject() {
		$trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');
		return $trialSiteDao->getTrialSiteById($this->getSiteId());
	}

        /**
	 * Get the ERC name (extra field) object for this article site.
	 * @return string
	 */
	function &getERCName() {
		$extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
		$erc = $extraFieldDao->getExtraField($this->getERCId());
                return $erc->getLocalizedExtraFieldName();
	}
        
        /**
	 * Get all the CVs of the principal investigator.
	 * @return array object SuppFile
	 */
	function &getCVs() {
            $suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
            return $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->getArticleId(), SUPP_FILE_CV, $this->getId());
	}

        /**
	 * Get all the endorsment letters for this particular site.
	 * @return array object SuppFile
	 */
	function &getEndorsments() {
            $suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
            return $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->getArticleId(), SUPP_FILE_ENDORSMENT, $this->getId());
	}

}
?>
