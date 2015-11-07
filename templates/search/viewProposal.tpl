
{strip}
{assign var=pageTitle value="search.summary"}
{include file="common/header.tpl"}
{/strip}

{if !$dateFrom}
{assign var="dateFrom" value="--"}
{/if}

{if !$dateTo}
{assign var="dateTo" value="--"}
{/if}

<br/>
<form name="revise" action="{url op="advanced"}" method="post">
	<input type="hidden" name="query" value="{$query|escape}"/>
	<div style="display:none">
		{html_select_date prefix="dateFrom" time=$dateFrom all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
		{html_select_date prefix="dateTo" time=$dateTo all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
	</div>
</form>

<form name="generate" action="{url op="generateCSV"}" method="post">
	<input type="hidden" name="query" value="{$query|escape}"/>
	<div style="display:none">
		{html_select_date prefix="dateFrom" time=$dateFrom all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
		{html_select_date prefix="dateTo" time=$dateTo all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
	</div>
</form>

<div id="downloadCompletionReport">
    {if $submission->getStatus() == STATUS_COMPLETED}
        {assign var="finalReport" value=$submission->getPublishedFinalReport()}
        <h3 align="right"><b><a href="{url op="downloadFinalReport" path=$submission->getArticleId()|to_array:$finalReport->getFileId()}" class="file">{translate key="search.downloadFinalReport"}</a></b></h3>
    {/if}
</div>
        
<div id="authors">
<h4>{translate key="article.authors"}</h4>
	
<table width="100%" class="data">
</table>
</div>

<div id="titleAndAbstract">
	<h4><br/>{translate key="search.titlesAndAbstract"}</h4>

	<table width="100%" class="data">
		{if $submission->getStatus() == 11}
			<tr valign="top">
				<td class="label">&nbsp;</td>
				<td class="value">
				Completion Report:&nbsp;&nbsp;&nbsp;&nbsp;
				{foreach name="suppFiles" from=$suppFiles item=suppFile}
				{if $suppFile->getType() == "Completion Report"}<br/>
					<a href="{url op="downloadFile" path=$submission->getArticleId()|to_array:$suppFile->getFileId():$suppFile->getSuppFileId()}" class="file">{$suppFile->getFileName()|escape}</a>
				{/if}
				{foreachelse}
				Not available.
				{/foreach}
			</td>
			</tr>
		{/if}
    	<tr valign="top">
        	<td class="label" width="20%">{translate key="proposal.scientificTitle"}</td>
        	<td class="value">title</td>
    	</tr>
    	<tr valign="top">
        	<td class="label" width="20%">{translate key="proposal.publicTitle"}</td>
        	<td class="value">title</td>
    	</tr>
</table>
</div>

{include file="common/footer.tpl"}

