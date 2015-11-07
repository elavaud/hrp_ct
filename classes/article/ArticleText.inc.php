<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleText.inc.php
 *
 *
 * @brief ArticleText class.
 */

class ArticleText extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleText() {
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
	 * Get the scientific title.
	 * @return string
	 */
	function getScientificTitle() {
		return $this->getData('scientificTitle');
	}
	/**
	 * Set the scientific title.
	 * @param $title string
	 */
	function setScientificTitle($title) {
		$punctuation = array ("\"", "\'", ",", ".", "!", "?", "-", "$", "(", ")");
		return $this->setData('scientificTitle', str_replace($punctuation, "", $title));
	} 

	
	/**
	 * Get public title.
	 * @return string
	 */
	function getPublicTitle() {
		return $this->getData('publicTitle');
	}
	/**
	 * Set public title.
	 * @param $title string
	 */
	function setPublicTitle($title) {
		$punctuation = array ("\"", "\'", ",", ".", "!", "?", "-", "$", "(", ")");
		return $this->setData('publicTitle', str_replace($punctuation, "", $title));
	}	

        
	/**
	 * Get description.
	 * @return string
	 */
	function getDescription() {
		return $this->getData('description');
	}
	/**
	 * Set description.
	 * @param $description string
	 */
	function setDescription($description) {
                $description = preg_replace('/<\s*/', '< ', $description);
                $description = preg_replace('/\s*>/', ' >', $description);
		return $this->setData('description', $description);
	}

        
	/**
	 * Get key inclusion criteria.
	 * @return string
	 */
	function getKeyInclusionCriteria() {
		return $this->getData('keyInclusionCriteria');
	}
	/**
	 * Set key inclusion criteria.
	 * @param $keyInclusionCriteria string
	 */
	function setKeyInclusionCriteria($keyInclusionCriteria) {
                $keyInclusionCriteria = preg_replace('/<\s*/', '< ', $keyInclusionCriteria);
                $keyInclusionCriteria = preg_replace('/\s*>/', ' >', $keyInclusionCriteria);
		return $this->setData('keyInclusionCriteria', $keyInclusionCriteria);
	}

        
	/**
	 * Get key exclusion criteria.
	 * @return string
	 */
	function getKeyExclusionCriteria() {
		return $this->getData('keyExclusionCriteria');
	}
	/**
	 * Set key exclusion criteria.
	 * @param $keyExclusionCriteria string
	 */
	function setKeyExclusionCriteria($keyExclusionCriteria) {
                $keyExclusionCriteria = preg_replace('/<\s*/', '< ', $keyExclusionCriteria);
                $keyExclusionCriteria = preg_replace('/\s*>/', ' >', $keyExclusionCriteria);
		return $this->setData('keyExclusionCriteria', $keyExclusionCriteria);
	}
        

	/**
	 * Get recruitment information.
	 * @return string
	 */
	function getRecruitmentInfo() {
		return $this->getData('recruitmentInfo');
	}
	/**
	 * Set recruitment information.
	 * @param $recruitmentInfo string
	 */
	function setRecruitmentInfo($recruitmentInfo) {
                $recruitmentInfo = preg_replace('/<\s*/', '< ', $recruitmentInfo);
                $recruitmentInfo = preg_replace('/\s*>/', ' >', $recruitmentInfo);
		return $this->setData('recruitmentInfo', $recruitmentInfo);
	}

}
?>
