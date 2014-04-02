{**
 * submission.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show the reviewer administration page.
 *
 * FIXME: At "Notify The Editor", fix the date.
 *
 * $Id$
 *}
 
<div id="reviewSchedule">
	<h3>{translate key="reviewer.article.reviewSchedule"}</h3>
	<form method="post" action="{url op="reviewMeetingSchedule" }" >
		<table width="100%" class="data">
			<tr valign="top">
				<td class="label" width="20%">{translate key="reviewer.article.schedule.request"}</td>
				<td class="value" width="80%">{if $submission->getDateNotified()}{$submission->getDateNotified()|date_format:$dateFormatLong}{else}&mdash;{/if}</td>
			</tr>
			<tr valign="top">
				<td class="label">{translate key="reviewer.article.schedule.response"}</td>
				<td class="value">{if $submission->getDateConfirmed()}{$submission->getDateConfirmed()|date_format:$dateFormatLong}{else}&mdash;{/if}</td>
			</tr>
			<tr valign="top">
				<td class="label">{translate key="reviewer.article.schedule.submitted"}</td>
				<td class="value">{if $submission->getDateCompleted()}{$submission->getDateCompleted()|date_format:$dateFormatLong}{else}&mdash;{/if}</td>
			</tr>
			<tr valign="top">
				<td class="label">{translate key="reviewer.article.schedule.due"}</td>
				<td class="value">{if $submission->getDateDue()}{$submission->getDateDue()|date_format:$dateFormatLong}{else}&mdash;{/if}</td>
			</tr>
			{if $reviewAssignment->getDateCompleted() || $reviewAssignment->getDeclined() == 1 || $reviewAssignment->getCancelled() == 1}
				<tr valign="top">
					<td class="label">{translate key="reviewer.article.schedule.decision"}</td>
					<td class="value">
						{if $submission->getCancelled()}
							{translate key="common.cancelled"}
						{elseif $submission->getDeclined()}
							{translate key="submissions.declined"}
						{else}
							{assign var=recommendation value=$submission->getRecommendation()}
							{if $recommendation === '' || $recommendation === null}
								&mdash;
							{else}
								{translate key=$reviewerRecommendationOptions.$recommendation}
							{/if}
						{/if}
					</td>
				</tr>
			{/if}
			{**<tr valign="top">
				<td class="label">{translate key="reviewer.article.schedule.dateOfMeeting"}</td>
				<td class="value">{if $submission->getDateOfMeeting()}{$submission->getDateOfMeeting()|date_format:$datetimeFormatLong}{else}&mdash;{/if}</td>
			</tr>

			<tr valign="top">
				<td class="label">{translate key="reviewer.article.schedule.isAttending"} </td>
				<td class="value">	
					<input type="radio" name="isAttending" id="acceptMeetingSchedule" value="1" {if  $submission->getIsAttending() == 1 } checked="checked"{/if} > </input> {translate key="common.yes"}
					<input type="radio" name="isAttending" id="regretMeetingSchedule" value="0" {if  $submission->getIsAttending() == 0 } checked="checked"{/if} > </input> {translate key="common.no"}
				</td>
			</tr> 
			<tr>
				<td class="label">{translate key="reviewer.article.schedule.remarks"} </td>
				<td class="value">
					<textarea class="textArea" name="remarks" id="proposedDate" rows="5" cols="40" />{$submission->getRemarks()|escape}</textarea>
				</td>
			</tr>
			<tr>
				<td class="label"></td>
				<td class="value">
					<input type="hidden" id="reviewId" name="reviewId" value={$reviewId}> </input>
					<input type="submit" value="{translate key="common.save"}" class="button defaultButton" /> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="document.location.href='{url page="user" escape=false}'" />
				</td>
			</tr>**}
		</table>
	</form>
</div>

<div class="separator"></div>


