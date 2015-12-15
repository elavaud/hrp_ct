<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleSponsor.inc.php
 *
 *
 * @brief ArticleSponsor class.
 */

// For integers
define ('ARTICLE_SPONSOR_NOT_PROVIDED', 0);

define ('ARTICLE_SPONSOR_TYPE_FUNDING', 1);          // Funding source
define ('ARTICLE_SPONSOR_TYPE_PRIMARY', 2);          // Primary sponsor
define ('ARTICLE_SPONSOR_TYPE_SECONDARY', 3);        // Secondary sponsor



class ArticleSponsor extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleSponsor() {
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
	 * Get type.
	 * @return int
	 */
	function getType() {
		return $this->getData('type');
	}
	/**
	 * Set type.
	 * @param $type int
	 */
	function setType($type) {
		return $this->setData('type', $type);
	}
        
        /**
	 * Get the institution ID.
	 * @return string
	 */
	function getInstitutionId() {
		return $this->getData('institutionId');
	}
	/**
	 * Set the institution ID.
	 * @param $institutionId int
	 */
	function setInstitutionId($institutionId) {
		return $this->setData('institutionId', $institutionId);
	}
        
        /**
	 * Get the institution object.
	 * @return object Institution
	 */
	function getInstitutionObject() {
                $institutionDao =& DAORegistry::getDAO('InstitutionDAO');
		return $institutionDao->getInstitutionById($this->getInstitutionId());
	}
}
?>
