<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep8Form.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AuthorSubmitStep8Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 8 of author article submission.
 */

// $Id$


import('classes.author.form.submit.AuthorSubmitForm');

class AuthorSubmitStep8Form extends AuthorSubmitForm {
	/**
	 * Constructor.
	 */
	function AuthorSubmitStep8Form(&$article, &$journal) {
		parent::AuthorSubmitForm($article, 8, $journal);
	}

	/**
	 * Display the form.
	 */
	function display() {
            
		$article =& $this->article;
                $sites = $article->getArticleSites();
                $details = $article->getArticleDetails();
                $drugs = $article->getArticleDrugs();
                $CROs = $article->getArticleCROs();
                
		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
		$trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');                
                
                $goToNextStep = true;
                
                $impds = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_IMPD);
                $approvalLetters = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_APPROVAL);
                $informedConsents = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_CONSENT);
                $labelss = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_LABELS);
                $gmps = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_GMP);
                $policies = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_POLICY);
                $relatedPublications = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_PUBLICATIONS);
                if (empty($impds) 
                        || empty($approvalLetters) 
                        || empty($informedConsents) 
                        || empty($labelss) 
                        || empty($gmps) 
                        || empty($policies)) {
                    $goToNextStep = false;
                }
                $sitesList = array();
                $sitesArray = array();
                foreach ($sites as $site) {
                    $trialSite = $trialSiteDao->getTrialSiteById($site->getSiteId());
                    $endorsmentLetters = $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->articleId, SUPP_FILE_ENDORSMENT, $site->getId());
                    $CVs = $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->articleId, SUPP_FILE_CV, $site->getId());
                    if (empty($endorsmentLetters) || empty($CVs)) {
                        $goToNextStep = false;
                    }
                    $sitesList[$site->getId()] = $trialSite->getName();
                    $siteArray = array('name' => $trialSite->getName(), 'endorsmentLetters' => $endorsmentLetters, 'CVs' => $CVs);
                    array_push($sitesArray, $siteArray);
                }
                $CROsList = array();
                $CROsArray = array();
                if ($details->getCROInvolved() == ARTICLE_DETAIL_YES) {
                    foreach ($CROs as $CRO) {
                        $delegationLetters = $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->articleId, SUPP_FILE_DELEGATION, $CRO->getId());
                        if (empty($delegationLetters)) {
                            $goToNextStep = false;
                        }
                        $CROsList[$CRO->getId()] = $CRO->getName();
                        array_push($CROsArray, array('name' => $CRO->getName(), 'delegations' => $delegationLetters));
                    }
                }                
                $drugsListForIB = array();
                $drugsListForSMPC = array();                
                $drugsArray = array();
                foreach ($drugs as $drug) {
                    $IB = false;
                    $classes = $drug->getClassesArray();
                    foreach ($classes as $class) {
                        if ($class == ARTICLE_DRUG_INFO_CLASS_IV) {
                            $SmPCs = $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->articleId, SUPP_FILE_SMPC, $drug->getId());
                            array_push($drugsArray, array('name' => $drug->getName(), 'ib' => false, 'smpcs' => $SmPCs));
                            $drugsListForSMPC[$drug->getId()] = $drug->getName();
                            if (empty($SmPCs)) {
                                $goToNextStep = false;
                            }
                        } else {
                            if(!$IB){
                                $IBs = $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->articleId, SUPP_FILE_BROCHURE, $drug->getId());
                                array_push($drugsArray, array('name' => $drug->getName(), 'ib' => true, 'ibs' => $IBs));
                                $drugsListForIB[$drug->getId()] = $drug->getName();
                                if (empty($IBs)) {
                                    $goToNextStep = false;
                                }   
                            }
                            $IB = true;
                        }
                    }
                }
                $showAdvertisements = false;
                if ($details->getAdvertisingScheme() == ARTICLE_DETAIL_YES) {
                    $showAdvertisements = true;
                    $advertisements = $suppFileDao->getSuppFilesByArticleAndType($this->articleId, SUPP_FILE_ADVERTISEMENT);
                    if (empty($advertisements)) {$goToNextStep = false;}
                }
                
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('typeOptions', $suppFileDao->getTypeMap());
		$templateMgr->assign_by_ref('impds', $impds);
		$templateMgr->assign_by_ref('approvalLetters', $approvalLetters);
		$templateMgr->assign_by_ref('informedConsents', $informedConsents);
		$templateMgr->assign_by_ref('labelss', $labelss);
		$templateMgr->assign_by_ref('gmps', $gmps);
		$templateMgr->assign_by_ref('policies', $policies);
		$templateMgr->assign('sitesArray', $sitesArray);
		$templateMgr->assign('sitesList', $sitesList);
		$templateMgr->assign('drugsArray', $drugsArray);
		$templateMgr->assign('drugsListForIB', $drugsListForIB);
		$templateMgr->assign('drugsListForSMPC', $drugsListForSMPC);                
		$templateMgr->assign('showAdvertisements', $showAdvertisements);
		$templateMgr->assign_by_ref('advertisements', $advertisements);
		$templateMgr->assign('CROsList', $CROsList);
		$templateMgr->assign('CROsArray', $CROsArray);
		$templateMgr->assign_by_ref('relatedPublications', $relatedPublications);     
		$templateMgr->assign('goToNextStep', $goToNextStep);
                
                parent::display();
	}

	/**
	 * Save changes to article.
	 */
	function execute() {
		$articleDao =& DAORegistry::getDAO('ArticleDAO');

		// Update article
		$article =& $this->article;
		if ($article->getSubmissionProgress() <= $this->step) {
			$article->stampStatusModified();
			$article->setSubmissionProgress($this->step + 1);
		}
		$articleDao->updateArticle($article);

		return $this->articleId;
	}
}

?>
