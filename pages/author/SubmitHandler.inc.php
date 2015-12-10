<?php

/**
 * @file SubmitHandler.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmitHandler
 * @ingroup pages_author
 *
 * @brief Handle requests for author article submission.
 */

// $Id$

import('pages.author.AuthorHandler');
import('classes.article.Article');

class SubmitHandler extends AuthorHandler {
	/** article associated with the request **/
	var $article;

	/**
	 * Constructor
	 **/
	function SubmitHandler() {
		parent::AuthorHandler();
	}


    function resubmit($args) {
        $articleId = isset($args[0]) ? (int) $args[0] : 0;

        $sectionDecisionDao = DAORegistry::getDAO('SectionDecisionDAO');
        $lastDecision = $sectionDecisionDao->getLastSectionDecision($articleId);

        $authorSubmissionDao =& DAORegistry::getDAO('AuthorSubmissionDAO');
        $authorSubmission = $authorSubmissionDao->getAuthorSubmission($articleId);
        $lastDecisionValue = $lastDecision->getDecision();

        if ($lastDecisionValue == SUBMISSION_SECTION_DECISION_INCOMPLETE || $lastDecisionValue == SUBMISSION_SECTION_DECISION_RESUBMIT) {
            
            $newSectionDecision =& new SectionDecision();
            $newSectionDecision->setArticleId($articleId);
            $newSectionDecision->setReviewType($lastDecision->getReviewType());
            $newSectionDecision->setRound($lastDecision->getRound()+1);
            $newSectionDecision->setSectionId($lastDecision->getSectionId());
            $newSectionDecision->setDecision(0);
            $newSectionDecision->setDateDecided(date(Core::getCurrentDate()));
            $authorSubmission->addDecision($newSectionDecision);    
                        
            $authorSubmissionDao->updateAuthorSubmission($authorSubmission);
            
            $step = 2;
            $articleDao =& DAORegistry::getDAO('ArticleDAO');
            $articleDao->changeArticleStatus($articleId, STATUS_QUEUED);
            $articleDao->changeArticleProgress($articleId, $step);
            
            Request::redirect(null, null, 'submit', $step, array('articleId' => $articleId));
        }
        else
        {
            Request::redirect(null, 'author', '');
        }
    }
        
     /**
      * Rename all the submitted files 
      * Enter description here ...
      */
    function renameSubmittedFiles(){
    	import('classes.file.ArticleFileManager');
    	
    	$article =& $this->article;
    	$articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
    	$articleFiles =& $articleFileDao->getArticleFilesByArticle($article->getId());
    	$articleId = $article->getId();

    	$articleFileManager = new ArticleFileManager($articleId);
    	
    	$suppFileCounter = array();
    	$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
    	 
    	/*Rename each uploaded file*/
    	foreach  ($articleFiles as $file){
            if ($file->getType() == 'supp') {
                $suppFile = $suppFileDao->getSuppFileByFileId($file->getFileId());
                if (!array_key_exists($suppFile->getType(), $suppFileCounter)) {
                    $suppFileCounter[$suppFile->getType()] = 0;
                }
    		$suppFileCounter[$suppFile->getType()] = $articleFileManager->renameFile($file->getFileId(),$file->getType(),$suppFileCounter[$suppFile->getType()], $suppFile->getType());
            } else {
    		$articleFileManager->renameFile($file->getFileId(),$file->getType());
            }
    	}
    }

	/**
	 * Display journal author article submission.
	 * Displays author index page if a valid step is not specified.
	 * @param $args array optional, if set the first parameter is the step to display
	 */
	function submit($args, $request) {
		$step = isset($args[0]) ? (int) $args[0] : 0;
		$articleId = $request->getUserVar('articleId');
                $journal =& $request->getJournal();

                $this->validate($articleId, $step, 'author.submit.authorSubmitLoginMessage');
		$article =& $this->article;
		$this->setupTemplate(true);

		$formClass = "AuthorSubmitStep{$step}Form";
		import("classes.author.form.submit.$formClass");

		$submitForm = new $formClass($article, $journal);
		if ($submitForm->isLocaleResubmit()) {
			$submitForm->readInputData();
		} else {
			$submitForm->initData();
		}
		$submitForm->display();
	}

