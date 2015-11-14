<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleSecId.inc.php
 *
 *
 * @brief ArticleSecId class.
 */

// For integers
define ('ARTICLE_SEC_ID_NOT_PROVIDED', 0);

define ('ARTICLE_SEC_ID_TYPE_SPONSOR', 1);          //Sponsor issued trial number
define ('ARTICLE_SEC_ID_TYPE_OTHER_REGISTRY', 2);   //Trial number by other registry
define ('ARTICLE_SEC_ID_TYPE_UTN', 3);              //Universal Trial Number
define ('ARTICLE_SEC_ID_TYPE_OTHER', 4);            //Other



class ArticleSecId extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleSecId() {
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
	 * Get type of the seconday ID.
	 * @return int
	 */
	function getType() {
		return $this->getData('type');
	}
	/**
	 * Set type of the seconday ID.
	 * @param $type int
	 */
	function setType($type) {
		return $this->setData('type', $type);
	}
        /**
	 * Get a map for the type constants to locale key.
	 * @return array
	 */
	function &getTypeMap() {
		static $typeMap;
		if (!isset($typeMap)) {
			$typeMap = array(
                                ARTICLE_SEC_ID_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_SEC_ID_TYPE_SPONSOR => 'proposal.secId.sponsor',
				ARTICLE_SEC_ID_TYPE_OTHER_REGISTRY => 'proposal.secId.otherRegistry',
				ARTICLE_SEC_ID_TYPE_UTN => 'proposal.secId.utn',
				ARTICLE_SEC_ID_TYPE_OTHER => 'common.other'                            
			);
		}
		return $typeMap;
	}
	/**
	 * Get a locale key for the unit to use for the mimimum age of participants
	 */
	function getTypeKey() {
                $type = $this->getType();
		$typeMap =& $this->getTypeMap();
		return $typeMap[$type];
	}

        
        /**
	 * Get value of the secondary ID.
	 * @return string
	 */
	function getSecId() {
		return $this->getData('secId');
	}
	/**
	 * Set value of the secondary ID.
	 * @param $secId string
	 */
	function setSecId($secId) {
		return $this->setData('secId', $secId);
	}
}
?>
