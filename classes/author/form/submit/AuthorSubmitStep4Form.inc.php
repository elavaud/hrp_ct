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

	/**
	 * Constructor.
	 */
	function AuthorSubmitStep4Form(&$article, &$journal) {
		parent::AuthorSubmitForm($article, 4, $journal);
		        
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
                    $articleSitesArray = array(0 => null);
                } else foreach ($articleSites as $articleSite) {
                    array_push(
                        $articleSitesArray,
                        array(
                            'id' => $articleSite->getId(),
                            'site' => $articleSite->getSiteId()
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
					)
		);

                // Load the section. This is used in the step 2 form to
		// determine whether or not to display indexing options.
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
		$this->_data['section'] =& $sectionDao->getSection($this->article->getSectionId());

		/*
		if ($this->_data['section']->getAbstractsNotRequired() == 0) {
			$this->addCheck(new FormValidatorLocale($this, 'abstract', 'required', 'author.submit.form.abstractRequired', $this->getRequiredLocale()));
		}
		*/
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
