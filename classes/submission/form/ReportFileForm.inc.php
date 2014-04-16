<?php

/**
 * @file classes/submission/form/ReportFileForm.inc.php
 *
 * @class ReportFileForm
 * @ingroup submission_form
 *
 * @brief Report file form.
 */

// $Id$


import('lib.pkp.classes.form.Form');

class ReportFileForm extends Form {
    
	/** @var int the ID of the report file */
	var $fileId;

	/** @var Article current article */
	var $article;

	/** @var ArticleFile current report file */
	var $file;

	/**
	 * Constructor.
	 * @param $article object
	 * @param $fileId int (optional)
	 */
	function ReportFileForm($article, $fileId = null) {

		parent::Form(
			'author/submission/reportFileForm.tpl',
			true
		);

		$this->article = $article;

		if (isset($fileId) && !empty($fileId)) {
			$articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
			$this->file =& $articleFileDao->getArticleFile($fileId, $article->getId());
			if (isset($this->file)) {
				$this->fileId = $fileId;
			}
		}

		// Validation checks for this form
                // Comment out, AIM, June 1, 2011
		//$this->addCheck(new FormValidatorLocale($this, 'title', 'required', 'author.submit.suppFile.form.titleRequired'));
		//$this->addCheck(new FormValidatorPost($this));
	}

	/**
	 * Get the default form locale.
	 * @return string
	 */
	function getDefaultFormLocale() {
		//if ($this->article) return $this->article->getLocale();
		//return parent::getDefaultFormLocale();
	}

	/**
	 * Get the names of fields for which data should be localized
	 * @return array
	 */
	function getLocaleFieldNames() {
		//$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
		//return $suppFileDao->getLocaleFieldNames();
	}


	/**
	 * Display the form.
	 */
	function display() {
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('rolePath', Request::getRequestedPage());
		$templateMgr->assign('articleId', $this->article->getArticleId());
		$templateMgr->assign('fileId', $this->fileId);

                // Sometimes it's necessary to track the page we came from in
		// order to redirect back to the right place
		$templateMgr->assign('from', Request::getUserVar('from'));

		if (isset($this->file)) {
			$templateMgr->assign_by_ref('file', $this->file);
		}
		parent::display();
	}

	/**
	 * Validate the form
	 */
	function validate() {

		import ('classes.file.ArticleFileManager');
		$articleFileManager = new ArticleFileManager($this->article->getArticleId());
		if (!$articleFileManager->uploadedFileExists('uploadReportFile')){
                        $this->addError('uploadReportFile', Locale::translate('author.submit.form.noFileSelected'));	
		}
		return parent::validate();
	}

	/**
	 * Initialize form data from current report file (if applicable).
	 */
	function initData() {
                
	}

        
	/**
	 * Assign form data to user-submitted data.
	 * 
         */
	function readInputData() {
		$this->readUserVars(
			array(
				//'title',
				//'creator',
				//'subject',
				//'type',
				//'typeOther',
				//'description',
				//'publisher',
				//'sponsor',
				//'dateCreated',
				//'source',
				//'language',
				//'showReviewers',
				//'publicSuppFileId',
                                //'fileType',
                                //'otherFileType'
                                'type',
                                'articleId',
                                'from',
                                'uploadReportFile'
			)
		);
	}
         

	/**
	 * Save changes to the report file.
	 * @return int the report file ID
	 */
	function execute($fileName = null) {
            
                $sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
                $articleDao =& DAORegistry::getDAO('ArticleDAO');
                
		import('classes.file.ArticleFileManager');
		$articleFileManager = new ArticleFileManager($this->article->getArticleId());
                
		$fileName = isset($fileName) ? $fileName : 'uploadReportFile';
                
                $lastDecision = $this->article->getLastSectionDecision();
                
                if (($lastDecision->getDecision() == SUBMISSION_SECTION_DECISION_APPROVED || $lastDecision->getDecision() == SUBMISSION_SECTION_DECISION_EXEMPTED)&& $articleFileManager->uploadedFileExists($fileName)) {
                        $this->fileId = $articleFileManager->uploadReportFile($fileName);
                } else {
                        $this->fileId = 0;
                }

                if ($this->fileId && $this->fileId > 0){
                    $sectionDecision =& new SectionDecision();
                    $sectionDecision->setSectionId($lastDecision->getSectionId());
                    $sectionDecision->setDecision(0);
                    $sectionDecision->setDateDecided(date(Core::getCurrentDate()));      
                    $sectionDecision->setArticleId($this->article->getArticleId());
                    
                    if ($lastDecision->getReviewType() == REVIEW_TYPE_CONTINUING) {
                        $lastRound = (int) $lastDecision->getRound();
                        $sectionDecision->setRound($lastRound + 1);
                    } else {
                        $sectionDecision->setRound(1);
                    }
                            
                    
                    if ($this->getData('type') == 'progress') {
                        $sectionDecision->setReviewType(REVIEW_TYPE_CONTINUING);
                    } else {
                        $sectionDecision->setReviewType(REVIEW_TYPE_EOS);
                    }
                    
                    $sectionDecisionDao->insertSectionDecision($sectionDecision);
                    $articleDao->changeArticleStatus($this->article->getArticleId(), STATUS_QUEUED);
                }
                
		// Notifications
		import('lib.pkp.classes.notification.NotificationManager');
		$notificationManager = new NotificationManager();
		$journal =& Request::getJournal();
		$url = Request::url($journal->getPath(), 'sectionEditor', 'submissionReview', array($this->article->getArticleId()));
                $sectionEditorsDao =& DAORegistry::getDAO('SectionEditorsDAO');
                $sectionEditors =& $sectionEditorsDao->getEditorsBySectionId($journal->getId(), $lastDecision->getSectionId());
		foreach ($sectionEditors as $sectionEditor) {
                    $notificationSectionEditors[] = array('id' => $sectionEditor->getId());
                }
                if ($this->getData('type') == 'progress') {
                    $message = 'notification.type.progressReport'; 
                } else { 
                    $message = 'notification.type.completionReport';
                }
                if (isset($message)){
                    foreach ($notificationSectionEditors as $userRole) {
                        $notificationManager->createNotification(
                                $userRole['id'], $message,
                                $this->article->getProposalId(), $url, 1, NOTIFICATION_TYPE_SUPP_FILE_MODIFIED
                        );
                    }
                }
		
		return $this->fileId;
	}

}

?>
