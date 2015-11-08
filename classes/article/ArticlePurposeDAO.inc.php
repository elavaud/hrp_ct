<?php

/**
 * @file classes/article/ArticlePurposeDAO.inc.php
 *
 * @class ArticlePurposeDAO
 *
 * @brief Operations for retrieving and modifying article purpose objects.
 */

import('classes.article.ArticlePurpose');

class ArticlePurposeDAO extends DAO{
 
        /**
	 * Constructor.
	 */
	function ArticlePurposeDAO() {
		parent::DAO();
        }

        /**
	 * Get specific article purpose.
	 * @param $articlePurposeId int
	 * @return articlePurpose object
	 */
	function &getArticlePurposeById($articlePurposeId) {

		$result =& $this->retrieve(
			'SELECT * FROM article_purpose WHERE article_purpose_id = ? LIMIT 1',
			(int) $articlePurposeId
		);

		$articlePurpose =& $this->_returnArticlePurposeFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articlePurpose;
	}

        /**
	 * Get all article purposes for a specific article.
	 * @param $articleId int
	 * @return articlePurpose array
	 */
	function &getArticlePurposesByArticleId($articleId) {
                
                $articlePurposes = array();
                
		$result =& $this->retrieve(
			'SELECT * FROM article_purpose WHERE submission_id = ?',
			(int) $articleId
		);

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articlePurposes[] =& $this->_returnArticlePurposeFromRow($row);
			$result->moveNext();
		}

		$result->Close();
		unset($result);

		return $articlePurpose;
	}
        
	/**
	 * Insert a new article purpose.
	 * @param $articlePurpose object
	 */
	function insertArticlePurpose(&$articlePurpose) {
		$this->update(
			'INSERT INTO article_purpose (article_id, type, ct_phase, allocation, masking, control, assignment, endpoint)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articlePurpose->getArticleId(),
				(int) $articlePurpose->getType(),
				(int) $articlePurpose->getCTPhase(),
				(int) $articlePurpose->getAllocation(),
				(int) $articlePurpose->getMasking(),
                                (int) $articlePurpose->getControl(),
				(int) $articlePurpose->getAssignment(),
				(int) $articlePurpose->getEndpoint()
			)
		);
		
		return true;
	}

	/**
	 * Update an existing article details object.
	 * @param $articlePurpose ArticlePurpose object
	 */
	function updateArticlePurpose(&$articlePurpose) {
		$returner = $this->update(
			'UPDATE article_purpose
			SET	
                                article_id = ?, 
                                type = ?, 
                                ct_phase = ?, 
                                allocation = ?, 
                                masking = ?, 
                                control = ?, 
                                assignment = ?, 
                                endpoint = ?
			WHERE	article_purpose_id = ?',
			array(
				(int) $articlePurpose->getArticleId(),
				(int) $articlePurpose->getType(),
				(int) $articlePurpose->getCTPhase(),
				(int) $articlePurpose->getAllocation(),
				(int) $articlePurpose->getMasking(),
                                (int) $articlePurpose->getControl(),
				(int) $articlePurpose->getAssignment(),
				(int) $articlePurpose->getEndpoint(),
                                (int) $articlePurpose->getId()
                        )
		);
                
		return true;
	}

	/**
	 * Delete a specific article purpose
	 * @param $articlePurposeId int
	 */
	function deleteArticlePurpose($articlePurposeId) {
		$returner = $this->update(
			'DELETE FROM article_purpose WHERE article_purpose_id = ?',
			$articlePurposeId
		);

		return true;
	}
 
       /**
	 * Delete all article purposes by article ID
	 * @param $articleId int
	 */
	function deleteArticlePurposes($articleId) {
		$returner = $this->update(
			'DELETE FROM article_purpose WHERE article_id = ?',
			$articleId
		);

		return true;
	}
        
	/**
	 * Check if an article details object exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articlePurposeExists($submissionId) {
		$result =& $this->retrieve('SELECT count(*) FROM article_purpose WHERE article_id = ?', (int) $submissionId);
		$returner = $result->fields[0]?true:false;
		$result->Close();
		return $returner;
	}
        
        /**
	 * Internal function to return a article purpose object from a row.
	 * @param $row array
	 * @return ArticlePurpose object
	 */
	function &_returnArticlePurposeFromRow(&$row) {
            
		$articlePurpose = new ArticlePurpose();
                
		$articlePurpose->setId($row['article_purpose_id']);
		$articlePurpose->setArticleId($row['article_id']);
		$articlePurpose->setType($row['type']);
		$articlePurpose->setCTPhase($row['ct_phase']);
		$articlePurpose->setAllocation($row['allocation']);
		$articlePurpose->setMasking($row['masking']);
		$articlePurpose->setControl($row['control']);
		$articlePurpose->setAssignment($row['assignment']);
		$articlePurpose->setEndpoint($row['endpoint']);
                        
		HookRegistry::call('ArticlePurposeDAO::_returnArticlePurposeFromRow', array(&$articlePurpose, &$row));

		return $articlePurpose;
	}
        
        
}

?>