	/**
	 * Save a submission step.
	 * @param $args array first parameter is the step being saved
	 * @param $request Request
	 */
	function saveSubmit($args, &$request) {
		$step = isset($args[0]) ? (int) $args[0] : 0;
		$articleId = $request->getUserVar('articleId');
                
		$journal =& $request->getJournal();

		$this->validate($articleId, $step);
		$this->setupTemplate(true);
		$article =& $this->article;

		$formClass = "AuthorSubmitStep{$step}Form";
		import("classes.author.form.submit.$formClass");

		$submitForm = new $formClass($article, $journal);
		$submitForm->readInputData();

		if (!HookRegistry::call('SubmitHandler::saveSubmit', array($step, &$article, &$submitForm))) {
                
			// Check for any special cases before trying to save
			switch ($step) {
				case 2:
					break;                            
				case 3:
					break;
				case 4:
					break;
				case 5:
					break;
				case 6:
					break;
				case 7:
					if ($request->getUserVar('uploadSubmissionFile')) {
                                                $submitForm->uploadSubmissionFile('submissionFile');
						$editData = true;
					}
					break;
				case 8:
                                        if ($request->getUserVar('submitUploadSuppFile')) {
                                            if($request->getUserVar('fileType'))
                                                SubmitHandler::submitUploadSuppFile(array(), $request);
                                            else
                                                Request::redirect(null, null, 'submit', '8', array('articleId' => $articleId));
                                        }
                                        break;
			}

			if (!isset($editData) && $submitForm->validate()) {
				$articleId = $submitForm->execute($request);
				HookRegistry::call('Author::SubmitHandler::saveSubmit', array(&$step, &$article, &$submitForm));
                                
				if ($step == 9) {
					
					// Rename uploaded files
					$this->renameSubmittedFiles(); /*Added by MSB, Sept29, 2011*/

					$journal =& $request->getJournal();
					$templateMgr =& TemplateManager::getManager();
					$templateMgr->assign_by_ref('journal', $journal);
					// If this is an editor and there is a
					// submission file, article can be expedited.
					if (Validation::isEditor($journal->getId()) && $article->getSubmissionFileId()) {
						$templateMgr->assign('canExpedite', true);
					}
					$templateMgr->assign('articleId', $articleId);
					$templateMgr->assign('helpTopicId','submission.index');

                                        $templateMgr->assign_by_ref('article', $this->article);

                                        $articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
                                        $articleFiles =& $articleFileDao->getArticleFilesByArticle($articleId);
                                        $templateMgr->assign_by_ref('files', $articleFiles);

                                        $templateMgr->assign_by_ref('abstractLocales', $journal->getSupportedLocaleNames());

                                        $sectionDao =& DAORegistry::getDAO('SectionDAO');
                                        $section = $sectionDao->getSection($article->getSectionId());
                                        $templateMgr->assign_by_ref('section', $section);
                                        
                                        $currencyDao =& DAORegistry::getDAO('CurrencyDAO');
                                        $sourceCurrencyId = $journal->getSetting('sourceCurrency');
                                        $templateMgr->assign('sourceCurrency', $currencyDao->getCurrencyByAlphaCode($sourceCurrencyId));
                
                                        $templateMgr->display('author/submit/complete.tpl');
					
				} else {
					$request->redirect(null, null, 'submit', $step+1, array('articleId' => $articleId));
				}
			} else {
				$submitForm->display();
			}
		}
	}

	/**
	 * Create new supplementary file with a uploaded file.
	 */
	function submitUploadSuppFile($args, $request) {
		$articleId = $request->getUserVar('articleId');
                $fileType = $request->getUserVar('fileType');
                $articleSite = $request->getUserVar('articleSite');
		$journal =& $request->getJournal();

		$this->validate($articleId, 8);
		$article =& $this->article;
		$this->setupTemplate(true);

		import('classes.author.form.submit.AuthorSubmitSuppFileForm');
		$submitForm = new AuthorSubmitSuppFileForm($article, $journal);
		$submitForm->setData('title', array($article->getLocale() => Locale::translate('common.untitled')));
		$suppFileId = $submitForm->execute();
                
                Request::redirect(null, null, 'saveSubmitSuppFile', $suppFileId, array('articleId' => $articleId, 'type' => $fileType, 'articleSite' => $articleSite));
                // End Edit Raf Tan 04/30/2011
	}

