<?php

/**
 * @file classes/manager/form/TrialSiteForm.inc.php
 *
 * @class TrialSiteForm
 * @ingroup manager_form
 *
 * @brief Form for creating and modifying trialSites.
 */

// $Id$

import('lib.pkp.classes.form.Form');
import('classes.journal.TrialSite');

class TrialSiteForm extends Form {

	/** @var $trialSiteId int The ID of the trialSite being edited */
	var $trialSiteId;
        
        var $trialSiteDao;


	/**
	 * Constructor.
	 * @param $trialSiteId int omit for a new journal
	 */
	function TrialSiteForm($trialSiteId = null) {
		parent::Form('manager/trialSites/trialSiteForm.tpl');
		$this->trialSiteId = $trialSiteId;
                $this->trialSiteDao = DAORegistry::getDAO('TrialSiteDAO');

		// Validation checks for this form

		$this->addCheck(new FormValidator($this, 'name', 'required', 'manager.trialSites.form.name.required'));
		$this->addCheck(new FormValidator($this, 'address', 'required', 'manager.trialSites.form.address.required'));
		$this->addCheck(new FormValidator($this, 'city', 'required', 'manager.trialSites.form.city.required'));
		$this->addCheck(new FormValidator($this, 'region', 'required', 'manager.trialSites.form.region.required'));
		$this->addCheck(new FormValidator($this, 'licensure', 'required', 'manager.trialSites.form.licensure.required'));
		$this->addCheck(new FormValidator($this, 'accreditation', 'required', 'manager.trialSites.form.accreditation.required')); 
                if(isset($_POST['city'])) {         
                    $this->addCheck(new FormValidatorCustom($this, 'name', 'required', 'manager.trialSites.form.nameAndCityExists', array($this->trialSiteDao, 'trialSiteExistsByNameAndCity'), array($_POST["city"], $this->trialSiteId), true));
                }
                $this->addCheck(new FormValidatorCustom($this, 'licensure', 'required', 'manager.trialSites.form.licensureExists', array($this->trialSiteDao, 'trialSiteExistsByLicensure'), array($this->trialSiteId), true));
                $this->addCheck(new FormValidatorCustom($this, 'accreditation', 'required', 'manager.trialSites.form.accreditationExists', array($this->trialSiteDao, 'trialSiteExistsByAccreditation'), array($this->trialSiteId), true));
	}


	/**
	 * Display the form.
	 */
	function display() {
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
                $trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');
                         
                $regions = $extraFieldDao->getExtraFieldsList(EXTRA_FIELD_GEO_AREA);
                
		$templateMgr =& TemplateManager::getManager();
                
		$templateMgr->assign('trialSiteId', $this->trialSiteId);
                $templateMgr->assign_by_ref('regions', $regions);
                
		parent::display(); 
	}

	/**
	 * Initialize form data from current settings.
	 */
	function initData() {
		if (isset($this->trialSiteId)) {
                    $trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');
                    $trialSite =& $trialSiteDao->getTrialSiteById($this->trialSiteId);

                    $this->_data = array(
                        'name' => $trialSite->getName(),
                        'region' => $trialSite->getRegion(),
                        'city' => $trialSite->getCity(),
                        'address' => $trialSite->getAddress(),
                        'licensure' => $trialSite->getLicensure(),
                        'accreditation' => $trialSite->getAccreditation()
                    );
		}
	}

	/**
	 * Assign form data to user-submitted data.
	*/
	function readInputData() {
	
		$this->readUserVars(array('name', 'region', 'city', 'address', 'licensure', 'accreditation'));
	}

	/**
	 * Save trialSite.
	*/
	function execute() {

		$trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');

		if (isset($this->trialSiteId)) {
                    $trialSite =& $trialSiteDao->getTrialSiteById($this->trialSiteId);
		}
		
		if (!isset($trialSite)) {
                    $trialSite = new TrialSite();
                }
                
		$trialSite->setName($this->getData('name'));
		$trialSite->setRegion($this->getData('region'));
		$trialSite->setCity($this->getData('city'));
		$trialSite->setAddress($this->getData('address'));
		$trialSite->setLicensure($this->getData('licensure'));
		$trialSite->setAccreditation($this->getData('accreditation'));
                

		if ($trialSite->getId() != null) {
                    $trialSiteDao->updateTrialSite($trialSite);
                } else {
                    $trialSiteDao->insertTrialSite($trialSite);
                }
	}
}

?>
