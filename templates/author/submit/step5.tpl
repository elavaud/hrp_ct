{**
 * step5.tpl
 *
 * Step 5 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step5"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

<div class="separator"></div>

<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}
    
    {foreach from=$fundingSources key=k item=fundingSource} 
        {assign var="fundingSourcesTitleD" value='fundingSources-'|cat:$k}   
        {assign var="fundingSourcesSelectB" value='fundingSources['|cat:$k|cat:'][institutionId]'}
        {assign var="fundingSourcesSelectD" value='fundingSources-'|cat:$k|cat:'-institutionId'}             
        {assign var="fundingSourcesNameB" value='fundingSources['|cat:$k|cat:'][name]'}
        {assign var="fundingSourcesNameD" value='fundingSources-'|cat:$k|cat:'-name'}     
        {assign var="fundingSourcesNameFieldD" value='fundingSources-'|cat:$k|cat:'-nameField'}     
        {assign var="fundingSourcesAcronymB" value='fundingSources['|cat:$k|cat:'][acronym]'}
        {assign var="fundingSourcesAcronymD" value='fundingSources-'|cat:$k|cat:'-acronym'}  
        {assign var="fundingSourcesAcronymFieldD" value='fundingSources-'|cat:$k|cat:'-acronymField'}     
        {assign var="fundingSourcesTypeB" value='fundingSources['|cat:$k|cat:'][type]'}
        {assign var="fundingSourcesTypeD" value='fundingSources-'|cat:$k|cat:'-type'} 
        {assign var="fundingSourcesTypeFieldD" value='fundingSources-'|cat:$k|cat:'-typeField'}                     
        {assign var="fundingSourcesLocationB" value='fundingSources['|cat:$k|cat:'][location]'}
        {assign var="fundingSourcesLocationD" value='fundingSources-'|cat:$k|cat:'-location'}     
        {assign var="fundingSourcesLocationFieldD" value='fundingSources-'|cat:$k|cat:'-locationField'}     
        {assign var="fundingSourcesLocationCountryB" value='fundingSources['|cat:$k|cat:'][locationCountry]'}
        {assign var="fundingSourcesLocationCountryD" value='fundingSources-'|cat:$k|cat:'-locationCountry'}  
        {assign var="fundingSourcesLocationCountryFieldD" value='fundingSources-'|cat:$k|cat:'-locationCountryField'}     
        {assign var="fundingSourcesLocationInternationalB" value='fundingSources['|cat:$k|cat:'][locationInternational]'}
        {assign var="fundingSourcesLocationInternationalD" value='fundingSources-'|cat:$k|cat:'-locationInternational'}  
        {assign var="fundingSourcesLocationInternationalFieldD" value='fundingSources-'|cat:$k|cat:'-locationInternationalField'}          
        <table width="100%" id="{$fundingSourcesTitleD|escape}" {if $k > 0}class="sourceSupp"{/if}>
            {if $fundingSources.$k.id}<input type="hidden" class="hiddenInputs" name="fundingSources[{$k|escape}][id]" value="{$fundingSources.$k.id|escape}" />{/if}
            <tr valign="top">
                <td width="20%" class="sourceTitle" {if $k > 0}style="display: none;"{/if}><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name=$fundingSourcesTitleD required="true" key="proposal.articleSponsor.fundingSources"}</td>
                <td width="20%" class="noSourceTitle" {if $k == 0}style="display: none;"{/if}>&nbsp;</td>                        
                <td width="80%" colspan="2" class="value">
                    <select name="{$fundingSourcesSelectB|escape}" id="{$fundingSourcesSelectD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$institutionsList selected=$fundingSources.$k.institutionId}                                
                    </select>
                    <a class="removeFundingSource" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                </td>                                           
            </tr>
            <tr valign="top" id="{$fundingSourcesNameFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesNameD required="true" key="proposal.articleSponsor.name"}</td>                        
                <td width="70%" class="value"><input type="text" class="textField" name="{$fundingSourcesNameB|escape}" id="{$fundingSourcesNameD|escape}" value="{$fundingSources.$k.name|escape}" size="30" maxlength="255" /></td>                                           
            </tr>
            <tr valign="top" id="{$fundingSourcesAcronymFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesAcronymD required="true" key="proposal.articleSponsor.acronym"}</td>                        
                <td width="70%" class="value"><input type="text" class="textField" name="{$fundingSourcesAcronymB|escape}" id="{$fundingSourcesAcronymD|escape}" value="{$fundingSources.$k.acronym|escape}" size="30" maxlength="255" /></td>                                           
            </tr>
            <tr valign="top" id="{$fundingSourcesTypeFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesTypeD required="true" key="proposal.articleSponsor.type"}</td>                        
                <td width="70%" class="value">
                    <select name="{$fundingSourcesTypeB|escape}" id="{$fundingSourcesTypeD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$institutionTypesList selected=$fundingSources.$k.type}                                
                    </select>
                </td>                                           
            </tr>            
            <tr valign="top" id="{$fundingSourcesLocationFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesLocationD required="true" key="proposal.articleSponsor.location"}</td>                        
                <td width="70%" class="value">
                    {html_radios name=$fundingSourcesLocationB options=$internationalArray selected=$fundingSources.$k.location separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                </td>                                           
            </tr>
            <tr valign="top" id="{$fundingSourcesLocationCountryFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesLocationCountryD required="true" key="proposal.articleSponsor.locationCountry"}</td>                        
                <td width="70%" class="value">
                    <select name="{$fundingSourcesLocationCountryB|escape}" id="{$fundingSourcesLocationCountryD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$geoAreasList selected=$fundingSources.$k.locationCountry}                                
                    </select>
                </td>                                           
            </tr>
            <tr valign="top" id="{$fundingSourcesLocationInternationalFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$fundingSourcesLocationInternationalD required="true" key="proposal.articleSponsor.locationInternational"}</td>                        
                <td width="70%" class="value">
                    <select name="{$fundingSourcesLocationInternationalB|escape}" id="{$fundingSourcesLocationInternationalD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$coutryList selected=$fundingSources.$k.locationInternational}                                
                    </select>                
                </td>                                           
            </tr>
            {if $k == 0}
            <tr valign="top" hidden class="showHideHelpField">
                <td width="20%">&nbsp;</td>
                <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleSponsor.fundingSources.instruct"}</i></td>
            </tr>    
            {/if}
            <tr><td colspan="3">&nbsp;</td></tr>
        </table>
    {/foreach}
    <table width="100%" class="data">
        <tr valign="top">
            <td width="20%">&nbsp;</td>
            <td width="80%" class="value"><a id="addFundingSourceClick" style="cursor: pointer;">{translate key="proposal.articleSponsor.fundingSources.add"}</a></td>
        </tr>
    </table>
    <br/>
    <table width="100%">
        {if $primarySponsor.id}<input type="hidden" class="hiddenInputs" name="primarySponsor[id]" value="{$primarySponsor.id|escape}" />{/if}
        <tr valign="top">
            <td width="20%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="primarySponsor-institutionId" required="true" key="proposal.articleSponsor.primarySponsor"}</td>
            <td width="80%" colspan="2" class="value">
                <select name="primarySponsor[institutionId]" id="primarySponsor-institutionId" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$institutionsList selected=$primarySponsor.institutionId}                                
                </select>
            </td>                                           
        </tr>
        <tr valign="top" id="primarySponsorNameField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-name" required="true" key="proposal.articleSponsor.name"}</td>                        
            <td width="70%" class="value"><input type="text" class="textField" name="primarySponsor[name]" id="primarySponsor-name" value="{$primarySponsor.name|escape}" size="30" maxlength="255" /></td>                                           
        </tr>
        <tr valign="top" id="primarySponsorAcronymField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-acronym" required="true" key="proposal.articleSponsor.acronym"}</td>                        
            <td width="70%" class="value"><input type="text" class="textField" name="primarySponsor[acronym]" id="primarySponsor-acronym" value="{$primarySponsor.acronym|escape}" size="30" maxlength="255" /></td>                                           
        </tr>
        <tr valign="top" id="primarySponsorTypeField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-type" required="true" key="proposal.articleSponsor.type"}</td>                        
            <td width="70%" class="value">
                <select name="primarySponsor[type]" id="primarySponsor-type" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$institutionTypesList selected=$primarySponsor.type}                                
                </select>
            </td>                                           
        </tr>                  
        <tr valign="top" id="primarySponsorLocationField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-location" required="true" key="proposal.articleSponsor.location"}</td>                        
            <td width="70%" class="value">
                {html_radios name="primarySponsor[location]" options=$internationalArray selected=$primarySponsor.location separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
            </td>                                           
        </tr>
        <tr valign="top" id="primarySponsorLocationCountryField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-locationCountry" required="true" key="proposal.articleSponsor.locationCountry"}</td>                        
            <td width="70%" class="value">
                <select name="primarySponsor[locationCountry]" id="primarySponsor-locationCountry" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$geoAreasList selected=$primarySponsor.locationCountry}                                
                </select>
            </td>                                           
        </tr>
        <tr valign="top" id="primarySponsorLocationInternationalField">
            <td width="20%">&nbsp;</td>                        
            <td width="10%">{fieldLabel name="primarySponsor-locationInternational" required="true" key="proposal.articleSponsor.locationInternational"}</td>                        
            <td width="70%" class="value">
                <select name="primarySponsor[locationInternational]" id="primarySponsor-locationInternational" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$coutryList selected=$primarySponsor.locationInternational}                                
                </select>                
            </td>                                           
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%">&nbsp;</td>
            <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleSponsor.primarySponsor.instruct"}</i></td>
        </tr>    
        <tr><td colspan="3">&nbsp;</td></tr>
    </table>
    <br/>
    {foreach from=$secondarySponsors key=k item=secondarySponsor} 
        {assign var="secondarySponsorsTitleD" value='secondarySponsors-'|cat:$k}   
        {assign var="secondarySponsorsSelectB" value='secondarySponsors['|cat:$k|cat:'][ssInstitutionId]'}
        {assign var="secondarySponsorsSelectD" value='secondarySponsors-'|cat:$k|cat:'-ssInstitutionId'}             
        {assign var="secondarySponsorsNameB" value='secondarySponsors['|cat:$k|cat:'][ssName]'}
        {assign var="secondarySponsorsNameD" value='secondarySponsors-'|cat:$k|cat:'-ssName'}     
        {assign var="secondarySponsorsNameFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssNameField'}     
        {assign var="secondarySponsorsAcronymB" value='secondarySponsors['|cat:$k|cat:'][ssAcronym]'}
        {assign var="secondarySponsorsAcronymD" value='secondarySponsors-'|cat:$k|cat:'-ssAcronym'}  
        {assign var="secondarySponsorsAcronymFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssAcronymField'}     
        {assign var="secondarySponsorsTypeB" value='secondarySponsors['|cat:$k|cat:'][ssType]'}
        {assign var="secondarySponsorsTypeD" value='secondarySponsors-'|cat:$k|cat:'-ssType'} 
        {assign var="secondarySponsorsTypeFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssTypeField'}                     
        {assign var="secondarySponsorsLocationB" value='secondarySponsors['|cat:$k|cat:'][ssLocation]'}
        {assign var="secondarySponsorsLocationD" value='secondarySponsors-'|cat:$k|cat:'-ssLocation'}     
        {assign var="secondarySponsorsLocationFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssLocationField'}     
        {assign var="secondarySponsorsLocationCountryB" value='secondarySponsors['|cat:$k|cat:'][ssLocationCountry]'}
        {assign var="secondarySponsorsLocationCountryD" value='secondarySponsors-'|cat:$k|cat:'-ssLocationCountry'}  
        {assign var="secondarySponsorsLocationCountryFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssLocationCountryField'}     
        {assign var="secondarySponsorsLocationInternationalB" value='secondarySponsors['|cat:$k|cat:'][ssLocationInternational]'}
        {assign var="secondarySponsorsLocationInternationalD" value='secondarySponsors-'|cat:$k|cat:'-ssLocationInternational'}  
        {assign var="secondarySponsorsLocationInternationalFieldD" value='secondarySponsors-'|cat:$k|cat:'-ssLocationInternationalField'}          
        <table width="100%" id="{$secondarySponsorsTitleD|escape}" {if $k > 0}class="sSponsorSupp"{/if}>
            {if $secondarySponsors.$k.id}<input type="hidden" class="hiddenInputs" name="secondarySponsors[{$k|escape}][id]" value="{$secondarySponsors.$k.id|escape}" />{/if}
            <tr valign="top">
                <td width="20%" class="sSponsorTitle" {if $k > 0}style="display: none;"{/if}><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name=$secondarySponsorsTitleD required="true" key="proposal.articleSponsor.secondarySponsors"}</td>
                <td width="20%" class="noSSponsorTitle" {if $k == 0}style="display: none;"{/if}>&nbsp;</td>                        
                <td width="80%" colspan="2" class="value">
                    <select name="{$secondarySponsorsSelectB|escape}" id="{$secondarySponsorsSelectD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$institutionsList selected=$secondarySponsors.$k.ssInstitutionId}                                
                    </select>
                    <a class="removeSecondarySponsor" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                </td>                                           
            </tr>
            <tr valign="top" id="{$secondarySponsorsNameFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsNameD required="true" key="proposal.articleSponsor.name"}</td>                        
                <td width="70%" class="value"><input type="text" class="textField" name="{$secondarySponsorsNameB|escape}" id="{$secondarySponsorsNameD|escape}" value="{$secondarySponsors.$k.ssName|escape}" size="30" maxlength="255" /></td>                                           
            </tr>
            <tr valign="top" id="{$secondarySponsorsAcronymFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsAcronymD required="true" key="proposal.articleSponsor.acronym"}</td>                        
                <td width="70%" class="value"><input type="text" class="textField" name="{$secondarySponsorsAcronymB|escape}" id="{$secondarySponsorsAcronymD|escape}" value="{$secondarySponsors.$k.ssAcronym|escape}" size="30" maxlength="255" /></td>                                           
            </tr>
            <tr valign="top" id="{$secondarySponsorsTypeFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsTypeD required="true" key="proposal.articleSponsor.type"}</td>                        
                <td width="70%" class="value">
                    <select name="{$secondarySponsorsTypeB|escape}" id="{$secondarySponsorsTypeD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$institutionTypesList selected=$secondarySponsors.$k.ssType}                                
                    </select>
                </td>                                           
            </tr>                        
            <tr valign="top" id="{$secondarySponsorsLocationFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsLocationD required="true" key="proposal.articleSponsor.location"}</td>                        
                <td width="70%" class="value">
                    {html_radios name=$secondarySponsorsLocationB options=$internationalArray selected=$secondarySponsors.$k.ssLocation separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                </td>                                           
            </tr>
            <tr valign="top" id="{$secondarySponsorsLocationCountryFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsLocationCountryD required="true" key="proposal.articleSponsor.locationCountry"}</td>                        
                <td width="70%" class="value">
                    <select name="{$secondarySponsorsLocationCountryB|escape}" id="{$secondarySponsorsLocationCountryD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$geoAreasList selected=$secondarySponsors.$k.ssLocationCountry}                                
                    </select>
                </td>                                           
            </tr>
            <tr valign="top" id="{$secondarySponsorsLocationInternationalFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="10%">{fieldLabel name=$secondarySponsorsLocationInternationalD required="true" key="proposal.articleSponsor.locationInternational"}</td>                        
                <td width="70%" class="value">
                    <select name="{$secondarySponsorsLocationInternationalB|escape}" id="{$secondarySponsorsLocationInternationalD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$coutryList selected=$secondarySponsors.$k.ssLocationInternational}                                
                    </select>                
                </td>                                           
            </tr>
            {if $k == 0}
            <tr valign="top" hidden class="showHideHelpField">
                <td width="20%">&nbsp;</td>
                <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleSponsor.secondarySponsors.instruct"}</i></td>
            </tr>    
            {/if}
            <tr><td colspan="3">&nbsp;</td></tr>
        </table>
    {/foreach}
    <table width="100%" class="data">
        <tr valign="top">
            <td width="20%">&nbsp;</td>
            <td width="80%" class="value"><a id="addSecondarySponsorClick" style="cursor: pointer;">{translate key="proposal.articleSponsor.secondarySponsors.add"}</a></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr valign="top">
            <td width="20%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="croInvolved" required="true" key="proposal.articleSponsor.croInvolved"}</td>
            <td width="80%" class="value">
                {html_radios name="croInvolved" options=$yesNoMap selected=$croInvolved separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.articleSponsor.croInvolved.instruct"}</i></td>
        </tr>    
    </table>
    {foreach from=$CROs key=k item=CRO} 
        {assign var="CROTitleD" value='CROs-'|cat:$k}
        {assign var="CRONameB" value='CROs['|cat:$k|cat:'][croName]'}
        {assign var="CRONameD" value='CROs-'|cat:$k|cat:'-croName'}   
        {assign var="CRONameFieldD" value='CROs-'|cat:$k|cat:'-croNameField'}           
        {assign var="CROLocationB" value='CROs['|cat:$k|cat:'][croLocation]'}
        {assign var="CROLocationD" value='CROs-'|cat:$k|cat:'-croLocation'}     
        {assign var="CROLocationFieldD" value='CROs-'|cat:$k|cat:'-croLocationField'}     
        {assign var="CROLocationCountryB" value='CROs['|cat:$k|cat:'][croLocationCountry]'}
        {assign var="CROLocationCountryD" value='CROs-'|cat:$k|cat:'-croLocationCountry'}  
        {assign var="CROLocationCountryFieldD" value='CROs-'|cat:$k|cat:'-croLocationCountryField'}     
        {assign var="CROLocationInternationalB" value='CROs['|cat:$k|cat:'][croLocationInternational]'}
        {assign var="CROLocationInternationalD" value='CROs-'|cat:$k|cat:'-croLocationInternational'}  
        {assign var="CROLocationInternationalFieldD" value='CROs-'|cat:$k|cat:'-croLocationInternationalField'}        
        {assign var="CROCityB" value='CROs['|cat:$k|cat:'][city]'}
        {assign var="CROCityD" value='CROs-'|cat:$k|cat:'-city'}   
        {assign var="CROCityFieldD" value='CROs-'|cat:$k|cat:'-cityField'}           
        {assign var="CROAddressB" value='CROs['|cat:$k|cat:'][address]'}
        {assign var="CROAddressD" value='CROs-'|cat:$k|cat:'-address'}   
        {assign var="CROAddressFieldD" value='CROs-'|cat:$k|cat:'-addressField'}           
        {assign var="CROPrimaryPhoneB" value='CROs['|cat:$k|cat:'][primaryPhone]'}
        {assign var="CROPrimaryPhoneD" value='CROs-'|cat:$k|cat:'-primaryPhone'}   
        {assign var="CROPrimaryPhoneFieldD" value='CROs-'|cat:$k|cat:'-primaryPhoneField'}           
        {assign var="CROSecondaryPhoneB" value='CROs['|cat:$k|cat:'][secondaryPhone]'}
        {assign var="CROSecondaryPhoneD" value='CROs-'|cat:$k|cat:'-secondaryPhone'}   
        {assign var="CROSecondaryPhoneFieldD" value='CROs-'|cat:$k|cat:'-secondaryPhoneField'}           
        {assign var="CROFaxB" value='CROs['|cat:$k|cat:'][fax]'}
        {assign var="CROFaxD" value='CROs-'|cat:$k|cat:'-fax'}   
        {assign var="CROFaxFieldD" value='CROs-'|cat:$k|cat:'-faxField'}           
        {assign var="CROEmailB" value='CROs['|cat:$k|cat:'][email]'}
        {assign var="CROEmailD" value='CROs-'|cat:$k|cat:'-email'}   
        {assign var="CROEmailFieldD" value='CROs-'|cat:$k|cat:'-emailField'}           
        <table width="100%" id="{$CROTitleD|escape}" {if $k > 0}class="CROSupp"{/if}>
            {if $CROs.$k.id}<input type="hidden" class="hiddenInputs" name="CROs[{$k|escape}][id]" value="{$CROs.$k.id|escape}" />{/if}
            <tr valign="top" id="{$CRONameFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CRONameD required="true" key="proposal.articleSponsor.cro.name"}</td>                        
                <td width="60%" class="value">
                    <input type="text" class="textField" name="{$CRONameB|escape}" id="{$CRONameD|escape}" value="{$CROs.$k.croName|escape}" size="30" maxlength="255" />
                    <a class="removeCRO" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                </td>                                           
            </tr>
            <tr valign="top" id="{$CROLocationFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROLocationD required="true" key="proposal.articleSponsor.cro.location"}</td>                        
                <td width="60%" class="value">
                    {html_radios name=$CROLocationB options=$internationalArray selected=$CROs.$k.croLocation separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                </td>                                           
            </tr>            
            <tr valign="top" id="{$CROLocationCountryFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROLocationCountryD required="true" key="proposal.articleSponsor.cro.locationCountry"}</td>                        
                <td width="60%" class="value">
                    <select name="{$CROLocationCountryB|escape}" id="{$CROLocationCountryD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$geoAreasList selected=$CROs.$k.croLocationCountry}                                
                    </select>
                </td>                                           
            </tr>
            <tr valign="top" id="{$CROLocationInternationalFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROLocationInternationalD required="true" key="proposal.articleSponsor.locationInternational"}</td>                        
                <td width="60%" class="value">
                    <select name="{$CROLocationInternationalB|escape}" id="{$CROLocationInternationalD|escape}" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$coutryList selected=$CROs.$k.croLocationInternational}                                
                    </select>                
                </td>                                           
            </tr>
            <tr valign="top" id="{$CROCityFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROCityD required="true" key="proposal.articleSponsor.cro.city"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROCityB|escape}" id="{$CROCityD|escape}" value="{$CROs.$k.city|escape}" size="30" maxlength="40" /></td>                                           
            </tr>
            <tr valign="top" id="{$CROAddressFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROAddressD required="true" key="proposal.articleSponsor.cro.address"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROAddressB|escape}" id="{$CROAddressD|escape}" value="{$CROs.$k.address|escape}" size="30" maxlength="255" /></td>                                           
            </tr>
            <tr valign="top" id="{$CROPrimaryPhoneFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROPrimaryPhoneD required="true" key="proposal.articleSponsor.cro.primaryPhone"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROPrimaryPhoneB|escape}" id="{$CROPrimaryPhoneD|escape}" value="{$CROs.$k.primaryPhone|escape}" size="30" maxlength="24" /></td>                                           
            </tr>
            <tr valign="top" id="{$CROSecondaryPhoneFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROSecondaryPhoneD key="proposal.articleSponsor.cro.secondaryPhone"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROSecondaryPhoneB|escape}" id="{$CROSecondaryPhoneD|escape}" value="{$CROs.$k.secondaryPhone|escape}" size="30" maxlength="24" /></td>                                           
            </tr>
            <tr valign="top" id="{$CROFaxFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROFaxD key="proposal.articleSponsor.cro.fax"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROFaxB|escape}" id="{$CROFaxD|escape}" value="{$CROs.$k.fax|escape}" size="30" maxlength="24" /></td>                                           
            </tr>
            <tr valign="top" id="{$CROEmailFieldD|escape}">
                <td width="20%">&nbsp;</td>                        
                <td width="20%">{fieldLabel name=$CROEmailD required="true" key="proposal.articleSponsor.cro.email"}</td>                        
                <td width="60%" class="value"><input type="text" class="textField" name="{$CROEmailB|escape}" id="{$CROEmailD|escape}" value="{$CROs.$k.email|escape}" size="30" maxlength="90" /></td>                                           
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
        </table>
    {/foreach}
    <table width="100%" class="data">
        <tr valign="top" id="addCROField">
            <td width="20%">&nbsp;</td>
            <td width="80%" class="value"><a id="addCROClick" style="cursor: pointer;">{translate key="proposal.articleSponsor.cro.add"}</a></td>
        </tr>
    </table>
    
    <p><input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" /></p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep5.tpl"}