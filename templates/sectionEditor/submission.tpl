{**
 * submission.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Submission summary.
 *
 * $Id$
 *}
{strip}
{translate|assign:"pageTitleTranslated" key="submission.page.summary" id=$proposalId}
{assign var="pageCrumbTitle" value="submission.summary"}
{include file="common/header.tpl"}
{/strip}


<ul class="menu">
    <li{if ($pageToDisplay == "articleDetails")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleDetails"}">{translate key="common.queue.short.articleDetails"}</a></li>
    <li{if ($pageToDisplay == "articleDrugs")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleDrugs"}">{translate key="common.queue.short.articleDrugs"}</a></li>
    <li{if ($pageToDisplay == "articleSites")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleSites"}">{translate key="common.queue.short.articleSites"}</a></li>
    <li{if ($pageToDisplay == "articleSponsors")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleSponsors"}">{translate key="common.queue.short.articleSponsors"}</a></li>
    <li{if ($pageToDisplay == "articleContact")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleContact"}">{translate key="common.queue.short.articleContact"}</a></li>
    <li{if ($pageToDisplay == "articleFiles")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleFiles"}">{translate key="common.queue.short.articleFiles"}</a></li>
    {if !$isEditor && $canReview}<li><a href="{url op="submissionReview" path=$articleId}">{translate key="submission.review"}</a></li>{/if}
    <li><a href="{url op="submissionHistory" path=$articleId}">{translate key="submission.history"}</a></li>
</ul>

{include file="sectionEditor/submission/management.tpl"}

<div class="separator"></div>

{include file="submission/metadata/$pageToDisplay.tpl"}

{include file="common/footer.tpl"}

