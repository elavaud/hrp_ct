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
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.primaryPhone.required', array('primaryPhone')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.email.required', array('email')));	
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.subjectsNumber.required', array('subjectsNumber')));
            $this->addCheck(new FormValidatorArray($this, 'articleSites', 'required', 'author.submit.form.investigators.required', array('investigators')));
        }

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
            $sectionDao =& DAORegistry::getDAO('SectionDAO');
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
                
                $sitesList = $trialSiteDao->getTrialSitesList();
                $sitesListWithOther = $sitesList + array('OTHER' => Locale::translate('common.other'));
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('sitesList', $sitesListWithOther);
                $templateMgr->assign('geoAreas', $geoAreas);
                
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
                
		// Retrieve the previous citation list for comparison.
		$previousRawCitationList = $article->getCitations();
              
                //update step
                if ($article->getSubmissionProgress() <= $this->step) {
			$article->stampStatusModified();
			$article->setSubmissionProgress($this->step + 1);
		}                

		parent::execute();

		// Save the article
		$articleDao->updateArticle($article);

		// Update references list if it changed.
		$citationDao =& DAORegistry::getDAO('CitationDAO');
		$rawCitationList = $article->getCitations();
		if ($previousRawCitationList != $rawCitationList) {
			$citationDao->importCitations($request, ASSOC_TYPE_ARTICLE, $article->getId(), $rawCitationList);
		}
		return $this->articleId;
	}
}

?>
