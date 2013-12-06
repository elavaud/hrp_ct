<?php

/**
 * @file MeetingReviewerHandler.inc.php
 *
 *
 * @class MeetingReviewerHandler
 * @ingroup pages_reviewer
 *
 * @brief Handle requests for meeting reviewer functions.
 * 
 * Added by ayveemallare
 * Last Updated: 7/6/2011
 */

/**
 * Last update on February 2013
 * EL
**/

import('classes.handler.Handler');
import('pages.reviewer.ReviewerHandler');

class MeetingReviewerHandler extends ReviewerHandler {
	var $meeting;
	var $sectionDecisions;
	var $user;
	var $decisionReviewMap;
	/**
	 * Constructor
	 **/
	function MeetingReviewerHandler() {
		parent::ReviewerHandler();

		$this->addCheck(new HandlerValidatorJournal($this));
		$this->addCheck(new HandlerValidatorRoles($this, true, null, null, array(ROLE_ID_REVIEWER)));		
	}

	/**
	 * Display view meeting page.
	 * Last update: EL on February 25th 2013
	 */
	function viewMeeting($args) {
		$meetingId = $args[0];
		$this->validate($meetingId);
		$user =& Request::getUser();
		$journal =& Request::getJournal();
		$sectionDao =& DAORegistry::getDao('SectionDAO');
		$ercReviewersDao = DAORegistry::getDAO('ErcReviewersDAO');
		
		$meeting =& $this->meeting;
		$sectionDecisions =& $this->sectionDecisions;
		
		$decisionReviewMap =& $this->decisionReviewMap;
		$this->setupTemplate(true, 1);
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign_by_ref('meeting', $meeting);
		$templateMgr->assign_by_ref('sectionDecisions', $sectionDecisions);
		$templateMgr->assign_by_ref('map', $decisionReviewMap);
		$templateMgr->assign('erc', $sectionDao->getSection($meeting->getUploader())); 			
		$templateMgr->assign('isReviewer', $ercReviewersDao->ercReviewerExists($journal->getId(),$meeting->getUploader(), $user->getId()));
		$templateMgr->assign('userId', $user->getId());

		$templateMgr->display('reviewer/viewMeeting.tpl');
	}
	
        
	/**
	 *  Response to Meeting Scheduler
	 */
	function replyMeeting(){
		$meetingId = Request::getUserVar('meetingId');
		$this->validate($meetingId);
		$user =& Request::getUser();
		$userId = $user->getId();
		
		$meetingAttendanceDao =& DAORegistry::getDao('MeetingAttendanceDAO');
		$meetingAttendance = $meetingAttendanceDao->getMeetingAttendance($meetingId, $userId);
		
		$meetingAttendance->setIsAttending(Request::getUserVar('isAttending'));
		$meetingAttendance->setRemarks(Request::getUserVar('remarks'));	
		
		$meetingAttendanceDao =& DAORegistry::getDao('MeetingAttendanceDAO');
		$meetingAttendanceDao->updateReplyOfAttendance($meetingAttendance);
		Request::redirect(null, 'reviewer', 'viewMeeting', $meetingId);
	}
	
        
	/** TODO:
	 * (non-PHPdoc)
	 * @see PKPHandler::validate()
	 */
	function validate($meetingId) {
		$meetingDao =& DAORegistry::getDAO('MeetingDAO');
		$journal =& Request::getJournal();
		$user =& Request::getUser();
			
			// EL on March 1st 2013
			$journalId = $journal->getId();
		
		$isValid = true;
		$newKey = Request::getUserVar('key');

		$meeting =& $meetingDao->getMeetingByMeetingAndUserId($meetingId, $user->getId());

		if (!$meeting) {
			$isValid = false;
		} elseif ($user && empty($newKey)) {
			if ($meeting->getUserId() != $user->getId()) {
				$isValid = false;
			}
		} 
		else {
			//$user =& MeetingReviewerHandler::validateAccessKey($meeting->getUserId(), $meetingId, $newKey);
			if (!$user) $isValid = false;
		}

		if (!$isValid) {
			Request::redirect(null, Request::getRequestedPage());
		}
		$sectionDecisionIds = array();
		$sectionDecisions = array();
		$reviewIds = array();
		$map = array();
		$meetingSectionDecisionDao =& DAORegistry::getDAO('MeetingSectionDecisionDAO');
		$reviewerSubmissionDao =& DAORegistry::getDAO('ReviewerSubmissionDAO');
		$sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		$sectionDecisionIds = $meetingSectionDecisionDao->getMeetingSectionDecisionsByMeetingId($meeting->getId());
		
		foreach($sectionDecisionIds as $decisionId) {
			$sectionDecision = $sectionDecisionDao->getSectionDecision($decisionId);
			$review = $reviewerSubmissionDao->getReviewerSubmissionByReviewerAndDecisionId($user->getId(), $decisionId, $journal->getId());
			$map[$decisionId] = $review->getReviewId();
			array_push($sectionDecisions, $sectionDecision);
		}
		$this->decisionReviewMap =& $map;
		$this->sectionDecisions =& $sectionDecisions;
		$this->meeting =& $meeting;
		$this->user =& $user;
		
		return true;
	}
}

?>
