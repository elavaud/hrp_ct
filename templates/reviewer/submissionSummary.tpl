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

<div id="Authors">
	<h4>{translate key="article.authors"}</h4>
	<table class="listing" width="100%">
		{foreach name=authors from=$submission->getAuthors() item=author}
			<tr valign="top">
				<td width="20%" class="label">{if $author->getPrimaryContact()}{translate key="user.role.primaryInvestigator"}{else}{translate key="user.role.coinvestigator"}{/if}</td>
        		<td class="value">
					{$author->getFullName()|escape}<br />
					{$author->getEmail()|escape}<br />
					{if ($author->getAffiliation()) != ""}{$author->getAffiliation()|escape}<br/>{/if}
					{if ($author->getPrimaryPhoneNumber()) != ""}{$author->getPrimaryPhoneNumber()|escape}<br/>{/if}
        		</td>
    		</tr>
		{/foreach}
	</table>
	<div class="separator"></div>
</div>

<div class="separator"></div>


