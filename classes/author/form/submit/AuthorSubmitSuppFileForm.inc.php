<?php

/**
 * @file classes/author/form/submit/AuthorSubmitSuppFileForm.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AuthorSubmitSuppFileForm
 * @ingroup author_form_submit
 *
 * @brief Supplementary file author submission form.
 */

// $Id$


import('lib.pkp.classes.form.Form');

class AuthorSubmitSuppFileForm extends Form {
	/** @var int the ID of the article */
	var $articleId;

	/** @var int the ID of the supplementary file */
	var $suppFileId;

	/** @var Article current article */
	var $article;

	/** @var SuppFile current file */
	var $suppFile;

	/**
	 * Constructor.
	 * @param $article object
	 * @param $journal object
	 * @param $suppFileId int (optional)
	 */
	function AuthorSubmitSuppFileForm(&$article, &$journal, $suppFileId = null) {
		$supportedSubmissionLocales = $journal->getSetting('supportedSubmissionLocales');
		if (empty($supportedSubmissionLocales)) $supportedSubmissionLocales = array($journal->getPrimaryLocale());

		parent::Form(
			'author/submit/suppFile.tpl',
			true,
			$journal->getPrimaryLocale(),
			array_flip(array_intersect(
				array_flip(Locale::getAllLocales()),
				$supportedSubmissionLocales
			))
		);
		$this->articleId = $article->getId();

		if (isset($suppFileId) && !empty($suppFileId)) {
			$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
			$this->suppFile =& $suppFileDao->getSuppFile($suppFileId, $article->getId());
			if (isset($this->suppFile)) {
				$this->suppFileId = $suppFileId;
			}
		}

		// Validation checks for this form
		//$this->addCheck(new FormValidatorLocale($this, 'title', 'required', 'author.submit.suppFile.form.titleRequired', $this->getRequiredLocale()));
		//$this->addCheck(new FormValidatorPost($this));
	}

	/**
	 * Get the names of fields for which data should be localized
	 * @return array
	 */
	function getLocaleFieldNames() {
		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
		return $suppFileDao->getLocaleFieldNames();
	}

	/**
	 * Display the form.
	 */
	function display() {
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('articleId', $this->articleId);
		$templateMgr->assign('suppFileId', $this->suppFileId);
		$templateMgr->assign('submitStep', 8);

		$typeOptionsOutput = array(
			'author.submit.suppFile.researchInstrument',
			'author.submit.suppFile.researchMaterials',
			'author.submit.suppFile.researchResults',
			'author.submit.suppFile.transcripts',
			'author.submit.suppFile.dataAnalysis',
			'author.submit.suppFile.dataSet',
			'author.submit.suppFile.sourceText'
		);
		$typeOptionsValues = $typeOptionsOutput;
		array_push($typeOptionsOutput, 'common.other');
		array_push($typeOptionsValues, '');

		$templateMgr->assign('typeOptionsOutput', $typeOptionsOutput);
		$templateMgr->assign('typeOptionsValues', $typeOptionsValues);

		if (isset($this->article)) {
			$templateMgr->assign('submissionProgress', $this->article->getSubmissionProgress());
		}

		if (isset($this->suppFile)) {
			$templateMgr->assign_by_ref('suppFile', $this->suppFile);
		}
		$templateMgr->assign('helpTopicId','submission.supplementaryFiles');
		parent::display();
	}

	/**
	 * Initialize form data from current supplementary file (if applicable).
	 */
	function initData() {
		if (isset($this->suppFile)) {
			$suppFile =& $this->suppFile;
			$this->_data = array(
				'title' => $suppFile->getTitle(null), // Localized
				'creator' => $suppFile->getCreator(null), // Localized
				'subject' => $suppFile->getSubject(null), // Localized
				'type' => $suppFile->getType(),
				'typeOther' => $suppFile->getTypeOther(null), // Localized
				'description' => $suppFile->getDescription(null), // Localized
				'publisher' => $suppFile->getPublisher(null), // Localized
				'sponsor' => $suppFile->getSponsor(null), // Localized
				'dateCreated' => $suppFile->getDateCreated(),
				'source' => $suppFile->getSource(null), // Localized
				'language' => $suppFile->getLanguage(),
				'showReviewers' => $suppFile->getShowReviewers()
			);

		} else {
			$this->_data = array(
				'type' => ''
			);
		}

	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(
			array(
				'title',
				'creator',
				'subject',
				'type',
				'articleSite',
				'description',
				'publisher',
				'sponsor',
				'dateCreated',
				'source',
				'language',
				'showReviewers'
			)
		);
	}

	/**
	 * Save changes to the supplementary file.
	 * @return int the supplementary file ID
	 */
	function execute() {
		import('classes.file.ArticleFileManager');
		$articleFileManager = new ArticleFileManager($this->articleId);
		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');

		$fileName = 'uploadSuppFile';

		// edit an existing supp file, otherwise create new supp file entry
		if (isset($this->suppFile)) {
			$suppFile =& $this->suppFile;

			// Remove old file and upload new, if file is selected.
			if ($articleFileManager->uploadedFileExists($fileName)) {
				$articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
				$suppFileId = $articleFileManager->uploadSuppFile($fileName, $suppFile->getFileId(), true);
				$suppFile->setFileId($suppFileId);
			}

			// Update existing supplementary file
			$this->setSuppFileData($suppFile);
			$suppFileDao->updateSuppFile($suppFile);

		} else {
			// Upload file, if file selected.
			if ($articleFileManager->uploadedFileExists($fileName)) {
				$fileId = $articleFileManager->uploadSuppFile($fileName);

                                // Insert new supplementary file
                                $suppFile = new SuppFile();
                                $suppFile->setArticleId($this->articleId);
                                $suppFile->setFileId($fileId);
                                $this->setSuppFileData($suppFile);
                                $suppFileDao->insertSuppFile($suppFile);
                                $this->suppFileId = $suppFile->getId();
			} else {
				$fileId = 0;
			}
		}
		return $this->suppFileId;
	}

	/**
	 * Assign form data to a SuppFile.
	 * @param $suppFile SuppFile
	 */
	function setSuppFileData(&$suppFile) {
		$suppFile->setTitle($this->getData('title'), null); // Null
		$suppFile->setType($this->getData('type'));
                if ($this->getData('type') == SUPP_FILE_ENDORSMENT || $this->getData('type') == SUPP_FILE_CV) {
                    $suppFile->setSuppAssocId($this->getData('articleSite'));
                }
                $suppFile->setShowReviewers(1);
	}
}

?>
