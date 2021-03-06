{**
 * waitingForResubmissions.tpl
 *
 * Show section secretary's proposals waiting for resubmission.
 *
 * $Id$
 *}
 
<br/><br/>
<div id="submissions">
<table class="listing" width="100%">
	<tr><td colspan="6" class="headseparator">&nbsp;</td></tr>
	<tr class="heading" valign="bottom">
		<td width="10%">{translate key="common.proposalId"}</td>
		<td width="10%">{sort_heading key="submissions.submit" sort="submitDate"}</td>
		<td width="40%">{sort_heading key="article.title" sort="title"}</td>
		<td width="15%">{sort_heading key="submissions.reviewRound" sort="round"}</td>
		<td width="10%" align="right">{sort_heading key="common.status" sort="status"}</td>
	</tr>
	<tr><td colspan="6" class="headseparator">&nbsp;</td></tr>
<p></p>

{iterate from=submissions item=submission}
    {assign var="lastDecision" value=$submission->getLastSectionDecision()}
    {assign var="decisionValue" value=$lastDecision->getDecision()}
    {assign var="articleId" value=$submission->getArticleId()}
    {assign var="proposalId" value=$submission->getProposalId()}

	<tr valign="top">
		<td>{if $proposalId}{$proposalId|escape}{else}&mdash;{/if}</td>
		<td>{$submission->getDateSubmitted()|date_format:$dateFormatLong}</td>
        <td><a href="{url op="submissionReview" path=$submission->getId()}" class="action">{if $submission->getScientificTitle()}{$submission->getScientificTitle()|strip_unsafe_html|truncate:60:"..."}{else}{translate key="common.untitled"}{/if}</a></td>
        <td>{$lastDecision->getSectionAcronym()} - {translate key=$lastDecision->getReviewTypeKey()} - {$lastDecision->getRound()}</td>
		<td align="right">{translate key=$lastDecision->getReviewStatusKey()}</td>		
	</tr>
	<tr>
		<td colspan="6" class="{if $submissions->eof()}end{/if}separator">&nbsp;</td>
	</tr>
{/iterate}
{if $submissions->wasEmpty()}
	<tr>
		<td colspan="6" class="nodata">{translate key="submissions.noSubmissions"}</td>
	</tr>
	<tr>
		<td colspan="6" class="endseparator">&nbsp;</td>
	</tr>
{else}
	<tr>
		<td colspan="4" align="left">{page_info iterator=$submissions}</td>
		<td align="right" colspan="2">{page_links anchor="submissions" name="submissions" iterator=$submissions searchField=$searchField searchMatch=$searchMatch search=$search dateFromDay=$dateFromDay dateFromYear=$dateFromYear dateFromMonth=$dateFromMonth dateToDay=$dateToDay dateToYear=$dateToYear dateToMonth=$dateToMonth dateSearchField=$dateSearchField section=$section sort=$sort sortDirection=$sortDirection}</td>
	</tr>
{/if}
</table>
</div>

