{**
 * submission.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Author's submission summary.
 *
 * $Id$
 *}
{strip}
    {translate|assign:"pageTitleTranslated" key="common.queue.long.$pageToDisplay" id=$proposalId} 
    {assign var="pageCrumbTitle" value="common.queue.short.$pageToDisplay"}
    {include file="common/header.tpl"}
{/strip}

<ul class="menu">
    <li{if ($pageToDisplay == "articleDetails")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleDetails"}">{translate key="common.queue.short.articleDetails"}</a></li>
    <li{if ($pageToDisplay == "articleDrugs")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleDrugs"}">{translate key="common.queue.short.articleDrugs"}</a></li>
    <li{if ($pageToDisplay == "articleSites")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleSites"}">{translate key="common.queue.short.articleSites"}</a></li>
    <li{if ($pageToDisplay == "articleSponsors")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleSponsors"}">{translate key="common.queue.short.articleSponsors"}</a></li>
    <li{if ($pageToDisplay == "articleContact")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleContact"}">{translate key="common.queue.short.articleContact"}</a></li>
    <li{if ($pageToDisplay == "articleFiles")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"articleFiles"}">{translate key="common.queue.short.articleFiles"}</a></li>
    <li{if ($pageToDisplay == "submissionReview")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"submissionReview"}">{translate key="common.queue.short.submissionReview"}</a></li>
</ul>

{include file="author/submission/management.tpl"}

<div class="separator"></div>
<br/>
{if ($pageToDisplay == "submissionReview")}
    {include file="author/submission/peerReview.tpl"}
{else}
    {include file="submission/metadata/$pageToDisplay.tpl"}
{/if}

{include file="common/footer.tpl"}

