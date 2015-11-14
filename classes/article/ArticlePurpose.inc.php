<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticlePurpose.inc.php
 *
 *
 * @brief article purpose class.
 */

// For integers
define ('ARTICLE_PURPOSE_NOT_PROVIDED', 0);

define ('ARTICLE_PURPOSE_TYPE_OBS', 1);             //Obeservational Study
define ('ARTICLE_PURPOSE_TYPE_INT', 2);             //Interventional Study
define ('ARTICLE_PURPOSE_TYPE_DIAGNOSIS', 3);       //Interventional Study Diagnosis
define ('ARTICLE_PURPOSE_TYPE_EARLY', 4);           //Interventional Study Early Detection - Screening
define ('ARTICLE_PURPOSE_TYPE_PREVENTION', 5);      //Interventional Study Prevention
define ('ARTICLE_PURPOSE_TYPE_TREAT_DRUGS', 6);     //Interventional Study Treatment Drugs
define ('ARTICLE_PURPOSE_TYPE_TREAT_DEVICES', 7);   //Interventional Study Treatment Devices
define ('ARTICLE_PURPOSE_TYPE_TREAT_OTHERS', 8);    //Interventional Study Treatment Others

define ('ARTICLE_PURPOSE_CT_PHASE_0', 1);           //Clinical Trial Phase 0
define ('ARTICLE_PURPOSE_CT_PHASE_I', 2);           //Clinical Trial Phase I
define ('ARTICLE_PURPOSE_CT_PHASE_II', 3);          //Clinical Trial Phase II
define ('ARTICLE_PURPOSE_CT_PHASE_III', 4);         //Clinical Trial Phase III
define ('ARTICLE_PURPOSE_CT_PHASE_IV', 5);          //Clinical Trial Phase IV
define ('ARTICLE_PURPOSE_CT_PHASE_BIO', 6);         //Clinical Trial Phase Bioequivalence

define ('ARTICLE_PURPOSE_ALLOCATION_RAND', 1);      //Randomized
define ('ARTICLE_PURPOSE_ALLOCATION_NON_RAND', 2);  //Non randomized

define ('ARTICLE_PURPOSE_MASKING_OPEN', 1);         //Open Label
define ('ARTICLE_PURPOSE_MASKING_SINGLE', 2);       //Single blind
define ('ARTICLE_PURPOSE_MASKING_DOUBLE', 3);       //Double blind

define ('ARTICLE_PURPOSE_CONTROL_PLACEBO', 1);      //Placebo
define ('ARTICLE_PURPOSE_CONTROL_ACTIVE', 2);       //Active
define ('ARTICLE_PURPOSE_CONTROL_UNCONTROLLED', 3); //Uncontrolled
define ('ARTICLE_PURPOSE_CONTROL_HISTORICAL', 4);   //Historical
define ('ARTICLE_PURPOSE_CONTROL_DOSE', 5);         //Dose comparison

define ('ARTICLE_PURPOSE_ASSIGNMENT_SINGLE', 1);    //Single
define ('ARTICLE_PURPOSE_ASSIGNMENT_PARALLEL', 2);  //Parallel
define ('ARTICLE_PURPOSE_ASSIGNMENT_CROSSOVER', 3); //Crossover
define ('ARTICLE_PURPOSE_ASSIGNMENT_FACTORIAL', 4); //Factorial
define ('ARTICLE_PURPOSE_ASSIGNMENT_OTHER', 5);     //Other
               
define ('ARTICLE_PURPOSE_ENDPOINT_SAF', 1);         //Safety
define ('ARTICLE_PURPOSE_ENDPOINT_EFF', 2);         //Efficacy
define ('ARTICLE_PURPOSE_ENDPOINT_SAF_EFF', 3);     //Safety and Efficacy
define ('ARTICLE_PURPOSE_ENDPOINT_KIN', 4);         //Pharmacokinetics
define ('ARTICLE_PURPOSE_ENDPOINT_DYN', 5);         //Pharmacodynamics
define ('ARTICLE_PURPOSE_ENDPOINT_KIN_DYN', 6);     //Pharmacokinetics and Pharmacodynamics

class ArticlePurpose extends DataObject {
    
        var $articlePurposeDAO;
        
