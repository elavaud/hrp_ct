<?php

/**
 * @defgroup submission
 */

/**
 * @file classes/submission/Submission.inc.php
 *
 * Copyright (c) 2000-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Submission
 * @ingroup submission
 *
 * @brief Submission class.
 */
 
define('PROPOSAL_STATUS_SUBMITTED',1);		//NEW
define('PROPOSAL_STATUS_RETURNED',2);		//INCOMPLETE
define('PROPOSAL_STATUS_CHECKED',3);		//COMPLETE
define('PROPOSAL_STATUS_FULL_REVIEW',4);	//ASSIGNED FOR A FULL REVIEW
define('PROPOSAL_STATUS_EXEMPTED',5);		//EXEMPTED FROM REVIEW
define('PROPOSAL_STATUS_REVIEWED',6);		//DECISION AFTER NORMAL/EXPEDITED REVIEW
define('PROPOSAL_STATUS_EXPEDITED',7);		//ASSIGNED FOR EXPEDITED REVIEW

define('PROPOSAL_STATUS_DRAFT',8);              //Replaces STATUS_INCOMPLETE
define('PROPOSAL_STATUS_WITHDRAWN',9); 		//Special tag, not part of lifecycle
define('PROPOSAL_STATUS_ARCHIVED',10); 		//To archive Not Approved and Exempt From Review
define('PROPOSAL_STATUS_COMPLETED',11); 
define('PROPOSAL_STATUS_RESUBMITTED',12); 	//Special tag for Revise and resubmit proposals that were resubmitted

class Submission extends DataObject {
			
	/**
	 * Constructor.
	 */
	function Submission() {
		parent::DataObject();
	}

	/**
	 * Returns the association type of this submission
	 * @return integer one of the ASSOC_TYPE_* constants
	 */
	function getAssocType() {
		// Must be implemented by sub-classes.
		assert(false);
	}

	/**
	 * Get a piece of data for this object, localized to the current
	 * locale if possible.
	 * @param $key string
	 * @return mixed
	 */
	function &getLocalizedData($key) {
		$localePrecedence = array(Locale::getLocale(), $this->getLocale());
		foreach ($localePrecedence as $locale) {
			$value =& $this->getData($key, $locale);
			if (!empty($value)) return $value;
			unset($value);
		}

		// Fallback: Get the first available piece of data.
		$data =& $this->getData($key, null);
		if (!empty($data)) return $data[array_shift(array_keys($data))];

		// No data available; return null.
		unset($data);
		$data = null;
		return $data;
	}

	//
	// Get/set methods
	//
        
	/**
	 * Get user ID of the submitter.
	 * @return int
	 */
	function getUserId() {
		return $this->getData('userId');
	}

	/**
	 * Set user ID of the submitter.
	 * @param $userId int
	 */
	function setUserId($userId) {
		return $this->setData('userId', $userId);
	}

	/**
	 * Return the user of the submitter.
	 * @return User
	 */
	function getUser() {
		$userDao =& DAORegistry::getDAO('UserDAO');
		return $userDao->getUser($this->getUserId(), true);
	}

	/**
	 * Get the locale of the submission.
	 * @return string
	 */
	function getLocale() {
		return $this->getData('locale');
	}

	/**
	 * Set the locale of the submission.
	 * @param $locale string
	 */
	function setLocale($locale) {
		return $this->setData('locale', $locale);
	}

	/**
	 * Return the localized discipline
	 * @return string
	 */
	function getLocalizedDiscipline() {
		return $this->getLocalizedData('discipline');
	}

	/**
	 * Get discipline
	 * @param $locale
	 * @return string
	 */
	function getDiscipline($locale) {
		return $this->getData('discipline', $locale);
	}

	/**
	 * Set discipline
	 * @param $discipline string
	 * @param $locale
	 */
	function setDiscipline($discipline, $locale) {
		return $this->setData('discipline', $discipline, $locale);
	}

	/**
	 * Return the localized subject classification
	 * @return string
	 */
	function getLocalizedSubjectClass() {
		return $this->getLocalizedData('subjectClass');
	}

	/**
	 * Get subject classification.
	 * @param $locale
	 * @return string
	 */
	function getSubjectClass($locale) {
		return $this->getData('subjectClass', $locale);
	}

	/**
	 * Set subject classification.
	 * @param $subjectClass string
	 * @param $locale
	 */
	function setSubjectClass($subjectClass, $locale) {
		return $this->setData('subjectClass', $subjectClass, $locale);
	}

