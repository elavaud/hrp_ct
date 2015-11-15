<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/Article.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Article
 * @ingroup article
 * @see ArticleDAO
 *
 * @brief Article class.
 */


// Submission status constants
define('STATUS_ARCHIVED', 0);
define('STATUS_QUEUED', 1); 	// In Review
define('STATUS_REVIEWED', 2);	// The proposal is not anymore under review
define('STATUS_WITHDRAWN', 3);	// Withdrawn proposal
define('STATUS_COMPLETED', 4);	// Completed proposal


// Author display in ToC
define ('AUTHOR_TOC_DEFAULT', 0);
define ('AUTHOR_TOC_HIDE', 1);
define ('AUTHOR_TOC_SHOW', 2);

// Article RT comments
define ('COMMENTS_SECTION_DEFAULT', 0);
define ('COMMENTS_DISABLE', 1);
define ('COMMENTS_ENABLE', 2);

import('lib.pkp.classes.submission.Submission');

class Article extends Submission {
    
        var $articleTexts;
        
        var $removedArticleTexts;

        var $articleSecIds;
        
        var $removedArticleSecIds;

	var $articleDetails;

        var $articlePurposes;
        
        var $removedArticlePurposes;

        var $articleOutcomes;
        
        var $removedArticleOutcomes;

        var $articleDrugs;
        
        var $removedArticleDrugs;
        
        
	/**
	 * Constructor.
	 */
	function Article() {
		parent::Submission();
                $this->articleTexts = array();
		$this->removedArticleTexts = array();
                $this->articleSecIds = array();
		$this->removedArticleSecIds = array();	
                $this->articlePurposes = array();
		$this->removedArticlePurposes = array();	
                $this->articleOutcomes = array();
		$this->removedArticleOutcomes = array();
                $this->articleDrugs = array();
		$this->removedArticleDrugs = array();
        }

	/**
	 * @see Submission::getAssocType()
	 */
	function getAssocType() {
		return ASSOC_TYPE_ARTICLE;
	}

	//
	// Get/set methods
	//

