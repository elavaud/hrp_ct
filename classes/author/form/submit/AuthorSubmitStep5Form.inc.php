<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep5Form.inc.php
 *
 * @class AuthorSubmitStep5Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 5 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');
import('classes.form.validation.FormValidatorArrayRadios');

class AuthorSubmitStep5Form extends AuthorSubmitForm {

	/**
	 * Constructor.
	 */
	function AuthorSubmitStep5Form(&$article, &$journal) {
            parent::AuthorSubmitForm($article, 5, $journal);
                
            $this->addCheck(new FormValidatorArray($this, 'fundingSources', 'required', 'author.submit.form.fundingSources.required', array('institutionId', 'name', 'acronym', 'type', 'location', 'locationCountry', 'locationInternational')));	
            //$this->addCheck(new FormValidatorArray($this, 'primarySponsor', 'required', 'author.submit.form.primarySponsor.required'));	
            //$this->addCheck(new FormValidatorArray($this, 'secondarySponsors', 'required', 'author.submit.form.secondarySponsors.required'));	
		        
        }

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
            if (isset($this->article)) {
                $article =& $this->article;

                $fundingSources = $article->getArticleFundingSources();
                $fundingSourcesArray = array();
                if ($fundingSources == null) {
                    $fundingSourcesArray = array(0 => null);
                } else foreach ($fundingSources as $fundingSource){
                    array_push (
                        $fundingSourcesArray,
                        array(
                            'id' => $fundingSource->getId(),
                            'institutionId' => $fundingSource->getInstitutionId()
                        )
                    );
                }
                $primarySponsor = $article->getArticlePrimarySponsor();
                $secondarySponsors = $article->getArticleSecondarySponsors();
                $secondarySponsorsArray = array();
                if ($secondarySponsors == null) {
                    $secondarySponsorsArray = array(0 => null);
                } else foreach ($secondarySponsors as $secondarySponsor){
                    array_push (
                        $secondarySponsorsArray,
                        array(
                            'id' => $secondarySponsor->getId(),
                            'institutionId' => $secondarySponsor->getInstitutionId()
                        )
                    );
                }
                
                $this->_data = array(
                    'fundingSources' => $fundingSourcesArray,
                    'primarySponsor' => $primarySponsor->getInstitutionId(),
                    'secondarySponsors' => $secondarySponsorsArray
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
                            'fundingSources',
                            'primarySponsor',
                            'secondarySponsors'
                        )
		);

                // Load the section. This is used in the step 5 form to
		// determine whether or not to display indexing options.
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
		$this->_data['section'] =& $sectionDao->getSection($this->article->getSectionId());
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
		$countryDao =& DAORegistry::getDAO('CountryDAO');
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
		$institutionDao =& DAORegistry::getDAO('InstitutionDAO');
                
                $geoAreas =& $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_GEO_AREA, EXTRA_FIELD_ACTIVE);
                
                $institutionsList = $institutionDao->getInstitutionsList();
                $institutionsListWithOther = $institutionsList + array('OTHER' => Locale::translate('common.other'));
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('institutionTypesList', $institutionDao->getInstitutionTypes());
                $templateMgr->assign('geoAreasList', $geoAreas);
                $templateMgr->assign('coutryList', $countryDao->getCountries());
                $templateMgr->assign('institutionsList', $institutionsListWithOther);
                $templateMgr->assign('internationalArray', $institutionDao->getInstitutionInternationalArray());
                                
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
