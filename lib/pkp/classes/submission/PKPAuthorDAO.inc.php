<?php

/**
 * @file classes/submission/PKPAuthorDAO.inc.php
 *
 * Copyright (c) 2000-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPAuthorDAO
 * @ingroup site
 * @see PKPAuthor
 *
 * @brief Operations for retrieving and modifying PKPAuthor objects.
 */

// $Id$


import('lib.pkp.classes.submission.PKPAuthor');

class PKPAuthorDAO extends DAO {
	/**
	 * Constructor
	 */
	function PKPAuthorDAO() {
		parent::DAO();
	}

	/**
	 * Retrieve an author by ID.
	 * @param $authorId int
	 * @return Author
	 */
	function &getAuthor($authorId) {
		$result =& $this->retrieve(
			'SELECT * FROM authors WHERE author_id = ?',
			(int) $authorId
		);

		$returner = null;
		if ($result->RecordCount() != 0) {
			$returner =& $this->_returnAuthorFromRow($result->GetRowAssoc(false));
		}

		$result->Close();
		unset($result);

		return $returner;
	}

	/**
	 * Internal function to return an Author object from a row.
	 * @param $row array
	 * @return Author
	 */
	function &_returnAuthorFromRow(&$row) {
		$author = $this->newDataObject();
		$author->setId($row['author_id']);
		$author->setSiteId($row['site_id']);
		$author->setFirstName($row['first_name']);
		$author->setMiddleName($row['middle_name']);
		$author->setLastName($row['last_name']);
		$author->setAffiliation($row['affiliation']);
		$author->setEmail($row['email']);
		$author->setPrimaryPhoneNumber($row['phone']);
		$author->setPrimaryContact($row['primary_contact']);
		$author->setSequence($row['seq']);

		HookRegistry::call('AuthorDAO::_returnAuthorFromRow', array(&$author, &$row));
		return $author;
	}

	/**
	 * Internal function to return an Author object from a row. Simplified
	 * not to include object settings.
	 * @param $row array
	 * @return Author
	 */
	function &_returnSimpleAuthorFromRow(&$row) {
		$author = $this->newDataObject();
		$author->setId($row['author_id']);
		$author->setSiteId($row['site_id']);
		$author->setFirstName($row['first_name']);
		$author->setMiddleName($row['middle_name']);
		$author->setLastName($row['last_name']);
		$author->setAffiliation($row['affiliation']);
		$author->setEmail($row['email']);
		$author->setPrimaryPhoneNumber($row['phone']);
		$author->setPrimaryContact($row['primary_contact']);
		$author->setSequence($row['seq']);
		$author->setAffiliation($row['affiliation']);

		HookRegistry::call('AuthorDAO::_returnSimpleAuthorFromRow', array(&$author, &$row));
		return $author;
	}

	/**
	 * Get a new data object
	 * @return DataObject
	 */
	function newDataObject() {
		assert(false); // Should be overridden by child classes
	}

	/**
	 * Delete an Author.
	 * @param $author Author
	 */
	function deleteAuthor(&$author) {
		return $this->deleteAuthorById($author->getId());
	}

	/**
	 * Delete an author by ID.
	 * @param $authorId int
	 * @param $siteId int optional
	 */
	function deleteAuthorById($authorId, $siteId = null) {
		$params = array((int) $authorId);
		if ($siteId) $params[] = (int) $siteId;
		$returner = $this->update(
			'DELETE FROM authors WHERE author_id = ?' .
			($siteId?' AND site_id = ?':''),
			$params
		);
		return $returner;
	}

	/**
	 * Sequentially renumber a site's authors in their sequence order.
	 * @param $siteId int
	 */
	function resequenceAuthors($siteId) {
		$result =& $this->retrieve(
			'SELECT author_id FROM authors WHERE site_id = ? ORDER BY seq',
			(int) $siteId
		);

		for ($i=1; !$result->EOF; $i++) {
			list($authorId) = $result->fields;
			$this->update(
				'UPDATE authors SET seq = ? WHERE author_id = ?',
				array(
					$i,
					$authorId
				)
			);

			$result->moveNext();
		}

		$result->close();
		unset($result);
	}

	/**
	 * Remove other primary contacts from a site and set to authorId
	 * @param $authorId int
	 * @param $siteId int
	 */
	function resetPrimaryContact($authorId, $siteId) {
		$this->update(
			'UPDATE authors SET primary_contact = 0 WHERE primary_contact = 1 AND site_id = ?',
			(int) $siteId
		);
		$this->update(
			'UPDATE authors SET primary_contact = 1 WHERE author_id = ? AND site_id = ?',
			array((int) $authorId, (int) $siteId)
		);
	}

	/**
	 * Get the ID of the last inserted author.
	 * @return int
	 */
	function getInsertAuthorId() {
		return $this->getInsertId('authors', 'author_id');
	}
}

?>
