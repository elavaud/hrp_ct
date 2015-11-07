<?php

/**
 * @file classes/article/ArticleTextDAO.inc.php
 *
 * @class ArticleTextDAO
 *
 * @brief Operations for retrieving and modifying ArticleText objects.
 */

import('classes.article.ArticleText');

class ArticleTextDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleTextDAO() {
	}
        
    	/**
	 * Get the article text object of a submission.
	 * @param $articleTextId int
	 * @return ArticleText object
	 */
	function &getArticleTextById($articleTextId) {

		$result =& $this->retrieve('SELECT * FROM article_text WHERE article_text_id = ?', (int) $articleTextId);		

		$articleText =& $this->_returnArticleTextFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleText;
	}

        /**
	 * Get all article text objects of a submission.
	 * @param $articleId int
	 * @return array ArticleText
	 */
	function &getArticleTextsByArticleId($articleId) {
                $articleTexts = array();
                
		$result =& $this->retrieve('SELECT * FROM article_text WHERE article_id = ?', (int) $articleId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleTexts[$row['locale']] =& $this->_returnArticleTextFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleTexts;
	}


	/**
	 * Insert a new ArticleText object.
	 * @param $articleText ArticleText
	 */
	function insertArticleText(&$articleText) {
		$this->update(
			'INSERT INTO article_text 
				(article_id, locale, scientific_title, public_title, description, key_inclusion_criteria, key_exclusion_criteria, recruitment_info)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleText->getArticleId(),
				$articleText->getLocale(),
				$articleText->getScientificTitle(),
				$articleText->getPublicTitle(),
				$articleText->getDescription(),
				$articleText->getKeyInclusionCriteria(),
				$articleText->getKeyExclusionCriteria(),
				$articleText->getRecruitmentInfo()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleText.
	 * @param $articleText ArticleText
	 */
	function updateArticleText(&$articleText) {
		$returner = $this->update(
			'UPDATE article_text
			SET	
				article_id = ?,
				locale = ?,
				scientific_title = ?, 
				public_title = ?,
				description = ?,
                                key_inclusion_criteria = ?,
                                key_exclusion_criteria = ?,
                                recruitment_info = ?
			WHERE	article_text_id = ?',
			array(
				(int) $articleText->getArticleId(),
				$articleText->getLocale(),
				$articleText->getScientificTitle(),
				$articleText->getPublicTitle(),
				$articleText->getDescription(),
				$articleText->getKeyInclusionCriteria(),
				$articleText->getKeyExclusionCriteria(),
				$articleText->getRecruitmentInfo(),
                                $articleText->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleText by ID
	 * @param $articleTextId int
	 */
	function deleteArticleText($articleTextId) {
		
		$returner = $this->update('DELETE FROM article_text WHERE article_text_id = ?',(int) $articleTextId);
		
		return $returner;
	}

        /**
	 * Delete articleTexts by article ID
	 * @param $articleId int
	 */
	function deleteArticleTextsByArticleId($articleId) {
		
		$returner = $this->update('DELETE FROM article_text WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
        
        
        /**
	 * Delete a specific articleText by article ID and locale
	 * @param $articleId int
	 */
	function deleteArticleTextsByLocaleAndArticleId($locale, $articleId) {
		
		$returner = $this->update('DELETE FROM article_text WHERE locale = ' . $locale . ' AND article_id = ' . $articleId);
		
		return $returner;
	}
        
        
	/**
	 * Check if an articleText exists
	 * @param $submissionId int
	 * @param $locale int optional
	 * @return boolean
	 */
	function articleTextExists($submissionId, $locale = null) {
		
		if ($locale == null) $result =& $this->retrieve('SELECT count(*) FROM article_text WHERE article_id = ?', (int) $submissionId);
		else $result =& $this->retrieve('SELECT count(*) FROM article_text WHERE article_id = ? AND locale = ?', array((int) $submissionId, $locale));
		
		$returner = $result->fields[0]?true:false;
		$result->Close();
		
		return $returner;
	}

	/**
	 * Internal function to return an articleText object from a row.
	 * @param $row array
	 * @return articleText ArticleText
	 */
	function &_returnArticleTextFromRow(&$row) {
		$articleText = new ArticleText();
		$articleText->setId($row['article_text_id']);
		$articleText->setArticleId($row['article_id']);
		$articleText->setLocale($row['locale']);
		$articleText->setScientificTitle($row['scientific_title']);
		$articleText->setPublicTitle($row['public_title']);
		$articleText->setDescription($row['description']);
		$articleText->setKeyInclusionCriteria($row['key_inclusion_criteria']);
		$articleText->setKeyExclusionCriteria($row['key_exclusion_criteria']);
		$articleText->setRecruitmentInfo($row['recruitment_info']);
                
		HookRegistry::call('ArticleTextDAO::_returnArticleTextFromRow', array(&$articleText, &$row));

		return $articleText;
	}
}

?>