	/**
	 * Display supplementary file submission form.
	 * @param $args array optional, if set the first parameter is the supplementary file to edit
	 */
	function submitSuppFile($args, $request) {
		$articleId = $request->getUserVar('articleId');
		$suppFileId = isset($args[0]) ? (int) $args[0] : 0;
		$journal =& $request->getJournal();

		$this->validate($articleId, 8);
		$article =& $this->article;
		$this->setupTemplate(true);

		import('classes.author.form.submit.AuthorSubmitSuppFileForm');
		$submitForm = new AuthorSubmitSuppFileForm($article, $journal, $suppFileId);

		if ($submitForm->isLocaleResubmit()) {
			$submitForm->readInputData();
		} else {
			$submitForm->initData();
		}
		$submitForm->display();
	}

	/**
	 * Save a supplementary file.
	 * @param $args array optional, if set the first parameter is the supplementary file to update
	 */
	function saveSubmitSuppFile($args, $request) {
		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
            
		$articleId = $request->getUserVar('articleId');
                $type = $request->getUserVar('type');
                $articleSite = $request->getUserVar('articleSite');
                
		$suppFileId = isset($args[0]) ? (int) $args[0] : 0;
		$journal =& $request->getJournal();

		$this->validate($articleId, 8);
		$article =& $this->article;
		$this->setupTemplate(true);

		import('classes.author.form.submit.AuthorSubmitSuppFileForm');
		$submitForm = new AuthorSubmitSuppFileForm($article, $journal, $suppFileId);
                
                $typeMap = $suppFileDao->getTypeMap();
                $submitForm->setData('title', array($article->getLocale() => ($typeMap[$type])));

                $submitForm->setData('type', $type);
                $submitForm->setData('articleSite', $articleSite);
                
                $submitForm->execute();
                Request::redirect(null, null, 'submit', '8', array('articleId' => $articleId));
	}

	/**
	 * Delete a supplementary file.
	 * @param $args array, the first parameter is the supplementary file to delete
	 */
	function deleteSubmitSuppFile($args) {
		import('classes.file.ArticleFileManager');

		$articleId = Request::getUserVar('articleId');
		$suppFileId = isset($args[0]) ? (int) $args[0] : 0;

		$this->validate($articleId, 8);
		$article =& $this->article;
		$this->setupTemplate(true);

		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
		$suppFile = $suppFileDao->getSuppFile($suppFileId, $articleId);
		$suppFileDao->deleteSuppFileById($suppFileId, $articleId);

		if ($suppFile->getFileId()) {
			$articleFileManager = new ArticleFileManager($articleId);
			$articleFileManager->deleteFile($suppFile->getFileId());
		}

		Request::redirect(null, null, 'submit', '8', array('articleId' => $articleId));
	}

	function expediteSubmission() {
		$articleId = (int) Request::getUserVar('articleId');
		$this->validate($articleId);
		$journal =& Request::getJournal();
		$article =& $this->article;

		// The author must also be an editor to perform this task.
		if (Validation::isEditor($journal->getId()) && $article->getSubmissionFileId()) {
			import('classes.submission.editor.EditorAction');
			EditorAction::expediteSubmission($article);
			Request::redirect(null, 'editor', 'submissionEditing', array($article->getId()));
		}

		Request::redirect(null, null, 'track');
	}

	/**
	 * Validation check for submission.
	 * Checks that article ID is valid, if specified.
	 * @param $articleId int
	 * @param $step int
	 */
	function validate($articleId = null, $step = false, $reason = null) {
		parent::validate($reason);
		$authorSubmissionDao =& DAORegistry::getDAO('AuthorSubmissionDAO');
		$user =& Request::getUser();
		$journal =& Request::getJournal();

		if ($step !== false && ($step < 1 || $step > 9 || (!isset($articleId) && $step != 1))) {
			Request::redirect(null, null, 'submit', array(1));
		}

		$article = null;

		// Check that article exists for this journal and user and that submission is incomplete
		if (isset($articleId)) {
			$article =& $authorSubmissionDao->getAuthorSubmission((int) $articleId);
			if (!$article || $article->getUserId() !== $user->getId() || $article->getJournalId() !== $journal->getId() || ($step !== false && $step > $article->getSubmissionProgress())) {
				Request::redirect(null, null, 'submit');
			}
		}
                
		$this->article =& $article;
		return true;
	}
}
?>
