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
			'SELECT * FROM article_details WHERE article_id = ? LIMIT 1',
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
                                    enrolment_end_date, recruitment_status, advertising_scheme, cro, compensation_policy)
				VALUES(
                                    ?, ?, ?, ?, ?, ?, ?, 
                                    ?, ?, ?, ?, ?, ?, %s, 
                                    %s, ?, ?, ?, ?)',
                        $this->dateToDB(strtotime($articleDetails->getStartDateForDB())), $this->dateToDB(strtotime($articleDetails->getEndDateForDB()))),
			array(
				(int) $articleDetails->getArticleId(),
				(string) $articleDetails->getProtocolVersion(),
				(string) $articleDetails->getRightTherapeuticAreaInsert(),
				(string) $articleDetails->getHealthCondDisease(),
				(int) $articleDetails->getMinAgeNum(),
				(int) $articleDetails->getMinAgeUnit(),
				(int) $articleDetails->getMaxAgeNum(),
				(int) $articleDetails->getMaxAgeUnit(),
                                (int) $articleDetails->getSex(),
				(int) $articleDetails->getHealthy(),
				(int) $articleDetails->getLocaleSampleSize(),
				(int) $articleDetails->getMultinational(),
				(string) $articleDetails->getIntSampleSize(),
				(int) $articleDetails->getRecruitmentStatus(),
				(int) $articleDetails->getAdvertisingScheme(),
				(int) $articleDetails->getCROInvolved(),
				(int) $articleDetails->getCompensationPolicy()                            
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
                                advertising_scheme = ?,
                                cro = ?,
                                compensation_policy = ?
			WHERE	article_id = ?',
                        $this->datetimeToDB(strtotime($articleDetails->getStartDateForDB())), 
                        $this->datetimeToDB(strtotime($articleDetails->getEndDateForDB()))),
			array(
				(string) $articleDetails->getProtocolVersion(),
				(string) $articleDetails->getRightTherapeuticAreaInsert(),
				(string) $articleDetails->getHealthCondDisease(),
				(int) $articleDetails->getMinAgeNum(),
				(int) $articleDetails->getMinAgeUnit(),
				(int) $articleDetails->getMaxAgeNum(),
				(int) $articleDetails->getMaxAgeUnit(),
                                (int) $articleDetails->getSex(),
				(int) $articleDetails->getHealthy(),
				(int) $articleDetails->getLocaleSampleSize(),
				(int) $articleDetails->getMultinational(),
				(string) $articleDetails->getIntSampleSize(),
				(int) $articleDetails->getRecruitmentStatus(),
				(int) $articleDetails->getAdvertisingScheme(),
				(int) $articleDetails->getCROInvolved(),
				(int) $articleDetails->getCompensationPolicy(),                            
				(int) $articleDetails->getArticleId()                            
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

		$articleDetails->setProtocolVersion($row['protocol_version']);
		$articleDetails->setTherapeuticArea($row['therapeutic_area']);
		$articleDetails->setHealthCondDisease($row['healthcond_disease']);
		$articleDetails->setMinAgeNum($row['min_age_num']);
		$articleDetails->setMinAgeUnit($row['min_age_unit']);
		$articleDetails->setMaxAgeNum($row['max_age_num']);
		$articleDetails->setMaxAgeUnit($row['max_age_unit']);
		$articleDetails->setSex($row['sex']);
		$articleDetails->setHealthy($row['healthy']);
		$articleDetails->setLocaleSampleSize($row['local_sample_size']);
		$articleDetails->setMultinational($row['multinational']);
		$articleDetails->setIntSampleSize($row['international_sample_size']);
                if(isset($row['enrolment_start_date']))$articleDetails->setStartDate(date("d-M-Y", strtotime($this->dateFromDB($row['enrolment_start_date']))));
		if(isset($row['enrolment_end_date']))$articleDetails->setEndDate(date("d-M-Y", strtotime($this->dateFromDB($row['enrolment_end_date']))));                
		$articleDetails->setRecruitmentStatus($row['recruitment_status']);
		$articleDetails->setAdvertisingScheme($row['advertising_scheme']);
		$articleDetails->setCROInvolved($row['cro']);
		$articleDetails->setCompensationPolicy($row['compensation_policy']);
                        
		HookRegistry::call('ArticleDetailsDAO::_returnArticleDetailsFromRow', array(&$articleDetails, &$row));

		return $articleDetails;
	}
        
        function getYesNoArray() {
            return array(
                ARTICLE_DETAIL_YES => Locale::translate("common.yes"),
                ARTICLE_DETAIL_NO => Locale::translate("common.no")
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
        
        /**
	 * Get a map for of units of age.
	 * @return array
	 */
	function &getAgeUnitMap() {
		static $ageUnitMap;
		if (!isset($ageUnitMap)) {
			$ageUnitMap = array(
				ARTICLE_DETAIL_AGE_UNIT_HOURS => Locale::translate('common.time.hours'),
				ARTICLE_DETAIL_AGE_UNIT_DAYS => Locale::translate('common.days'),
				ARTICLE_DETAIL_AGE_UNIT_WEEKS => Locale::translate('common.weeks'),
				ARTICLE_DETAIL_AGE_UNIT_MONTHS => Locale::translate('common.months'),
				ARTICLE_DETAIL_AGE_UNIT_YEARS => Locale::translate('common.years')                            
			);
		}
		return $ageUnitMap;
	}
        
        /**
	 * Get a map for male/female/not provided constant to locale key.
	 * @return array
	 */
	function &getSexMap() {
		static $sexMap;
		if (!isset($sexMap)) {
			$sexMap = array(
				ARTICLE_DETAIL_MALES => Locale::translate('proposal.participants.males'),
				ARTICLE_DETAIL_FEMALES => Locale::translate('proposal.participants.females'),
				ARTICLE_DETAIL_BOTH_MALES_FEMALES => Locale::translate('proposal.participants.both')                            
			);
		}
		return $sexMap;
	}
        
        /**
	 * Get a map for yes/no/not provided constant to locale key.
	 * @return array
	 */
	function &getYesNoMap() {
		static $yesNoMap;
		if (!isset($yesNoMap)) {
			$yesNoMap = array(
				ARTICLE_DETAIL_NO => Locale::translate('common.no'),
				ARTICLE_DETAIL_YES => Locale::translate('common.yes')
			);
		}
		return $yesNoMap;
	}
        
        /**
	 * Get a map for recruitment status constants to locale key.
	 * @return array
	 */
	function &getRecruitmentStatusMap() {
		static $recruitmentStatusMap;
		if (!isset($recruitmentStatusMap)) {
			$recruitmentStatusMap = array(
				ARTICLE_DETAIL_RECRUIT_NOTYET => Locale::translate('proposal.recruit.notyet'),
				ARTICLE_DETAIL_RECRUIT_RECRUITING => Locale::translate('proposal.recruit.recruiting'),
				ARTICLE_DETAIL_RECRUIT_ACTIVE => Locale::translate('proposal.recruit.active'),
				ARTICLE_DETAIL_RECRUIT_COMPLETED => Locale::translate('proposal.recruit.completed'),
				ARTICLE_DETAIL_RECRUIT_INVITATION => Locale::translate('proposal.recruit.invitation'),
				ARTICLE_DETAIL_RECRUIT_SUSPENDED => Locale::translate('proposal.recruit.suspended'),
				ARTICLE_DETAIL_RECRUIT_TERMINATED => Locale::translate('proposal.recruit.terminated'),
				ARTICLE_DETAIL_RECRUIT_WITHDRAWN => Locale::translate('proposal.recruit.withdrawn'),
				ARTICLE_DETAIL_RECRUIT_CLOSED_CONT => Locale::translate('proposal.recruit.closedCont'),
				ARTICLE_DETAIL_RECRUIT_CLOSED_COMP => Locale::translate('proposal.recruit.closedComp')                            
			);
		}
		return $recruitmentStatusMap;
	}	
        
        
        
        ////////////////////////////
        ////////// ICD 10 //////////
        ////////////////////////////
        
        function getFilename($locale = null) {
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
				array(&$this, '_ICD10CacheMiss')
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
			// Reload ICD10 registry file
			$xmlDao = new XMLDAO();
			$data = $xmlDao->parseStruct($this->getFilename(), array('ICD10s', 'ICD10'));
                        if (isset($data['ICD10s'])) {
				foreach ($data['ICD10'] as $ICD10Data) {
                                        if (strlen($ICD10Data['attributes']['name']) > 60) {
                                            $name = substr($ICD10Data['attributes']['name'], 0, 60).'...';
                                        } else {
                                            $name = $ICD10Data['attributes']['name'];
                                        }
					$ICD10s[$id][$ICD10Data['attributes']['code']] = $ICD10Data['attributes']['code'].' '.$name;
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
