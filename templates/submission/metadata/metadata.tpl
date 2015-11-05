{**
 * metadata.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Subtemplate defining the submission metadata table. Non-form implementation.
 *}

{assign var="status" value=$submission->getSubmissionStatus()}
{assign var="decision" value=$submission->getMostRecentDecisionValue()}

{if $canEditMetadata && $isSectionEditor && $status!=PROPOSAL_STATUS_COMPLETED && $status!=PROPOSAL_STATUS_ARCHIVED && $decision!=SUBMISSION_SECTION_DECISION_EXEMPTED && $decision!=SUBMISSION_SECTION_DECISION_APPROVED}
	<p><a href="{url op="viewMetadata" path=$submission->getId()}" class="action">{translate key="submission.editMetadata"}</a></p>
	{call_hook name="Templates::Submission::Metadata::Metadata::AdditionalEditItems"}
{/if}
{if $isSectionEditor}
<p style="text-align:right"><a href="{url op="downloadSummary" path=$submission->getId()}" class="file"><b>{translate key="common.download"} {translate key="submission.summary"}</b></a></p>
{/if}
<div id="authors">
<h4>{translate key="article.authors"}</h4>
	
<table width="100%" class="data">
	{foreach name=authors from=$submission->getAuthors() item=author}
	<tr valign="top">
		<td {if $author->getPrimaryContact()}title="{translate key="user.role.primaryInvestigatorInstruct"}"{else}title="{translate key="user.role.coinvestigatorInstruct"}"{/if}width="30%" class="label">{if $author->getPrimaryContact()}[?] {translate key="user.role.primaryInvestigator"}{else}[?] {translate key="user.role.coinvestigator"}{/if}</td>
		<td width="70%" class="value">
			{assign var=emailString value=$author->getFullName()|concat:" <":$author->getEmail():">"}
			{url|assign:"url" page="user" op="email" redirectUrl=$currentUrl to=$emailString|to_array subject=""|strip_tags articleId=$submission->getId()}
			{$author->getFullName()|escape} {icon name="mail" url=$url}<br />
			{$author->getEmail()|escape}<br />
			{if ($author->getAffiliation()) != ""}{$author->getAffiliation()|escape}<br />{/if}
			{if ($author->getPhoneNumber()) != ""}{$author->getPhoneNumber()}
			{/if}
		</td>
	</tr>

        
	{if !$smarty.foreach.authors.last}
		<tr>
			<td colspan="2" class="separator">&nbsp;</td>
		</tr>
	{/if}
	{/foreach}
</table>
</div>