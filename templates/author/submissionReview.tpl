{**
 * submissionReview.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Author's submission review.
 *
 * $Id$
 *}
{strip}
{translate|assign:"pageTitleTranslated" key="submission.page.review" id=$submission->getProposalId()}
{assign var="pageCrumbTitle" value="submission.review"}
{include file="common/header.tpl"}
{/strip}

<ul class="menu">
	<li><a href="{url op="submission" path=$submission->getId()|to_array:"submissionReview"}">{translate key="submission.summary"}</a></li>
	<li class="current"><a href="{url op="submissionReview" path=$submission->getId()}">{translate key="submission.review"}</a></li>
</ul>

{include file="author/submission/management.tpl"}

<div class="separator"></div>

{include file="author/submission/peerReview.tpl"}

<!--{*
<div class="separator"></div>

{include file="author/submission/status.tpl"}

<div class="separator"></div>

{include file="author/submission/editorDecision.tpl"}

*}-->

{include file="common/footer.tpl"}

