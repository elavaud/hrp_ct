<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleOutcome.inc.php
 *
 *
 * @brief ArticleOutcome class.
 */

// For integers
define ('ARTICLE_OUTCOME_NOT_PROVIDED', 0);

define ('ARTICLE_OUTCOME_PRIMARY', 1);
define ('ARTICLE_OUTCOME_SECONDARY', 2);


class ArticleOutcome extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleOutcome() {
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
	 * Get locale.
	 * @return string
	 */
	function getLocale() {
		return $this->getData('locale');
	}
	/**
	 * Set locale.
	 * @param $locale string
	 */
	function setLocale($locale) {
		return $this->setData('locale', $locale);
	}
        
        
        /**
	 * Get type (primary/secondary).
	 * @return int
	 */
	function getType() {
		return $this->getData('type');
	}
	/**
	 * Set type (primary/secondary).
	 * @param $type int
	 */
	function setType($type) {
		return $this->setData('type', $type);
	}
        
        
        /**
	 * Get the name of the outcome.
	 * @return string
	 */
	function getName() {
		return $this->getData('name');
	}
	/**
	 * Set name of the outcome.
	 * @param $name string
	 */
	function setName($name) {
		return $this->setData('name', $name);
	}
        
        
        /**
	 * Get the method of measurement.
	 * @return string
	 */
	function getMeasurement() {
		return $this->getData('measurement');
	}
	/**
	 * Set the method of measurement.
	 * @param $measurement string
	 */
	function setMeasurement($measurement) {
		return $this->setData('measurement', $measurement);
	}
        
        /**
	 * Get the timepoint.
	 * @return string
	 */
	function getTimepoint() {
		return $this->getData('timepoint');
	}
	/**
	 * Set the timepoint.
	 * @param $timepoint string
	 */
	function setTimepoint($timepoint) {
		return $this->setData('timepoint', $timepoint);
	}
}
?>
