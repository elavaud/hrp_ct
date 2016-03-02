<?php

/**
 * @file classes/manager/form/ExtraFieldDeleteForm.inc.php
 *
 * @class ExtraFieldDeleteForm
 * @ingroup manager_form
 *
 * @brief Form for deleting an extra field.
 */

// $Id$

import('lib.pkp.classes.form.Form');
import('classes.journal.ExtraField');

class ExtraFieldDeleteForm extends Form {

        /** @var $type string The type of the extra field being deleted */
	var $type;

        /** @var $typeConst int The constant for the type of the extra field being deleted */
	var $typeConst;
	 
        /** @var $extraFieldId int The ID of the extra field being deleted */
	var $extraFieldId;
        
        
	/**
	 * Constructor.
	 * @param $journalId int omit for a new journal
	 */
	function ExtraFieldDeleteForm($type, $extraFieldId) {
		parent::Form('manager/extraFields/extraFieldDeleteForm.tpl');
                $this->extraFieldId = $extraFieldId;
                $this->type = $type;
                switch ($type) {
                    case 'geoAreas':
                        $this->typeConst = (int) EXTRA_FIELD_GEO_AREA;
        		$this->addCheck(new FormValidator($this, 'replacement', 'required', 'manager.extraFields.geoAreas.replacement.required'));
                        break;
                    case 'therapeuticAreas':
                        $this->typeConst = (int) EXTRA_FIELD_THERAPEUTIC_AREA;
        		$this->addCheck(new FormValidator($this, 'replacement', 'required','manager.extraFields.therapeuticAreas.replacement.required'));
                        break;
                    case 'level3erc':
                        $this->typeConst = (int) EXTRA_FIELD_LEVEL3_ERC;
        		$this->addCheck(new FormValidator($this, 'replacement', 'required','manager.extraFields.level3erc.replacement.required'));
                        break;                    
                }                
	}


	/**
	 * Display the form.
	 */
	function display() {
		$templateMgr =& TemplateManager::getManager();
                
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
                $institutionDao =& DAORegistry::getDAO('InstitutionDAO');
                $sectionDao =& DAORegistry::getDAO('SectionDAO');        
                
                // Get the list of extra fields for the replacement and remove from it the one to delete
                $extraFieldsList = $extraFieldDao->getExtraFieldsList($this->typeConst);
                unset($extraFieldsList[$this->extraFieldId]);
                
                // Get the extra Field to delete
                $extraFieldToDelete =& $extraFieldDao->getExtraField($this->extraFieldId);
                
                if ($this->typeConst == EXTRA_FIELD_GEO_AREA){
                    $replacementMessage = 'manager.extraFields.geoAreas.replacement.message';
                    $replacementWarning = 'manager.extraFields.geoAreas.replacement.warning';
                } elseif ($this->typeConst == EXTRA_FIELD_THERAPEUTIC_AREA) {
                    $replacementMessage = 'manager.extraFields.therapeuticAreas.replacement.message';
                    $replacementWarning = 'manager.extraFields.therapeuticAreas.replacement.warning';                    
                } elseif ($this->typeConst == EXTRA_FIELD_LEVEL3_ERC) {
                    $replacementMessage = 'manager.extraFields.level3erc.replacement.message';
                    $replacementWarning = 'manager.extraFields.level3erc.replacement.warning';                    
                }else {
                    $replacementMessage = 'manager.extraFields.replacement.message';
                    $replacementWarning = 'manager.extraFields.replacement.warning';
                }
                
		$templateMgr->assign('type', $this->type);
		$templateMgr->assign('extraFieldId', $this->extraFieldId);
		$templateMgr->assign('extraFieldToDelete', $extraFieldToDelete);
                $templateMgr->assign('extraFieldsList', $extraFieldsList);
		$templateMgr->assign('countInstitutions', count($institutionDao->getGeoAreas($this->extraFieldId)));
		$templateMgr->assign('countCommittees', count($sectionDao->getGeoAreas($this->extraFieldId)));
                $templateMgr->assign('pageTitle', 'manager.extraFields.'.$this->type.'.delete');
                $templateMgr->assign('replacementMessage', $replacementMessage);
                $templateMgr->assign('replacementWarning', $replacementWarning);

                parent::display(); 
	}

	/**
	 * Assign form data to user-submitted data.
	*/
	function readInputData() {
	
		$this->readUserVars(array('replacement'));
	}

	/**
	 * Delete an institution.
	*/
	function execute() {
                $institutionDao =& DAORegistry::getDAO('InstitutionDAO');            
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
                $sectionDao =& DAORegistry::getDAO('SectionDAO');            

                if ($this->typeConst == EXTRA_FIELD_GEO_AREA) {
                    $institutions = $institutionDao->getGeoAreas($this->extraFieldId);    
                    $committees = $sectionDao->getGeoAreas($this->extraFieldId);
                } else {
                    $committees = null;
                    $institutions = null;
                }
                
                $replacementExtraFieldId = $this->getData('replacement');

                if ($institutions && count($institutions) > 0 ) {
                    foreach ($institutions as $institution) {
                        if ($institution->getInstitutionInternational() == INSTITUTION_NATIONAL && $institution->getInstitutionLocation() == $this->extraFieldId){
                            $institution->setInstitutionLocation($replacementExtraFieldId);
                        }
                        $institutionDao->updateInstitution($institution);
                    }
                }
                if ($committees && count($committees) > 0 ) {
                    foreach ($committees as $committee) {
                        $regions = $committee->getRegion(null);
                        foreach ($regions as $regionKey => $regionValue) {
                            if ($regionValue == $this->extraFieldId) {
                                $committee->setRegion($replacementExtraFieldId, $regionKey);
                            }
                        }
                        $sectionDao->updateSection($committee);
                    }
                }
                
                $extraFieldDao->deleteExtraFieldById($this->extraFieldId);
	}
}

?>
