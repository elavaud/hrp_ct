<?php

/**
 * @file classes/article/ArticleSecIdDAO.inc.php
 *
 * @class ArticleSecIdDAO
 *
 * @brief Operations for retrieving and modifying ArticleSecId objects.
 */

import('classes.article.ArticleSecId');

class ArticleSecIdDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleSecIdDAO() {
	}
        
    	/**
	 * Get the article secondary ID object of a submission.
	 * @param $articleSecIdId int
	 * @return ArticleSecId object
	 */
	function &getArticleSecIdById($articleSecIdId) {

		$result =& $this->retrieve('SELECT * FROM article_sec_id WHERE article_sec_id_id = ?', (int) $articleSecIdId);		

		$articleSecId =& $this->_returnArticleSecIdFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleSecId;
	}

        /**
	 * Get all article secondary ID objects of a submission.
	 * @param $articleId int
	 * @return array ArticleSecId
	 */
	function &getArticleSecIdsByArticleId($articleId) {
                $articleSecIds = array();
                
		$result =& $this->retrieve('SELECT * FROM article_sec_id WHERE article_id = ?', (int) $articleId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleSecIds[$row['locale']] =& $this->_returnArticleSecIdFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleSecIds;
	}


	/**
	 * Insert a new ArticleSecId object.
	 * @param $articleSecId ArticleSecId
	 */
	function insertArticleSecId(&$articleSecId) {
		$this->update(
			'INSERT INTO article_sec_id 
				(article_id, type, sec_id)
			VALUES
				(?, ?, ?)',
			array(
				(int) $articleSecId->getArticleId(),
				$articleSecId->getType(),
				$articleSecId->getSecId()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleSecId.
	 * @param $articleSecId ArticleSecId
	 */
	function updateArticleSecId(&$articleSecId) {
		$returner = $this->update(
			'UPDATE article_sec_id
			SET	
				article_id = ?,
				type = ?,
				sec_id = ? 
			WHERE	article_sec_id_id = ?',
			array(
				(int) $articleSecId->getArticleId(),
                                $articleSecId->getType(),
                                $articleSecId->getSecId(),
                                $articleSecId->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleSecId by ID
	 * @param $articleSecIdId int
	 */
	function deleteArticleSecId($articleSecIdId) {
		
		$returner = $this->update('DELETE FROM article_sec_id WHERE article_sec_id_id = ?',(int) $articleSecIdId);
		
		return $returner;
	}

        /**
	 * Delete articleSecIds by article ID
	 * @param $articleId int
	 */
	function deleteArticleSecIdsByArticleId($articleId) {
		
		$returner = $this->update('DELETE FROM article_sec_id WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Check if an articleSecId exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articleSecIdExists($submissionId) {
		
		$result =& $this->retrieve('SELECT count(*) FROM article_sec_id WHERE article_id = ?', (int) $submissionId);
		
		$returner = $result->fields[0]?true:false;
		$result->Close();
		
		return $returner;
	}

	/**
	 * Internal function to return an articleSecId object from a row.
	 * @param $row array
	 * @return articleSecId ArticleSecId
	 */
	function &_returnArticleSecIdFromRow(&$row) {
		$articleSecId = new ArticleSecId();
		$articleSecId->setId($row['article_sec_id_id']);
		$articleSecId->setArticleId($row['article_id']);
                $articleSecId->setType($row['type']);
                $articleSecId->setSecId($row['sec_id']);
                
		HookRegistry::call('ArticleSecIdDAO::_returnArticleSecIdFromRow', array(&$articleSecId, &$row));

		return $articleSecId;
	}
}

?>
