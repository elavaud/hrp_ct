<?php

/**
 * @file TrialSiteHandler.inc.php
 * @class TrialSiteHandler
 * @ingroup pages_manager
 *
 * @brief Handle requests for trial sites management functions.
 */

// $Id$

import('pages.manager.ManagerHandler');

class TrialSiteHandler extends ManagerHandler {
	/**
	 * Constructor
	 **/
	function TrialSiteHandler() {
		parent::ManagerHandler();
	}
	/**
	 * Display a list of the trialSites within the current journal.
	 */
	function trialSites() {
		$this->validate();
		$this->setupTemplate();
		$trialSiteDAO =& DAORegistry::getDAO('TrialSiteDAO');
		
		$rangeInfo =& Handler::getRangeInfo('trialSites');
		
		/* Addition of sort and sortDirection*/
                $sort = Request::getUserVar('sort');
		$sort = isset($sort) ? $sort : 'trialSite';
                $sortDirection = Request::getUserVar('sortDirection');
		$sortDirection = (isset($sortDirection) && ($sortDirection == SORT_DIRECTION_ASC || $sortDirection == SORT_DIRECTION_DESC)) ? $sortDirection : SORT_DIRECTION_ASC;
		
		$trialSites =& $trialSiteDAO->getAllTrialSites($sort, $sortDirection, $rangeInfo);
		
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->addJavaScript('lib/pkp/js/jquery.tablednd_0_5.js');
		$templateMgr->addJavaScript('lib/pkp/js/tablednd.js');
		//$templateMgr->assign('pageHierarchy', array(array(Request::url(null, 'manager'), 'manager.journalManagement')));
		$templateMgr->assign('sort', $sort);
		$templateMgr->assign('sortDirection', $sortDirection);
		$templateMgr->assign_by_ref('trialSites', $trialSites);
		$templateMgr->display('manager/trialSites/trialSites.tpl');
	}
	
	/**
	 * Delete an trialSite.
	 */
	function deleteTrialSite($args) {
		$this->validate();
		$this->setupTemplate(true);
                
		if (isset($args) && !empty($args)) {
                        import('classes.manager.form.TrialSiteDeleteForm');                
                        $trialSiteDeleteForm = new TrialSiteDeleteForm((int) $args[0]);
                        
                        $trialSiteDeleteForm->readInputData();
                        if ($trialSiteDeleteForm->validate()) {
                                $trialSiteDeleteForm->execute();
                                Request::redirect(null, null, 'trialSites');
                        } else {
                                $trialSiteDeleteForm->display();
                        }                        
		}
		else {
                    Request::redirect(null, null, 'trialSites');
                }
	}
	
	/**
	 * Save changes to an trialSite.
	 */
	function updateTrialSite($args = array()) {
		$this->validate();
		$this->setupTemplate(true);
		import('classes.manager.form.TrialSiteForm');                
		$trialSiteForm = new TrialSiteForm(!isset($args) || empty($args) ? null : ((int) $args[0]));

		$trialSiteForm->readInputData();
		if ($trialSiteForm->validate()) {
			$trialSiteForm->execute();
			Request::redirect(null, null, 'trialSites');
		} else {
			$trialSiteForm->display();
		}
	}
	
	/*
	 * Display form to create a new trialSite.
	*/
	function createTrialSite() { 
		$this->editTrialSite();
	}
	
	/**
	 * Display form to create/edit a trialSite.
	 * @param $args array optional, if set the first parameter is the ID of the trialSite to edit
	*/
	function editTrialSite($args = array()) {

		$this->validate();
		$this->setupTemplate(true);
		import('classes.manager.form.TrialSiteForm');
		
		$trialSiteForm = new TrialSiteForm(!isset($args) || empty($args) ? null : ((int) $args[0]));
		
		$trialSiteForm->initData();
		
		$trialSiteForm->display();
	}
	
	/**
	 * Display form to delete a trialSite.
	 * @param $args array optional, if set the first parameter is the ID of the trialSite to edit
	*/
	function deleteTrialSiteForm($args) {

		$this->validate();
		$this->setupTemplate(true);
		import('classes.manager.form.TrialSiteDeleteForm');
		if (isset($args) && !empty($args)) {
                    $trialSiteDeleteForm = new TrialSiteDeleteForm((int)$args[0]);
                } else {
                    Request::redirect(null, null, 'trialSites');
                }
		$trialSiteDeleteForm->initData();
                
		$trialSiteDeleteForm->display();
	}
        
	function setupTemplate($subclass = false) {
		Locale::requireComponents(array(LOCALE_COMPONENT_PKP_SUBMISSION, LOCALE_COMPONENT_PKP_READER));
		parent::setupTemplate(true);
		if ($subclass) {
			$templateMgr =& TemplateManager::getManager();
			$templateMgr->append('pageHierarchy', array(Request::url(null, 'manager', 'trialSites'), 'trialSite.trialSites'));
		}
	}
}

?>
