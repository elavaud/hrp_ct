{**
 * complete.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * The submission process has been completed; notify the author.
 *
 * $Id$
 *}
{strip}
{assign var="pageTitle" value="author.track"}
{include file="common/header.tpl"}
{/strip}

<div id="submissionComplete">

<p style="font-size: larger;">{translate key="author.submit.submissionComplete" journalTitle=$journal->getLocalizedTitle()}</p>

<h1>{translate key="article.metadata"}</h1>
<p>{$section->getSectionTitle()}</p>

    <div class="separator"></div>

    <h4>{translate key="author.submit.step2"}</h4>
    <br />
    {include file="submission/metadata/articleDetails.tpl"}
    
    <div class="separator"></div>
    
    <h4>{translate key="author.submit.step3"}</h4>
    <br />
    {include file="submission/metadata/articleDrugs.tpl"}

    <div class="separator"></div>
    
    <h4>{translate key="author.submit.step4"}</h4>
    <br />
    {include file="submission/metadata/articleSites.tpl"}

    <div class="separator"></div>
    
    <h4>{translate key="author.submit.step5"}</h4>
    <br />
    {include file="submission/metadata/articleSponsors.tpl"}
    
    <div class="separator"></div>
    
    <h4>{translate key="author.submit.step6"}</h4>
    <br />
    {include file="submission/metadata/articleContact.tpl"}
    
    <div class="separator"></div>
    
    <div id="fileSummary">

        <h3>{translate key="author.submit.filesSummary"}</h3>
        <table class="listing" width="100%">
            <tr>
                <td colspan="5" class="headseparator">&nbsp;</td>
            </tr>
            <tr class="heading" valign="bottom">
                <td width="35%">{translate key="common.originalFileName"}</td>
                <td width="25%">{translate key="common.type"}</td>
                <td width="20%" class="nowrap">{translate key="common.fileSize"}</td>
                <td width="10%" class="nowrap">{translate key="common.dateUploaded"}</td>
            </tr>
            <tr>
                <td colspan="5" class="headseparator">&nbsp;</td>
            </tr>
            {foreach from=$files item=file}
                <tr valign="top">
                    <td><a class="file" href="{url op="download" path=$articleId|to_array:$file->getFileId()}">{$file->getOriginalFileName()|escape}</a></td>
                    <td>
                        {if ($file->getType() == 'submission/original')}
                            {translate key="author.submit.submissionFile"}
                        {elseif ($file->getType() == 'previous')}
                            {translate key="author.submit.previousSubmissionFile"}
                        {else}
                            {$file->getType()}
                        {/if}
                    </td>
                    <td>{$file->getNiceFileSize()}</td>
                    <td>{$file->getDateUploaded()|date_format:$dateFormatTrunc}</td>
                </tr>
            {foreachelse}
                <tr valign="top">
                    <td colspan="5" class="nodata">{translate key="author.submit.noFiles"}</td>
                </tr>
            {/foreach}
        </table>
    </div>

<div class="separator"></div>

<br />
<!--
{if $canExpedite}
	{url|assign:"expediteUrl" op="expediteSubmission" articleId=$articleId}
	{translate key="author.submit.expedite" expediteUrl=$expediteUrl}
{/if}
{if $paymentButtonsTemplate }
	{include file=$paymentButtonsTemplate orientation="vertical"}
{/if}
-->

<p>&#187; <a href="{url op="index"}">{translate key="author.track"}</a></p>

</div>

{include file="common/footer.tpl"}

