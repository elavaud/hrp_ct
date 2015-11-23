<?php

/**
 * @file classes/manager/form/TrialSiteDeleteForm.inc.php
 *
 * @class TrialSiteForm
 * @ingroup manager_form
 *
 * @brief Form for deleting a specific trialSite.
 */

// $Id$

import('lib.pkp.classes.form.Form');
import('classes.journal.TrialSite');

class TrialSiteDeleteForm extends Form {

	/** @var $trialSiteId int The ID of the insitution being deleted */
	var $trialSiteId;
        
        
	/**
	 * Constructor.
	 * @param $journalId int omit for a new journal
	 */
	function TrialSiteDeleteForm($trialSiteId) {
		parent::Form('manager/trialSites/trialSiteDeleteForm.tpl');
                $this->trialSiteId = $trialSiteId;
                
		$this->addCheck(new FormValidator($this, 'replacementTrialSite', 'required', 'manager.trialSites.form.replacementTrialSiteRequired'));
	}


	/**
	 * Display the form.
	 */
	function display() {
		$templateMgr =& TemplateManager::getManager();
		                
                $trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');

                // Get the list of trialSites for the replacement and remove from it the one to delete
                $trialSitesList = $trialSiteDao->getTrialSitesList();
                unset($trialSitesList[$this->trialSiteId]);
                
                // Get the trialSite to delete
                $trialSiteToDelete =& $trialSiteDao->getTrialSiteById($this->trialSiteId);
                
		$templateMgr->assign('trialSiteId', $this->trialSiteId);
		$templateMgr->assign('trialSiteToDelete', $trialSiteToDelete);
                $templateMgr->assign('trialSitesList', $trialSitesList);
                
                parent::display(); 
	}

	/**
	 * Assign form data to user-submitted data.
	*/
	function readInputData() {
	
		$this->readUserVars(array('replacementTrialSite'));
	}

	/**
	 * Delete an trialSite.
	*/
	function execute() {
                $trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');            
                                
                $trialSiteDao->deleteTrialSiteById($this->trialSiteId);
	}
}

?>
