<?php

/**
 * @file classes/article/ArticleDetailsDAO.inc.php
 *
 * @class ArticleDetailsDAO
 *
 * @brief Operations for retrieving and modifying article details objects.
 */

// $Id$

import('classes.article.ArticleDetails');

class ArticleDetailsDAO extends DAO{
 
        /**
	 * Constructor.
	 */
	function ArticleDetailsDAO() {
		parent::DAO();
        }

        /**
	 * Get the article details for a submission.
	 * @param $submissionId int
	 * @return articleDetails object
	 */
	function &getArticleDetailsByArticleId($submissionId) {

		$result =& $this->retrieve(
			'SELECT * FROM article_details WHERE submission_id = ? LIMIT 1',
			(int) $submissionId
		);

		$articleDetails =& $this->_returnArticleDetailsFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleDetails;
	}

	/**
	 * Insert a new article details.
	 * @param $articleDetails object
	 */
	function insertArticleDetails(&$articleDetails) {
		$this->update(
                        sprintf(
			'INSERT INTO article_details (
                                    article_id, protocol_version, therapeutic_area, healthcond_disease, min_age_num, min_age_unit, max_age_num,
                                    max_age_unit, sex, healthy, local_sample_size, multinational, international_sample_size, enrolment_start_date,
                                    enrolment_end_date, recruitment_status, advertising_scheme)
				VALUES(
                                    ?, ?, ?, ?, ?, ?, ?, 
                                    ?, ?, ?, ?, ?, ?, %s, 
                                    %s, ?, ?)',
                        $this->dateToDB(strtotime($articleDetails->getStartDate())), $this->dateToDB(strtotime($articleDetails->getEndDate()))),
			array(
				(int) $articleDetails->getArticleId(),
				(string) $articleDetails->getProtocolVersion(),
				(string) $articleDetails->getTherapeuticArea(),
				(string) $articleDetails->getHealthCondDisease(),
				(int) $articleDetails->getMinAgeNum(),
				(int) $articleDetails->getMinAgeUnit(),
				(int) $articleDetails->getMaxAgeNum(),
				(int) $articleDetails->getMaxAgeUnit(),
                                (int) $articleDetails->getSex(),
				(int) $articleDetails->getHealthy(),
				(int) $articleDetails->getLocalSampleSize(),
				(int) $articleDetails->getMultinational(),
				(string) $articleDetails->getIntSampleSize(),
				(int) $articleDetails->getRecruitmentStatus(),
				(int) $articleDetails->getAdvertisingScheme()                            
			)
		);
		