<div id="reviewSteps">
	<h3>{translate key="reviewer.article.reviewSteps"}</h3>

	{include file="common/formErrors.tpl"}

	{assign var="currentStep" value=1}

	<table width="100%" class="data">
		<tr valign="top">
			{* FIXME: Should be able to assign primary editorial contact *}
			<td width="3%">{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
			<td width="97%"><span class="instruct">{translate key="reviewer.article.notifyEditorA"} {translate key="reviewer.article.notifyEditorB"}</span></td>
		</tr>
		<tr valign="top">
			<td>&nbsp;</td>
			<td>
				{translate key="submission.response"}&nbsp;&nbsp;&nbsp;&nbsp;
				{if not $confirmedStatus}
					{url|assign:"acceptUrl" op="confirmReview" reviewId=$reviewId}
					{url|assign:"declineUrl" op="confirmReview" reviewId=$reviewId declineReview=1}

					{if !$submission->getCancelled()}
						{translate key="reviewer.article.canDoReview"} {icon name="mail" url=$acceptUrl}
						&nbsp;&nbsp;&nbsp;&nbsp;
						{translate key="reviewer.article.cannotDoReview"} {icon name="mail" url=$declineUrl}
					{else}
						{url|assign:"url" op="confirmReview" reviewId=$reviewId}
						{translate key="reviewer.article.canDoReview"} {icon name="mail" disabled="disabled" url=$acceptUrl}
						&nbsp;&nbsp;&nbsp;&nbsp;
						{url|assign:"url" op="confirmReview" reviewId=$reviewId declineReview=1}
						{translate key="reviewer.article.cannotDoReview"} {icon name="mail" disabled="disabled" url=$declineUrl}
					{/if}
				{else}
					{if not $declined}{translate key="submission.accepted"}{else}{translate key="submission.rejected"}{/if}
				{/if}
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		{if $journal->getLocalizedSetting('reviewGuidelines') != ''}
			<tr valign="top">
        		<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
				<td><span class="instruct">{translate key="reviewer.article.consultGuidelines"}</span></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		{/if}
		<tr valign="top">
			<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
			<td><span class="instruct">{translate key="reviewer.article.downloadSubmission"}</span></td>
		</tr>

		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		{if $currentJournal->getSetting('requireReviewerCompetingInterests')}
			<tr valign="top">
				<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
				<td>
					{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}
					<span class="instruct">{translate key="reviewer.article.enterCompetingInterests" competingInterestGuidelinesUrl=$competingInterestGuidelinesUrl}</span>
					{if not $confirmedStatus or $declined or $submission->getCancelled() or $submission->getRecommendation()}<br/>
						{$reviewAssignment->getCompetingInterests()|strip_unsafe_html|nl2br}
					{else}
						<form action="{url op="saveCompetingInterests" reviewId=$reviewId}" method="post">
							<textarea {if $cannotChangeCI}disabled="disabled" {/if}name="competingInterests" class="textArea" id="competingInterests" rows="5" cols="40">{$reviewAssignment->getCompetingInterests()|escape}</textarea><br />
							<input {if $cannotChangeCI}disabled="disabled" {/if}class="button defaultButton" type="submit" value="{translate key="common.save"}" />
						</form>
					{/if}
				</td>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		{/if}{* $currentJournal->getSetting('requireReviewerCompetingInterests') *}

		{if $reviewAssignment->getReviewFormId()}
			<tr valign="top">
				<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
				<td><span class="instruct">{translate key="reviewer.article.enterReviewForm"}</span></td>
			</tr>
			<tr valign="top">
				<td>&nbsp;</td>
				<td>
					{translate key="submission.reviewForm"} 
					{if $confirmedStatus and not $declined}
						<a href="{url op="editReviewFormResponse" path=$reviewId|to_array:$reviewAssignment->getReviewFormId()}" class="icon">{icon name="comment"}</a>
					{else}
				 		{icon name="comment" disabled="disabled"}
					{/if}
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		{else}{* $reviewAssignment->getReviewFormId() *}
			<tr valign="top">
				<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
				<td><span class="instruct">{translate key="reviewer.article.enterReviewA"}</span></td>
			</tr>
			<tr valign="top">
				<td>&nbsp;</td>
				<td>
					{translate key="common.chatRoom"}&nbsp; 
					{if $confirmedStatus and not $declined}
						<a href="javascript:openComments('{url op="viewPeerReviewComments" path=$articleId|to_array:$reviewId}');" class="icon">{icon name="comment"}</a>
					{else}
				 		{icon name="comment" disabled="disabled"}
					{/if}
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		{/if}{* $reviewAssignment->getReviewFormId() *}
		<tr valign="top">
			<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
			<td><span class="instruct">{translate key="reviewer.article.uploadFile"}</span></td>
		</tr>
		<tr valign="top">
			<td>&nbsp;</td>
			<td>
				<table class="data" width="100%">
					{assign var="reviewerFile" value=$reviewAssignment->getReviewerFile()}
					{if $reviewerFile}
						{assign var=uploadedFileExists value="1"}
						<tr valign="top">
							<td class="label" width="20%">
								{translate key="reviewer.article.uploadedFile"}
							</td>
							<td class="value" width="80%">
								<a href="{url op="downloadFile" path=$reviewId|to_array:$articleId:$reviewerFile->getFileId()}" class="file">{$reviewerFile->getFileName()|escape}</a>
								&nbsp;{$reviewerFile->getDateModified()|date_format:$dateFormatLong}&nbsp;
								{if ($submission->getRecommendation() === null || $submission->getRecommendation() === '') && (!$submission->getCancelled())}
									<a class="action" href="{url op="deleteReviewerVersion" path=$reviewId|to_array:$reviewerFile->getFileId():$articleId}">{translate key="common.delete"}</a>
								{/if}
							</td>
						</tr>
					{else}
						<tr valign="top">
							<td class="label" width="20%">
								{translate key="reviewer.article.uploadedFile"}
							</td>
							<td class="nodata">
								{translate key="common.none"}
							</td>
						</tr>
					{/if}
				</table>
				&nbsp;
				{if $submission->getRecommendation() === null || $submission->getRecommendation() === ''}
					<form method="post" action="{url op="uploadReviewerVersion"}" enctype="multipart/form-data">
						<input type="hidden" name="reviewId" value="{$reviewId|escape}" />
						<input type="file" name="upload" {if not $confirmedStatus or $declined or $submission->getCancelled()}disabled="disabled"{/if} class="uploadField" />
						<input type="submit" name="submit" value="{if $uploadedFileExists}{translate key="common.replaceFile"}{else}{translate key="common.upload"}{/if}" {if not $confirmedStatus or $declined or $submission->getCancelled()}disabled="disabled"{/if} class="button" />
					</form>

					{if $currentJournal->getSetting('showEnsuringLink')}
						<span class="instruct">
							<a class="action" href="javascript:openHelp('{get_help_id key="editorial.sectionEditorsRole.review.blindPeerReview" url="true"}')">{translate key="reviewer.article.ensuringBlindReview"}</a>
						</span>
					{/if}
				{/if}
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="top">
			<td>{$currentStep|escape}.{assign var="currentStep" value=$currentStep+1}</td>
			<td><span class="instruct">{translate key="reviewer.article.selectRecommendation"}</span></td>
		</tr>
		<tr valign="top">
			<td>&nbsp;</td>
			<td>
				<table class="data" width="100%">
					<tr valign="top">
						<td class="label" width="30%">{translate key="submission.recommendation"}</td>
						<td class="value" width="70%">
							{if $submission->getRecommendation() !== null && $submission->getRecommendation() !== ''}
								{assign var="recommendation" value=$submission->getRecommendation()}
								<strong>{translate key=$reviewerRecommendationOptions.$recommendation}</strong>&nbsp;&nbsp;
								{$submission->getDateCompleted()|date_format:$dateFormatShort}
							{else}
								<form name="recommendation" method="post" action="{url op="recordRecommendation"}">
									<input type="hidden" name="reviewId" value="{$reviewId|escape}" />
									<select name="recommendation" {if not $confirmedStatus or $declined or $submission->getCancelled() or (!$reviewFormResponseExists and !$uploadedFileExists)}disabled="disabled"{/if} class="selectMenu">
										{html_options_translate options=$reviewerRecommendationOptions selected=''}
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="submit" name="submit" onclick="return confirmSubmissionCheck()" class="button" value="{translate key="reviewer.article.submitReview"}" {if not $confirmedStatus or $declined or $submission->getCancelled() or (!$reviewFormResponseExists and !$reviewAssignment->getMostRecentPeerReviewComment() and !$uploadedFileExists)}disabled="disabled"{/if} />
								</form>					
							{/if}
						</td>		
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>


<div class="separator"></div>



{if $journal->getLocalizedSetting('reviewGuidelines') != ''}
	<div class="separator"></div>

	<div id="reviewerGuidelines">
		<h3>{translate key="reviewer.article.reviewerGuidelines"}</h3>
		<p>{$journal->getLocalizedSetting('reviewGuidelines')|nl2br}</p>
	</div>
{/if}



