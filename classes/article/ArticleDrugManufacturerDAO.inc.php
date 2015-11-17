<?php

/**
 * @file classes/article/ArticleDrugManufacturerDAO.inc.php
 *
 * @class ArticleDrugManufacturerDAO
 *
 * @brief Operations for retrieving and modifying ArticleDrugManufacturer objects.
 */

import('classes.article.ArticleDrugManufacturer');

class ArticleDrugManufacturerDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleDrugManufacturerDAO() {
            parent::DAO();
	}
        
    	/**
	 * Get the article drug manufacturer object of a submission.
	 * @param $articleDrugManufacturerId int
	 * @return ArticleDrugManufacturer object
	 */
	function &getArticleDrugManufacturerById($articleDrugManufacturerId) {

		$result =& $this->retrieve('SELECT * FROM article_drug_manu_info WHERE drug_manu_id = ?', (int) $articleDrugManufacturerId);		

		$articleDrugManufacturer =& $this->_returnArticleDrugManufacturerFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleDrugManufacturer;
	}

        /**
	 * Get all article drug manufacturer objects of a drug.
	 * @param $drugId int
	 * @return array ArticleDrugManufacturer
	 */
	function &getArticleDrugManufacturersByDrugId($drugId) {
                $articleDrugManufacturers = array();
                
		$result =& $this->retrieve('SELECT * FROM article_drug_manu_info WHERE drug_id = ?', (int) $drugId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleDrugManufacturers[] =& $this->_returnArticleDrugManufacturerFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleDrugManufacturers;
	}


	/**
	 * Insert a new ArticleDrugManufacturer object.
	 * @param $articleDrugManufacturer ArticleDrugManufacturer
	 */
	function insertArticleDrugManufacturer(&$articleDrugManufacturer) {
		$this->update(
			'INSERT INTO article_drug_manu_info 
				(drug_id, name, address)
			VALUES
				(?, ?, ?)',
			array(
				(int) $articleDrugManufacturer->getDrugId(),
				$articleDrugManufacturer->getName(),
				$articleDrugManufacturer->getAddress()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleDrugManufacturer.
	 * @param $articleDrugManufacturer ArticleDrugManufacturer
	 */
	function updateArticleDrugManufacturer(&$articleDrugManufacturer) {
		$returner = $this->update(
			'UPDATE article_drug_manu_info
			SET	
				drug_id = ?,
				name = ?,
				address = ? 
			WHERE	drug_manu_id = ?',
			array(
				(int) $articleDrugManufacturer->getDrugId(),
                                $articleDrugManufacturer->getName(),
                                $articleDrugManufacturer->getAddress(),
                                $articleDrugManufacturer->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleDrugManufacturer by ID
	 * @param $articleDrugManufacturerId int
	 */
	function deleteArticleDrugManufacturer($articleDrugManufacturerId) {
		
		$returner = $this->update('DELETE FROM article_drug_manu_info WHERE drug_manu_id = ?',(int) $articleDrugManufacturerId);
		
		return $returner;
	}

        /**
	 * Delete articleDrugManufacturers by drug ID
	 * @param $drugId int
	 */
	function deleteArticleDrugManufacturersByDrugId($drugId) {
		
		$returner = $this->update('DELETE FROM article_drug_manu_info WHERE drug_id = ?',(int) $drugId);
		
		return $returner;
	}
              
	/**
	 * Internal function to return an articleDrugManufacturer object from a row.
	 * @param $row array
	 * @return articleDrugManufacturer ArticleDrugManufacturer
	 */
	function &_returnArticleDrugManufacturerFromRow(&$row) {
		$articleDrugManufacturer = new ArticleDrugManufacturer();
		$articleDrugManufacturer->setId($row['drug_manu_id']);
		$articleDrugManufacturer->setDrugId($row['drug_id']);
                $articleDrugManufacturer->setName($row['name']);
                $articleDrugManufacturer->setAddress($row['address']);
                
		HookRegistry::call('ArticleDrugManufacturerDAO::_returnArticleDrugManufacturerFromRow', array(&$articleDrugManufacturer, &$row));

		return $articleDrugManufacturer;
	}
}

?>