	/**
	 * Get ID of article.
	 * @return int
	 */
	function getArticleId() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getId();
	}

	/**
	 * Set ID of article.
	 * @param $articleId int
	 */
	function setArticleId($articleId) {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->setId($articleId);
	}

        /**
	 * Get ID of the last section decision.
	 * @return int
	 */
	function getSectionId() {
                $sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
                $lastSectionDecision =& $sectionDecisionDao->getLastSectionDecision($this->getArticleId());
		return $lastSectionDecision->getSectionId();
	}

	/**
	 * Get ID of journal.
	 * @return int
	 */
	function getJournalId() {
		return $this->getData('journalId');
	}

	/**
	 * Set ID of journal.
	 * @param $journalId int
	 */
	function setJournalId($journalId) {
		return $this->setData('journalId', $journalId);
	}

	/**
	 * Get stored DOI of the submission.
	 * @return int
	 */
	function getStoredDOI() {
		return $this->getData('doi');
	}

	/**
	 * Set the stored DOI of the submission.
	 * @param $doi string
	 */
	function setStoredDOI($doi) {
		return $this->setData('doi', $doi);
	}

	/**
	 * Get title of article's section.
	 * @return string
	 */
	function getSectionTitle() {
		return $this->getData('sectionTitle');
	}

	/**
	 * Set title of article's section.
	 * @param $sectionTitle string
	 */
	function setSectionTitle($sectionTitle) {
		return $this->setData('sectionTitle', $sectionTitle);
	}

	/**
	 * Get section abbreviation.
	 * @return string
	 */
	function getSectionAbbrev() {
		return $this->getData('sectionAbbrev');
	}

	/**
	 * Set section abbreviation.
	 * @param $sectionAbbrev string
	 */
	function setSectionAbbrev($sectionAbbrev) {
		return $this->setData('sectionAbbrev', $sectionAbbrev);
	}

	/**
	 * Return the localized discipline. DEPRECATED in favour of
	 * getLocalizedDiscipline.
	 * @return string
	 */
	function getArticleDiscipline() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedDiscipline();
	}

	/**
	 * Return the localized subject classification. DEPRECATED
	 * in favour of getLocalizedSubjectClass.
	 * @return string
	 */
	function getArticleSubjectClass() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedSubjectClass();
	}

	/**
	 * Return the localized subject. DEPRECATED in favour of
	 * getLocalizedSubject.
	 * @return string
	 */
	function getArticleSubject() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedSubject();
	}

	/**
	 * Return the localized geographical coverage. DEPRECATED
	 * in favour of getLocalizedCoverageGeo.
	 * @return string
	 */
	function getArticleCoverageGeo() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedCoverageGeo();
	}

	/**
	 * Return the localized chronological coverage. DEPRECATED
	 * in favour of getLocalizedCoverageChron.
	 * @return string
	 */
	function getArticleCoverageChron() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedCoverageChron();
	}

	/**
	 * Return the localized sample coverage. DEPRECATED in favour
	 * of getLocalizedCoverageSample.
	 * @return string
	 */
	function getArticleCoverageSample() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedCoverageSample();
	}

	/**
	 * Return the localized type (method/approach). DEPRECATED
	 * in favour of getLocalizedType.
	 * @return string
	 */
	function getArticleType() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedType();
	}

	/**
	 * Return the localized sponsor. DEPRECATED in favour
	 * of getLocalizedSponsor.
	 * @return string
	 */
	function getArticleSponsor() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedSponsor();
	}

	/**
	 * Get the localized article cover filename. DEPRECATED
	 * in favour of getLocalizedFileName.
	 * @return string
	 */
	function getArticleFileName() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedFileName('fileName');
	}

	/**
	 * Get the localized article cover width. DEPRECATED
	 * in favour of getLocalizedWidth.
	 * @return string
	 */
	function getArticleWidth() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedWidth();
	}

	/**
	 * Get the localized article cover height. DEPRECATED
	 * in favour of getLocalizedHeight.
	 * @return string
	 */
	function getArticleHeight() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedHeight();
	}

	/**
	 * Get the localized article cover filename on the uploader's computer.
	 * DEPRECATED in favour of getLocalizedOriginalFileName.
	 * @return string
	 */
	function getArticleOriginalFileName() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedData('originalFileName');
	}

	/**
	 * Get the localized article cover alternate text. DEPRECATED
	 * in favour of getLocalizedCoverPageAltText.
	 * @return string
	 */
	function getArticleCoverPageAltText() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedCoverPageAltText();
	}

	/**
	 * Get the flag indicating whether or not to show
	 * an article cover page. DEPRECATED in favour of
	 * getLocalizedShowCoverPage.
	 * @return string
	 */
	function getArticleShowCoverPage() {
		if (Config::getVar('debug', 'deprecation_warnings')) trigger_error('Deprecated function.');
		return $this->getLocalizedShowCoverPage();
	}

	/**
	 * Get comments to editor.
	 * @return string
	 */
	function getCommentsToEditor() {
		return $this->getData('commentsToEditor');
	}

	/**
	 * Set comments to editor.
	 * @param $commentsToEditor string
	 */
	function setCommentsToEditor($commentsToEditor) {
		return $this->setData('commentsToEditor', $commentsToEditor);
	}

	/**
	 * Get editor file id.
	 * @return int
	 */
	function getEditorFileId() {
		return $this->getData('editorFileId');
	}

	/**
	 * Set editor file id.
	 * @param $editorFileId int
	 */
	function setEditorFileId($editorFileId) {
		return $this->setData('editorFileId', $editorFileId);
	}

	/**
	 * get expedited
	 * @return boolean
	 */
	function getFastTracked() {
		return $this->getData('fastTracked');
	}

	/**
	 * set fastTracked
	 * @param $fastTracked boolean
	 */
	function setFastTracked($fastTracked) {
		return $this->setData('fastTracked',$fastTracked);
	}

	/**
	 * Return boolean indicating if author should be hidden in issue ToC.
	 * @return boolean
	 */
	function getHideAuthor() {
		return $this->getData('hideAuthor');
	}

	/**
	 * Set if author should be hidden in issue ToC.
	 * @param $hideAuthor boolean
	 */
	function setHideAuthor($hideAuthor) {
		return $this->setData('hideAuthor', $hideAuthor);
	}

	/**
	 * Return locale string corresponding to RT comments status.
	 * @return string
	 */
	function getCommentsStatusString() {
		switch ($this->getCommentsStatus()) {
			case COMMENTS_DISABLE:
				return 'article.comments.disable';
			case COMMENTS_ENABLE:
				return 'article.comments.enable';
			default:
				return 'article.comments.sectionDefault';
		}
	}

	/**
	 * Return boolean indicating if article RT comments should be enabled.
	 * Checks both the section and article comments status. Article status
	 * overrides section status.
	 * @return int
	 */
	function getEnableComments() {
		switch ($this->getCommentsStatus()) {
			case COMMENTS_DISABLE:
				return false;
			case COMMENTS_ENABLE:
				return true;
			case COMMENTS_SECTION_DEFAULT:
				$sectionDao =& DAORegistry::getDAO('SectionDAO');
				$section =& $sectionDao->getSection($this->getSectionId(), $this->getJournalId(), true);
				if ($section->getDisableComments()) {
					return false;
				} else {
					return true;
				}
		}
	}
        
        
	/**
	 * Get an associative array matching RT comments status codes with locale strings.
	 * @return array comments status => localeString
	 */
	function &getCommentsStatusOptions() {
		static $commentsStatusOptions = array(
			COMMENTS_SECTION_DEFAULT => 'article.comments.sectionDefault',
			COMMENTS_DISABLE => 'article.comments.disable',
			COMMENTS_ENABLE => 'article.comments.enable'
		);
		return $commentsStatusOptions;
	}

	/**
	 * Get an array of user IDs associated with this article
	 * @param $authors boolean
	 * @param $reviewers boolean
	 * @param $editors boolean
	 * @param $proofreader boolean
	 * @param $copyeditor boolean
	 * @param $layoutEditor boolean
	 * @return array User IDs
	 */
	function getAssociatedUserIds($authors = true, $reviewers = true, $editors = true, $sectionEditors = true, $proofreader = true, $copyeditor = true, $layoutEditor = true) {
		$articleId = $this->getId();
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');

		$userIds = array();

		if($authors) {
			$userId = $this->getUserId();
			if ($userId) $userIds[] = array('id' => $userId, 'role' => 'author');
		}
		
		if($sectionEditors) {
			$sectionEditorsDao =& DAORegistry::getDAO('SectionEditorsDAO');
			$sectionEditors =& $sectionEditorsDao->getEditorsBySectionId($this->getJournalId(), $this->getSectionId());
			foreach ($sectionEditors as $sectionEditor) $userIds[] = array('id' => $sectionEditor->getId(), 'role' => 'sectionEditor');
		}
		
		if($copyeditor) {
			$copyedSignoff = $signoffDao->getBySymbolic('SIGNOFF_COPYEDITING_INITIAL', ASSOC_TYPE_ARTICLE, $articleId);
			$userId = $copyedSignoff->getUserId();
			if ($userId) $userIds[] = array('id' => $userId, 'role' => 'copyeditor');
		}

		if($layoutEditor) {
			$layoutSignoff = $signoffDao->getBySymbolic('SIGNOFF_LAYOUT', ASSOC_TYPE_ARTICLE, $articleId);
			$userId = $layoutSignoff->getUserId();
			if ($userId) $userIds[] = array('id' => $userId, 'role' => 'layoutEditor');
		}

		if($proofreader) {
			$proofSignoff = $signoffDao->getBySymbolic('SIGNOFF_PROOFREADING_PROOFREADER', ASSOC_TYPE_ARTICLE, $articleId);
			$userId = $proofSignoff->getUserId();
			if ($userId) $userIds[] = array('id' => $userId, 'role' => 'proofreader');
		}

		if($reviewers) {
			$reviewAssignmentDao =& DAORegistry::getDAO('ReviewAssignmentDAO');
			$reviewAssignments =& $reviewAssignmentDao->getByDecisionId($this->getLastSectionDecisionId());
			foreach ($reviewAssignments as $reviewAssignment) {
				$userId = $reviewAssignment->getReviewerId();
				if ($userId) $userIds[] = array('id' => $userId, 'role' => 'reviewer');
				unset($reviewAssignment);
			}
		}

		return $userIds;
	}
        
        
	/**
	 * Get the signoff for this article
	 * @param $signoffType string
	 * @return Signoff
	 */
	function getSignoff($signoffType) {
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');
		return $signoffDao->getBySymbolic($signoffType, ASSOC_TYPE_ARTICLE, $this->getId());
	}

	/**
	 * Get the file for this article at a given signoff stage
	 * @param $signoffType string
	 * @param $idOnly boolean Return only file ID
	 * @return ArticleFile
	 */
	function &getFileBySignoffType($signoffType, $idOnly = false) {
		$articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');

		$signoff = $signoffDao->getBySymbolic($signoffType, ASSOC_TYPE_ARTICLE, $this->getId());
		if (!$signoff) {
			$returner = false;
			return $returner;
		}

		if ($idOnly) {
			$returner = $signoff->getFileId();
			return $returner;
		}

		$articleFile =& $articleFileDao->getArticleFile($signoff->getFileId());
		return $articleFile;
	}

	/**
	 * Get the user associated with a given signoff and this article
	 * @param $signoffType string
	 * @return User
	 */
	function &getUserBySignoffType($signoffType) {
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');
		$userDao =& DAORegistry::getDAO('UserDAO');

		$signoff = $signoffDao->getBySymbolic($signoffType, ASSOC_TYPE_ARTICLE, $this->getId());
		if (!$signoff) {
			$returner = false;
			return $returner;
		}

		$user =& $userDao->getUser($signoff->getUserId());
		return $user;
	}

	/**
	 * Get the user id associated with a given signoff and this article
	 * @param $signoffType string
	 * @return int
	 */
	function getUserIdBySignoffType($signoffType) {
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');

		$signoff = $signoffDao->getBySymbolic($signoffType, ASSOC_TYPE_ARTICLE, $this->getId());
		if (!$signoff) return false;

		return $signoff->getUserId();
	}
	
	/**
	 * Get the most recent decision.
	 * @return int 
	 * Transferred from AuthorSubmission.inc.php
	 */
	function getMostRecentDecisionValue() {
	    $articleId = $this->getArticleId();
	
	    $sectionDecisionDao = DAORegistry::getDAO('SectionDecisionDAO');
	    $decision = $sectionDecisionDao->getLastSectionDecision($articleId);
	    
	    return $decision->getDecision();
	}

	/**
	 * Get the number of resubmission for the last decision
	 * @return int
	*/
	function getResubmitCount(){
	    $articleId = $this->getArticleId();
	
	    $sectionDecisionDao = DAORegistry::getDAO('SectionDecisionDAO');
	    $decision = $sectionDecisionDao->getLastSectionDecision($articleId);
	    if (isset($decision)) return $decision->getResubmitCount();	
	    else return 0;
	}
	
	/*
	 * Get a map for editor decision to locale key.
	 * @return array
	 * Added by aglet 6/20/2011
	 */	 
	function &getEditorDecisionMap() {
		static $editorDecisionMap;
		if (!isset($editorDecisionMap)) {
			$editorDecisionMap = array(
				SUBMISSION_SECTION_DECISION_APPROVED => 'editor.article.decision.approved',
				SUBMISSION_SECTION_DECISION_RESUBMIT => 'editor.article.decision.resubmit',
				SUBMISSION_SECTION_DECISION_DECLINED => 'editor.article.decision.declined',
				SUBMISSION_SECTION_DECISION_COMPLETE => 'editor.article.decision.complete',
				SUBMISSION_SECTION_DECISION_INCOMPLETE => 'editor.article.decision.incomplete',
				SUBMISSION_SECTION_DECISION_EXEMPTED => 'editor.article.decision.exempted',
				SUBMISSION_SECTION_DECISION_FULL_REVIEW => 'editor.article.decision.fullReview',
				SUBMISSION_SECTION_DECISION_EXPEDITED => 'editor.article.decision.expedited',
				SUBMISSION_SECTION_DECISION_DONE => 'editor.article.decision.researchCompleted'	
			);
		}
		return $editorDecisionMap;
	}
	
	/**
	 * Get a locale key for the paper's most recent decision
	 * @return string
	 */
	function getEditorDecisionKey() {
		$editorDecisionMap =& $this->getEditorDecisionMap();
		return $editorDecisionMap[$this->getMostRecentDecision()];
	}
	

	/**
	 * Get the last section decision id for this article.
	 * @return Section Decision object
	 */
	function getLastSectionDecisionId() {
		$sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		$sDecision =& $sectionDecisionDao->getLastSectionDecision($this->getId());
		return $sDecision->getId();
	}

	/**
	 * Get the last section decision id for this article.
	 * @return Section Decision object
	 */
	function getLastSectionDecisionDate() {
		$sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		$sDecision =& $sectionDecisionDao->getLastSectionDecision($this->getId());
		return $sDecision->getDateDecided();
	}

        /**
	 * Getter/setter methods for publishedFinalReport
	 */
	 
	function setPublishedFinalReport($finalReport) {
		return $this->setData('publishedFinalReport', $finalReport);
	}
	
	function getPublishedFinalReport() {
		return $this->getData('publishedFinalReport');
	}
        
        
        /**
	 * Add an article text.
	 * @param $articleText ArticleText
	 */
	function addArticleText($articleText) {
		$this->articleTexts[$articleText->getLocale()] = $articleText;
	}
        /**
	 * Remove an article text.
	 * @param $articleTextId ID of the article text to remove
	 * @return boolean article text was removed
	 */
	function removeArticleText($articleTextId) {
                $found = false;
		if ($articleTextId != 0) {
                    $articleTexts = array();
                    foreach ($this->articleTexts as $articleText) {
                        if ($articleText->getId() == $articleTextId) {
                            array_push($this->removedArticleTexts, $articleText->getLocale());
                            $found = true;
                        }
                        else array_push($articleTexts[$articleText->getLocale()], $articleText);       
                    }
                    $this->articleTexts = $articleTexts;
		}
		return $found;
	}
	/**
	 * Get all article texts for this submission.
	 * @return array ArticleText
	 */
	function &getArticleTexts() {
		return $this->articleTexts;
	}
        /**
	 * Get a specific article text of this submission by locale.
	 * @param $locale string
	 * @return object ArticleText
	 */
	function &getArticleTextByLocale($locale) {
                $articleTextToReturn = null;
                foreach ($this->articleTexts as $articleText)
                    if ($articleText->getLocale() == $locale) $articleTextToReturn = $articleText;
		return $articleTextToReturn;
	}
        /**
	 * Get localized article text. If no article text on the current locale, try the primary locale, if not takes any.
	 * @param $locale string
	 * @return object ArticleText
	 */
	function &getLocalizedArticleText() {
                $locale = Locale::getLocale();
                $articleText = $this->getArticleTextByLocale($locale);
                if (!$articleText){
                    $primaryLocale = Locale::getPrimaryLocale();
                    if ($locale != $primaryLocale) $articleText = $this->getArticleTextByLocale($primaryLocale);
                    if (!$articleText) {
                        $journal = Request::getJournal();
                        $supportedLocales = $journal->getSetting('supportedLocales');
                        foreach ($supportedLocales as $supportedLocale) {
                            if (!$articleText) $articleText = $this->getArticleTextByLocale($supportedLocale);
                        }
                    }
                }
                return $articleText;
	}
        /**
	 * Get the IDs of all article texts removed from this submission.
	 * @return array int
	 */
	function &getRemovedArticleTexts() {
		return $this->removedArticleTexts;
	}
        /**
	 * Set article texts of this submission.
	 * @param $articleTexts array ArticleText
	 */
	function setArticleTexts($articleTexts) {
		return $this->articleTexts = $articleTexts;
	}
        
        
        /**
	 * Add an article secondary ID.
	 * @param $articleSecId ArticleSecId
	 */
	function addArticleSecId($articleSecId) {
                $found = false;
                $i = 0;
                $articleSecIds = $this->articleSecIds;
                foreach ($this->articleSecIds as $asiKey => $asiValue) {
                    if ($articleSecId->getId() == $asiValue->getId()){
                        $articleSecIds[$asiKey] = $articleSecId;
                        $found = true;
                    }
                    $i++;
                }
                if (!$found) {
                    $articleSecIds[$i] = $articleSecId;
                }
                $this->articleSecIds = $articleSecIds;
	}
        /**
	 * Remove an article secondary ID.
	 * @param $articleSecIdId ID of the article secondary ID to remove
	 * @return boolean article secondary ID was removed
	 */
	function removeArticleSecId($articleSecIdId) {
                $found = false;
                $i = 0;
		if ($articleSecIdId != 0) {
                    $articleSecIds = $this->articleSecIds;
                    foreach ($this->articleSecIds as $articleSecId) {
                        if ($articleSecId->getId() == $articleSecIdId) {
                            array_push($this->removedArticleSecIds, $articleSecIdId);
                            $found = true;
                        }
                        else {
                            $articleSecIds[$i] = $articleSecId;
                            $i++;
                        }       
                    }
                    $this->articleSecIds = $articleSecIds;
		}
		return $found;
	}
	/**
	 * Get all article secondary IDs for this submission.
	 * @return array ArticleSecId
	 */
	function &getArticleSecIds() {
		return $this->articleSecIds;
	}
        /**
	 * Get article secondary ID by ID for this submission.
	 * @return object ArticleSecId
	 */
	function &getArticleSecId($id) {
                foreach ($this->articleSecIds as $articleSecId) {
                    if ($articleSecId->getId() == $id) {
                        return $articleSecId;
                    }
                }
		return null;
	}
        /**
	 * Get the IDs of all article secondary IDs removed from this submission.
	 * @return array int
	 */
	function &getRemovedArticleSecIds() {
		return $this->removedArticleSecIds;
	}
        /**
	 * Set article secondary IDs of this submission.
	 * @param $articleSecIds array ArticleSecId
	 */
	function setArticleSecIds($articleSecIds) {
		return $this->articleSecIds = $articleSecIds;
	}
        
        
        /**
	 * Get the article details of this submission.
	 * @return object article details
	 */
	function &getArticleDetails() {
		return $this->articleDetails;
	}
        /**
	 * Set article details of this submission.
	 * @param $articleDetails object articleDetails
	 */
	function setArticleDetails($articleDetails) {
		return $this->articleDetails = $articleDetails;
	}
        
        
        /**
	 * Add an article purpose.
	 * @param $articlePurpose ArticlePurpose
	 */
	function addArticlePurpose($articlePurpose) {
                $articlePurposes = $this->articlePurposes;
                $i = 0;
                $found = false;
                foreach ($this->articlePurposes as $apKey => $apValue) {
                    if ($articlePurpose->getId() == $apValue->getId()){
                        $articlePurposes[$apKey] = $articlePurpose;
                        $found = true;
                    }
                    $i++;
                }
                if (!$found) {
                    $articlePurposes[$i] = $articlePurpose;
                }
		$this->articlePurposes = $articlePurposes;
	}
        /**
	 * Remove an article purpose.
	 * @param $articlePurposeId ID of the article purpose to remove
	 * @return boolean article purpose was removed
	 */
	function removeArticlePurpose($articlePurposeId) {
                $found = false;
		if ($articlePurposeId != 0) {
                    $articlePurposes = array();
                    $i = 0;
                    foreach ($this->articlePurposes as $articlePurpose) {
                        if ($articlePurpose->getId() == $articlePurposeId) {
                            array_push($this->removedArticlePurposes, $articlePurpose->getId());
                            $found = true;
                        }
                        else {
                            $articlePurposes[$i] = $articlePurpose;      
                            $i++;
                        }
                    }
                    $this->articlePurposes = $articlePurposes;
		}
		return $found;
	}
	/**
	 * Get all article purposes for this submission.
	 * @return array ArticlePurpose
	 */
	function &getArticlePurposes() {
		return $this->articlePurposes;
	}
        /**
	 * Get a specific article purpose for this submission.
	 * @return object ArticlePurpose
	 */
	function &getArticlePurpose($purposeId) {
                foreach ($this->articlePurposes as $purpose) {
                    if ($purpose->getId() == $purposeId) {
                        return $purpose;
                    }
                }
		return null;
	}
        /**
	 * Get the IDs of all article purposes removed from this submission.
	 * @return array int
	 */
	function &getRemovedArticlePurposes() {
		return $this->removedArticlePurposes;
	}
        /**
	 * Set article purposes of this submission.
	 * @param $articlePurposes array ArticlePurpose
	 */
	function setArticlePurposes($articlePurposes) {
		return $this->articlePurposes = $articlePurposes;
	}
        
        
        
        
        /**
	 * Add an article outcome.
	 * @param $articleOutcome ArticleOutcome
	 */
	function addArticleOutcome($articleOutcome) {
                $journal = Request::getJournal();
                $articleOutcomes = $this->articleOutcomes;
                $found=false;
                $i = 0;
                if(!empty($this->articleOutcomes)){
                    foreach ($this->articleOutcomes as $key => $value) {
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if (!empty($value[$localeKey]) && $articleOutcome->getId()) {
                                if ($value[$localeKey]->getId() == $articleOutcome->getId()) {
                                    $articleOutcomes[$key][$localeKey] = $articleOutcome;
                                    $found =true;
                                }                            
                            }
                        }
                        $i++;
                    }
                    if (!$found) {
                        $articleOutcomes[$i][$articleOutcome->getLocale()] = $articleOutcome;
                    }
                    
                } else {
                    $articleOutcomes[0][$articleOutcome->getLocale()] = $articleOutcome;
                    
                }
		$this->articleOutcomes = $articleOutcomes;
	}
        /**
	 * Remove an article outcome.
	 * @param $articleOutcomeId ID of the article outcome to remove
	 * @return boolean article outcome was removed
	 */
	function removeArticleOutcome($articleOutcomeId) {
                $journal = Request::getJournal();
                $found = false;
		if ($articleOutcomeId != 0) {
                    $articleOutcomes = array();
                    $i = 0;
                    foreach ($this->articleOutcomes as $aoKey => $articleOutcome) {
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if(!empty($articleOutcome[$localeKey])) {
                                if ($articleOutcome[$localeKey]->getId() == $articleOutcomeId) {
                                    array_push($this->removedArticleOutcomes, $articleOutcome[$localeKey]->getId());
                                    $found = true;
                                }
                                else {
                                    $articleOutcomes[$i][$localeKey] = $articleOutcome[$localeKey];  
                                    $i++;
                                }
                            }
                            
                        }
                    }
                    $this->articleOutcomes = $articleOutcomes;
		}
		return $found;
	}
	/**
	 * Get all article outcomes for this submission.
	 * @return array ArticleOutcome
	 */
	function &getArticleOutcomes() {
		return $this->articleOutcomes;
	}
        /**
	 * Get a specific article outcome for this submission.
	 * @return object ArticleOutcome
	 */
	function &getArticleOutcome($outcomeId) {
                $found = false;
                $journal = Request::getJournal();
                foreach ($this->articleOutcomes as $outcome) {
                    foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                        if (!empty($outcome[$localeKey])) {
                            if ($outcome[$localeKey]->getId() == $outcomeId) {
                                return $outcome[$localeKey];
                            }   
                        }
                    }
                }
		return $found;
	}
        /**
	 * Get the IDs of all article outcomes removed from this submission.
	 * @return array int
	 */
	function &getRemovedArticleOutcomes() {
		return $this->removedArticleOutcomes;
	}
        /**
	 * Set article outcomes of this submission.
	 * @param $articleOutcomes array ArticleOutcome
	 */
	function setArticleOutcomes($articleOutcomes) {
		return $this->articleOutcomes = $articleOutcomes;
	}
        /**
	 * Get all article outcomes for this submission by type (primary/secondary).
	 * @return array ArticleOutcome
	 */
	function &getArticleOutcomesByType($type) {
                $journal = Request::getJournal();
                $array = array();
                $i = 0;
                foreach ($this->articleOutcomes as $articleOutcome) {
                    foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                        if (!empty($articleOutcome[$localeKey])) {
                            if ($articleOutcome[$localeKey]->getType() == $type) {
                                $array[$i][$localeKey] = $articleOutcome[$localeKey];
                                $i++;
                            }
                        }
                    }
                }
		return $array;
	}
        
        
        /**
	 * Add an article drug.
	 * @param $articleDrug ArticleDrug
	 */
	function addArticleDrug($articleDrug) {
                $found = false;
                $i = 0;
                $articleDrugs = $this->articleDrugs;
                foreach ($this->articleDrugs as $adKey => $adValue) {
                    if ($articleDrug->getId() == $adValue->getId()){
                        $articleDrugs[$adKey] = $adValue;
                        $found = true;
                    }
                    $i++;
                }
                if (!$found) {
                    $articleDrugs[$i] = $articleDrug;
                }
                $this->articleDrugs = $articleDrugs;
	}
        /**
	 * Remove an article drug.
	 * @param $articleDrugId ID of the article drug to remove
	 * @return boolean article drug was removed
	 */
	function removeArticleDrug($articleDrugId) {
                $found = false;
                $i = 0;
		if ($articleDrugId != 0) {
                    $articleDrugs = $this->articleDrugs;
                    foreach ($this->articleDrugs as $articleDrug) {
                        if ($articleDrug->getId() == $articleDrugId) {
                            array_push($this->removedArticleDrugs, $articleDrugId);
                            $found = true;
                        }
                        else {
                            $articleDrugs[$i] = $articleDrug;
                            $i++;
                        }       
                    }
                    $this->articleDrugs = $articleDrugs;
		}
		return $found;
	}
	/**
	 * Get all article drugs for this submission.
	 * @return array ArticleDrugInfo
	 */
	function &getArticleDrugs() {
		return $this->articleDrugs;
	}
        /**
	 * Get article drug by ID for this submission.
	 * @return object ArticleDrugInfo
	 */
	function &getArticleDrug($id) {
                foreach ($this->articleDrugs as $articleDrug) {
                    if ($articleDrug->getId() == $id) {
                        return $articleDrug;
                    }
                }
		return null;
	}
        /**
	 * Get the IDs of all article drugs removed from this submission.
	 * @return array int
	 */
	function &getRemovedArticleDrugs() {
		return $this->removedArticleDrugs;
	}
        /**
	 * Set article drugs of this submission.
	 * @param $articleDrugs array ArticleDrugInfo
	 */
	function setArticleDrugs($articleDrugs) {
		return $this->articleDrugs = $articleDrugs;
	}
}
?>
