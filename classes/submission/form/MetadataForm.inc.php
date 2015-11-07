<?php

/**
 * @file classes/submission/form/MetadataForm.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class MetadataForm
 * @ingroup submission_form
 *
 * @brief Form to change metadata information for a submission.
 */


import('lib.pkp.classes.form.Form');
import('classes.form.validation.FormValidatorArrayRadios');

class MetadataForm extends Form {
	/** @var Article current article */
	var $article;

	/** @var boolean can edit metadata */
	var $canEdit;

	/** @var boolean can view authors */
	var $canViewAuthors;

	/** @var boolean is an Editor, can edit all metadata */
	var $isEditor;

	/**
	 * Constructor.
	 */
	function MetadataForm($article, $journal) {
		$roleDao =& DAORegistry::getDAO('RoleDAO');
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');

		$user =& Request::getUser();
		$roleId = $roleDao->getRoleIdFromPath(Request::getRequestedPage());

                if ($roleId == ROLE_ID_AUTHOR || $roleId == ROLE_ID_SECTION_EDITOR) {
                    $this->canEdit = true;
                } else {
                    $this->canEdit = false;
                }

                if ($this->canEdit) {
                        $supportedSubmissionLocales = $journal->getSetting('supportedSubmissionLocales');
                        if (empty($supportedSubmissionLocales)) $supportedSubmissionLocales = array($journal->getPrimaryLocale());

                        parent::Form(
                                'submission/metadata/metadataEdit.tpl',
                                true,
                                $article->getLocale(),
                                array_flip(array_intersect(
                                        array_flip(Locale::getAllLocales()),
                                        $supportedSubmissionLocales
                                ))
                        );

                       
                } else {
                        parent::Form('submission/metadata/metadataView.tpl');
                }

		$this->article = $article;
                
		$this->addCheck(new FormValidatorPost($this));
	}

	/**
	 * Get the default form locale.
	 * @return string
	 */
	function getDefaultFormLocale() {
		return parent::getDefaultFormLocale();
	}

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
		if (isset($this->article)) {
			$article =& $this->article;
                        // Initialize th proposal details
                                                                       						
			$this->_data = array(
				'section' => $sectionDao->getSection($article->getSectionId())                                 
			);
			
		}
		return parent::initData();
	}

	/**
	 * Get the field names for which data can be localized
	 * @return array
	 */
	function getLocaleFieldNames() {
		return array();
	}

	/**
	 * Display the form.
	 */
	function display() {
                $journal = Request::getJournal();
                $settingsDao =& DAORegistry::getDAO('JournalSettingsDAO');
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
                
		Locale::requireComponents(array(LOCALE_COMPONENT_OJS_EDITOR)); // editor.cover.xxx locale keys; FIXME?

		$templateMgr =& TemplateManager::getManager();

		$templateMgr->assign('helpTopicId','submission.indexingAndMetadata');
		if ($this->article) {
			$templateMgr->assign_by_ref('section', $sectionDao->getSection($this->article->getSectionId()));
		}

		if ($this->isEditor) {
			import('classes.article.Article');
			$hideAuthorOptions = array(
				AUTHOR_TOC_DEFAULT => Locale::Translate('editor.article.hideTocAuthorDefault'),
				AUTHOR_TOC_HIDE => Locale::Translate('editor.article.hideTocAuthorHide'),
				AUTHOR_TOC_SHOW => Locale::Translate('editor.article.hideTocAuthorShow')
			);
			$templateMgr->assign('hideAuthorOptions', $hideAuthorOptions);
			$templateMgr->assign('isEditor', true);
		}
                
		                
		$templateMgr->assign('articleId', isset($this->article)?$this->article->getId():null);
		$templateMgr->assign('journalSettings', $settingsDao->getJournalSettings($journal->getId()));
		$templateMgr->assign('rolePath', Request::getRequestedPage());
		$templateMgr->assign('canViewAuthors', $this->canViewAuthors);
                
                parent::display();
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
	 * Save changes to article.
	 * @param $request PKPRequest
	 * @return int the article ID
	 */
	function execute(&$request) {
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$article =& $this->article;
                
		// Retrieve the previous citation list for comparison.
		$previousRawCitationList = $article->getCitations();

               
		parent::execute();

		// Save the article
		$articleDao->updateArticle($article);

		// Update references list if it changed.
		$citationDao =& DAORegistry::getDAO('CitationDAO');
		$rawCitationList = $article->getCitations();
		if ($previousRawCitationList != $rawCitationList) {
			$citationDao->importCitations($request, ASSOC_TYPE_ARTICLE, $article->getId(), $rawCitationList);
		}
	}

	/**
	 * Determine whether or not the current user is allowed to edit metadata.
	 * @return boolean
	 */
	function getCanEdit() {
		return $this->canEdit;
	}
}

?>
