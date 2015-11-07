<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleDetails.inc.php
 *
 *
 * @brief article details class.
 */

// For integers
define ('PROPOSAL_DETAIL_NOT_PROVIDED', 0);

define ('PROPOSAL_DETAIL_NO', 1);
define ('PROPOSAL_DETAIL_YES', 2);

define ('PROPOSAL_DETAIL_AGE_UNIT_HOURS', 1);      // Hours
define ('PROPOSAL_DETAIL_AGE_UNIT_DAYS', 2);       // Days
define ('PROPOSAL_DETAIL_AGE_UNIT_WEEKS', 3);      // Weeks
define ('PROPOSAL_DETAIL_AGE_UNIT_MONTHS', 4);     // Months
define ('PROPOSAL_DETAIL_AGE_UNIT_YEARS', 5);      // Years

define ('PROPOSAL_DETAIL_MALES', 1);                // Males
define ('PROPOSAL_DETAIL_FEMALES', 2);              // Females
define ('PROPOSAL_DETAIL_BOTH_MALES_FEMALES', 3);   // Both males and females

define ('PROPOSAL_DETAIL_RECRUIT_RECRUITING', 1);    // Currently recruiting
define ('PROPOSAL_DETAIL_RECRUIT_NOTYET', 2);        // Not yet recruiting
define ('PROPOSAL_DETAIL_RECRUIT_ACTIVE', 3);        // Active, not yet recruiting
define ('PROPOSAL_DETAIL_RECRUIT_COMPLETED', 4);     // Completed
define ('PROPOSAL_DETAIL_RECRUIT_INVITATION', 5);    // Enrolling by invitation
define ('PROPOSAL_DETAIL_RECRUIT_SUSPENDED', 6);     // Suspended
define ('PROPOSAL_DETAIL_RECRUIT_TERMINATED', 7);    // Terminated
define ('PROPOSAL_DETAIL_RECRUIT_WITHDRAWN', 8);     // Withdrawn
define ('PROPOSAL_DETAIL_RECRUIT_CLOSED_CONT', 9);   // Closed - follow up continuing
define ('PROPOSAL_DETAIL_RECRUIT_CLOSED_COMP', 10);  // Closed - follow-up complete



class ArticleDetails extends DataObject {
    
        var $articleDetailsDAO;
        
	/**
	 * Constructor.
	 */
	function ArticleDetails() {
                $this->articleDetailsDAO =& DAORegistry::getDAO('ArticleDetailsDAO');
	}

        
	/**
	 * Set article id.
	 * @param $articleId int
	 */
	function setArticleId($articleId) {
		return $this->setData('articleId', $articleId);
	}    
	/**
	 * Get article id.
	 * @return int
	 */
	function getArticleId() {
		return $this->getData('articleId');
	}
        
        
        /**
	 * Set protocol version.
	 * @param $protocolVersion string
	 */
	function setProtocolVersion($protocolVersion) {
		return $this->setData('protocolVersion', $protocolVersion);
	}    
	/**
	 * Get protocol version.
	 * @return string
	 */
	function getProtocolVersion() {
		return $this->getData('protocolVersion');
	}
        
        
        /**
	 * Set therapeutic area.
	 * @param $therapeuticArea string
	 */
	function setTherapeuticArea($therapeuticArea) {
		return $this->setData('therapeuticArea', $therapeuticArea);
	}    
	/**
	 * Get therapeutic area.
	 * @return string
	 */
	function getTherapeuticArea() {
		return $this->getData('therapeuticArea');
	}
        