	/**
	 * Constructor.
	 */
	function ArticlePurpose() {
                $this->articlePurposeDAO =& DAORegistry::getDAO('ArticlePurposeDAO');
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
	 * Set type.
	 * @param $type int
	 */
	function setType($type) {
                if ($type == ARTICLE_PURPOSE_TYPE_OBS || $type == ARTICLE_PURPOSE_NOT_PROVIDED) {
                    $this->setInterventional($type);
                } else {
                    $this->setInterventional(ARTICLE_PURPOSE_TYPE_INT);                    
                }
		return $this->setData('type', $type);
	}    
	/**
	 * Get type.
	 * @return int
	 */
	function getType() {
		return $this->getData('type');
	}
        /**
	 * Get a map for of types.
	 * @return array
	 */
	function &getTypeMap() {
		static $typeMap;
		if (!isset($typeMap)) {
			$typeMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_TYPE_OBS => 'proposal.purpose.type.obs',
				ARTICLE_PURPOSE_TYPE_DIAGNOSIS => 'proposal.purpose.type.diganosis',
				ARTICLE_PURPOSE_TYPE_EARLY => 'proposal.purpose.type.early',
				ARTICLE_PURPOSE_TYPE_PREVENTION => 'proposal.purpose.type.prevention',
				ARTICLE_PURPOSE_TYPE_TREAT_DRUGS => 'proposal.purpose.type.drugs',
				ARTICLE_PURPOSE_TYPE_TREAT_DEVICES => 'proposal.purpose.type.devices',
				ARTICLE_PURPOSE_TYPE_TREAT_OTHERS => 'proposal.purpose.type.others'                            
                        );
		}
		return $typeMap;
	}
      	/**
	 * Get a locale key for the type
	 */
	function getTypeKey() {
                $type = $this->getType();
		$typeMap =& $this->getTypeMap();
		return $typeMap[$type];
	}
        /**
         * Set if the study is interventional
	 * @param $interventional int
         */
        function setInterventional($interventional){
		return $this->setData('interventional', $interventional);
        }
        /**
         * Get if the study is interventional
         */
        function getInterventional(){
		return $this->getData('interventional');
        }
        
        
        /**
	 * Set clinical trial phase.
	 * @param $CTPhase int
	 */
	function setCTPhase($CTPhase) {
		return $this->setData('CTPhase', $CTPhase);
	}    
	/**
	 * Get clinical trial phase.
	 * @return int
	 */
	function getCTPhase() {
		return $this->getData('CTPhase');
	}
        /**
	 * Get a map for of clinical trial phases.
	 * @return array
	 */
	function &getCTPhaseMap() {
		static $ctPhaseMap;
		if (!isset($ctPhaseMap)) {
			$ctPhaseMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_CT_PHASE_0 => 'proposal.purpose.phase.0',
				ARTICLE_PURPOSE_CT_PHASE_I => 'proposal.purpose.phase.I',
				ARTICLE_PURPOSE_CT_PHASE_II => 'proposal.purpose.phase.II',
				ARTICLE_PURPOSE_CT_PHASE_III => 'proposal.purpose.phase.III',
				ARTICLE_PURPOSE_CT_PHASE_IV => 'proposal.purpose.phase.IV',
				ARTICLE_PURPOSE_CT_PHASE_BIO => 'proposal.purpose.phase.bio'
                        );
		}
		return $ctPhaseMap;
	}
      	/**
	 * Get a locale key for the clinical trial phase
	 */
	function getCTPhaseKey() {
                $ctPhase = $this->getCTPhase();
		$ctPhaseMap =& $this->getCTPhaseMap();
		return $ctPhaseMap[$ctPhase];
	}
        
        
        /**
	 * Set Allocation.
	 * @param $allocation int
	 */
	function setAllocation($allocation) {
		return $this->setData('allocation', $allocation);
	}    
	/**
	 * Get allocation.
	 * @return int
	 */
	function getAllocation() {
		return $this->getData('allocation');
	}
        /**
	 * Get a map for of allocation constants.
	 * @return array
	 */
	function &getAllocationMap() {
		static $allocationMap;
		if (!isset($allocationMap)) {
			$allocationMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_ALLOCATION_RAND => 'proposal.purpose.allocation.rand',
				ARTICLE_PURPOSE_ALLOCATION_NON_RAND => 'proposal.purpose.allocation.nonRand'
                        );
		}
		return $allocationMap;
	}
      	/**
	 * Get a locale key for the allocation
	 */
	function getAllocationKey() {
                $allocation = $this->getAllocation();
		$allocationMap =& $this->getAllocationMap();
		return $allocationMap[$allocation];
	}
        
        
        /**
	 * Set Masking.
	 * @param $masking int
	 */
	function setMasking($masking) {
		return $this->setData('masking', $masking);
	}    
	/**
	 * Get Masking.
	 * @return int
	 */
	function getMasking() {
		return $this->getData('masking');
	}
        /**
	 * Get a map for of Masking constants.
	 * @return array
	 */
	function &getMaskingMap() {
		static $maskingMap;
		if (!isset($maskingMap)) {
			$maskingMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_MASKING_OPEN => 'proposal.purpose.masking.open',
				ARTICLE_PURPOSE_MASKING_SINGLE => 'proposal.purpose.masking.single',
				ARTICLE_PURPOSE_MASKING_DOUBLE => 'proposal.purpose.masking.double'
                        );
		}
		return $maskingMap;
	}
      	/**
	 * Get a locale key for the Masking
	 */
	function getMaskingKey() {
                $masking = $this->getMasking();
		$maskingMap =& $this->getMaskingMap();
		return $maskingMap[$masking];
	}
        
        
        /**
	 * Set Control.
	 * @param $control int
	 */
	function setControl($control) {
		return $this->setData('control', $control);
	}    
	/**
	 * Get Control.
	 * @return int
	 */
	function getControl() {
		return $this->getData('control');
	}
        /**
	 * Get a map for of control constants.
	 * @return array
	 */
	function &getControlMap() {
		static $controlMap;
		if (!isset($controlMap)) {
			$controlMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_CONTROL_PLACEBO => 'proposal.purpose.control.placebo',
				ARTICLE_PURPOSE_CONTROL_ACTIVE => 'proposal.purpose.control.active',
				ARTICLE_PURPOSE_CONTROL_UNCONTROLLED => 'proposal.purpose.control.uncontrolled',
				ARTICLE_PURPOSE_CONTROL_HISTORICAL => 'proposal.purpose.control.historical',
				ARTICLE_PURPOSE_CONTROL_DOSE => 'proposal.purpose.control.dose'
                        );
		}
		return $controlMap;
	}
      	/**
	 * Get a locale key for the control
	 */
	function getControlKey() {
                $control = $this->getControl();
		$controlMap =& $this->getControlMap();
		return $controlMap[$control];
	}
        
        
        /**
	 * Set assignment.
	 * @param $assignment int
	 */
	function setAssignment($assignment) {
		return $this->setData('assignment', $assignment);
	}    
	/**
	 * Get assignment.
	 * @return int
	 */
	function getAssignment() {
		return $this->getData('assignment');
	}
        /**
	 * Get a map for of assignment constants.
	 * @return array
	 */
	function &getAssignmentMap() {
		static $assignmentMap;
		if (!isset($assignmentMap)) {
			$assignmentMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_ASSIGNMENT_SINGLE => 'proposal.purpose.assignment.single',
				ARTICLE_PURPOSE_ASSIGNMENT_PARALLEL => 'proposal.purpose.assignment.parallel',
				ARTICLE_PURPOSE_ASSIGNMENT_CROSSOVER => 'proposal.purpose.assignment.crossover',
				ARTICLE_PURPOSE_ASSIGNMENT_FACTORIAL => 'proposal.purpose.assignment.factorial',
				ARTICLE_PURPOSE_ASSIGNMENT_OTHER => 'common.other'
                        );
		}
		return $assignmentMap;
	}
      	/**
	 * Get a locale key for the assignment
	 */
	function getAssignmentKey() {
                $assignment = $this->getAssignment();
		$assignmentMap =& $this->getAssignmentMap();
		return $assignmentMap[$assignment];
	}
        
        
        /**
	 * Set endpoint.
	 * @param $endpoint int
	 */
	function setEndpoint($endpoint) {
		return $this->setData('endpoint', $endpoint);
	}    
	/**
	 * Get $endpoint.
	 * @return int
	 */
	function getEndpoint() {
		return $this->getData('endpoint');
	}
        /**
	 * Get a map for of endpoint constants.
	 * @return array
	 */
	function &getEndpointMap() {
		static $endpointMap;
		if (!isset($endpointMap)) {
			$endpointMap = array(
                                ARTICLE_PURPOSE_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_PURPOSE_ENDPOINT_SAF => 'proposal.purpose.endpoint.saf',
				ARTICLE_PURPOSE_ENDPOINT_EFF => 'proposal.purpose.endpoint.eff',
				ARTICLE_PURPOSE_ENDPOINT_SAF_EFF => 'proposal.purpose.endpoint.safAndEff',
				ARTICLE_PURPOSE_ENDPOINT_KIN => 'proposal.purpose.endpoint.kin',
				ARTICLE_PURPOSE_ENDPOINT_DYN => 'proposal.purpose.endpoint.dyn',
				ARTICLE_PURPOSE_ENDPOINT_KIN_DYN => 'proposal.purpose.endpoint.kinAndDyn'
                        );
		}
		return $endpointMap;
	}
      	/**
	 * Get a locale key for the endpoint
	 */
	function getEndpointKey() {
                $endpoint = $this->getEndpoint();
		$endpointMap =& $this->getEndpointMap();
		return $endpointMap[$$endpoint];
	}
}
?>
