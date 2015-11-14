<?php

/**
 * @file classes/article/ArticlePurposeDAO.inc.php
 *
 * @class ArticlePurposeDAO
 *
 * @brief Operations for retrieving and modifying article purpose objects.
 */

import('classes.article.ArticlePurpose');

class ArticlePurposeDAO extends DAO{
 
        /**
	 * Constructor.
	 */
	function ArticlePurposeDAO() {
		parent::DAO();
        }

        /**
	 * Get specific article purpose.
	 * @param $articlePurposeId int
	 * @return articlePurpose object
	 */
	function &getArticlePurposeById($articlePurposeId) {

		$result =& $this->retrieve(
			'SELECT * FROM article_purpose WHERE article_purpose_id = ? LIMIT 1',
			(int) $articlePurposeId
		);

		$articlePurpose =& $this->_returnArticlePurposeFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articlePurpose;
	}

        /**
	 * Get all article purposes for a specific article.
	 * @param $articleId int
	 * @return articlePurpose array
	 */
	function &getArticlePurposesByArticleId($articleId) {
                
                $articlePurposes = array();
                
		$result =& $this->retrieve(
			'SELECT * FROM article_purpose WHERE article_id = ?',
			(int) $articleId
		);

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articlePurposes[] =& $this->_returnArticlePurposeFromRow($row);
			$result->moveNext();
		}

		$result->Close();
		unset($result);

