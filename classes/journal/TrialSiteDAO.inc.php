<?php

/**
 * @file classes/journal/TrialSiteDAO.inc.php
 *
 *
 * @class TrialSiteDAO
 * @ingroup journal
 *
 * @brief Class for trial sites data access
 */

// $Id$

import ('classes.journal.TrialSite');

class TrialSiteDAO extends DAO {

	/*
	 *Returns all trial sites in the database
	 * 
         */
	function &getAllTrialSites($sortBy, $sortDirection, $rangeInfo = null) {

		$params = array();
		$sql = 'SELECT * FROM trial_site';
		
		$result =& $this->retrieveRange(
			$sql.($sortBy?(' ORDER BY ' . $this->getSortMapping($sortBy) . ' ' . $this->getDirectionMapping($sortDirection)) : ''),
				count($params)===1?array_shift($params):$params,
				$rangeInfo);

		$trialSite = new DAOResultFactory($result, $this, '_returnTrialSiteFromRow');
		return $trialSite;
	}
        
        
        /*
	 *Returns an array of the trial site's IDs and names
	 * 
         */
	function &getTrialSitesList() {
		$trialSites = array();

		$result =& $this->retrieve(
			'SELECT * FROM trial_site ORDER BY name'
		);

		while (!$result->EOF) {
                        $row = $result->GetRowAssoc(false);
			$trialSites = $trialSites + array($row['site_id'] => $row['name']);
			$result->moveNext();
		}

		$result->Close();
		unset($result);

		return $trialSites;
	}
        
	
	function getSortMapping($heading) {
		switch ($heading) {
			case 'name': return 'name';
			case 'region': return 'region';
			case 'city': return 'city';
                        default: return 'name';
		}
	}

	/*
	 * Return trialSite object using its ID
	 */
	function getTrialSiteById($trialSiteId){
		$result =& $this->retrieve(
			"SELECT * FROM trial_site WHERE site_id = ".$trialSiteId
		);
		$trialSite = $this->_returnTrialSiteFromRow($result->GetRowAssoc(false));
		
		return $trialSite;
	}

	function insertTrialSite(&$trialSite){
            $this->update(
			'INSERT INTO trial_site
				(name, region, city, address, doh_licensure_number, philhealth_accreditation_number)
				VALUES
				(?,?,?,?,?, ?)',
			array(
				(string) $trialSite->getName(),
				(int) $trialSite->getRegion(),
				(string) $trialSite->getCity(),
				(string) $trialSite->getAddress(),
				(string) $trialSite->getLicensure(),
				(string) $trialSite->getAccreditation()                            
                        )
		);
		$trialSite->setId($this->getInsertTrialSiteId());
		return $trialSite->getId();
        }
	
	function deleteTrialSiteById($trialSiteId) {
		return $this->update('DELETE FROM trial_site WHERE site_id = ?', array($trialSiteId));
	}
	
	function updateTrialSite(&$trialSite){

		return $this->update(
			'UPDATE trial_site
				SET
					name = ?,
                                        region = ?,
					city = ?,
					address = ?,
                                        doh_licensure_number = ?,
                                        philhealth_accreditation_number = ?
				WHERE site_id = ?',
			array(
				(string) $trialSite->getName(),
				(int) $trialSite->getRegion(),
				(string) $trialSite->getCity(),
				(string) $trialSite->getAddress(),
				(string) $trialSite->getLicensure(),
				(string) $trialSite->getAccreditation(),
				(int) $trialSite->getId()                            
			)
		);
	}
        
	/**
	 * Internal function to return a TrialSite object from a row.
	 * @param $row array
	 * @return Section
	 */
	function &_returnTrialSiteFromRow(&$row) {
		$trialSite = new TrialSite();
		$trialSite->setId($row['site_id']);
		$trialSite->setName($row['name']);
		$trialSite->setRegion($row['region']);
		$trialSite->setCity($row['city']);
		$trialSite->setAddress($row['address']);
		$trialSite->setLicensure($row['doh_licensure_number']);
		$trialSite->setAccreditation($row['philhealth_accreditation_number']);

		HookRegistry::call('TrialSiteDAO::_returnTrialSiteFromRow', array(&$trialSite, &$row));

		return $trialSite;
	}        
                
        /**
	 * Check if a trial site exists with the specified name.
	 * @param $name string
	 * @param $trialSiteId int optional, ignore matches with this trialSite ID
	 * @return boolean
	 */
	function trialSiteExistsByName($name, $trialSiteId = null) {
		$result =& $this->retrieve(
			'SELECT COUNT(*) FROM trial_site WHERE name = ?' . (isset($trialSiteId) ? ' AND site_id != ?' : ''),
			isset($trialSiteId) ? array($name, (int) $trialSiteId) : array($name)
		);
		$returner = isset($result->fields[0]) && $result->fields[0] == 1 ? true : false;

		$result->Close();
		unset($result);
		return $returner;
	}
                
        
        /**
	 * Get the ID of the last inserted trialSite.
	 * @return int
	 */
	function getInsertTrialSiteId() {
		return $this->getInsertId('trial_site', 'site_id');
	}        
        
        
        /**
         * Get a random ID of an trialSite
         * @return int
         */
        function getRandomTrialSiteId(){
                $result = $this->retrieve('SELECT `site_id` FROM `trial_site` ORDER BY RAND() LIMIT 0,1;');
                $row = $result->GetRowAssoc(false);
                return $row['site_id'];
        }
        
}

?>