        /**
	 * Set health condition or disease.
	 * @param $healthCondDisease string
	 */
	function setHealthCondDisease($healthCondDisease) {
		return $this->setData('healthCondDisease', $healthCondDisease);
	}
        /**
	 * Set health condition(s) or disases(s) of the research from an array.
	 * @param $healthConds array
	 */
	function setHealthCondDiseaseFromArray($healthConds) {
                return $this->setHealthCondDisease(implode("+", $healthConds));
	}
	/**
	 * Get health condition or disease.
	 * @return string
	 */
	function getHealthCondDisease() {
		return $this->getData('healthCondDisease');
	}
        /**
	 * Get geographical areas of the research in an array.
	 * @return array
	 */
	function getHealthCondDiseaseArray() {
                $healthConds = $this->getHealthCondDisease();
                if($healthConds == '' || $healthConds == null) {
                    return null;
                } else {                
                    return explode("+", $healthConds);
                }
        }
        
        
        /**
	 * Set minimum age.
	 * @param $minAgeNum int
	 */
	function setMinAgeNum($minAgeNum) {
		return $this->setData('minAgeNum', $minAgeNum);
	}    
	/**
	 * Get minimum age.
	 * @return int
	 */
	function getMinAgeNum() {
		return $this->getData('minAgeNum');
	}
        /**
	 * Set minimum age (unit).
	 * @param $minAgeUnit int
	 */
	function setMinAgeUnit($minAgeUnit) {
		return $this->setData('minAgeUnit', $minAgeUnit);
	}    
	/**
	 * Get minimum age (unit).
	 * @return int
	 */
	function getMinAgeUnit() {
		return $this->getData('minAgeUnit');
	}
        /**
	 * Set maximum age.
	 * @param $maxAgeNum int
	 */
	function setMaxAgeNum($maxAgeNum) {
		return $this->setData('maxAgeNum', $maxAgeNum);
	}    
	/**
	 * Get maximum age.
	 * @return int
	 */
	function getMaxAgeNum() {
		return $this->getData('maxAgeNum');
	}        
        /**
	 * Set maximum age (unit).
	 * @param $maxAgeUnit int
	 */
	function setMaxAgeUnit($maxAgeUnit) {
		return $this->setData('maxAgeUnit', $maxAgeUnit);
	}    
	/**
	 * Get maximum age (unit).
	 * @return int
	 */
	function getMaxAgeUnit() {
		return $this->getData('maxAgeUnit');
	}
        /**
	 * Get a map for of units of age.
	 * @return array
	 */
	function &getAgeUnitMap() {
		static $ageUnitMap;
		if (!isset($ageUnitMap)) {
			$ageUnitMap = array(
                                PROPOSAL_DETAIL_NOT_PROVIDED => 'common.dataNotProvided',
				PROPOSAL_DETAIL_AGE_UNIT_HOURS => 'common.time.hours',
				PROPOSAL_DETAIL_AGE_UNIT_DAYS => 'common.days',
				PROPOSAL_DETAIL_AGE_UNIT_WEEKS => 'common.weeks',
				PROPOSAL_DETAIL_AGE_UNIT_MONTHS => 'common.months',
				PROPOSAL_DETAIL_AGE_UNIT_YEARS => 'common.years'                            
			);
		}
		return $ageUnitMap;
	}
	/**
	 * Get a locale key for the unit to use for the mimimum age of participants
	 */
	function getMinAgeUnitKey() {
                $ageUnit = $this->getMinAgeUnit();
		$ageUnitMap =& $this->getAgeUnitMap();
		return $ageUnitMap[$ageUnit];
	}
        /**
	 * Get a locale key for the unit to use for the maximum age of participants
	 */
	function getMaxAgeUnitKey() {
                $ageUnit = $this->getMaxAgeUnit();
		$ageUnitMap =& $this->getAgeUnitMap();
		return $ageUnitMap[$ageUnit];
	}
        
       
        /**
	 * Set sex.
	 * @param $sex int
	 */
	function setSex($sex) {
		return $this->setData('sex', $sex);
	}    
	/**
	 * Get sex.
	 * @return int
	 */
	function getSex() {
		return $this->getData('sex');
	}
        /**
	 * Get a map for male/female/not provided constant to locale key.
	 * @return array
	 */
	function &getSexMap() {
		static $sexMap;
		if (!isset($sexMap)) {
			$sexMap = array(
                                PROPOSAL_DETAIL_NOT_PROVIDED => 'common.dataNotProvided',
				PROPOSAL_DETAIL_MALES => 'proposal.participants.males',
				PROPOSAL_DETAIL_FEMALES => 'proposal.participants.females',
				PROPOSAL_DETAIL_BOTH_MALES_FEMALES => 'proposal.participants.both'                            
			);
		}
		return $sexMap;
	}	
	/**
	 * Get a locale key for yes/no/not provided
	 * @param $value
	 */
	function getSexKey($value) {
		$sexMap =& $this->getSexMap();
		return $sexMap[$value];
	}
        
        
        /**
	 * Set healthy.
	 * @param $healthy int
	 */
	function setHealthy($healthy) {
		return $this->setData('healthy', $healthy);
	}    
	/**
	 * Get healthy.
	 * @return int
	 */
	function getHealthy() {
		return $this->getData('healthy');
	}
        
        
        /**
	 * Set local sample size.
	 * @param $localSampleSize int
	 */
	function setLocalSampleSize($localSampleSize) {
		return $this->setData('localSampleSize', $localSampleSize);
	}    
	/**
	 * Get local sample size.
	 * @return int
	 */
	function getLocalSampleSize() {
		return $this->getData('localSampleSize');
	}
        
        
        /**
	 * Set if the study involves participants internationnally.
	 * @param $multinational int
	 */
	function setMultinational($multinational) {
		return $this->setData('multinational', $multinational);
	}    
	/**
	 * Get if the study involves participants internationnally.
	 * @return int
	 */
	function getMultinational() {
		return $this->getData('multinational');
	}
        
        
        /**
	 * Set the international sample size of the study.
	 * @param $intSampleSize string
	 */
	function setIntSampleSize($intSampleSize) {
		return $this->setData('intSampleSize', $intSampleSize);
	}    
        /**
	 * Set international sample size of the study from an array of countries and numbers.
	 * @param $intSampleSize array
	 */
	function setIntSampleSizeFromArray($intSampleSize) {
            foreach ($intSampleSize as $i => $intCountryAndNumberArray) {
                $intSampleSize[$i] = implode("-", $intCountryAndNumberArray);
            }
            return $this->setIntSampleSize(implode("+", $intSampleSize));
	}
	/**
	 * Get the international sample size of the study.
	 * @return string
	 */
	function getIntSampleSize() {
		return $this->getData('intSampleSize');
	}
        /**
	 * Get international countries with numbers of participants in an array.
	 * @return array
	 */
	function getIntSampleSizeArray() {
                $intSampleSizes = $this->getIntSampleSize();
                if($intSampleSizes == '' || $intSampleSizes == null) {
                    return null;
                } else {
                    $countriesAndNumbersArray = explode("+", $intSampleSizes);
                    foreach ($countriesAndNumbersArray as $i => $countryAndNumber) {
                        if($countryAndNumber != '' || $countryAndNumber != null) {
                            $countryAndNumberArray = explode("-", $countryAndNumber);
                            $countriesAndNumbersArray[$i] = array('country'=>$countryAndNumberArray[0], 'number'=>$countryAndNumberArray[1]);
                        }                        
                    }
                    return $countriesAndNumbersArray;
                }
        }
        
