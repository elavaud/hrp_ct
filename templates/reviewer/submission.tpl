{**
 * submission.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show the reviewer administration page.
 *
 * FIXME: At "Notify The Editor", fix the date.
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
    <li{if ($pageToDisplay == "submissionReview")} class="current"{/if}><a href="{url op="submission" path=$articleId|to_array:"submissionReview"}">{translate key="reviewer.article.submissionReview"}</a></li>
</ul>

<p style="text-align:right"><a href="{url op="downloadSummary" path=$articleId}" class="file"><b>{translate key="common.download"} {translate key="submission.summary"}</b></a></p>

<script type="text/javascript">
    {literal}
        <!--
        function confirmSubmissionCheck() {
            if (document.recommendation.recommendation.value=='') {
                alert('{/literal}{translate|escape:"javascript" key="reviewer.article.mustSelectDecision"}{literal}');
                return false;
            }
            return confirm('{/literal}{translate|escape:"javascript" key="reviewer.article.confirmDecision"}{literal}');
        }

        $(document).ready(function() {
            $( "#proposedDate" ).datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd-M-yy', minDate: '-6 m'});
        });
        // -->
    {/literal}
</script>

<div id="submissionToBeReviewed">
    <h3>{translate key="reviewer.article.submissionToBeReviewed"}</h3>
    <table width="100%" class="data">
        <tr valign="top">
            <td width="20%" class="label">{translate key="common.proposalId"}</td>
            <td width="80%" class="value"><ul><li>{$proposalId|strip_unsafe_html}</li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="article.title"}</td>
            <td width="80%" class="value"><ul><li>{$scientificTitle|escape}</li></ul></td>
        </tr>
        <tr valign="top">
            <td class="label">{translate key="article.journalSection"}</td>
            <td class="value"><ul><li>{$section->getSectionTitle()|escape}</li></ul></td>
        </tr>
    </table>
</div>

<div class="separator"></div>

{if ($pageToDisplay == "submissionReview")}
    {include file="reviewer/$pageToDisplay.tpl"}
{else}
    {include file="submission/metadata/$pageToDisplay.tpl"}
{/if}

{include file="common/footer.tpl"}