	/**
	 * Return the localized subject
	 * @return string
	 */
	function getLocalizedSubject() {
		return $this->getLocalizedData('subject');
	}

	/**
	 * Get subject.
	 * @param $locale
	 * @return string
	 */
	function getSubject($locale) {
		return $this->getData('subject', $locale);
	}

	/**
	 * Set subject.
	 * @param $subject string
	 * @param $locale
	 */
	function setSubject($subject, $locale) {
		return $this->setData('subject', $subject, $locale);
	}

	/**
	 * Return the localized geographical coverage
	 * @return string
	 */
	function getLocalizedCoverageGeo() {
		return $this->getLocalizedData('coverageGeo');
	}

	/**
	 * Get geographical coverage.
	 * @param $locale
	 * @return string
	 */
	function getCoverageGeo($locale) {
		return $this->getData('coverageGeo', $locale);
	}

	/**
	 * Set geographical coverage.
	 * @param $coverageGeo string
	 * @param $locale
	 */
	function setCoverageGeo($coverageGeo, $locale) {
		return $this->setData('coverageGeo', $coverageGeo, $locale);
	}

	/**
	 * Return the localized chronological coverage
	 * @return string
	 */
	function getLocalizedCoverageChron() {
		return $this->getLocalizedData('coverageChron');
	}

	/**
	 * Get chronological coverage.
	 * @param $locale
	 * @return string
	 */
	function getCoverageChron($locale) {
		return $this->getData('coverageChron', $locale);
	}

	/**
	 * Set chronological coverage.
	 * @param $coverageChron string
	 * @param $locale
	 */
	function setCoverageChron($coverageChron, $locale) {
		return $this->setData('coverageChron', $coverageChron, $locale);
	}

	/**
	 * Return the localized sample coverage
	 * @return string
	 */
	function getLocalizedCoverageSample() {
		return $this->getLocalizedData('coverageSample');
	}

	/**
	 * Get research sample coverage.
	 * @param $locale
	 * @return string
	 */
	function getCoverageSample($locale) {
		return $this->getData('coverageSample', $locale);
	}

	/**
	 * Set geographical coverage.
	 * @param $coverageSample string
	 * @param $locale
	 */
	function setCoverageSample($coverageSample, $locale) {
		return $this->setData('coverageSample', $coverageSample, $locale);
	}

	/**
	 * Return the localized type (method/approach)
	 * @return string
	 */
	function getLocalizedType() {
		return $this->getLocalizedData('type');
	}

	/**
	 * Get type (method/approach).
	 * @param $locale
	 * @return string
	 */
	function getType($locale) {
		return $this->getData('type', $locale);
	}

	/**
	 * Set type (method/approach).
	 * @param $type string
	 * @param $locale
	 */
	function setType($type, $locale) {
		return $this->setData('type', $type, $locale);
	}

	/**
	 * Get language.
	 * @return string
	 */
	function getLanguage() {
		return $this->getData('language');
	}

	/**
	 * Set language.
	 * @param $language string
	 */
	function setLanguage($language) {
		return $this->setData('language', $language);
	}

	/**
	 * Return the localized sponsor
	 * @return string
	 */
	function getLocalizedSponsor() {
		return $this->getLocalizedData('sponsor');
	}

	/**
	 * Get sponsor.
	 * @param $locale
	 * @return string
	 */
	function getSponsor($locale) {
		return $this->getData('sponsor', $locale);
	}

	/**
	 * Set sponsor.
	 * @param $sponsor string
	 * @param $locale
	 */
	function setSponsor($sponsor, $locale) {
		return $this->setData('sponsor', $sponsor, $locale);
	}

	/**
	 * Get citations.
	 * @return string
	 */
	function getCitations() {
		return $this->getData('citations');
	}

	/**
	 * Set citations.
	 * @param $citations string
	 */
	function setCitations($citations) {
		return $this->setData('citations', $citations);
	}

	/**
	 * Get the localized cover filename
	 * @return string
	 */
	function getLocalizedFileName() {
		return $this->getLocalizedData('fileName');
	}

	/**
	 * get file name
	 * @param $locale string
	 * @return string
	 */
	function getFileName($locale) {
		return $this->getData('fileName', $locale);
	}

	/**
	 * set file name
	 * @param $fileName string
	 * @param $locale string
	 */
	function setFileName($fileName, $locale) {
		return $this->setData('fileName', $fileName, $locale);
	}

