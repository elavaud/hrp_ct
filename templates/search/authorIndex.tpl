{**
 * authorIndex.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Index of published articles by author.
 *
 * $Id$
 *}
{strip}
{assign var="pageTitle" value="search.investigators"}
{include file="common/header.tpl"}
{/strip}

<p>{foreach from=$alphaList item=letter}<a href="{url op="authors" searchInitial=$letter}">{if $letter == $searchInitial}<strong>{$letter|escape}</strong>{else}{$letter|escape}{/if}</a> {/foreach}<a href="{url op="authors"}">{if $searchInitial==''}<strong>{translate key="common.all"}</strong>{else}{translate key="common.all"}{/if}</a></p>

<div id="authors">
    <table width="100%" class="listing">
        <tr class="heading" valign="bottom">
            <td width="20%">{translate key="common.name"}</td>
            <td width="20%">{translate key="user.affiliation"}</td>
            <td width="60%">{translate key="proposal.researchField"}</td>
	</tr>
	<tr><td colspan="3" class="headseparator">&nbsp;</td></tr>

    
        {iterate from=authors item=author}
            <tr valign="top">
                {assign var=lastAuthorName value=$authorName}

                {assign var=authorAffiliation value=$author->getAllAffiliations()}
                {assign var=authorResearchFields value=$author->getAllResearchFieldsText()}

                {assign var=authorFirstName value=$author->getFirstName()}
                {assign var=authorMiddleName value=$author->getMiddleName()}
                {assign var=authorLastName value=$author->getLastName()}
                {assign var=authorName value="$authorLastName, $authorFirstName"}

                {if $authorMiddleName != ''}{assign var=authorName value="$authorName $authorMiddleName"}{/if}
                {strip}
                    <td><a href="{url op="authors" path="view"|to_array:$author->getId()}">{$authorName|escape}</a></td>
                    <td>{if $authorAffiliation}{$authorAffiliation|escape}{else}&mdash;{/if}</td>
                    <td>{if $authorResearchFields}{$authorResearchFields|escape}{else}&mdash;{/if}</td>
                {/strip}
            </tr>
            <tr><td colspan="3" class="{if $authors->eof()}end{/if}separator">&nbsp;</td></tr>
        {/iterate}
        {if $authors->wasEmpty()}
            <tr><td colspan="3" class="nodata">{translate key="submissions.noSubmissions"}</td></tr>
            <tr><td colspan="3" class="endseparator">&nbsp;</td></tr>
        {else}
	<tr>
            <td colspan="2" align="left">{page_info iterator=$authors}</td>
            <td align="right">{page_links anchor="authors" name="authors" iterator=$authors searchInitial=$searchInitial}</td>
	</tr>
        {/if}
    </table>
</div>
{include file="common/footer.tpl"}

