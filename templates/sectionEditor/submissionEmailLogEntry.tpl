{**
 * submissionEmailLogEntry.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show a single email log entry.
 *
 *
 * $Id$
 *}
{strip}
    {translate|assign:"pageTitleTranslated" key="submission.emailLog" id=$proposalId}
    {include file="common/header.tpl"}
{/strip}

<ul class="menu">
    <li><a href="{url op="submission" path=$articleId|to_array:"articleDetails"}">{translate key="common.queue.short.articleDetails"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleDrugs"}">{translate key="common.queue.short.articleDrugs"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleSites"}">{translate key="common.queue.short.articleSites"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleSponsors"}">{translate key="common.queue.short.articleSponsors"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleContact"}">{translate key="common.queue.short.articleContact"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleFiles"}">{translate key="common.queue.short.articleFiles"}</a></li>
    {if $canReview}<li><a href="{url op="submissionReview" path=$articleId}">{translate key="submission.review"}</a></li>{/if}
    <li class="current"><a href="{url op="submissionHistory" path=$articleId}">{translate key="submission.history"}</a></li>
</ul>

<ul class="menu">
	<li><a href="{url op="submissionEventLog" path=$articleId}">{translate key="submission.history.submissionEventLog"}</a></li>
	<li class="current"><a href="{url op="submissionEmailLog" path=$articleId}">{translate key="submission.history.submissionEmailLog"}</a></li>
	<li><a href="{url op="submissionNotes" path=$articleId}">{translate key="submission.history.submissionNotes"}</a></li>
</ul>

<div class="separator"></div>

<h3>{translate key="submission.history.submissionEmailLog"}</h3>
<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="common.id"}</td>
		<td width="80%" class="value">{$logEntry->getId()}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.date"}</td>
		<td class="value">{$logEntry->getDateSent()|date_format:$datetimeFormatLong}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.type"}</td>
		<td class="value">{translate key=$logEntry->getAssocTypeLongString()}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.sender"}</td>
		<td class="value">
			{if $logEntry->getSenderFullName()}
				{assign var=emailString value=$logEntry->getSenderFullName()|concat:" <":$logEntry->getSenderEmail():">"}
				{url|assign:"url" page="user" op="email" to=$emailString|to_array redirectUrl=$currentUrl subject=$logEntry->getSubject() articleId=$articleId}
				{$logEntry->getSenderFullName()|escape} {icon name="mail" url=$url}
			{else}
				{translate key="common.notApplicable"}
			{/if}
		</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.from"}</td>
		<td class="value">{$logEntry->getFrom()|escape}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.to"}</td>
		<td class="value">{$logEntry->getRecipients()|escape}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.cc"}</td>
		<td class="value">{$logEntry->getCcs()|escape}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.bcc"}</td>
		<td class="value">{$logEntry->getBccs()|escape}</td>
	</tr>
	{if !empty($attachments)}
		<tr valign="top">
			<td class="label">{translate key="email.attachments"}</td>
			<td class="value">{foreach from=$attachments item=attachment}
				<a href="{url op="downloadFile" path=$attachment->getArticleId()|to_array:$attachment->getFileId()}" class="action">{$attachment->getOriginalFilename()|escape}</a>
			{/foreach}</td>
		</tr>
	{/if}
	<tr valign="top">
		<td class="label">{translate key="email.subject"}</td>
		<td class="value">{$logEntry->getSubject()|escape}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="email.body"}</td>
		<td class="value">{$logEntry->getBody()|escape|nl2br}</td>
	</tr>
</table>
{if $isEditor}
	<a href="{url op="clearSubmissionEmailLog" path=$articleId|to_array:$logEntry->getId()}" onclick="return confirm('{translate|escape:"jsparam" key="submission.email.confirmDeleteLogEntry"}')" class="action">{translate key="submission.email.deleteLogEntry"}</a><br/>
{/if}

<a href="{url op="submissionEmailLog" path=$articleId}" class="action">{translate key="submission.email.backToEmailLog"}</a>

{include file="common/footer.tpl"}

