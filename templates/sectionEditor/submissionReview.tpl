{**
 * submissionReview.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Submission review.
 *
 * $Id$
 *}
{strip}
{translate|assign:"pageTitleTranslated" key="submission.page.review" id=$proposalId}
{assign var="pageCrumbTitle" value="submission.review"}
{include file="common/header.tpl"}
{/strip}

<ul class="menu">
    <li><a href="{url op="submission" path=$articleId|to_array:"articleDetails"}">{translate key="common.queue.short.articleDetails"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleDrugs"}">{translate key="common.queue.short.articleDrugs"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleSites"}">{translate key="common.queue.short.articleSites"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleSponsors"}">{translate key="common.queue.short.articleSponsors"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleContact"}">{translate key="common.queue.short.articleContact"}</a></li>
    <li><a href="{url op="submission" path=$articleId|to_array:"articleFiles"}">{translate key="common.queue.short.articleFiles"}</a></li>
    <li class="current"><a href="{url op="submissionReview" path=$articleId}">{translate key="submission.review"}</a></li>
    <li><a href="{url op="submissionHistory" path=$articleId}">{translate key="submission.history"}</a></li>
</ul>

<p style="text-align:right"><a href="{url op="downloadSummary" path=$articleId}" class="file"><b>{translate key="common.download"} {translate key="submission.summary"}</b></a></p>

{include file="sectionEditor/submission/management.tpl"}

<div class="separator"></div>

{include file="sectionEditor/submission/editorDecision.tpl"}

<div class="separator"></div>

{include file="common/footer.tpl"}

