{**
 * index.tpl
 *
 * Reviewer index.
 *
 * $Id$
 *}

{strip}
	{assign var="pageTitle" value="common.queue.long.meetingProposals"}
	{include file="common/header.tpl"}
{/strip}

{if !$dateFrom}
	{assign var="dateFrom" value="--"}
{/if}

{if !$dateTo}
	{assign var="dateTo" value="--"}
{/if}
<ul class="menu">
	<li><a href="{url journal=$journalPath page="reviewer" path="active"}">{translate key="common.queue.short.reviewAssignments"}</a></li>
	<li class="current"><a href="{url op="meetings}">{translate key="reviewer.meetings"}</a></li>
</ul>
<ul class="menu">
	<li><a href="{url op="meetings"}">{translate key="common.queue.long.meetingList"}</a></li>
	{if $isReviewer}
		<li class="current"><a href="{url op="proposalsFromMeetings"}">{translate key="common.queue.long.meetingProposals"}</a></li>
	{/if}
</ul>

<div class="separator"></div>
<br/>
 
{if !$dateFrom}
	{assign var="dateFrom" value="--"}
{/if}

{if !$dateTo}
	{assign var="dateTo" value="--"}
{/if}

<form method="post" name="submit" action="{url op='proposalsFromMeetings'}">
	<input type="hidden" name="sort" value="id"/>
	<input type="hidden" name="sortDirection" value="ASC"/>
	<select name="searchField" size="1" class="selectMenu">
		{html_options_translate options=$fieldOptions selected=$searchField}
	</select>
	<select name="searchMatch" size="1" class="selectMenu">
		<option value="contains"{if $searchMatch == 'contains'} selected="selected"{/if}>{translate key="form.contains"}</option>
		<option value="is"{if $searchMatch == 'is'} selected="selected"{/if}>{translate key="form.is"}</option>
		<option value="startsWith"{if $searchMatch == 'startsWith'} selected="selected"{/if}>{translate key="form.startsWith"}</option>
	</select>
	<input type="text" size="15" name="search" class="textField" value="{$search|escape}" />
	<br/>
	<input type="submit" value="{translate key="common.search"}" class="button" />
	<br/>
	<br/>
</form>

<div id="submissions">
	<table class="listing" width="100%">
		<tr><td colspan="3" class="headseparator">&nbsp;</td></tr>
		<tr class="heading" valign="bottom">
			<td width="20%">{translate key="common.proposalId"}</td>
			<td width="60%">{translate key="article.title" sort='title'}</td>
			<td width="20%">Investigator</td>
		</tr>
		<tr><td colspan="3" class="headseparator">&nbsp;</td></tr>
		{iterate from=sectionDecisions item=sectionDecision}
			<tr valign="top">
				<td>{$sectionDecision->getProposalId()|escape}</td>
				<td><a href="{url op="viewProposalFromMeeting" path=$sectionDecision->getId()}" class="action">{$sectionDecision->getLocalizedProposalTitle()|strip_unsafe_html|truncate:60:"..."}</a></td>
   				<td>{$sectionDecision->getAuthorString()|truncate:40:"..."|escape}</td>		
			</tr>	
			<td colspan="3" class="separator">&nbsp;</td>
		{/iterate}
		{if $sectionDecisions->wasEmpty()}
			<tr>
				<td colspan="3" class="nodata">{translate key="submissions.noSubmissions"}</td>
			</tr>
			<tr>
				<td colspan="3" class="endseparator">&nbsp;</td>
			</tr>
		{else}
			<tr>
				<td colspan="3" align="left">{page_info iterator=$sectionDecisions}</td>
				<td colspan="3" align="right">{page_links anchor="sectionDecisions" name="sectionDecisions" iterator=$sectionDecisions sort=$sort sortDirection=$sortDirection}</td>
			</tr>
		{/if}
	</table>
</div>

{include file="common/footer.tpl"}

