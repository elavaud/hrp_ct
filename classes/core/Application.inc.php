<?php

/**
 * @file classes/core/Application.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Application
 * @ingroup core
 * @see PKPApplication
 *
 * @brief Class describing this application.
 *
 */

import('lib.pkp.classes.core.PKPApplication');

define('PHP_REQUIRED_VERSION', '4.2.0');

define('ASSOC_TYPE_JOURNAL',  0x0000100);
define('ASSOC_TYPE_ARTICLE',  0x0000101);

define('CONTEXT_JOURNAL', 1);

class Application extends PKPApplication {

	function Application() {
		parent::PKPApplication();
	}

	/**
	 * Get the "context depth" of this application, i.e. the number of
	 * parts of the URL after index.php that represent the context of
	 * the current request (e.g. Journal [1], or Conference and
	 * Scheduled Conference [2]).
	 * @return int
	 */
	function getContextDepth() {
		return 1;
	}

	function getContextList() {
		return array('journal');
	}
	/**
	 * Get the symbolic name of this application
	 * @return string
	 */
	function getName() {
		return 'ojs2';
	}

	/**
	 * Get the locale key for the name of this application.
	 * @return string
	 */
	function getNameKey() {
		return('common.openJournalSystems');
	}

	/**
	 * Get the URL to the XML descriptor for the current version of this
	 * application.
	 * @return string
	 */
	function getVersionDescriptorUrl() {
		return('http://pkp.sfu.ca/ojs/xml/ojs-version.xml');
	}

