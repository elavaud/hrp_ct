{**
 * searchResults.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Display article search results.
 *
 * $Id$
 *}
{strip}
{assign var=pageTitle value="search.research"}
{include file="common/header.tpl"}
{/strip}

{include file="search/search.tpl"}

<script type="text/javascript">
{literal}
function showExportOptions(){
	$('#exportOptions').show();
	$('#showExportOptions').hide();
	$('#hideExportOptions').show();
}

function hideExportOptions(){
	$('#exportOptions').hide();
	$('#hideExportOptions').hide();
	$('#showExportOptions').show();
}

$(document).ready(
	function (){
		$('#exportOptions').hide();
		$('#hideExportOptions').hide();
	}
);
// -->
{/literal}
</script>

{if !$dateFrom}
{assign var="dateFrom" value="--"}
{/if}

{if !$dateTo}
{assign var="dateTo" value="--"}
{/if}

<form name="generate" action="{url op="generateCustomizedCSV"}" method="post"  id="exportOptions">
    <input type="hidden" name="query" value="{$query|escape}"/>
    <input type="hidden" name="region" value="{$region|escape}"/>
    <input type="hidden" name="statusFilter" value="{$statusFilter|escape}"/>
    <input type="hidden" name="trialSite" value="{$trialSite|escape}"/>    
    <input type="hidden" name="dateFrom" value="{$dateFrom|escape}"/>
    <input type="hidden" name="dateTo" value="{$dateTo|escape}"/>

    <table class="data" width="100%">
        <tr><i><br />{translate key="search.exportIntruct"}<br /></i></tr>
        <tr valign="top">
            <td width="20%" class="value">
                <input type="checkbox" name="proposalId" checked="checked"/>&nbsp;{translate key="article.submissionId"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="scientificTitle" checked="checked"/>&nbsp;{translate key="article.scientificTitle"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="publicTitle"/>&nbsp;{translate key="article.publicTitle"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="recruitmentStatus"/>&nbsp;{translate key="proposal.recruitment"}&nbsp;{translate key="proposal.recruitment.status"}
            </td>
            <td width="20%" class="value">
                &nbsp;
            </td>            
        </tr>
        <tr valign="top">
            <td width="20%" class="value">
                <input type="checkbox" name="therapeuticArea" checked="checked"/>&nbsp;{translate key="proposal.therapeuticArea"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="minAge"/>&nbsp;{translate key="proposal.age.minimum"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="maxAge"/>&nbsp;{translate key="proposal.age.maximum"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="sex"/>&nbsp;{translate key="proposal.sex"}
            </td>
            <td width="20%" class="value">
                &nbsp;
            </td>            
        </tr>
        <tr valign="top">
            <td width="20%" class="value">
                <input type="checkbox" name="healthy"/>&nbsp;{translate key="proposal.healthy"}
            </td>
            <td width="20%" class="value">
                <input type="checkbox" name="pSponsor" checked="checked"/>&nbsp;{translate key="proposal.primarySponsor"}
            </td>
            <td width="20%" class="value" colspan="2">
                <input type="checkbox" name="enrolment"/>&nbsp;{translate key="proposal.expectedDate"}
            </td>
            <td width="20%" class="value">
                &nbsp;
            </td>            
        </tr>
    </table>
    <p><input type="submit" value="{translate key="common.export"}" class="button defaultButton"/>
</form>

<br/>
<h4>
    {if $statusFilter != "ALL"}{$recruitmentStatusMap.$statusFilter}<br/>{/if}
    {if $query}{translate key="help.searchResultsFor"} '{$query}' {else} {translate key="common.search"} {/if}
    {if $dateFrom != '--'}{translate key="search.dateFrom"} {$dateFrom|date_format:$dateFormatLong} {/if}
    {if $dateFrom != '--' && $dateTo != '--'} {translate key="search.operator.and"} {/if}
    {if $dateTo != '--'}{translate key="search.dateTo"} {$dateTo|date_format:$dateFormatLong} {/if}
    {if $country}{translate key="search.takingPlaceIn"} {$country} {/if}
    {if $trialSite}<br/>{$sitesList.$trialSite} {/if}    
    : {$count} {translate key="search.results"}. 
</h4>
<div id="results">
	<table width="100%" class="listing">
		<tr class="heading" valign="bottom">
			<td>{sort_heading key='article.title' sort="title"}</td>
			<td>{sort_heading key='proposal.articleSponsor.primarySponsor' sort="sponsor"}</td>
			<td>{sort_heading key='proposal.therapeuticArea' sort="therapeuticarea"}</td>
			<td>{sort_heading key="common.status" sort="status"}</td>
		</tr>
		<tr>
			<td colspan="4" class="headseparator">&nbsp;</td>
		</tr>
		<p></p>
		{iterate from=results item=result}
			<tr valign="bottom">
				<td><a href="{url op="viewProposal" path=$result->getId()}" class="action">{$result->getScientificTitle()|escape}</a></td>
				<td>{$result->getArticlePrimarySponsorName()|escape}</td>
				<td>{$result->getArticleTherapeuticArea()|escape}</td>
				<td>
                                    {if $result->getStatus() == STATUS_COMPLETED}
                                        {translate key="common.queue.short.completedResearches"}
                                	{assign var="finalReport" value=$result->getPublishedFinalReport()}
                                	<br/><a href="{url op="downloadFinalReport" path=$result->getArticleId()|to_array:$finalReport->getFileId()}" class="file">{translate key="search.downloadFinalReport"}</a>
                                    {else}
                                        {$result->getArticleRecruitmentStatus()|escape}
                                    {/if}
                                </td>
			</tr>
			<tr>
				<td colspan="4" class="{if $results->eof()}end{/if}separator">&nbsp;</td>
			</tr>
		{/iterate}
		{if $results->wasEmpty()}
			<tr>
				<td colspan="4" class="nodata">{translate key="search.noResults"}</td>
			</tr>
			<tr>
				<td colspan="4" class="endseparator">&nbsp;</td>
			</tr>
		{else}
			<tr>
				<td colspan="2" align="left">{page_info iterator=$results}</td>
				<td align="right" colspan="2">{page_links anchor="results" iterator=$results name="search" query=$query dateFrom=$dateFrom dateTo=$dateTo proposalCountry=$country status=$statusFilter sort=$sort sortDirection=$sortDirection}</td>
			</tr>
		{/if}
	</table>
</div>	

{include file="common/footer.tpl"}