	/**
	 * Get the localized submission cover width
	 * @return string
	 */
	function getLocalizedWidth() {
		return $this->getLocalizedData('width');
	}

	/**
	 * get width of cover page image
	 * @param $locale string
	 * @return string
	 */
	function getWidth($locale) {
		return $this->getData('width', $locale);
	}

	/**
	 * set width of cover page image
	 * @param $locale string
	 * @param $width int
	 */
	function setWidth($width, $locale) {
		return $this->setData('width', $width, $locale);
	}

	/**
	 * Get the localized submission cover height
	 * @return string
	 */
	function getLocalizedHeight() {
		return $this->getLocalizedData('height');
	}

	/**
	 * get height of cover page image
	 * @param $locale string
	 * @return string
	 */
	function getHeight($locale) {
		return $this->getData('height', $locale);
	}

	/**
	 * set height of cover page image
	 * @param $locale string
	 * @param $height int
	 */
	function setHeight($height, $locale) {
		return $this->setData('height', $height, $locale);
	}

	/**
	 * Get the localized cover filename on the uploader's computer
	 * @return string
	 */
	function getLocalizedOriginalFileName() {
		return $this->getLocalizedData('originalFileName');
	}

	/**
	 * get original file name
	 * @param $locale string
	 * @return string
	 */
	function getOriginalFileName($locale) {
		return $this->getData('originalFileName', $locale);
	}

	/**
	 * set original file name
	 * @param $originalFileName string
	 * @param $locale string
	 */
	function setOriginalFileName($originalFileName, $locale) {
		return $this->setData('originalFileName', $originalFileName, $locale);
	}

	/**
	 * Get the localized cover alternate text
	 * @return string
	 */
	function getLocalizedCoverPageAltText() {
		return $this->getLocalizedData('coverPageAltText');
	}

	/**
	 * get cover page alternate text
	 * @param $locale string
	 * @return string
	 */
	function getCoverPageAltText($locale) {
		return $this->getData('coverPageAltText', $locale);
	}

	/**
	 * set cover page alternate text
	 * @param $coverPageAltText string
	 * @param $locale string
	 */
	function setCoverPageAltText($coverPageAltText, $locale) {
		return $this->setData('coverPageAltText', $coverPageAltText, $locale);
	}

	/**
	 * Get the flag indicating whether or not to show
	 * a cover page.
	 * @return string
	 */
	function getLocalizedShowCoverPage() {
		return $this->getLocalizedData('showCoverPage');
	}

	/**
	 * get show cover page
	 * @param $locale string
	 * @return int
	 */
	function getShowCoverPage($locale) {
		return $this->getData('showCoverPage', $locale);
	}

	/**
	 * set show cover page
	 * @param $showCoverPage int
	 * @param $locale string
	 */
	function setShowCoverPage($showCoverPage, $locale) {
		return $this->setData('showCoverPage', $showCoverPage, $locale);
	}

	/**
	 * get hide cover page thumbnail in Toc
	 * @param $locale string
	 * @return int
	 */
	function getHideCoverPageToc($locale) {
		return $this->getData('hideCoverPageToc', $locale);
	}

	/**
	 * set hide cover page thumbnail in Toc
	 * @param $hideCoverPageToc int
	 * @param $locale string
	 */
	function setHideCoverPageToc($hideCoverPageToc, $locale) {
		return $this->setData('hideCoverPageToc', $hideCoverPageToc, $locale);
	}

	/**
	 * get hide cover page in abstract view
	 * @param $locale string
	 * @return int
	 */
	function getHideCoverPageAbstract($locale) {
		return $this->getData('hideCoverPageAbstract', $locale);
	}

	/**
	 * set hide cover page in abstract view
	 * @param $hideCoverPageAbstract int
	 * @param $locale string
	 */
	function setHideCoverPageAbstract($hideCoverPageAbstract, $locale) {
		return $this->setData('hideCoverPageAbstract', $hideCoverPageAbstract, $locale);
	}

	/**
	 * Get localized hide cover page in abstract view
	 */
	function getLocalizedHideCoverPageAbstract() {
		return $this->getLocalizedData('hideCoverPageAbstract');
	}

	/**
	 * Get submission date.
	 * @return date
	 */
	function getDateSubmitted() {
		return $this->getData('dateSubmitted');
	}

	/**
	 * Set submission date.
	 * @param $dateSubmitted date
	 */
	function setDateSubmitted($dateSubmitted) {
		return $this->setData('dateSubmitted', $dateSubmitted);
	}

