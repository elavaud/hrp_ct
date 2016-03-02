<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep4Form.inc.php
 *
 * @class AuthorSubmitStep4Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 4 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');
import('classes.form.validation.FormValidatorArrayRadios');

class AuthorSubmitStep4Form extends AuthorSubmitForm {

        var $trialSiteDao;
	/**
	 * Constructor.
	 */
	function AuthorSubmitStep4Form(&$article, &$journal) {
            parent::AuthorSubmitForm($article, 4, $journal);
            $this->trialSiteDao = DAORegistry::getDAO("TrialSiteDAO");
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.siteSelect.required', array('siteSelect')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.siteInfo.required', array('siteName', 'siteAddress', 'siteCity', 'siteRegion', 'siteLicensure', 'siteAccreditation')));	
            $this->addCheck(new FormValidatorCustom($this, 'articleSites', 'required', 'author.submit.form.site.nameAndCityUsed', function($articleSites) {foreach ($articleSites as $articleSite) { if($this->trialSiteDao->trialSiteExistsByNameAndCity($articleSite['siteName'], $articleSite['siteCity'])) {return false;}} return true;})); 
            $this->addCheck(new FormValidatorCustom($this, 'articleSites', 'required', 'author.submit.form.site.licensureUsed', function($articleSites) {foreach ($articleSites as $articleSite) {if($this->trialSiteDao->trialSiteExistsByLicensure($articleSite['siteLicensure'])) {return false;}}return true;})); 
            $this->addCheck(new FormValidatorCustom($this, 'articleSites', 'required', 'author.submit.form.site.accreditationUsed', function($articleSites) {foreach ($articleSites as $articleSite) { if($this->trialSiteDao->trialSiteExistsByAccreditation($articleSite['siteAccreditation'])) {return false;}}return true;})); 
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.authority.required', array('authority')));
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.erc.required', array('erc')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.primaryPhone.required', array('primaryPhone')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.email.required', array('email')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.subjectsNumber.required', array('subjectsNumber')));
            $this->addCheck(new FormValidatorCustom($this, 'articleSites', 'required', 'author.submit.form.investigators.required', 
                function($articleSites) {
                    foreach ($articleSites as $articleSite) {
                        $investigators = $articleSite['investigators'];
                        foreach ($investigators as $investigator) {
                            if($investigator['firstName'] == ''
                                    || $investigator['lastName'] == ''
                                    || $investigator['iPrimaryPhone'] == ''
                                    || $investigator['expertise'] == ''
                                    || $investigator['iEmail'] == '') {
                                return false;
                            }
                        }
                    }
                    return true;
                }
            )); 

        }

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
            if (isset($this->article)) {
                $article =& $this->article;

                $articleSites = $article->getArticleSites();
                $articleSitesArray = array();
                if ($articleSites == null) {
                    $articleSitesArray = array(0 => array('investigators' => array(0 => null)));
                } else foreach ($articleSites as $articleSite) {
                    $investigators = $articleSite->getInvestigators();
                    $investigatorsArray = array();
                    foreach ($investigators as $investigator) {
                        array_push(
                            $investigatorsArray, 
                            array (
                                'id' => $investigator->getId(),
                                'firstName' => $investigator->getFirstName(),
                                'lastName' => $investigator->getLastName(),
                                'expertise' => $investigator->getExpertise(),                                
                                'iPrimaryPhone' => $investigator->getPrimaryPhoneNumber(),
                                'iSecondaryPhone' => $investigator->getSecondaryPhoneNumber(),
                                'iFax' => $investigator->getFaxNumber(),
                                'iEmail' => $investigator->getEmail()
                            )
                        );
                    }
                    array_push(
                        $articleSitesArray,
                        array(
                            'id' => $articleSite->getId(),
                            'siteSelect' => $articleSite->getSiteId(),
                            'authority' => $articleSite->getAuthority(),
                            'erc' => $articleSite->getERCId(),
                            'primaryPhone' => $articleSite->getPrimaryPhone(),
                            'secondaryPhone' => $articleSite->getSecondaryPhone(),
                            'fax' => $articleSite->getFax(),
                            'email' => $articleSite->getEmail(),
                            'subjectsNumber' =>  $articleSite->getSubjectsNumber(),
                            'investigators' => $investigatorsArray
                        )
                    );
                }
                $this->_data = array(
                    'articleSites' => $articleSitesArray
                );

            }
            return parent::initData();
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(
			array(
                            'articleSites'
                        )
		);
	}

	/**
	 * Get the names of fields for which data should be localized
	 * @return array
	 */
	function getLocaleFieldNames() {
		return array();
	}

	/**
	 * Display the form.
	 */
	function display() {                
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
		$trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');
                
                $geoAreas =& $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_GEO_AREA, EXTRA_FIELD_ACTIVE);
                $ercList =& $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_LEVEL3_ERC, EXTRA_FIELD_ACTIVE);
                
                $sitesList = $trialSiteDao->getTrialSitesList();
                $sitesListWithOther = $sitesList + array('OTHER' => Locale::translate('common.other'));
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('sitesList', $sitesListWithOther);
                $templateMgr->assign('geoAreas', $geoAreas);
                $templateMgr->assign('ercList', $ercList);                
                $templateMgr->assign('expertisesList', $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_THERAPEUTIC_AREA, EXTRA_FIELD_ACTIVE));
                
                
                parent::display();
	}

	/**
	 * Save changes to article.
	 * @param $request Request
	 * @return int the article ID
	 */
	function execute(&$request) {
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$article =& $this->article;
                
                $articleSitesData = $this->getData('articleSites');
                $articleSites = $article->getArticleSites();
		import('classes.journal.TrialSite');
		import('classes.article.ArticleSite');

                // Remove deleted article sites
                foreach ($articleSites as $articleSite) {
                    $isPresent = false;
                    foreach ($articleSitesData as $articleSiteData) {
                        if (!empty($articleSiteData['id'])) {
                            if ($articleSite->getId() == $articleSiteData['id']) {
                                $isPresent = true;
                            }
                        }
                    }
                    if (!$isPresent) {
                        $article->removeArticleSite($articleSite->getId());
                    }
                    unset($isPresent);                    
                    unset($articleSite);
                }
                
                // Update / Insters article sites
                foreach ($articleSitesData as $articleSiteData) {
                    if (isset($articleSiteData['id'])) {
                        $articleSite = $article->getArticleSite($articleSiteData['id']);
                        $isExistingSite = true;
                    } else {
                        $articleSite = new ArticleSite();
                        $isExistingSite = false;
                    }
                    $articleSite->setArticleId($article->getId());
                    if ($articleSiteData['siteSelect'] == "OTHER") {
                        $trialSite = new TrialSite();
                        $trialSite->setName($articleSiteData['siteName']);
                        $trialSite->setAddress($articleSiteData['siteAddress']);
                        $trialSite->setCity($articleSiteData['siteCity']);
                        $trialSite->setRegion($articleSiteData['siteRegion']);
                        $trialSite->setLicensure($articleSiteData['siteLicensure']);
                        $trialSite->setAccreditation($articleSiteData['siteAccreditation']);
                        $articleSite->setSiteId($this->trialSiteDao->insertTrialSite($trialSite));
                    } else {
                        $articleSite->setSiteId($articleSiteData['siteSelect']);
                    }
                    $articleSite->setAuthority($articleSiteData['authority']);
                    $articleSite->setERCId($articleSiteData['erc']);
                    $articleSite->setPrimaryPhone($articleSiteData['primaryPhone']);
                    $articleSite->setSecondaryPhone($articleSiteData['secondaryPhone']);
                    $articleSite->setFax($articleSiteData['fax']);
                    $articleSite->setEmail($articleSiteData['email']);
                    $articleSite->setSubjectsNumber($articleSiteData['subjectsNumber']);
                    
                    $investigatorsData = $articleSiteData['investigators'];
                    $investigators = $articleSite->getInvestigators();
                    // Remove deleted investigators
                    foreach ($investigators as $investigator) {
                        $isPresent = false;
                        foreach ($investigatorsData as $investigatorData) {
                            if (!empty($investigatorData['id'])) {
                                if ($investigator->getId() == $investigatorData['id']) {
                                    $isPresent = true;
                                }
                            }
                        }
                        if (!$isPresent) {
                            $articleSite->removeInvestigator($investigator->getId());
                        }
                        unset($isPresent);                    
                        unset($investigator);
                    }
                    // Update / Insert Investigators
                    $investigatorIterator = 1;
                    foreach ($investigatorsData as $investigatorData) {
                        if (isset($investigatorData['id'])){
                            $investigator = $articleSite->getInvestigator($investigatorData['id']);
                        } else {
                            $investigator = new Author();
                        }
                        if ($isExistingSite) {
                            $investigator->setSiteId($articleSite->getId());
                        }
                        if ($investigatorIterator == 1) {
                            $investigator->setPrimaryContact(1);
                        }
                        $investigator->setSequence($investigatorIterator);
                        $investigator->setFirstName($investigatorData['firstName']);
                        $investigator->setLastName($investigatorData['lastName']);
                        $investigator->setExpertise($investigatorData['expertise']);
                        $investigator->setPrimaryPhoneNumber($investigatorData['iPrimaryPhone']);
                        $investigator->setSecondaryPhoneNumber($investigatorData['iSecondaryPhone']);
                        $investigator->setFaxNumber($investigatorData['iFax']);
                        $investigator->setEmail($investigatorData['iEmail']);
                        $articleSite->addInvestigator($investigator);
                        $investigatorIterator++;
                    }
                    $article->addArticleSite($articleSite);
                }
                
                //update step
                if ($article->getSubmissionProgress() <= $this->step) {
			$article->stampStatusModified();
			$article->setSubmissionProgress($this->step + 1);
		} elseif ($article->getSubmissionProgress() == 9) {
                        $article->setSubmissionProgress(8);                            
                }                

		parent::execute();

		// Save the article
		$articleDao->updateArticle($article);

		return $this->articleId;
	}
}

?>
