{**
 * submissionsUnassigned.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show listing of unassigned submissions.
 *}
<div id="submissions">
<table width="100%" class="listing">
	<tr>
		<td colspan="5" class="headseparator">&nbsp;</td>
	</tr>
	<tr class="heading" valign="bottom">
		<td width="10%">{translate key="common.proposalId"}</td>
		<td width="10%"><span class="disabled">{translate key="submission.date.yyyymmdd"}</span><br/>
<!-- {sort_search key="submissions.submit" sort="submitDate"}--> </td> 
		<td width="45%"><span class="disabled">{translate key="article.title"}</span><br/></td> <!-- {sort_search key="article.title" sort="title"}</td> -->
		<td width="5%"><span class="disabled">Resubmitted</span><br/></td>
	</tr>
	<tr>
		<td colspan="5" class="headseparator">&nbsp;</td>
	</tr>
	
	{iterate from=submissions item=submission}
	<tr valign="top" {if $submission->getFastTracked()} class="fastTracked"{/if}>
		{assign var="proposalId" value=$submission->getProposalId()}

		<td>{if $proposalId}{$proposalId|escape}{else}&mdash;{/if}</td>
		<td>{$submission->getDateSubmitted()|date_format:$dateFormatShort}</td>
		<td>{if $submission->getResubmitCount()}<a href="{url op="submissionReview" path=$submission->getId()}" class="action">{if $submission->getScientificTitle()}{$submission->getScientificTitle()|strip_unsafe_html|truncate:60:"..."}{else}{translate key="common.untitled"}{/if}</a>{else}<a href="{url op="submission" path=$submission->getId()|to_array:"submissionReview"}" class="action">{if $submission->getScientificTitle()}{$submission->getScientificTitle()|strip_unsafe_html|truncate:60:"..."}{else}{translate key="common.untitled"}{/if}</a>{/if}</td>
		<td>{if $submission->getResubmitCount()}{$submission->getResubmitCount()}{else}0{/if}</td>
	</tr>
	<tr>
		<td colspan="5" class="{if $submissions->eof()}end{/if}separator">&nbsp;</td>
	</tr>
{/iterate}
{if $submissions->wasEmpty()}
	<tr>
		<td colspan="4" class="nodata">{translate key="submissions.noSubmissions"}</td>
	</tr>
	<tr>
		<td colspan="4" class="endseparator">&nbsp;</td>
	</tr>
{else}
	<tr>
		<td colspan="4" align="left">{page_info iterator=$submissions}</td>
		<td align="right">{page_links anchor="submissions" name="submissions" iterator=$submissions searchField=$searchField searchMatch=$searchMatch search=$search dateFromDay=$dateFromDay dateFromYear=$dateFromYear dateFromMonth=$dateFromMonth dateToDay=$dateToDay dateToYear=$dateToYear dateToMonth=$dateToMonth dateSearchField=$dateSearchField section=$section sort=$sort sortDirection=$sortDirection}</td>
	</tr>
{/if}
</table>
</div>

