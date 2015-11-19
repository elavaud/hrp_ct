<?php

/**
 * @file classes/journal/TrialSite.inc.php
 *
 * @class TrialSite
 * @ingroup journal
 * @see TrialSIteDAO
 *
 * @brief Describes trial site's properties.
 */


class TrialSite extends DataObject {

	/**
	 * Constructor.
	 */
	function TrialSite() {
		parent::DataObject();
	}

        //
	// Get/set methods
	//

	/**
	 * Get trial site name.
	 * @return string
	 */
	function getName() {
		return $this->getData('name');
	} 
	/**
	 * Set trial site name.
	 * @param $name string
	 */
	function setName($name) {
		return $this->setData('name', $name);
	}
        
        
        /**
	 * Get trial site region.
	 * @return int
	 */
	function getRegion() {
		return $this->getData('region');
	} 
	/**
	 * Set trial site region.
	 * @param $region int
	 */
	function setRegion($region) {
		return $this->setData('region', $region);
	}
        
        
        /**
	 * Get trial site city.
	 * @return string
	 */
	function getCity() {
		return $this->getData('city');
	} 
	/**
	 * Set trial site city.
	 * @param $city string
	 */
	function setCity($city) {
		return $this->setData('city', $city);
	}
        
        
        /**
	 * Get trial site address.
	 * @return string
	 */
	function getAddress() {
		return $this->getData('address');
	} 
	/**
	 * Set trial site address.
	 * @param $address string
	 */
	function setAddress($address) {
		return $this->setData('address', $address);
	}
        
        
        /**
	 * Get trial site DOH licensure number.
	 * @return string
	 */
	function getLicensure() {
		return $this->getData('licensure');
	} 
	/**
	 * Set trial site DOH licensure number.
	 * @param $licensure string
	 */
	function setLicensure($licensure) {
		return $this->setData('licensure', $licensure);
	}
        
        
        /**
	 * Get trial site philhealth accreditation number.
	 * @return string
	 */
	function getAccreditation() {
		return $this->getData('accreditation');
	} 
	/**
	 * Set trial site philhealth accreditation number.
	 * @param $accreditation string
	 */
	function setAccreditation($accreditation) {
		return $this->setData('accreditation', $accreditation);
	}
}

?>