	/**
	 * Get the date of the last status modification.
	 * @return date
	 */
	function getDateStatusModified() {
		return $this->getData('dateStatusModified');
	}

	/**
	 * Set the date of the last status modification.
	 * @param $dateModified date
	 */
	function setDateStatusModified($dateModified) {
		return $this->setData('dateStatusModified', $dateModified);
	}

	/**
	 * Get the date of the last modification.
	 * @return date
	 */
	function getLastModified() {
		return $this->getData('lastModified');
	}

	/**
	 * Set the date of the last modification.
	 * @param $dateModified date
	 */
	function setLastModified($dateModified) {
		return $this->setData('lastModified', $dateModified);
	}

	/**
	 * Stamp the date of the last modification to the current time.
	 */
	function stampModified() {
		return $this->setLastModified(Core::getCurrentDate());
	}

	/**
	 * Stamp the date of the last status modification to the current time.
	 */
	function stampStatusModified() {
		return $this->setDateStatusModified(Core::getCurrentDate());
	}

	/**
	 * Get submission status.
	 * @return int
	 */
	function getStatus() {
		return $this->getData('status');
	}

	/**
	 * Set submission status.
	 * @param $status int
	 */
	function setStatus($status) {
		return $this->setData('status', $status);
	}

	/**
	 * Get a map for status constant to locale key.
	 * @return array
	 */
	function &getStatusMap() {
		static $statusMap;
		if (!isset($statusMap)) {
			$statusMap = array(
				STATUS_ARCHIVED => 'submissions.archived',
				STATUS_QUEUED => 'submissions.queued',
				STATUS_PUBLISHED => 'submissions.published',
				STATUS_DECLINED => 'submissions.declined',
				STATUS_QUEUED_UNASSIGNED => 'submissions.queuedUnassigned',
				STATUS_QUEUED_REVIEW => 'submissions.queuedReview',
				STATUS_QUEUED_EDITING => 'submissions.queuedEditing',
				STATUS_INCOMPLETE => 'submissions.incomplete'
			);
		}
		return $statusMap;
	}

	/**
	 * Get a locale key for the paper's current status.
	 * @return string
	 */
	function getStatusKey() {
		$statusMap =& $this->getStatusMap();
		return $statusMap[$this->getStatus()];
	}

	/**
	 * Get submission progress (most recently completed submission step).
	 * @return int
	 */
	function getSubmissionProgress() {
		return $this->getData('submissionProgress');
	}

	/**
	 * Set submission progress.
	 * @param $submissionProgress int
	 */
	function setSubmissionProgress($submissionProgress) {
		return $this->setData('submissionProgress', $submissionProgress);
	}

	/**
	 * Get submission file id.
	 * @return int
	 */
	function getSubmissionFileId() {
		return $this->getData('submissionFileId');
	}

	/**
	 * Set submission file id.
	 * @param $submissionFileId int
	 */
	function setSubmissionFileId($submissionFileId) {
		return $this->setData('submissionFileId', $submissionFileId);
	}

	/**
	 * Get revised file id.
	 * @return int
	 */
	function getRevisedFileId() {
		return $this->getData('revisedFileId');
	}

	/**
	 * Set revised file id.
	 * @param $revisedFileId int
	 */
	function setRevisedFileId($revisedFileId) {
		return $this->setData('revisedFileId', $revisedFileId);
	}

	/**
	 * Get review file id.
	 * @return int
	 */
	function getReviewFileId() {
		return $this->getData('reviewFileId');
	}

	/**
	 * Set review file id.
	 * @param $reviewFileId int
	 */
	function setReviewFileId($reviewFileId) {
		return $this->setData('reviewFileId', $reviewFileId);
	}

	/**
	 * get pages
	 * @return string
	 */
	function getPages() {
		return $this->getData('pages');
	}

	/**
	 * set pages
	 * @param $pages string
	 */
	function setPages($pages) {
		return $this->setData('pages',$pages);
	}

	/**
	 * Return submission RT comments status.
	 * @return int
	 */
	function getCommentsStatus() {
		return $this->getData('commentsStatus');
	}

	/**
	 * Set submission RT comments status.
	 * @param $commentsStatus boolean
	 */
	function setCommentsStatus($commentsStatus) {
		return $this->setData('commentsStatus', $commentsStatus);
	}	

