<?php

/**
 * @file classes/article/ArticleContactDAO.inc.php
 *
 * @class ArticleContactDAO
 *
 * @brief Operations for retrieving and modifying article contact objects.
 */

// $Id$

import('classes.article.ArticleContact');

class ArticleContactDAO extends DAO{
 
        /**
	 * Constructor.
	 */
	function ArticleContactDAO() {
		parent::DAO();
        }

        /**
	 * Get the article contact for a submission.
	 * @param $submissionId int
	 * @return articleContact object
	 */
	function &getArticleContactByArticleId($submissionId) {

		$result =& $this->retrieve(
			'SELECT * FROM article_contact WHERE article_id = ? LIMIT 1',
			(int) $submissionId
		);

		$articleContact =& $this->_returnArticleContactFromRow($result->GetRowAssoc(false));

                $result->Close();
		unset($result);

		return $articleContact;
	}

	/**
	 * Insert a new article contact.
	 * @param $articleContact object
	 */
	function insertArticleContact(&$articleContact) {
		$this->update(
			'INSERT INTO article_contact (
                                    article_id,
                                    pq_name, pq_affiliation, pq_address, pq_country, pq_phone, pq_fax, pq_email,
                                    sq_name, sq_affiliation, sq_address, sq_country, sq_phone, sq_fax, sq_email
                                    )
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleContact->getArticleId(),
				(string) $articleContact->getPQName(),
				(string) $articleContact->getPQAffiliation(),
				(string) $articleContact->getPQAddress(),
				(string) $articleContact->getPQCountry(),
				(string) $articleContact->getPQPhone(),
				(string) $articleContact->getPQFax(),
				(string) $articleContact->getPQEmail(),
				(string) $articleContact->getSQName(),
				(string) $articleContact->getSQAffiliation(),
				(string) $articleContact->getSQAddress(),
				(string) $articleContact->getSQCountry(),
				(string) $articleContact->getSQPhone(),
				(string) $articleContact->getSQFax(),
				(string) $articleContact->getSQEmail()
			)
		);
		
		return true;
	}

	/**
	 * Update an existing article contact object.
	 * @param $articleContact ArticleContact object
	 */
	function updateArticleContact(&$articleContact) {
		$returner = $this->update(
			'UPDATE article_contact
			SET	
                            pq_name = ?, 
                            pq_affiliation = ?,
                            pq_address = ?,
                            pq_country = ?, 
                            pq_phone = ?, 
                            pq_fax = ?,
                            pq_email = ?, 
                            sq_name = ?, 
                            sq_affiliation = ?,
                            sq_address = ?,
                            sq_country = ?, 
                            sq_phone = ?, 
                            sq_fax = ?,
                            sq_email = ? 
			WHERE	article_id = ?',
			array(
				(string) $articleContact->getPQName(),
				(string) $articleContact->getPQAffiliation(),
				(string) $articleContact->getPQAddress(),
				(string) $articleContact->getPQCountry(),
				(string) $articleContact->getPQPhone(),
				(string) $articleContact->getPQFax(),
				(string) $articleContact->getPQEmail(),
				(string) $articleContact->getSQName(),
				(string) $articleContact->getSQAffiliation(),
				(string) $articleContact->getSQAddress(),
				(string) $articleContact->getSQCountry(),
				(string) $articleContact->getSQPhone(),
				(string) $articleContact->getSQFax(),
				(string) $articleContact->getSQEmail(),
				(int) $articleContact->getArticleId()                            
			)
		);
                
		return true;
	}

	/**
	 * Delete a specific article contact by article ID
	 * @param $submissionId int
	 */
	function deleteArticleContact($submissionId) {
		$returner = $this->update(
			'DELETE FROM article_contact WHERE article_id = ?',
			$submissionId
		);

		return true;
	}

	/**
	 * Check if an article contact object exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articleContactExists($submissionId) {
		$result =& $this->retrieve('SELECT count(*) FROM article_contact WHERE article_id = ?', (int) $submissionId);
		$returner = $result->fields[0]?true:false;
		$result->Close();
		return $returner;
	}
        
        /**
	 * Internal function to return a article contact object from a row.
	 * @param $row array
	 * @return ArticleContact object
	 */
	function &_returnArticleContactFromRow(&$row) {
            
		$articleContact = new ArticleContact();
                
		$articleContact->setArticleId($row['article_id']);
		$articleContact->setPQName($row['pq_name']);
		$articleContact->setPQAffiliation($row['pq_affiliation']);
		$articleContact->setPQAddress($row['pq_address']);
		$articleContact->setPQCountry($row['pq_country']);
		$articleContact->setPQPhone($row['pq_phone']);
		$articleContact->setPQFax($row['pq_fax']);
		$articleContact->setPQEmail($row['pq_email']);
                $articleContact->setSQName($row['sq_name']);
		$articleContact->setSQAffiliation($row['sq_affiliation']);
		$articleContact->setSQAddress($row['sq_address']);
		$articleContact->setSQCountry($row['sq_country']);
		$articleContact->setSQPhone($row['sq_phone']);
		$articleContact->setSQFax($row['sq_fax']);
		$articleContact->setSQEmail($row['sq_email']);

		HookRegistry::call('ArticleContactDAO::_returnArticleContactFromRow', array(&$articleContact, &$row));

		return $articleContact;
	}        
}

?>
