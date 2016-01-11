{**
 * management.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Subtemplate defining the submission management table.
 *
 * $Id$
 *}
 
<div id="submission">
    <h3>{translate key="article.submission"}</h3>
        
    <table width="100%" class="data">
        <tr>
            <td width="20%" class="label">{translate key="common.proposalId"}</td>
            <td width="80%" class="data"><ul><li>{$proposalId|escape}</li></ul></td>
        </tr>
        <tr>
            <td width="20%" class="label">{translate key="article.title"}</td>
            <td width="80%" class="data"><ul><li>{$scientificTitle|escape}</li></ul></td>
        </tr>
        <tr>
            <td class="label">{translate key="submission.submitter"}</td>
            <td colspan="2" class="value">
                <ul><li>
                {assign var=emailString value=$submitter->getFullName()|concat:" <":$submitter->getEmail():">"}
                {url|assign:"url" page="user" op="email" to=$emailString|to_array redirectUrl=$currentUrl subject=$scientificTitle|strip_tags articleId=$articleId}
                {$submitter->getFullName()|escape} {icon name="mail" url=$url}
                </li></ul>
            </td>
        </tr>
        <tr>
            <td class="label">{translate key="common.dateSubmitted"}</td>
            <td><ul><li>{$dateSubmitted|date_format:$datetimeFormatLong}</li></ul></td>
        </tr>
        {if $commentsToEditor}
            <tr valign="top">
                <td width="20%" class="label">{translate key="article.commentsToEditor"}</td>
                <td width="80%" colspan="2" class="data"><ul><li>{$commentsToEditor|strip_unsafe_html|nl2br}</li></ul></td>
            </tr>
        {/if}
        {if $proposalStatus == PROPOSAL_STATUS_WITHDRAWN}
            <tr id="withdrawnReasons">
                <td class="label">&nbsp;</td>
                <td class="value"><ul><li>{translate key="common.reason"}: 
                    {if $withdrawReason == "0"}
                        {translate key="submission.withdrawLack"}
                    {elseif $withdrawReason == "1"}
                        {translate key="submission.withdrawAdverse"}
                    {else}
                        {$withdrawReason}
                    {/if}
                </li></ul></td>
            </tr>
            {if $withdrawComments}
                <tr id="withdrawComments">
                    <td class="label">&nbsp;</td>
                    <td class="value"><ul><li>{translate key="common.comments"}: {$withdrawComments}</li></ul></td>
                </tr>
            {/if}
        {/if}
    </table>
</div>

