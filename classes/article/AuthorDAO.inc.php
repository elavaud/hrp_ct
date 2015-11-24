<?php

/**
 * @file classes/article/AuthorDAO.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AuthorDAO
 * @ingroup article
 * @see Author
 *
 * @brief Operations for retrieving and modifying Author objects.
 */

// $Id$


import('classes.article.Author');
import('classes.article.Article');
import('lib.pkp.classes.submission.PKPAuthorDAO');

class AuthorDAO extends PKPAuthorDAO {
	/**
	 * Constructor
	 */
	function AuthorDAO() {
		parent::PKPAuthorDAO();
	}

	/**
	 * Retrieve all authors for a submission.
	 * @param $submissionId int
	 * @return array Authors ordered by sequence
	 */
	function &getAuthorsByArticle($submissionId) {
		$authors = array();

		$result =& $this->retrieve(
			'SELECT * FROM authors aa'
                        . 'LEFT JOIN article_site ars ON (aa.site_id = ars.site_id) '
                        . 'WHERE ars.article_id = ? ORDER BY seq',
			(int) $submissionId
		);

		while (!$result->EOF) {
			$authors[] =& $this->_returnAuthorFromRow($result->GetRowAssoc(false));
			$result->moveNext();
		}

		$result->Close();
		unset($result);

		return $authors;
	}

        
        /**
	 * Retrieve all authors for a particular site of a submission.
	 * @param $siteId int
	 * @return array Authors ordered by sequence
	 */
	function &getAuthorsByArticleSite($siteId) {
		$authors = array();

		$result =& $this->retrieve(
			'SELECT * FROM authors WHERE site_id = ? ORDER BY seq',
			(int) $siteId
		);

		while (!$result->EOF) {
			$authors[] =& $this->_returnAuthorFromRow($result->GetRowAssoc(false));
			$result->moveNext();
		}

		$result->Close();
		unset($result);

		return $authors;
	}

	/**
	 * Retrieve all published submissions associated with authors with
	 * the given first name, middle name, last name, affiliation.
	 * @param $journalId int (null if no restriction desired)
	 * @param $firstName string
	 * @param $middleName string
	 * @param $lastName string
	 * @param $affiliation string
	 */
	function &getPublishedArticlesForAuthor($journalId, $firstName, $middleName, $lastName, $affiliation) {
		$publishedArticles = array();
		$publishedArticleDao =& DAORegistry::getDAO('PublishedArticleDAO');
		$params = array(
			$firstName, $middleName, $lastName,
			$affiliation
		);
		if ($journalId !== null) $params[] = (int) $journalId;

		$result =& $this->retrieve(
			'SELECT DISTINCT
				ars.article_id
			FROM	authors aa
				LEFT JOIN article_site ars ON (ars.site_id = aa.site_id)
				LEFT JOIN articles a ON (ars.article_id = a.article_id)
			WHERE	aa.first_name = ?
				AND a.status = ' . STATUS_PUBLISHED . '
				AND (aa.middle_name = ?' . (empty($middleName)?' OR aa.middle_name IS NULL':'') . ')
				AND aa.last_name = ?
				AND (aa.affiliation = ?' . (empty($affiliation)?' OR aa.affiliation IS NULL':'') . ') ' .
				($journalId!==null?(' AND a.journal_id = ?'):''),
			$params
		);

		while (!$result->EOF) {
			$row =& $result->getRowAssoc(false);
			$publishedArticle =& $publishedArticleDao->getPublishedArticleByArticleId($row['article_id']);
			if ($publishedArticle) {
				$publishedArticles[] =& $publishedArticle;
			}
			$result->moveNext();
			unset($publishedArticle);
		}

		$result->Close();
		unset($result);

		return $publishedArticles;
	}

