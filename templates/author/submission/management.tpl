{**
 * management.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Subtemplate defining the author's submission management table.
 *
 * $Id$
 *}

<div id="submission">
    <h3>{translate key="article.submission"}</h3>

    {* When editing this page, edit templates/sectionEditor/submission/management.tpl as well *}

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
    </table>
</div>

