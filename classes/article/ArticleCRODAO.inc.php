<?php

/**
 * @file classes/article/ArticleCRODAO.inc.php
 *
 * @class ArticleCRODAO
 *
 * @brief Operations for retrieving and modifying ArticleCRO objects.
 */

import('classes.article.ArticleCRO');

class ArticleCRODAO extends DAO {
    
        /**
	 * Constructor
	 */
	function ArticleCRODAO() {
            parent::DAO();
	}
        
    	/**
	 * Get the article cro object of a submission.
	 * @param $articleCROId int
	 * @return ArticleCRO object
	 */
	function &getArticleCROById($articleCROId) {

		$result =& $this->retrieve('SELECT * FROM article_cro WHERE article_cro_id = ?', (int) $articleCROId);		

		$articleCRO =& $this->_returnArticleCROFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleCRO;
	}

        /**
	 * Get all article cro objects of a submission.
	 * @param $articleId int
	 * @return array ArticleCRO
	 */
	function &getArticleCROsByArticleId($articleId) {
                $articleCROs = array();
                
		$result =& $this->retrieve('SELECT * FROM article_cro WHERE article_id = ?', (int) $articleId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleCROs[] =& $this->_returnArticleCROFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleCROs;
	}


	/**
	 * Insert a new ArticleCRO object.
	 * @param $articleCRO ArticleCRO
	 */
	function insertArticleCRO(&$articleCRO) {
		$this->update(
			'INSERT INTO article_cro 
				(article_id, name, international, region_country, city, address, primary_phone, secondary_phone, fax, email)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleCRO->getArticleId(),
				(string) $articleCRO->getName(),
				(int) $articleCRO->getInternational(),
                                (string) $articleCRO->getCROLocation(),
                                (string) $articleCRO->getCity(),
                                (string) $articleCRO->getAddress(),
				(string) $articleCRO->getPrimaryPhone(),
				(string) $articleCRO->getSecondaryPhone(),
				(string) $articleCRO->getFax(),
				(string) $articleCRO->getEmail()
			)
		);	
                
                $articleCRO->setId($this->getInsertCROId());
                                
		return $articleCRO->getId();                
	}

	/**
	 * Update an existing ArticleCRO.
	 * @param $articleCRO ArticleCRO
	 */
	function updateArticleCRO(&$articleCRO) {
		$returner = $this->update(
			'UPDATE article_cro
			SET	
				article_id = ?,
				name = ?,
				international = ?,
                                region_country = ?,
                                city = ?,
                                address = ?,
				primary_phone = ? ,
				secondary_phone = ? ,
				fax = ? ,
				email = ? 
			WHERE	article_cro_id = ?',
			array(
				(int) $articleCRO->getArticleId(),
				(string) $articleCRO->getName(),
				(int) $articleCRO->getInternational(),
                                (string) $articleCRO->getCROLocation(),
                                (string) $articleCRO->getCity(),
                                (string) $articleCRO->getAddress(),
				(string) $articleCRO->getPrimaryPhone(),
				(string) $articleCRO->getSecondaryPhone(),
				(string) $articleCRO->getFax(),
				(string) $articleCRO->getEmail(),
                                (int) $articleCRO->getId()
			)
		);
                                
		return $returner;
	}

	/**
	 * Delete a specific articleCRO by ID
	 * @param $articleCROId int
	 */
	function deleteArticleCRO($articleCROId) {
		                
		$returner = $this->update('DELETE FROM article_cro WHERE article_cro_id = ?',(int) $articleCROId);
		
		return $returner;
	}

        /**
	 * Delete articleCROs by article ID
	 * @param $articleId int
	 */
	function deleteArticleCROsByArticleId($articleId) {
		                
		$returner = $this->update('DELETE FROM article_cro WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Internal function to return an articleCRO object from a row.
	 * @param $row array
	 * @return articleCRO ArticleCRO
	 */
	function &_returnArticleCROFromRow(&$row) {
		$articleCRO = new ArticleCRO();
		$articleCRO->setId($row['article_cro_id']);
		$articleCRO->setArticleId($row['article_id']);
                $articleCRO->setName($row['name']);
                $articleCRO->setInternational($row['international']);
                $articleCRO->setCROLocation($row['region_country']);
                $articleCRO->setCity($row['city']);
                $articleCRO->setAddress($row['address']);
                $articleCRO->setPrimaryPhone($row['primary_phone']);
                $articleCRO->setSecondaryPhone($row['secondary_phone']);
                $articleCRO->setFax($row['fax']);
                $articleCRO->setEmail($row['email']);
                                
		HookRegistry::call('ArticleCRODAO::_returnArticleCROFromRow', array(&$articleCRO, &$row));

		return $articleCRO;
	}
        
        
	/**
	 * Get the ID of the last inserted article cro.
	 * @return int
	 */
	function getInsertCROId() {
		return $this->getInsertId('article_cro', 'article_cro_id');
	}
}

?>
