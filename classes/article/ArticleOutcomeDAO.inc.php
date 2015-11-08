<?php

/**
 * @file classes/article/ArticleOutcomeDAO.inc.php
 *
 * @class ArticleOutcomeDAO
 *
 * @brief Operations for retrieving and modifying ArticleOutcome objects.
 */

import('classes.article.ArticleOutcome');

class ArticleOutcomeDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleOutcomeDAO() {
            parent::DAO();
	}
        
    	/**
	 * Get the article outcome object of a submission.
	 * @param $articleOutcomeId int
	 * @return ArticleOutcome object
	 */
	function &getArticleOutcomeById($articleOutcomeId) {
                           
		$result =& $this->retrieve('SELECT * FROM article_outcome WHERE article_outcome_id = '. $articleOutcomeId . ' LIMIT 1');		

		$articleOutcome =& $this->_returnArticleOutcomeFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleOutcome;
	}

        /**
	 * Get all article outcome objects of a submission.
	 * @param $articleId int
	 * @param $locale string optional
         * @return array ArticleOutcome
	 */
	function &getArticleOutcomesByArticleId($articleId, $locale = null) {
            
		if ($locale === null) $locale = Locale::getLocale();
                
                $articleOutcomes = array();
                
		$result =& $this->retrieve('SELECT * FROM article_outcome WHERE article_id = ' . $articleId . ' AND locale = ' . $locale);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleOutcomes[$row['locale']] =& $this->_returnArticleOutcomeFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleOutcomes;
	}


	/**
	 * Insert a new ArticleOutcome object.
	 * @param $articleOutcome ArticleOutcome
	 */
	function insertArticleOutcome(&$articleOutcome) {
		$this->update(
			'INSERT INTO article_outcome 
				(article_id, locale, type, name, measurement, timepoint)
			VALUES
				(?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleOutcome->getArticleId(),
				$articleOutcome->getLocale(),
				$articleOutcome->getType(),
				$articleOutcome->getName(),
				$articleOutcome->getMeasurement(),
				$articleOutcome->getTimepoint()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleOutcome.
	 * @param $articleOutcome ArticleOutcome
	 */
	function updateArticleOutcome(&$articleOutcome) {
		$returner = $this->update(
			'UPDATE article_outcome
			SET	
				article_id = ?,
                                locale = ?,
				type = ?,
				name = ?,
                                measurement = ?,
                                timepoint = ?
			WHERE	article_outcome_id = ?',
			array(
				(int) $articleOutcome->getArticleId(),
				$articleOutcome->getLocale(),
				$articleOutcome->getType(),
				$articleOutcome->getName(),
				$articleOutcome->getMeasurement(),
				$articleOutcome->getTimepoint(),
                                $articleOutcome->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleOutcome by ID
	 * @param $articleOutcomeId int
	 */
	function deleteArticleOutcome($articleOutcomeId) {
		
		$returner = $this->update('DELETE FROM article_outcome WHERE article_outcome_id = ?',(int) $articleOutcomeId);
		
		return $returner;
	}

        /**
	 * Delete articleOutcomes by article ID
	 * @param $articleId int
	 */
	function deleteArticleOutcomesByArticleId($articleId) {
		
		$returner = $this->update('DELETE FROM article_outcome WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Check if an articleOutcome exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articleOutcomeExists($submissionId) {
		
		$result =& $this->retrieve('SELECT count(*) FROM article_outcome WHERE article_id = ?', (int) $submissionId);
		
		$returner = $result->fields[0]?true:false;
		$result->Close();
		
		return $returner;
	}

	/**
	 * Internal function to return an articleOutcome object from a row.
	 * @param $row array
	 * @return articleOutcome ArticleOutcome
	 */
	function &_returnArticleOutcomeFromRow(&$row) {
		$articleOutcome = new ArticleOutcome();
		$articleOutcome->setId($row['article_outcome_id']);
		$articleOutcome->setArticleId($row['article_id']);
		$articleOutcome->setLocale($row['locale']);                
                $articleOutcome->setType($row['type']);
                $articleOutcome->setName($row['name']);
                $articleOutcome->setMeasurement($row['measurement']);
                $articleOutcome->setTimepoint($row['timepoint']);
                
		HookRegistry::call('ArticleOutcomeDAO::_returnArticleOutcomeFromRow', array(&$articleOutcome, &$row));

		return $articleOutcome;
	}
}

?>