	/**
	 * Retrieve all published authors for a journal in an associative array by
	 * the first letter of the last name, for example:
	 * $returnedArray['S'] gives array($misterSmithObject, $misterSmytheObject, ...)
	 * Keys will appear in sorted order. Note that if journalId is null,
	 * alphabetized authors for all journals are returned.
	 * @param $journalId int
	 * @param $initial An initial the last names must begin with
	 * @param $rangeInfo Range information
	 * @param $includeEmail Whether or not to include the email in the select distinct
	 * @return array Authors ordered by sequence
	 */
	function &getAuthorsAlphabetizedByJournal($journalId = null, $initial = null, $rangeInfo = null, $includeEmail = false) {
		$authors = array();
		$params = array();

		if (isset($journalId)) $params[] = $journalId;
		if (isset($initial)) {
			$params[] = String::strtolower($initial) . '%';
			$initialSql = ' AND LOWER(aa.last_name) LIKE LOWER(?)';
		} else {
			$initialSql = '';
		}

		$result =& $this->retrieveRange(
			'SELECT DISTINCT
				0 AS author_id,
				0 AS site_id,
				' . ($includeEmail?'aa.email AS email,':'CAST(\'\' AS CHAR) AS email,') . '
				0 AS primary_contact,
				0 AS seq,
				aa.first_name,
				aa.middle_name,
				aa.last_name,
				aa.affiliation,
				aa.primary_phone,
                                aa.secondary_phone,
                                aa.fax
			FROM	authors aa
				LEFT JOIN article_site ars ON (ars.site_id = aa.site_id)
				LEFT JOIN articles a ON (a.article_id = ars.article_id)
				LEFT JOIN published_articles pa ON (pa.article_id = a.article_id)
				LEFT JOIN issues i ON (pa.issue_id = i.issue_id)
			WHERE	i.published = 1 AND
				ars.article_id = a.article_id AND ' .
				(isset($journalId)?'a.journal_id = ? AND ':'') . '
				pa.article_id = a.article_id AND
				a.status = ' . STATUS_PUBLISHED . ' AND
				(aa.last_name IS NOT NULL AND aa.last_name <> \'\')' .
				$initialSql . '
			ORDER BY aa.last_name, aa.first_name',
			$params,
			$rangeInfo
		);

		$returner = new DAOResultFactory($result, $this, '_returnSimpleAuthorFromRow');
		return $returner;
	}

	/**
	 * Get a new data object
	 * @return DataObject
	 */
	function newDataObject() {
		return new Author();
	}

	/**
	 * Insert a new Author.
	 * @param $author Author
	 */
	function insertAuthor(&$author) {
		$this->update(
			'INSERT INTO authors
				(site_id, first_name, middle_name, last_name, expertise, affiliation, email, primary_phone, secondary_phone, fax, primary_contact, seq)
				VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				$author->getSiteId(),
				$author->getFirstName(),
				$author->getMiddleName() . '', // make non-null
				$author->getLastName(),
				$author->getExpertise(),                            
				$author->getAffiliation(),
				$author->getEmail(),
				$author->getPrimaryPhoneNumber(),
				$author->getSecondaryPhoneNumber(),
				$author->getFaxNumber(),                            
				(int) $author->getPrimaryContact(),
				(float) $author->getSequence()
			)
		);

		$author->setId($this->getInsertAuthorId());
		return $author->getId();
	}

	/**
	 * Update an existing Author.
	 * @param $author Author
	 */
	function updateAuthor(&$author) {
		$returner = $this->update(
			'UPDATE authors
			SET	first_name = ?,
				middle_name = ?,
				last_name = ?,
				expertise = ?,
				affiliation = ?,
				email = ?,
				primary_phone = ?,
				secondary_phone = ?,
				fax = ?,
                                primary_contact = ?,
				seq = ?
			WHERE	author_id = ?',
			array(
				$author->getFirstName(),
				$author->getMiddleName() . '', // make non-null
				$author->getLastName(),
				$author->getExpertise(),                            
				$author->getAffiliation(),
				$author->getEmail(),
				$author->getPrimaryPhoneNumber(),
				$author->getSecondaryPhoneNumber(),
				$author->getFaxNumber(),
                            (int) $author->getPrimaryContact(),
				(float) $author->getSequence(),
				(int) $author->getId()
			)
		);
		return $returner;
	}

