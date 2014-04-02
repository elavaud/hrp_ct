<?php

/**
 * @file ProposalFromMeetingReviewerHandler.inc.php
 *
 *
 * @class MeetingReviewerHandler
 * @ingroup pages_reviewer
 *
 * @brief Handle requests for meeting reviewer functions.
 * 
 * Added by EL
 * Last Updated: 4/3/2013
 */

/**
 * Last update on February 2013
 * EL
**/

import('classes.handler.Handler');
import('pages.reviewer.ReviewerHandler');

class ProposalFromMeetingReviewerHandler extends ReviewerHandler {

	var $sectionDecision;
	var $user;

	/**
	 * Constructor
	 **/
	function ProposalFromMeetingReviewerHandler() {
		parent::ReviewerHandler();

		$this->addCheck(new HandlerValidatorJournal($this));
		$this->addCheck(new HandlerValidatorRoles($this, true, null, null, array(ROLE_ID_REVIEWER)));		
	}

	/**
	 * Display view meeting proposal page.
	 * Last update: EL on February 25th 2013
	 */
	function viewProposalFromMeeting($args) {
		$journal =& Request::getJournal();
		$decisionId = $args[0];
		$this->validate($decisionId);
		$user =& Request::getUser();
		$authorSubmissionDao =& DAORegistry::getDao('AuthorSubmissionDAO');
                $sectionDao =& DAORegistry::getDao('SectionDAO');
		$articleFileDao =& DAORegistry::getDao('ArticleFileDAO');
		$ercReviewersDao = DAORegistry::getDAO('ErcReviewersDAO');
                $currencyDao =& DAORegistry::getDAO('CurrencyDAO');
                
		$sectionDecision =& $this->sectionDecision;
		$this->setupTemplate(true, 2);
		
		$section =& $sectionDao->getSection($sectionDecision->getSectionId());
		
                $submission =& $authorSubmissionDao->getAuthorSubmission($sectionDecision->getArticleId());
                
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign_by_ref('submission', $submission);
                $templateMgr->assign_by_ref('sectionDecision', $sectionDecision);
                
		$templateMgr->assign('ercTitle', $section->getLocalizedTitle());
		
		$templateMgr->assign_by_ref('submissionFile', $submission->getSubmissionFile());
		$templateMgr->assign_by_ref('suppFiles', $submission->getSuppFiles());
		$templateMgr->assign_by_ref('previousFiles', $articleFileDao->getPreviousFilesByArticleId($submission->getId()));
		$templateMgr->assign_by_ref('abstractLocales', $journal->getSupportedLocaleNames());
            
		$templateMgr->assign('isReviewer', $ercReviewersDao->ercReviewerExists($journal->getId(), $submission->getSectionId(), $user->getId()));
	
                $sourceCurrencyId = $journal->getSetting('sourceCurrency');
                $templateMgr->assign('sourceCurrency', $currencyDao->getCurrencyByAlphaCode($sourceCurrencyId));
                
		$templateMgr->display('reviewer/viewProposalFromMeeting.tpl');
	}

	/**
	 * Download a file.
	 * @param $args array ($articleId, $fileId)
	 */
	function downloadProposalFromMeetingFile($args) {
		$proposalId = isset($args[0]) ? $args[0] : 0;
		$fileId = isset($args[1]) ? $args[1] : 0;

		$this->validate($proposalId);

		if (!Action::downloadFile($proposalId, $fileId)) {
			Request::redirect(null, 'user');
		}
	}
		
	
	/** TODO:
	 * (non-PHPdoc)
	 * @see PKPHandler::validate()
	 */
	function validate($decisionId) {
		$meetingDao =& DAORegistry::getDAO('MeetingDAO');
		$ercReviewersDao =& DAORegistry::getDAO('ErcReviewersDAO');
                $journal =& Request::getJournal();
		$user =& Request::getUser();
		$journalId = $journal->getId();
		$isValid = false;
		$newKey = Request::getUserVar('key');
		$meetings =& $meetingDao->getMeetingsByReviewerId($user->getId());
		$meetings =& $meetings->toArray();
		if (!$ercReviewersDao->isExternalReviewer($journalId, $user->getId())) {
			if ($decisionId && $user && empty($newKey)) {
				$meetingSectionDecisionDao =& DAORegistry::getDAO('MeetingSectionDecisionDAO');
				foreach ($meetings as $meeting) {
					$mSectionDecisions =& $meetingSectionDecisionDao->getMeetingSectionDecisionsByMeetingId($meeting->getId());
					foreach ($mSectionDecisions as $mSectionDecision) {
                                            if ($decisionId == $mSectionDecision->getSectionDecisionId()) $isValid = true;
                                        }
				}
			}
		}
		if (!$isValid) {
			Request::redirect(null, Request::getRequestedPage());
		}
		$sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		
		$sectionDecision = $sectionDecisionDao->getSectionDecision($decisionId);
		$this->sectionDecision =& $sectionDecision;
		$this->user =& $user;
		
		return true;
	}
}

?>
