{**
 * submissionForFullReview.tpl
 * $Id$
 *}

{strip}
    {assign var="articleId" value=$submission->getArticleId()}
    {assign var="proposalId" value=$submission->getProposalId()}
    {translate|assign:"pageTitleTranslated" key="submission.page.proposalFromMeeting" id=$proposalId}
    {assign var="pageCrumbTitle" value="article.submission"}
    {include file="common/header.tpl"}
{/strip}
<ul class="menu">
    <li><a href="{url journal=$journalPath page="reviewer" path="active"}">{translate key="common.queue.short.reviewAssignments"}</a></li>
    <li class="current"><a href="{url op="meetings"}">{translate key="reviewer.meetings"}</a></li>
</ul>
<ul class="menu">
    <li><a href="{url op="meetings"}">{translate key="common.queue.long.meetingList"}</a></li>
    {if $isReviewer}
        <li class="current"><a href="{url op="proposalsFromMeetings"}">{translate key="common.queue.long.meetingProposals"}</a></li>
    {/if}
</ul>

<div class="separator"></div>

<div id="submissionToBeReviewed">
    <h3>{translate key="reviewer.article.submissionToBeReviewed"}</h3>
    <table width="100%" class="data">
        <tr valign="top">
            <td width="30%" class="label">{translate key="common.proposalId"}</td>
            <td width="70%" class="value">{$proposalId|strip_unsafe_html}</td>
        </tr>
        <tr valign="top">
            <td width="30%" class="label">{translate key="article.title"}</td>
            <td width="70%" class="value">title</td>
        </tr>
    </table>
</div>

<div class="separator"></div>

<div id="files">
    <h3>{translate key="common.file.s"}</h3>
    <table width="100%" class="data">
        <tr valign="top">
            <td width="30%" class="label">{translate key="submission.submissionManuscript"}</td>
            <td class="value" width="70%">
                {if $submissionFile}
                    <a href="{url op="downloadProposalFromMeetingFile" path=$submission->getArticleId()|to_array:$submissionFile->getFileId()}" class="file">{$submissionFile->getFileName()|escape}</a>
                    &nbsp;&nbsp;{$submissionFile->getDateModified()|date_format:$dateFormatLong}
                {else}
                    {translate key="common.none"}
                {/if}
            </td>
        </tr>
        {if count($previousFiles)>1}
            {assign var="count" value=0}
            <tr>
                <td class="label">{translate key="submission.previousProposalFile"}</td>
                <td width="70%" class="value">
                    {foreach name="previousFiles" from=$previousFiles item=previousFile}
                        {assign var="count" value=$count+1}
                        {if $count > 1}
                            <a href="{url op="downloadProposalFromMeetingFile" path=$submission->getArticleId()|to_array:$previousFile->getFileId()}" class="file">{$previousFile->getFileName()|escape}</a><br />
                        {/if}
                    {/foreach}
                </td>
            </tr>
        {/if}
        <tr valign="top">
            <td class="label">{translate key="article.suppFiles"}</td>
            <td class="value">
                {assign var=sawSuppFile value=0}
                {foreach from=$suppFiles item=suppFile}
                    {if $suppFile->getShowReviewers() }
                        {assign var=sawSuppFile value=1}
                        <a href="{url op="downloadProposalFromMeetingFile" path=$submission->getArticleId()|to_array:$suppFile->getFileId()}" class="file">{$suppFile->getFileName()|escape}</a><cite>&nbsp;&nbsp;({$suppFile->getType()})</cite><br />
                    {/if}
                {/foreach}
                {if !$sawSuppFile}
                    {translate key="common.none"}
                {/if}
            </td>
        </tr>
        <tr>
            <td class="label" title="{translate key="article.reports.instruct"}">[?] {translate key="article.reports"}</td>
            <td width="80%" class="value">
                {foreach name="reportFiles" from=$reportFiles item=reportFile}
                    <a href="{url op="downloadProposalFromMeetingFile"  path=$submission->getArticleId()|to_array:$reportFile->getFileId()}" class="file">{$reportFile->getFileName()|escape}</a>&nbsp;&nbsp;({$reportFile->getDateUploaded()|date_format:$datetimeFormatLong})
                    <br />
                {foreachelse}
                    {translate key="common.none"}
                {/foreach}
            </td>
        </tr>  
        <tr>
            <td class="label" title="{translate key="article.sae.instruct"}">[?] {translate key="article.sae"}</td>
            <td width="80%" class="value">
                {foreach name="saeFiles" from=$saeFiles item=saeFile}
                    <a href="{url op="downloadProposalFromMeetingFile"  path=$submission->getArticleId()|to_array:$saeFile->getFileId()}" class="file">{$saeFile->getFileName()|escape}</a>&nbsp;&nbsp;({$saeFile->getDateUploaded()|date_format:$datetimeFormatLong})
                    <br />
                {foreachelse}
                    {translate key="common.none"}
                {/foreach}
            </td>
        </tr>                 
    </table>
</div>

<div class="separator"></div>

<div id="pastDecisions">
    <h3>{translate key="submission.decision.s"}</h3>
    {foreach from=$sectionDecisions item=decision}
        <table width="100%">
            <tr valign="middle">
                <td colspan="2"><h6>{$decision->getSectionAcronym()} - {translate key=$decision->getReviewTypeKey()} - {$decision->getRound()}</h6></td>
            </tr>
            <tr>
                <td width="30%" class="label">{translate key="submission.decision"}</td>
                <td width="70%" class="value">{translate key=$decision->getReviewStatusKey()}</td>
            </tr>
            <tr>
                <td class="label">{translate key="common.queue.long.viewMeeting"}</td>
                <td class="value">
                    {assign var="meetings" value=$decision->getMeetings()}
                    {foreach from=$meetings item=meeting}
                        <a href="{url op="viewMeeting" path=$meeting->getId()}" class="action">{$meeting->getPublicId()|escape}</a><br/>
                    {/foreach}
                </td>
            </tr>
        </table>    
    {/foreach}
    
</div>

<div class="separator"></div>

{include file="common/footer.tpl"}