        /**
	 * Set start date of the enrollment.
	 * @param $startDate date
	 */
	function setStartDate($startDate) {
		return $this->setData('startDate', $startDate);
	}
	/**
	 * Get start date of the enrollment.
	 * @return date
	 */
	function getStartDate() {
		return $this->getData('startDate');
	}


	/**
	 * Set end date of the enrollment.
	 * @param $endDate date
	 */
	function setEndDate($endDate) {
		return $this->setData('endDate', $endDate);
	}
	/**
	 * Get end date of the enrollment.
	 * @return date
	 */
	function getEndDate() {
		return $this->getData('endDate');
	}

        
        /**
	 * Set the recruitment status.
	 * @param $recruitStatus int
	 */
	function setRecruitmentStatus($recruitStatus) {
		return $this->setData('recruitStatus', $recruitStatus);
	}
	/**
	 * Get the recruitment status.
	 * @return int
	 */
	function getRecruitmentStatus() {
		return $this->getData('recruitStatus');
	}
/**
	 * Get a map for recruitment status constants to locale key.
	 * @return array
	 */
	function &getRecruitmentStatusMap() {
		static $recruitmentStatusMap;
		if (!isset($recruitmentStatusMap)) {
			$recruitmentStatusMap = array(
                                PROPOSAL_DETAIL_NOT_PROVIDED => 'common.dataNotProvided',
				PROPOSAL_DETAIL_RECRUIT_RECRUITING => 'proposal.recruit.recruiting',
				PROPOSAL_DETAIL_RECRUIT_NOTYET => 'proposal.recruit.notyet',
				PROPOSAL_DETAIL_RECRUIT_ACTIVE => 'proposal.recruit.active',
				PROPOSAL_DETAIL_RECRUIT_COMPLETED => 'proposal.recruit.completed',
				PROPOSAL_DETAIL_RECRUIT_INVITATION => 'proposal.recruit.invitation',
				PROPOSAL_DETAIL_RECRUIT_SUSPENDED => 'proposal.recruit.suspended',
				PROPOSAL_DETAIL_RECRUIT_TERMINATED => 'proposal.recruit.terminated',
				PROPOSAL_DETAIL_RECRUIT_WITHDRAWN => 'proposal.recruit.withdrawn',
				PROPOSAL_DETAIL_RECRUIT_CLOSED_CONT => 'proposal.recruit.closedCont',
				PROPOSAL_DETAIL_RECRUIT_CLOSED_COMP => 'proposal.recruit.closedComp'                            
			);
		}
		return $recruitmentStatusMap;
	}	
	/**
	 * Get a locale key for a recruitment status provided
	 * @param $value
	 */
	function getRecruitmentStatusKey($value) {
		$recruitmentStatusMap =& $this->getRecruitmentStatusMap();
		return $recruitmentStatusMap[$value];
	}

        
        /**
	 * Set if the study will use any advertising scheme.
	 * @param $adScheme int
	 */
	function setAdvertisingScheme($adScheme) {
		return $this->setData('adScheme', $adScheme);
	}
	/**
	 * Get if the study will use any advertising scheme.
	 * @return int
	 */
	function getAdvertisingScheme() {
		return $this->getData('adScheme');
	}
        
        
        /**
	 * Get a map for yes/no/not provided constant to locale key.
	 * @return array
	 */
	function &getYesNoMap() {
		static $yesNoMap;
		if (!isset($yesNoMap)) {
			$yesNoMap = array(
                                PROPOSAL_DETAIL_NOT_PROVIDED => 'common.dataNotProvided',
				PROPOSAL_DETAIL_NO => 'common.no',
				PROPOSAL_DETAIL_YES => 'common.yes'
			);
		}
		return $yesNoMap;
	}	
	/**
	 * Get a locale key for yes/no/not provided
	 * @param $value
	 */
	function getYesNoKey($value) {
		$yesNoMap =& $this->getYesNoMap();
		return $yesNoMap[$value];
	}   
}
?>
