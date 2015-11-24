<?php

/**
 * @file classes/article/ArticleSponsorDAO.inc.php
 *
 * @class ArticleSponsorDAO
 *
 * @brief Operations for retrieving and modifying ArticleSponsor objects.
 */

import('classes.article.ArticleSponsor');

class ArticleSponsorDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleSponsorDAO() {
            parent::DAO();
	}
        
    	/**
	 * Get the article secondary ID object of a submission.
	 * @param $articleSponsorId int
	 * @return ArticleSponsor object
	 */
	function &getArticleSponsorById($articleSponsorId) {

		$result =& $this->retrieve('SELECT * FROM article_sponsor WHERE article_sponsor_id = ?', (int) $articleSponsorId);		

		$articleSponsor =& $this->_returnArticleSponsorFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleSponsor;
	}

        /**
	 * Get all article secondary ID objects of a submission.
	 * @param $articleId int
	 * @return array ArticleSponsor
	 */
	function &getArticleSponsorsByArticleId($articleId, $type = null) {
                $articleSponsors = array();
                
                if ($type) $result =& $this->retrieve('SELECT * FROM article_sponsor WHERE article_id = '. $articleId . ' AND type = '. $type);
                else $result =& $this->retrieve('SELECT * FROM article_sponsor WHERE article_id = '. $articleId);

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleSponsors[] =& $this->_returnArticleSponsorFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleSponsors;
	}


	/**
	 * Insert a new ArticleSponsor object.
	 * @param $articleSponsor ArticleSponsor
	 */
	function insertArticleSponsor(&$articleSponsor) {
		$this->update(
			'INSERT INTO article_sponsor 
				(article_id, type, institution_id)
			VALUES
				(?, ?, ?)',
			array(
				(int) $articleSponsor->getArticleId(),
				$articleSponsor->getType(),
				$articleSponsor->getInstitutionId()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleSponsor.
	 * @param $articleSponsor ArticleSponsor
	 */
	function updateArticleSponsor(&$articleSponsor) {
		$returner = $this->update(
			'UPDATE article_sponsor
			SET	
				article_id = ?,
				type = ?,
				institution_id = ? 
			WHERE	article_sponsor_id = ?',
			array(
				(int) $articleSponsor->getArticleId(),
                                $articleSponsor->getType(),
                                $articleSponsor->getInstitutionId(),
                                $articleSponsor->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleSponsor by ID
	 * @param $articleSponsorId int
	 */
	function deleteArticleSponsor($articleSponsorId) {
		
		$returner = $this->update('DELETE FROM article_sponsor WHERE article_sponsor_id = ?',(int) $articleSponsorId);
		
		return $returner;
	}

        /**
	 * Delete articleSponsors by article ID
	 * @param $articleId int
	 */
	function deleteArticleSponsorsByArticleId($articleId) {
		
		$returner = $this->update('DELETE FROM article_sponsor WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Internal function to return an articleSponsor object from a row.
	 * @param $row array
	 * @return articleSponsor ArticleSponsor
	 */
	function &_returnArticleSponsorFromRow(&$row) {
		$articleSponsor = new ArticleSponsor();
		$articleSponsor->setId($row['article_sponsor_id']);
		$articleSponsor->setArticleId($row['article_id']);
                $articleSponsor->setType($row['type']);
                $articleSponsor->setInstitutionId($row['institution_id']);
                
		HookRegistry::call('ArticleSponsorDAO::_returnArticleSponsorFromRow', array(&$articleSponsor, &$row));

		return $articleSponsor;
	}
        
}

?>
