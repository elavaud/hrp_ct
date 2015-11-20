{**
 * step4.tpl
 *
 * Step 4 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step4"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

<div class="separator"></div>

<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}
      
    {foreach from=$articleSites key=i item=articleSite}
        {assign var="articleSiteDivId" value='articleSites-'|cat:$i}  
        {assign var="articleSiteTitleId" value='articleSites-'|cat:$i|cat:'-title'}          
        <div id="{$articleSiteDivId|escape}" {if $i != 0}class="siteSupp"{/if}>
            <table width="100%">
                <tr>
                    <td width="50%"><h2>{translate key="proposal.articleSite"} #<span id="{$articleSiteTitleId|escape}">{$i+1|escape}</span></h2></td>
                    <td width="50%"><input type="button"  class="removeSite" value="{translate key="proposal.articleSite.remove"}" style="{if $i == 0}display: none; {/if}" /></td>
                </tr>
            </table>
            {if $articleSites.$i.id}<input type="hidden" class="hiddenInputs" name="articleSites[{$i|escape}][id]" value="{$articleSites.$i.id|escape}" />{/if}
            <table width="100%" class="data">
                {assign var="articleSiteSiteB" value='articleSites['|cat:$i|cat:'][site]'}
                {assign var="articleSiteSiteD" value='articleSites-'|cat:$i|cat:'-site'}   
                {assign var="articleSiteSiteNameB" value='articleSites['|cat:$i|cat:'][siteName]'}
                {assign var="articleSiteSiteNameD" value='articleSites-'|cat:$i|cat:'-siteName'}                   
                {assign var="articleSiteSiteNameFieldD" value='articleSites-'|cat:$i|cat:'-siteNameField'}                   
                {assign var="articleSiteSiteAddressB" value='articleSites['|cat:$i|cat:'][siteAddress]'}
                {assign var="articleSiteSiteAddressD" value='articleSites-'|cat:$i|cat:'-siteAddress'}                                   
                {assign var="articleSiteSiteAddressFieldD" value='articleSites-'|cat:$i|cat:'-siteAddressField'}                                   
                {assign var="articleSiteSiteCityB" value='articleSites['|cat:$i|cat:'][siteCity]'}
                {assign var="articleSiteSiteCityD" value='articleSites-'|cat:$i|cat:'-siteCity'}                                   
                {assign var="articleSiteSiteCityFieldD" value='articleSites-'|cat:$i|cat:'-siteCityField'}                                   
                {assign var="articleSiteSiteRegionB" value='articleSites['|cat:$i|cat:'][siteRegion]'}
                {assign var="articleSiteSiteRegionD" value='articleSites-'|cat:$i|cat:'-siteRegion'}   
                {assign var="articleSiteSiteRegionFieldD" value='articleSites-'|cat:$i|cat:'-siteRegionField'}   
                {assign var="articleSiteSiteLicensureB" value='articleSites['|cat:$i|cat:'][siteLicensure]'}
                {assign var="articleSiteSiteLicensureD" value='articleSites-'|cat:$i|cat:'-siteLicensure'}   
                {assign var="articleSiteSiteLicensureFieldD" value='articleSites-'|cat:$i|cat:'-siteLicensureField'}   
                {assign var="articleSiteSiteAccreditationB" value='articleSites['|cat:$i|cat:'][siteAccreditation]'}
                {assign var="articleSiteSiteAccreditationD" value='articleSites-'|cat:$i|cat:'-siteAccreditation'}   
                {assign var="articleSiteSiteAccreditationFieldD" value='articleSites-'|cat:$i|cat:'-siteAccreditationField'}                   
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteSiteD required="true" key="proposal.articleSite.site"}</td>
                    <td width="80%" colspan=2" class="value">
                        <select name="{$articleSiteSiteB|escape}" id="{$articleSiteSiteD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$sitesList selected=$articleSites.$i.site}                                
                        </select>
                    </td>                     
                </tr>
                <tr valign="top" id="{$articleSiteSiteNameFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteNameD required="true" key="proposal.articleSite.siteName"}</td>
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleSiteSiteNameB|escape}" id="{$articleSiteSiteNameD|escape}" value="{$articleSites.$i.siteName|escape}" size="40" maxlength="255" /></td>
                </tr>
                <tr valign="top" id="{$articleSiteSiteAddressFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteAddressD required="true" key="proposal.articleSite.siteAddress"}</td>
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleSiteSiteAddressB|escape}" id="{$articleSiteSiteAddressD|escape}" value="{$articleSites.$i.siteAddress|escape}" size="40" maxlength="255" /></td>
                </tr>
                <tr valign="top" id="{$articleSiteSiteCityFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteCityD required="true" key="proposal.articleSite.siteCity"}</td>
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleSiteSiteCityB|escape}" id="{$articleSiteSiteCityD|escape}" value="{$articleSites.$i.siteCity|escape}" size="40" maxlength="255" /></td>
                </tr>
                <tr valign="top" id="{$articleSiteSiteRegionFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteRegionD required="true" key="proposal.articleSite.siteRegion"}</td>
                    <td width="60%" class="value">
                        <select name="{$articleSiteSiteRegionB|escape}" id="{$articleSiteSiteRegionD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$geoAreas selected=$articleSites.$i.siteRegion}                                
                        </select>
                    </td>                     
                </tr>
                <tr valign="top" id="{$articleSiteSiteLicensureFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteLicensureD required="true" key="proposal.articleSite.siteLicensure"}</td>
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleSiteSiteLicensureB|escape}" id="{$articleSiteSiteLicensureD|escape}" value="{$articleSites.$i.siteLicensure|escape}" size="40" maxlength="255" /></td>
                </tr>
                <tr valign="top" id="{$articleSiteSiteAccreditationFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleSiteSiteAccreditationD required="true" key="proposal.articleSite.siteAccreditation"}</td>
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleSiteSiteAccreditationB|escape}" id="{$articleSiteSiteAccreditationD|escape}" value="{$articleSites.$i.siteAccreditation|escape}" size="40" maxlength="255" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" colspan=2" class="value"><i>[?] {translate key="proposal.articleSite.site.instruct"}</i></td>
                    </tr>    
                {/if}    
            </table>
        </div>
    {/foreach}
    
    <p>
        <input type="button" value="{translate key="proposal.articleSite.add"}" class="button" id="addSiteClick" />        
        <input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> 
        <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" />
    </p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep4.tpl"}