	/**
	 * Delete authors by submission.
	 * @param $submissionId int
	 */
	function deleteAuthorsByArticle($submissionId) {
		$authors =& $this->getAuthorsByArticle($submissionId);
		foreach ($authors as $author) {
			$this->deleteAuthor($author);
		}
	}

        /**
	 * Retrieve all authors for a journal in an associative array by
	 * the first letter of the last name, for example:
	 * $returnedArray['S'] gives array($misterSmithObject, $misterSmytheObject, ...)
	 * Keys will appear in sorted order. Note that if journalId is null,
	 * alphabetized authors for all journals are returned.
         * duplicates of email are suppressed
	 * @param $journalId int
	 * @param $initial An initial the last names must begin with
	 * @param $rangeInfo Range information
	 * @param $includeEmail Whether or not to include the email in the select distinct
	 * @return array Authors ordered by sequence
	 */
	function &getAuthorsAlphabetized($initial = null, $rangeInfo = null, $includeEmail = false) {
                
		$params = array();
                        
		if (isset($initial)) {
			$params[] = String::strtolower($initial) . '%';
			$initialSql = ' AND LOWER(aa.last_name) LIKE LOWER(?)';
		} else {
			$initialSql = '';
		}

		$result =& $this->retrieveRange(
			'SELECT aa.*
                        FROM	authors aa
				LEFT JOIN article_site ars ON (ars.site_id = aa.site_id)
				LEFT JOIN section_decisions sdec ON (ars.article_id = sdec.article_id)
			WHERE	sdec.review_type = 1 AND (sdec.decision = 1 
				OR sdec.decision = 6 
				OR sdec.decision = 9) AND 
				(aa.last_name IS NOT NULL AND aa.last_name <> \'\')' .
				$initialSql . '
                                GROUP BY aa.email
			ORDER BY aa.last_name, aa.first_name',
			$params,
			$rangeInfo
		);

		$returner = new DAOResultFactory($result, $this, '_returnSimpleAuthorFromRow');
		return $returner;
	}

	/**
	 * Retrieve all approved submissions associated with authors with
	 * the given email.
	 * @param $email string
	 */
	function &getArticlesForAuthor($email) {
		$articles = array();
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
                
		$result =& $this->retrieve(
			'SELECT DISTINCT
				ars.article_id
			FROM	authors aa
                                LEFT JOIN article_site ars ON (aa.site_id = ars.site_id)
				LEFT JOIN section_decisions sdec ON (ars.article_id = sdec.article_id)
			WHERE	sdec.review_type = 1 AND (sdec.decision = 1 
				OR sdec.decision = 6 
				OR sdec.decision = 9) AND
                                aa.email = ?',
			(string) $email
		);

		while (!$result->EOF) {
			$row =& $result->getRowAssoc(false);
			$article =& $articleDao->getArticle($row['article_id']);
			if ($article) {
				$articles[] =& $article;
			}
			$result->moveNext();
			unset($article);
		}

		$result->Close();
		unset($result);

		return $articles;
	}
        
        /**
         * Get authors by email
         * @param email
         */
        function getAuthorsByEmail($email){
                $authors = array();

		$result =& $this->retrieve(
			'SELECT *
			FROM	authors aa
                                LEFT JOIN article_site ars ON (aa.site_id = ars.site_id)
				LEFT JOIN section_decisions sdec ON (ars.article_id = sdec.article_id)
			WHERE	sdec.review_type = 1 AND (sdec.decision = 1 
				OR sdec.decision = 6 
				OR sdec.decision = 9) AND 
                                aa.email = ?', $email 
		);

		while (!$result->EOF) {
			$authors[] =& $this->_returnAuthorFromRow($result->GetRowAssoc(false));
			$result->moveNext();
		}
                
                return $authors;
        }
        
        
        /**
	 * Delete authors by site.
	 * @param $siteId int
	 */
	function deleteAuthorsBySite($siteId) {
		$params = array((int) $siteId);
		$returner = $this->update(
			'DELETE FROM authors WHERE site_id = ?',
			$params
		);
		return $returner;
	}

}

?>
