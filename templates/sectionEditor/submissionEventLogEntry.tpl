{**
 * submissionEventLogEntry.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show a single event log entry.
 *
 *
 * $Id$
 *}
{strip}
    {translate|assign:"pageTitleTranslated" key="submission.eventLog" id=$proposalId}
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
	<li class="current"><a href="{url op="submissionEventLog" path=$articleId}">{translate key="submission.history.submissionEventLog"}</a></li>
	<li><a href="{url op="submissionEmailLog" path=$articleId}">{translate key="submission.history.submissionEmailLog"}</a></li>
	<li><a href="{url op="submissionNotes" path=$articleId}">{translate key="submission.history.submissionNotes"}</a></li>
</ul>

<div class="separator"></div>
<div id="submissionEventLog">
<h3>{translate key="submission.history.submissionEventLog"}</h3>
<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="common.id"}</td>
		<td width="80%" class="value">{$logEntry->getId()}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.date"}</td>
		<td class="value">{$logEntry->getDateLogged()|date_format:$datetimeFormatLong}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="submission.event.logLevel"}</td>
		<td class="value">{translate key=$logEntry->getLogLevelString()}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.type"}</td>
		<td class="value">{translate key=$logEntry->getAssocTypeLongString()}</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.user"}</td>
		<td class="value">
			{assign var=emailString value=$logEntry->getUserFullName()|concat:" <":$logEntry->getUserEmail():">"}
			{url|assign:"url" page="user" op="email" to=$emailString|to_array redirectUrl=$currentUrl subject=$logEntry->getEventTitle()|translate articleId=$articleId}
			{$logEntry->getUserFullName()|escape} {icon name="mail" url=$url}
		</td>
	</tr>
	<tr valign="top">
		<td class="label">{translate key="common.event"}</td>
		<td class="value">
			<strong>{translate key=$logEntry->getEventTitle()}</strong>
			<br /><br />
			{$logEntry->getMessage()|strip_unsafe_html|nl2br}
		</td>
	</tr>
</table>
{if $isEditor}
	<a href="{url op="clearSubmissionEventLog" path=$articleId|to_array:$logEntry->getId()}" onclick="return confirm('{translate|escape:"jsparam" key="submission.event.confirmDeleteLogEntry"}')" class="action">{translate key="submission.event.deleteLogEntry"}</a><br/>
{/if}
</div>
<a class="action" href="{url op="submissionEventLog" path=$articleId}">{translate key="submission.event.backToEventLog"}</a>

{include file="common/footer.tpl"}

