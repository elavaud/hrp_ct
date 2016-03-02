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
                {assign var="articleSiteSiteB" value='articleSites['|cat:$i|cat:'][siteSelect]'}
                {assign var="articleSiteSiteD" value='articleSites-'|cat:$i|cat:'-siteSelect'}   
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
                            {html_options options=$sitesList selected=$articleSites.$i.siteSelect}                                
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
            <table width="100%" class="data">
                {assign var="articleSiteAuthorityB" value='articleSites['|cat:$i|cat:'][authority]'}
                {assign var="articleSiteAuthorityD" value='articleSites-'|cat:$i|cat:'-authority'}    
                {assign var="articleSiteERCB" value='articleSites['|cat:$i|cat:'][erc]'}
                {assign var="articleSiteERCD" value='articleSites-'|cat:$i|cat:'-erc'}    
                {assign var="articleSitePrimaryPhoneB" value='articleSites['|cat:$i|cat:'][primaryPhone]'}
                {assign var="articleSitePrimaryPhoneD" value='articleSites-'|cat:$i|cat:'-primaryPhone'}    
                {assign var="articleSiteSecondaryPhoneB" value='articleSites['|cat:$i|cat:'][secondaryPhone]'}
                {assign var="articleSiteSecondaryPhoneD" value='articleSites-'|cat:$i|cat:'-secondaryPhone'}    
                {assign var="articleSiteFaxB" value='articleSites['|cat:$i|cat:'][fax]'}
                {assign var="articleSiteFaxD" value='articleSites-'|cat:$i|cat:'-fax'}    
                {assign var="articleSiteEmailB" value='articleSites['|cat:$i|cat:'][email]'}
                {assign var="articleSiteEmailD" value='articleSites-'|cat:$i|cat:'-email'}    
                {assign var="articleSiteSubjectsNumberB" value='articleSites['|cat:$i|cat:'][subjectsNumber]'}
                {assign var="articleSiteSubjectsNumberD" value='articleSites-'|cat:$i|cat:'-subjectsNumber'}    
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteAuthorityD required="true" key="proposal.articleSite.authority"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleSiteAuthorityB|escape}" id="{$articleSiteAuthorityD|escape}" value="{$articleSites.$i.authority|escape}" size="40" maxlength="255" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.authority.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteERCD required="true" key="proposal.articleSite.erc"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleSiteERCB|escape}" id="{$articleSiteERCD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$ercList|truncate:80:"..." selected=$articleSites.$i.erc}                                
                        </select>
                    </td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.erc.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSitePrimaryPhoneD required="true" key="proposal.articleSite.primaryPhone"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleSitePrimaryPhoneB|escape}" id="{$articleSitePrimaryPhoneD|escape}" value="{$articleSites.$i.primaryPhone|escape}" size="40" maxlength="24" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.primaryPhone.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteSecondaryPhoneD key="proposal.articleSite.secondaryPhone"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleSiteSecondaryPhoneB|escape}" id="{$articleSiteSecondaryPhoneD|escape}" value="{$articleSites.$i.secondaryPhone|escape}" size="40" maxlength="24" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.secondaryPhone.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteFaxD key="proposal.articleSite.fax"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleSiteFaxB|escape}" id="{$articleSiteFaxD|escape}" value="{$articleSites.$i.fax|escape}" size="40" maxlength="24" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.fax.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteEmailD required="true" key="proposal.articleSite.email"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleSiteEmailB|escape}" id="{$articleSiteEmailD|escape}" value="{$articleSites.$i.email|escape}" size="40" maxlength="90" /></td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.email.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteSubjectsNumberD required="true" key="proposal.articleSite.subjectsNumber"}</td>
                    <td width="80%" class="value">
                        <input type="text" class="numField" name="{$articleSiteSubjectsNumberB|escape}" id="{$articleSiteSubjectsNumberD|escape}" value="{$articleSites.$i.subjectsNumber|escape}" size="20" maxlength="20" />
                        &nbsp;<i>{translate key="proposal.age.int"}</i>
                    </td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.articleSite.subjectsNumber.instruct"}</i></td>
                    </tr>    
                {/if}
            </table>
            {foreach from=$articleSites.$i.investigators key=k item=investigator} 
                {assign var="articleSiteInvestigatorTitleD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k}   
                {assign var="articleSiteInvestigatorFirstNameB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][firstName]'}
                {assign var="articleSiteInvestigatorFirstNameD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-firstName'}     
                {assign var="articleSiteInvestigatorLastNameB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][lastName]'}
                {assign var="articleSiteInvestigatorLastNameD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-lastName'}     
                {assign var="articleSiteInvestigatorExpertiseB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][expertise]'}
                {assign var="articleSiteInvestigatorExpertiseD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-expertise'}                     
                {assign var="articleSiteInvestigatorPrimaryPhoneB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][iPrimaryPhone]'}
                {assign var="articleSiteInvestigatorPrimaryPhoneD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-iPrimaryPhone'}                     
                {assign var="articleSiteInvestigatorSecondaryPhoneB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][iSecondaryPhone]'}
                {assign var="articleSiteInvestigatorSecondaryPhoneD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-iSecondaryPhone'}     
                {assign var="articleSiteInvestigatorFaxB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][iFax]'}
                {assign var="articleSiteInvestigatorFaxD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-iFax'}     
                {assign var="articleSiteInvestigatorEmailB" value='articleSites['|cat:$i|cat:'][investigators]['|cat:$k|cat:'][iEmail]'}
                {assign var="articleSiteInvestigatorEmailD" value='articleSites-'|cat:$i|cat:'-investigators-'|cat:$k|cat:'-iEmail'}     
                {assign var="articleSiteInvestigatorClassSuppD" value='investigatorSupp-'|cat:$i}                      
                <table width="100%" id="{$articleSiteInvestigatorTitleD|escape}" {if $k > 0}class="{$articleSiteInvestigatorClassSuppD|escape}"{/if}>
                    {if $articleSites.$i.investigators.$k.id}<input type="hidden" class="hiddenInputs" name="articleSites[{$i|escape}][investigators][{$k|escape}][id]" value="{$articleSites.$i.investigators.$k.id|escape}" />{/if}
                    <tr valign="top">
                        <td width="20%" class="investigatorTitle" {if $k > 0}style="display: none;"{/if}>{if $i==0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleSiteInvestigatorTitleD required="true" key="proposal.articleSite.investigators"}</td>
                        <td width="20%" class="noInvestigatorTitle" {if $k == 0}style="display: none;"{/if}>&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorFirstNameD required="true" key="proposal.articleSite.investigator.firstName"}</td>                        
                        <td width="70%" class="value">
                            <input type="text" class="textField" name="{$articleSiteInvestigatorFirstNameB|escape}" id="{$articleSiteInvestigatorFirstNameD|escape}" value="{$articleSites.$i.investigators.$k.firstName|escape}" size="30" maxlength="255" />
                            <a class="removeInvestigator" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                        </td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorLastNameD required="true" key="proposal.articleSite.investigator.lastName"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleSiteInvestigatorLastNameB|escape}" id="{$articleSiteInvestigatorLastNameD|escape}" value="{$articleSites.$i.investigators.$k.lastName|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorExpertiseD required="true" key="proposal.articleSite.investigator.expertise"}</td>                        
                        <td width="70%" class="value">
                            <select name="{$articleSiteInvestigatorExpertiseB|escape}" id="{$articleSiteInvestigatorExpertiseD|escape}" class="selectMenu">
                                <option value=""></option>
                                {html_options options=$expertisesList selected=$articleSites.$i.investigators.$k.expertise}                                
                            </select>
                        </td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorPrimaryPhoneD required="true" key="proposal.articleSite.investigator.iPrimaryPhone"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleSiteInvestigatorPrimaryPhoneB|escape}" id="{$articleSiteInvestigatorPrimaryPhoneD|escape}" value="{$articleSites.$i.investigators.$k.iPrimaryPhone|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorSecondaryPhoneD key="proposal.articleSite.investigator.iSecondaryPhone"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleSiteInvestigatorSecondaryPhoneB|escape}" id="{$articleSiteInvestigatorSecondaryPhoneD|escape}" value="{$articleSites.$i.investigators.$k.iSecondaryPhone|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorFaxD key="proposal.articleSite.investigator.iFax"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleSiteInvestigatorFaxB|escape}" id="{$articleSiteInvestigatorFaxD|escape}" value="{$articleSites.$i.investigators.$k.iFax|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleSiteInvestigatorEmailD required="true" key="proposal.articleSite.investigator.iEmail"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleSiteInvestigatorEmailB|escape}" id="{$articleSiteInvestigatorEmailD|escape}" value="{$articleSites.$i.investigators.$k.iEmail|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleSite.investigators.instruct"}</i></td>
                    </tr>    
                    {/if}
                    <tr><td colspan="3">&nbsp;</td></tr>
                </table>
            {/foreach}
            <table width="100%" class="data">
                {assign var="articleSiteAddInvestigatorD" value='articleSites-'|cat:$i|cat:'-addInvestigator'}                
                <tr valign="top">
                    <td width="20%">&nbsp;</td>
                    <td width="80%" class="value"><a class="addAnotherInvestigatorClick" id="{$articleSiteAddInvestigatorD|escape}" style="cursor: pointer;">{translate key="proposal.articleSite.investigator.add"}</a></td>
                </tr>
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