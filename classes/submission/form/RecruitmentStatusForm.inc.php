<?php

/**
 * @file classes/submission/form/RecruitmentStatusForm.inc.php
 *
 * @class RecruitmentStatusForm
 * @ingroup submission_form
 *
 * @brief Form for changing the recruitment status of a proposal.
 */

// $Id$


import('lib.pkp.classes.form.Form');

class RecruitmentStatusForm extends Form {

	/** @var Article current article */
	var $article;

	/**
	 * Constructor.
	 * @param $article object
	 */
	function RecruitmentStatusForm($article) {
		parent::Form(
			'submission/metadata/recruitmentStatus.tpl',
			true,
			$article->getLocale()			
		);
		$this->article = $article;
	}

	/**
	 * Display the form.
	 */
	function display() {
                $journal = Request::getJournal();
            
                $articleDetailsDao =& DAORegistry::getDAO('ArticleDetailsDAO');
            
		$templateMgr =& TemplateManager::getManager();

		$templateMgr->assign('rolePath', Request::getRequestedPage());
		$templateMgr->assign('articleId', $this->article->getArticleId());
                $templateMgr->assign('recruitmentStatusMap', $articleDetailsDao->getRecruitmentStatusMap());
                $templateMgr->assign('articleTextLocales', $journal->getSupportedLocaleNames());
                
                parent::display();
	}

	/**
	 * Initialize form data from current supplementary file (if applicable).
	 */
	function initData() {
            $journal = Request::getJournal();
            
            $details = $this->article->getArticleDetails();
            $this->_data = array(
                'articleTexts' => array(),
                'articleId' => $this->article->getId(),
                'recruitStatus' => $details->getRecruitmentStatus()
            );
            $articleTexts =& $this->article->getArticleTexts();
            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                if (isset($articleTexts[$localeKey])) {
                    $this->_data['articleTexts'][$localeKey] = $articleTexts[$localeKey]->getRecruitmentInfo();
                }
            }                
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
            $this->readUserVars(
                array(
                    'articleId',
                    'articleTexts',
                    'recruitStatus'
                )
            );
	}

	/**
	 * Save changes to the proposal.
	 * @return int the article ID
	 */
	function execute() {
            $articleDao =& DAORegistry::getDAO('ArticleDAO');
            $article =& $this->article;

            $journal = Request::getJournal();
            $articleTexts = $this->getData('articleTexts');
            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                $articleText = $article->getArticleTextByLocale($localeKey);
                if ($articleText != null) {
                    $articleText->setRecruitmentInfo($articleTexts[$localeKey]);		
                }
                unset($articleText);                    
            }                

            $articleDetails = $article->getArticleDetails();

            $articleDetails->setRecruitmentStatus($this->getData('recruitStatus'));

            parent::execute();

            // Save the article
            $articleDao->updateArticle($article);

            return true;
	}
}

?>