	/***********************************************
	 *
	 * Proposal status getters and setters and locale key methods
	 * Added by Gay Figueroa
	 * Last Update: 5/3/2011
	 *
	************************************************/

	function getProposalStatus() {
		return $this->getData('proposalStatus');
	}

	function setProposalStatus($proposalStatus) {
		return $this->setData('proposalStatus', $proposalStatus);
	}

	/**
	 * Get a map for proposal status constant to locale key.
	 * @return array
	 */
	function &getProposalStatusMap() {
		static $proposalStatusMap;
		if (!isset($proposalStatusMap)) {
			$proposalStatusMap = array(
				PROPOSAL_STATUS_SUBMITTED => 'submission.status.submitted',
				PROPOSAL_STATUS_RETURNED => 'submission.status.incomplete',
				PROPOSAL_STATUS_CHECKED => 'submission.status.complete',
				PROPOSAL_STATUS_EXEMPTED => 'submission.status.exempted',
				PROPOSAL_STATUS_FULL_REVIEW => 'submission.status.fullReview',
				PROPOSAL_STATUS_EXPEDITED => 'submission.status.expeditedReview',
				PROPOSAL_STATUS_REVIEWED => 'submission.status.reviewed',
				PROPOSAL_STATUS_DRAFT => 'submission.status.draft',
				PROPOSAL_STATUS_WITHDRAWN => 'submission.status.withdrawn',
				PROPOSAL_STATUS_ARCHIVED => 'submissions.proposal.archived',
				PROPOSAL_STATUS_COMPLETED => 'submission.status.completed',
				PROPOSAL_STATUS_RESUBMITTED => 'submission.status.resubmitted'
				);
		}
		return $proposalStatusMap;
	}
	
	/**
	 * Get a locale ke for the submission status
	 * @param $submissionStatus
	 */
	function getProposalStatusKey($submissionStatus = 0) {
		$submissionStatus = $submissionStatus > 0 ? $submissionStatus : $this->getProposalStatus(); 
		$proposalStatusMap =& $this->getProposalStatusMap();
		return $proposalStatusMap[$submissionStatus];
	}

	/**
	 * Get Proposal ID.
	 * @param $locale
	 * @return string
	 */
	function getProposalId() {
		return $this->getData('proposalId');
	}

	/**
	 * Set Proposal ID.
	 * @param $proposalId string
	 */
	function setProposalId($proposalId) {
		return $this->setData('proposalId', $proposalId);
	}

        /**
	 * Get withdraw reason.
	 * @param $locale
	 * @return string
	 */
	function getWithdrawReason($locale) {
		return $this->getData('withdrawReason', $locale);
	}
	
	/**
	 * Set withdraw reason.
	 * @param $withdrawReason string
	 * @param $locale
	 */
	function setWithdrawReason($withdrawReason, $locale) {
		return $this->setData('withdrawReason', $withdrawReason, $locale);
	}

        /**
	 * Get withdraw comments.
	 * @param $locale
	 * @return string
	 */
	function getWithdrawComments($locale) {
		return $this->getData('withdrawComments', $locale);
	}

	/**
	 * Set withdraw comments.
	 * @param $withdrawComments string
	 * @param $locale
	 */
	function setWithdrawComments($withdrawComments, $locale) {
		return $this->setData('withdrawComments', $withdrawComments, $locale);
	}
	
	/**
	 * Set approval date
	 * @param $approvalDate string
	 * @param $locale string
	 */
	function setApprovalDate($approvalDate, $locale) {
		return $this->setData('approvalDate', $approvalDate, $locale);
	}
	
	/**
	 * Get localized approvalDate
	 * @return string
	 */
	function getLocalizedApprovalDate() {
		return $this->getData("approvalDate");
	}
	
	/**
	 * Get approvalDate
	 * @return string
	 */
	function getApprovalDate($locale) {
		return $this->getData("approvalDate", $locale);
	}
	
	function setPrimaryEditor($editor) {
		return $this->setData('primaryEditor', $editor);
	}
	
	function getPrimaryEditor() {
		return $this->getData("primaryEditor");
	}
	

	/*
	 * check if the submission is due
	 */
    function isSubmissionDue() {
    	if ($this->getApprovalDate($this->getLocale()) == null) $startdate = strtotime($this->getDateStatusModified());   
    	else $startdate = strtotime($this->getApprovalDate($this->getLocale()));
        $afteroneyear = $newdate = strtotime ('+1 year', $startdate);
        $today = time();
        return ($today >= $afteroneyear);
    }
}

?>