		return $articlePurposes;
	}
        
	/**
	 * Insert a new article purpose.
	 * @param $articlePurpose object
	 */
	function insertArticlePurpose(&$articlePurpose) {
		$this->update(
			'INSERT INTO article_purpose (article_id, type, ct_phase, allocation, masking, control, assignment, endpoint)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articlePurpose->getArticleId(),
				(int) $articlePurpose->getType(),
				(int) $articlePurpose->getCTPhase(),
				(int) $articlePurpose->getAllocation(),
				(int) $articlePurpose->getMasking(),
                                (int) $articlePurpose->getControl(),
				(int) $articlePurpose->getAssignment(),
				(int) $articlePurpose->getEndpoint()
			)
		);
		
		return true;
	}

	/**
	 * Update an existing article details object.
	 * @param $articlePurpose ArticlePurpose object
	 */
	function updateArticlePurpose(&$articlePurpose) {
		$returner = $this->update(
			'UPDATE article_purpose
			SET	
                                article_id = ?, 
                                type = ?, 
                                ct_phase = ?, 
                                allocation = ?, 
                                masking = ?, 
                                control = ?, 
                                assignment = ?, 
                                endpoint = ?
			WHERE	article_purpose_id = ?',
			array(
				(int) $articlePurpose->getArticleId(),
				(int) $articlePurpose->getType(),
				(int) $articlePurpose->getCTPhase(),
				(int) $articlePurpose->getAllocation(),
				(int) $articlePurpose->getMasking(),
                                (int) $articlePurpose->getControl(),
				(int) $articlePurpose->getAssignment(),
				(int) $articlePurpose->getEndpoint(),
                                (int) $articlePurpose->getId()
                        )
		);
                
		return true;
	}

	/**
	 * Delete a specific article purpose
	 * @param $articlePurposeId int
	 */
	function deleteArticlePurpose($articlePurposeId) {
		$returner = $this->update(
			'DELETE FROM article_purpose WHERE article_purpose_id = ?',
			$articlePurposeId
		);

		return true;
	}
 
       /**
	 * Delete all article purposes by article ID
	 * @param $articleId int
	 */
	function deleteArticlePurposes($articleId) {
		$returner = $this->update(
			'DELETE FROM article_purpose WHERE article_id = ?',
			$articleId
		);

		return true;
	}
        
	/**
	 * Check if an article details object exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articlePurposeExists($submissionId) {
		$result =& $this->retrieve('SELECT count(*) FROM article_purpose WHERE article_id = ?', (int) $submissionId);
		$returner = $result->fields[0]?true:false;
		$result->Close();
		return $returner;
	}
        
        /**
	 * Internal function to return a article purpose object from a row.
	 * @param $row array
	 * @return ArticlePurpose object
	 */
	function &_returnArticlePurposeFromRow(&$row) {
            
		$articlePurpose = new ArticlePurpose();
                
		$articlePurpose->setId($row['article_purpose_id']);
		$articlePurpose->setArticleId($row['article_id']);
		$articlePurpose->setType($row['type']);
		$articlePurpose->setCTPhase($row['ct_phase']);
		$articlePurpose->setAllocation($row['allocation']);
		$articlePurpose->setMasking($row['masking']);
		$articlePurpose->setControl($row['control']);
		$articlePurpose->setAssignment($row['assignment']);
		$articlePurpose->setEndpoint($row['endpoint']);
                        
		HookRegistry::call('ArticlePurposeDAO::_returnArticlePurposeFromRow', array(&$articlePurpose, &$row));

		return $articlePurpose;
	}
        
        /**
	 * Get a map for the interventional constants to locale key.
	 * @return array
	 */
	function &getInterventionalMap() {
		static $interventionalMap;
		if (!isset($interventionalMap)) {
			$interventionalMap = array(
				ARTICLE_PURPOSE_TYPE_OBS => Locale::translate('proposal.purpose.type.obs'),
				ARTICLE_PURPOSE_TYPE_INT => Locale::translate('proposal.purpose.type.int')                            
			);
		}
		return $interventionalMap;
	}
        
        /**
	 * Get a map for of types.
	 * @return array
	 */
	function &getTypeMap() {
		static $typeMap;
		if (!isset($typeMap)) {
			$typeMap = array(
				ARTICLE_PURPOSE_TYPE_DIAGNOSIS => Locale::translate('proposal.purpose.type.diganosis'),
				ARTICLE_PURPOSE_TYPE_EARLY => Locale::translate('proposal.purpose.type.early'),
				ARTICLE_PURPOSE_TYPE_PREVENTION => Locale::translate('proposal.purpose.type.prevention'),
				ARTICLE_PURPOSE_TYPE_TREAT_DRUGS => Locale::translate('proposal.purpose.type.drugs'),
				ARTICLE_PURPOSE_TYPE_TREAT_DEVICES => Locale::translate('proposal.purpose.type.devices'),
				ARTICLE_PURPOSE_TYPE_TREAT_OTHERS => Locale::translate('proposal.purpose.type.others')                            
                        );
		}
		return $typeMap;
	}

        /**
	 * Get a map for of clinical trial phases.
	 * @return array
	 */
	function &getCTPhaseMap() {
		static $ctPhaseMap;
		if (!isset($ctPhaseMap)) {
			$ctPhaseMap = array(
				ARTICLE_PURPOSE_CT_PHASE_0 => Locale::translate('proposal.purpose.phase.0'),
				ARTICLE_PURPOSE_CT_PHASE_I => Locale::translate('proposal.purpose.phase.I'),
				ARTICLE_PURPOSE_CT_PHASE_II => Locale::translate('proposal.purpose.phase.II'),
				ARTICLE_PURPOSE_CT_PHASE_III => Locale::translate('proposal.purpose.phase.III'),
				ARTICLE_PURPOSE_CT_PHASE_IV => Locale::translate('proposal.purpose.phase.IV'),
				ARTICLE_PURPOSE_CT_PHASE_BIO => Locale::translate('proposal.purpose.phase.bio')
                        );
		}
		return $ctPhaseMap;
	}
        
        /**
	 * Get a map for of allocation constants.
	 * @return array
	 */
	function &getAllocationMap() {
		static $allocationMap;
		if (!isset($allocationMap)) {
			$allocationMap = array(
				ARTICLE_PURPOSE_ALLOCATION_RAND => Locale::translate('proposal.purpose.allocation.rand'),
				ARTICLE_PURPOSE_ALLOCATION_NON_RAND => Locale::translate('proposal.purpose.allocation.nonRand')
                        );
		}
		return $allocationMap;
	}
        
        /**
	 * Get a map for of Masking constants.
	 * @return array
	 */
	function &getMaskingMap() {
		static $maskingMap;
		if (!isset($maskingMap)) {
			$maskingMap = array(
				ARTICLE_PURPOSE_MASKING_OPEN => Locale::translate('proposal.purpose.masking.open'),
				ARTICLE_PURPOSE_MASKING_SINGLE => Locale::translate('proposal.purpose.masking.single'),
				ARTICLE_PURPOSE_MASKING_DOUBLE => Locale::translate('proposal.purpose.masking.double')
                        );
		}
		return $maskingMap;
	}
        
        /**
	 * Get a map for of control constants.
	 * @return array
	 */
	function &getControlMap() {
		static $controlMap;
		if (!isset($controlMap)) {
			$controlMap = array(
				ARTICLE_PURPOSE_CONTROL_PLACEBO => Locale::translate('proposal.purpose.control.placebo'),
				ARTICLE_PURPOSE_CONTROL_ACTIVE => Locale::translate('proposal.purpose.control.active'),
				ARTICLE_PURPOSE_CONTROL_UNCONTROLLED => Locale::translate('proposal.purpose.control.uncontrolled'),
				ARTICLE_PURPOSE_CONTROL_HISTORICAL => Locale::translate('proposal.purpose.control.historical'),
				ARTICLE_PURPOSE_CONTROL_DOSE => Locale::translate('proposal.purpose.control.dose')
                        );
		}
		return $controlMap;
	}
        
        /**
	 * Get a map for of assignment constants.
	 * @return array
	 */
	function &getAssignmentMap() {
		static $assignmentMap;
		if (!isset($assignmentMap)) {
			$assignmentMap = array(
				ARTICLE_PURPOSE_ASSIGNMENT_SINGLE => Locale::translate('proposal.purpose.assignment.single'),
				ARTICLE_PURPOSE_ASSIGNMENT_PARALLEL => Locale::translate('proposal.purpose.assignment.parallel'),
				ARTICLE_PURPOSE_ASSIGNMENT_CROSSOVER => Locale::translate('proposal.purpose.assignment.crossover'),
				ARTICLE_PURPOSE_ASSIGNMENT_FACTORIAL => Locale::translate('proposal.purpose.assignment.factorial'),
				ARTICLE_PURPOSE_ASSIGNMENT_OTHER => Locale::translate('common.other')
                        );
		}
		return $assignmentMap;
	}
        
        /**
	 * Get a map for of endpoint constants.
	 * @return array
	 */
	function &getEndpointMap() {
		static $endpointMap;
		if (!isset($endpointMap)) {
			$endpointMap = array(
				ARTICLE_PURPOSE_ENDPOINT_SAF => Locale::translate('proposal.purpose.endpoint.saf'),
				ARTICLE_PURPOSE_ENDPOINT_EFF => Locale::translate('proposal.purpose.endpoint.eff'),
				ARTICLE_PURPOSE_ENDPOINT_SAF_EFF => Locale::translate('proposal.purpose.endpoint.safAndEff'),
				ARTICLE_PURPOSE_ENDPOINT_KIN => Locale::translate('proposal.purpose.endpoint.kin'),
				ARTICLE_PURPOSE_ENDPOINT_DYN => Locale::translate('proposal.purpose.endpoint.dyn'),
				ARTICLE_PURPOSE_ENDPOINT_KIN_DYN => Locale::translate('proposal.purpose.endpoint.kinAndDyn')
                        );
		}
		return $endpointMap;
	}
}

?>