	/**
	 * Get the map of DAOName => full.class.Path for this application.
	 * @return array
	 */
	function getDAOMap() {
		return array_merge(parent::getDAOMap(), array(
			'AboutFileDAO' => 'classes.file.AboutFileDAO',
                        'AnnouncementDAO' => 'classes.announcement.AnnouncementDAO',
			'AnnouncementTypeDAO' => 'classes.announcement.AnnouncementTypeDAO',
			'ApprovalNoticeDAO' => 'classes.approvalNotice.ApprovalNoticeDAO',
			'ArticleEmailLogDAO' => 'classes.article.log.ArticleEmailLogDAO',
			'ArticleEventLogDAO' => 'classes.article.log.ArticleEventLogDAO',
			'ArticleCommentDAO' => 'classes.article.ArticleCommentDAO',
			'ArticleContactDAO' => 'classes.article.ArticleContactDAO',
			'ArticleCRODAO' => 'classes.article.ArticleCRODAO',
			'ArticleDAO' => 'classes.article.ArticleDAO',
			'ArticleDetailsDAO' => 'classes.article.ArticleDetailsDAO',
			'ArticleDrugInfoDAO' => 'classes.article.ArticleDrugInfoDAO',
                        'ArticleDrugManufacturerDAO' => 'classes.article.ArticleDrugManufacturerDAO',
			'ArticleFileDAO' => 'classes.article.ArticleFileDAO',
			'ArticleGalleyDAO' => 'classes.article.ArticleGalleyDAO',
			'ArticleNoteDAO' => 'classes.article.ArticleNoteDAO', // DEPRECATED
			'ArticleOutcomeDAO' => 'classes.article.ArticleOutcomeDAO',                    
			'ArticlePurposeDAO' => 'classes.article.ArticlePurposeDAO',                    
			'ArticleSearchDAO' => 'classes.search.ArticleSearchDAO',
			'ArticleSecIdDAO' => 'classes.article.ArticleSecIdDAO',
			'ArticleSiteDAO' => 'classes.article.ArticleSiteDAO',
			'ArticleSponsorDAO' => 'classes.article.ArticleSponsorDAO',
			'ArticleTextDAO' => 'classes.article.ArticleTextDAO',                    
			'AuthorDAO' => 'classes.article.AuthorDAO',
			'AuthorSubmissionDAO' => 'classes.submission.author.AuthorSubmissionDAO',
			'CitationDAO' => 'lib.pkp.classes.citation.CitationDAO',
			'CommentDAO' => 'lib.pkp.classes.comment.CommentDAO',
			'CopyeditorSubmissionDAO' => 'classes.submission.copyeditor.CopyeditorSubmissionDAO',
			'EditorSubmissionDAO' => 'classes.submission.editor.EditorSubmissionDAO',
			'EmailTemplateDAO' => 'classes.mail.EmailTemplateDAO',
			'ErcReviewersDAO' => 'classes.journal.ErcReviewersDAO',
                        'ExtraFieldDAO' => 'classes.journal.ExtraFieldDAO',
			'FilterDAO' => 'lib.pkp.classes.filter.FilterDAO',
			'GroupDAO' => 'lib.pkp.classes.group.GroupDAO',
			'GroupMembershipDAO' => 'lib.pkp.classes.group.GroupMembershipDAO',
			'IndividualSubscriptionDAO' => 'classes.subscription.IndividualSubscriptionDAO',
    			'InstitutionalSubscriptionDAO' => 'classes.subscription.InstitutionalSubscriptionDAO',
                        'InstitutionDAO' => 'classes.journal.InstitutionDAO',
                        'IssueDAO' => 'classes.issue.IssueDAO',
			'JournalDAO' => 'classes.journal.JournalDAO',
			'JournalSettingsDAO' => 'classes.journal.JournalSettingsDAO',
			'JournalStatisticsDAO' => 'classes.journal.JournalStatisticsDAO',
			'LayoutEditorSubmissionDAO' => 'classes.submission.layoutEditor.LayoutEditorSubmissionDAO',
			'MeetingDAO' => 'classes.meeting.MeetingDAO',
			'MeetingAttendanceDAO' => 'classes.meeting.MeetingAttendanceDAO',
			'MeetingSectionDecisionDAO' => 'classes.meeting.MeetingSectionDecisionDAO',
			'MetadataDescriptionDAO' => 'classes.metadata.MetadataDescriptionDAO',
			'MinutesFileDAO' => 'classes.meeting.MinutesFileDAO',
			'NoteDAO' => 'classes.note.NoteDAO',
			'OAIDAO' => 'classes.oai.ojs.OAIDAO',
			'OJSCompletedPaymentDAO' => 'classes.payment.ojs.OJSCompletedPaymentDAO',
			'PluginSettingsDAO' => 'classes.plugins.PluginSettingsDAO',
			'ProofreaderSubmissionDAO' => 'classes.submission.proofreader.ProofreaderSubmissionDAO',
			'PublishedArticleDAO' => 'classes.article.PublishedArticleDAO',
			'QueuedPaymentDAO' => 'lib.pkp.classes.payment.QueuedPaymentDAO',
			'ReviewAssignmentDAO' => 'classes.submission.reviewAssignment.ReviewAssignmentDAO',
			'ReviewerSubmissionDAO' => 'classes.submission.reviewer.ReviewerSubmissionDAO',
			'ReviewFormDAO' => 'lib.pkp.classes.reviewForm.ReviewFormDAO',
			'ReviewFormElementDAO' => 'lib.pkp.classes.reviewForm.ReviewFormElementDAO',
			'ReviewFormResponseDAO' => 'lib.pkp.classes.reviewForm.ReviewFormResponseDAO',
                        'RoleDAO' => 'classes.security.RoleDAO',
			'RTDAO' => 'classes.rt.ojs.RTDAO',
			'ScheduledTaskDAO' => 'lib.pkp.classes.scheduledTask.ScheduledTaskDAO',
			'SectionDAO' => 'classes.journal.SectionDAO',
			'SectionDecisionDAO' => 'classes.article.SectionDecisionDAO',
			'SectionEditorsDAO' => 'classes.journal.SectionEditorsDAO',
			'SectionEditorSubmissionDAO' => 'classes.submission.sectionEditor.SectionEditorSubmissionDAO',
                        'SubscriptionDAO' => 'classes.subscription.SubscriptionDAO',
			'SubscriptionTypeDAO' => 'classes.subscription.SubscriptionTypeDAO',
			'SuppFileDAO' => 'classes.article.SuppFileDAO',
                        'TrialSiteDAO' => 'classes.journal.TrialSiteDAO',
			'UserDAO' => 'classes.user.UserDAO',
			'UserSettingsDAO' => 'classes.user.UserSettingsDAO'
		));
	}

	/**
	 * Get the list of plugin categories for this application.
	 */
	function getPluginCategories() {
		return array(
			'auth',
			'blocks',
			'citationFormats',
			'gateways',
			'generic',
			'implicitAuth',
			'importexport',
			'oaiMetadataFormats',
			'paymethod',
			'reports',
			'themes'
		);
	}

	/**
	 * Instantiate the help object for this application.
	 * @return object
	 */
	function &instantiateHelp() {
		import('classes.help.Help');
		$help = new Help();
		return $help;
	}
}

?>