		return true;
	}

	/**
	 * Update an existing article details object.
	 * @param $articleDetails ArticleDetails object
	 */
	function updateArticleDetails(&$articleDetails) {
		$returner = $this->update(sprintf(
			'UPDATE article_details
			SET	
                        
                                protocol_version = ?, 
                                therapeutic_area = ?,
                                healthcond_disease = ?,
                                min_age_num = ?, 
                                min_age_unit = ?, 
                                max_age_num = ?,
                                max_age_unit = ?, 
                                sex = ?, 
                                healthy = ?, 
                                local_sample_size = ?, 
                                multinational = ?, 
                                international_sample_size = ?, 
                                enrolment_start_date = %s,
                                enrolment_end_date = %s, 
                                recruitment_status = ?, 
                                advertising_scheme = ?
			WHERE	article_id = ?',
                        $this->datetimeToDB(strtotime($articleDetails->getStartDate())), 
                        $this->datetimeToDB(strtotime($articleDetails->getEndDate()))),
			array(
				(string) $articleDetails->getProtocolVersion(),
				(string) $articleDetails->getTherapeuticArea(),
				(string) $articleDetails->getHealthCondDisease(),
				(int) $articleDetails->getMinAgeNum(),
				(int) $articleDetails->getMinAgeUnit(),
				(int) $articleDetails->getMaxAgeNum(),
				(int) $articleDetails->getMaxAgeUnit(),
                                (int) $articleDetails->getSex(),
				(int) $articleDetails->getHealthy(),
				(int) $articleDetails->getLocalSampleSize(),
				(int) $articleDetails->getMultinational(),
				(string) $articleDetails->getIntSampleSize(),
				(int) $articleDetails->getRecruitmentStatus(),
				(int) $articleDetails->getAdvertisingScheme()                            
			)
		);
                
		return true;
	}

	/**
	 * Delete a specific article details by article ID
	 * @param $submissionId int
	 */
	function deleteArticleDetails($submissionId) {
		$returner = $this->update(
			'DELETE FROM article_details WHERE article_id = ?',
			$submissionId
		);

		return true;
	}

	/**
	 * Check if an article details object exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articleDetailsExists($submissionId) {
		$result =& $this->retrieve('SELECT count(*) FROM article_details WHERE article_id = ?', (int) $submissionId);
		$returner = $result->fields[0]?true:false;
		$result->Close();
		return $returner;
	}
        
        /**
	 * Internal function to return a article details object from a row.
	 * @param $row array
	 * @return ArticleDetails object
	 */
	function &_returnArticleDetailsFromRow(&$row) {
            
		$articleDetails = new ArticleDetails();
                
		$articleDetails->setArticleId($row['article_id']);

		$articleDetails->getProtocolVersion($row['protocol_version']);
		$articleDetails->getTherapeuticArea($row['therapeutic_area']);
		$articleDetails->getHealthCondDisease($row['healthcond_disease']);
		$articleDetails->getMinAgeNum($row['min_age_num']);
		$articleDetails->getMinAgeUnit($row['min_age_unit']);
		$articleDetails->getMaxAgeNum($row['max_age_num']);
		$articleDetails->getMaxAgeUnit($row['max_age_unit']);
		$articleDetails->getSex($row['sex']);
		$articleDetails->getHealthy($row['healthy']);
		$articleDetails->getLocalSampleSize($row['local_sample_size']);
		$articleDetails->getMultinational($row['multinational']);
		$articleDetails->getIntSampleSize($row['international_sample_size']);
                if(isset($row['enrolment_start_date']))$articleDetails->setStartDate(date("d-M-Y", strtotime($this->dateFromDB($row['enrolment_start_date']))));
		if(isset($row['enrolment_end_date']))$articleDetails->setEndDate(date("d-M-Y", strtotime($this->dateFromDB($row['enrolment_end_date']))));                
		$articleDetails->getRecruitmentStatus($row['recruitment_status']);
		$articleDetails->getAdvertisingScheme($row['advertising_scheme']);
                        
		HookRegistry::call('ArticleDetailsDAO::_returnArticleDetailsFromRow', array(&$articleDetails, &$row));

		return $articleDetails;
	}
        
        function getYesNoArray() {
            return array(
                PROPOSAL_DETAIL_YES => Locale::translate("common.yes"),
                PROPOSAL_DETAIL_NO => Locale::translate("common.no")
            );
        }
        
        /*
         * Get all the article details using a specific extra field
         */
        function getExtraFields($type, $extraFieldId) {
            $articleDetails = array();
            switch ($type) {
                case 'geoAreas':
                    $result = $this->retrieve('SELECT * FROM article_details WHERE '
                            . 'geo_areas LIKE "'.$extraFieldId.'" OR '
                            . 'geo_areas LIKE "'.$extraFieldId.',%" OR '
                            . 'geo_areas LIKE "%,'.$extraFieldId.',%" OR '
                            . 'geo_areas LIKE "%,'.$extraFieldId.'"');
                    break;
            }            
            while (!$result->EOF) {
                    $row = $result->GetRowAssoc(false);
                    $articleDetails[] =& $this->_returnArticleDetailsFromRow($row);
                    $result->moveNext();
            }

            $result->Close();
            unset($result);
            return $articleDetails;
        }
        
        
        ////////////////////////////
        ////////// ICD 10 //////////
        ////////////////////////////
        
        function getICD10Filename($locale = null) {
		if ($locale === null) $locale = Locale::getLocale();
		return "locale/$locale/ICD10.xml";
	}
	function &_getICD10Cache($locale = null) {
		$caches =& Registry::get('allICD10s', true, array());
		if (!isset($locale)) $locale = Locale::getLocale();                
		if (!isset($caches[$locale])) {
			$cacheManager =& CacheManager::getManager();
			$caches[$locale] = $cacheManager->getFileCache(
				'ICD10', $locale,
				array(&$this, '_countryCacheMiss')
			);
			// Check to see if the data is outdated
			$cacheTime = $caches[$locale]->getCacheTime();
			if ($cacheTime !== null && $cacheTime < filemtime($this->getFilename())) {
				$caches[$locale]->flush();
			}
		}
		return $caches[$locale];
	}
	function _ICD10CacheMiss(&$cache, $id) {
		$ICD10s =& Registry::get('allICD10sData', true, array());
                
		if (!isset($ICD10s[$id])) {
			// Reload country registry file
			$xmlDao = new XMLDAO();
			$data = $xmlDao->parseStruct($this->getFilename(), array('ICD10s', 'ICD10'));

                        if (isset($data['ICD10s'])) {
				foreach ($data['ICD10'] as $ICD10Data) {
					$ICD10s[$id][$ICD10Data['attributes']['code']] = $ICD10Data['attributes']['name'];
				}
			}
			asort($ICD10s[$id]);
                        $cache->setEntireCache($ICD10s[$id]);
		}
		return null;
	}
	/**
	 * Return a list of all ICD10s.
	 * @param $locale string Name of locale (optional)
	 * @return array
	 */
	function &getICD10s($locale = null) {
		$cache =& $this->_getICD10Cache($locale);
                return $cache->getContents();
	}
	/**
	 * Return a translated ICD10 name, given a code.
	 * @param $locale string Name of locale (optional)
	 * @return array
	 */
	function getICD10($code, $locale = null) {
		$cache =& $this->_getICD10Cache($locale);
                $ICD10s = explode(",", $code);
                $ICD10sText = "";
                foreach($ICD10s as $i => $ICD10) {
                    $ICD10sText = $ICD10sText . $cache->get(trim($ICD10));
                    if($i < count($ICD10s)-1) $ICD10sText = $ICD10sText . ", ";
                }
		return $ICD10sText;
	}
        
}

?>
