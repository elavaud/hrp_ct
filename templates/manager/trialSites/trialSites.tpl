{**
 * trialSites.tpl
 *
 * Display list of trial sites in journal management.
 *
 *}

 {strip}
    {assign var="pageTitle" value="trialSite.trialSites"}
    {include file="common/header.tpl"}
{/strip}

<br/>

<div id="trialSite">
    <table width="100%" class="listing" id="dragTable">
	<tr>
            <td class="headseparator" colspan="5">&nbsp;</td>
	</tr>
	<tr class="heading" valign="bottom">
            <td width="35%">{sort_heading key="trialSite.name" sort="name"}</td>
            <td width="15%">{sort_heading key="trialSite.city" sort="city"}</td>
            <td width="15%">{sort_heading key="trialSite.region" sort="region"}</td>
            <td width="15%" align="right">{translate key="common.action"}</td>
	</tr>
	<tr>
            <td class="headseparator" colspan="4">&nbsp;</td>
	</tr>
        {iterate from=trialSites item=trialSite name=trialSites}
            <tr valign="top" class="data">
                <td class="drag">{$trialSite->getName()}</td>
                <td class="drag">{$trialSite->getCity()}</td>
                <td class="drag">{$trialSite->getRegionText()}</td>
                <td align="right" class="nowrap">
                    <a href="{url op='editTrialSite' path=$trialSite->getId()}" class="action">{translate key="common.edit"}</a>
                    &nbsp;|&nbsp;
                    <a href="{url op='deleteTrialSiteForm' path=$trialSite->getId()}" class="action">{translate key="common.delete"}</a>
                    &nbsp;
                </td>
            </tr>
        {/iterate}
	<tr>
            <td colspan="4" class="endseparator">&nbsp;</td>
	</tr>
        {if $trialSites->wasEmpty()}
            <tr>
                <td colspan="4" class="nodata">{translate key="manager.trialSites.noneCreated"}</td>
            </tr>
            <tr>
                <td colspan="4" class="endseparator">&nbsp;</td>
            </tr>
        {else}
            <tr>
                <td align="left">{page_info iterator=$trialSites}</td>
                <td colspan="4" align="right">{page_links anchor="trialSites" name="trialSites" iterator=$trialSites sort=$sort sortDirection=$sortDirection}</td>
            </tr>
        {/if}
    </table>
    <a class="action" href="{url op="createTrialSite"}">{translate key="manager.trialSites.create"}</a>
</div>

{include file="common/footer.tpl"}