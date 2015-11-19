<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleDrugManufacturer.inc.php
 * 
 * 
 * @brief ArticleDrugManufacturer class.
 */


class ArticleDrugManufacturer extends DataObject {
	
	/**
	 * Constructor.
	 */
	function ArticleDrugManufacturer() {
            parent::DataObject();
	}

	
        /**
	 * Get drug id.
	 * @return int
	 */
	function getDrugId() {
		return $this->getData('drugId');
	}
	/**
	 * Set drug id.
	 * @param $drugId int
	 */
	function setDrugId($drugId) {
		return $this->setData('drugId', $drugId);
	}
        
        
        /**
	 * Get name of manufacturer.
	 * @return string
	 */
	function getName() {
		return $this->getData('name');
	}
	/**
	 * Set name of manufacturer.
	 * @param $name string
	 */
	function setName($name) {
		return $this->setData('name', $name);
	}
        
        
        /**
	 * Get address of the drug manufacturer.
	 * @return string
	 */
	function getAddress() {
		return $this->getData('address');
	}
	/**
	 * Set address of the drug manufacturer.
	 * @param $address string
	 */
	function setAddress($address) {
		return $this->setData('address', $address);
	}
}
?>
