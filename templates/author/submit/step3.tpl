{**
 * step3.tpl
 *
 * Step 3 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step3"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

<div class="separator"></div>

<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}
    
    {foreach from=$articleDrugs key=i item=drug}
        {assign var="articleDrugDivId" value='articleDrugs-'|cat:$i}  
        {assign var="articleDrugTitleId" value='articleDrugs-'|cat:$i|cat:'-title'}          
        <div id="{$articleDrugDivId|escape}" {if $i != 0}class="drugSupp"{/if}>
            <table width="100%">
                <tr>
                    <td width="50%"><h2>{translate key="proposal.drugInfo"} #<span id="{$articleDrugTitleId|escape}">{$i+1|escape}</span></h2></td>
                    <td width="50%"><input type="button"  class="removeDrug" value="{translate key="proposal.drugInfo.remove"}" style="{if $i == 0}display: none; {/if}" /></td>
                </tr>
            </table>
            {if $articleDrugs.$i.id}<input type="hidden" class="hiddenInputs" name="articleDrugs[{$i|escape}][id]" value="{$articleDrugs.$i.id|escape}" />{/if}
            <table width="100%" class="data">
                {assign var="articleDrugTypeB" value='articleDrugs['|cat:$i|cat:'][type]'}
                {assign var="articleDrugTypeD" value='articleDrugs-'|cat:$i|cat:'-type'}   
                {assign var="articleDrugNameB" value='articleDrugs['|cat:$i|cat:'][name]'}
                {assign var="articleDrugNameD" value='articleDrugs-'|cat:$i|cat:'-name'}   
                {assign var="articleDrugBrandNameB" value='articleDrugs['|cat:$i|cat:'][brandName]'}
                {assign var="articleDrugBrandNameD" value='articleDrugs-'|cat:$i|cat:'-brandName'}  
                {assign var="articleDrugAdministrationB" value='articleDrugs['|cat:$i|cat:'][administration]'}
                {assign var="articleDrugAdministrationD" value='articleDrugs-'|cat:$i|cat:'-administration'}  
                {assign var="articleDrugOtherAdministrationB" value='articleDrugs['|cat:$i|cat:'][otherAdministration]'}
                {assign var="articleDrugOtherAdministrationD" value='articleDrugs-'|cat:$i|cat:'-otherAdministration'}  
                {assign var="articleDrugOtherAdministrationFieldD" value='articleDrugs-'|cat:$i|cat:'-otherAdministrationField'}   
                {assign var="articleDrugFormB" value='articleDrugs['|cat:$i|cat:'][form]'}
                {assign var="articleDrugFormD" value='articleDrugs-'|cat:$i|cat:'-form'}  
                {assign var="articleDrugOtherFormB" value='articleDrugs['|cat:$i|cat:'][otherForm]'}
                {assign var="articleDrugOtherFormD" value='articleDrugs-'|cat:$i|cat:'-otherForm'}  
                {assign var="articleDrugOtherFormFieldD" value='articleDrugs-'|cat:$i|cat:'-otherFormField'}   
                {assign var="articleDrugStrengthB" value='articleDrugs['|cat:$i|cat:'][strength]'}
                {assign var="articleDrugStrengthD" value='articleDrugs-'|cat:$i|cat:'-strength'}   
                {assign var="articleDrugStorageB" value='articleDrugs['|cat:$i|cat:'][storage]'}
                {assign var="articleDrugStorageD" value='articleDrugs-'|cat:$i|cat:'-storage'}   
                {assign var="articleDrugPharmClassB" value='articleDrugs['|cat:$i|cat:'][pharmaClass]'}
                {assign var="articleDrugPharmClassD" value='articleDrugs-'|cat:$i|cat:'-pharmaClass'}   
                {assign var="articleDrugStudyClassesB" value='articleDrugs['|cat:$i|cat:'][studyClasses]'}
                {assign var="articleDrugStudyClassesD" value='articleDrugs-'|cat:$i|cat:'-studyClasses'}     
                {assign var="articleDrugCPRB" value='articleDrugs['|cat:$i|cat:'][cpr]'}
                {assign var="articleDrugCPRD" value='articleDrugs-'|cat:$i|cat:'-cpr'}     
                {assign var="articleDrugRegistrationNumberB" value='articleDrugs['|cat:$i|cat:'][drugRegistrationNumber]'}
                {assign var="articleDrugRegistrationNumberD" value='articleDrugs-'|cat:$i|cat:'-drugRegistrationNumber'}     
                {assign var="articleDrugImportedQuantityB" value='articleDrugs['|cat:$i|cat:'][importedQuantity]'}
                {assign var="articleDrugImportedQuantityD" value='articleDrugs-'|cat:$i|cat:'-importedQuantity'}     
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugTypeD required="true" key="proposal.drugInfo.type"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleDrugTypeB|escape}" id="{$articleDrugTypeD|escape}" class="selectMenu" {if $i == 0}disabled="disabled"{/if}>
                            {if $i == 0}
                                {html_options options=$drugTypeMap selected=1}                                
                            {else}
                                <option value=""></option>
                                {html_options options=$drugTypeMap selected=$articleDrugs.$i.type}                                
                            {/if}
                        </select>
                    </td>                     
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.type.instruct"}</i></td>
                    </tr>    
                {/if}    
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugNameD required="true" key="proposal.drugInfo.name"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleDrugNameB|escape}" id="{$articleDrugNameD|escape}" value="{$articleDrugs.$i.name|escape}" size="50" maxlength="255" /></td>                   
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.name.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugBrandNameD key="proposal.drugInfo.brandName"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleDrugBrandNameB|escape}" id="{$articleDrugBrandNameD|escape}" value="{$articleDrugs.$i.brandName|escape}" size="50" maxlength="255" /></td>                   
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.brandName.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugAdministrationD required="true" key="proposal.drugInfo.administration"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleDrugAdministrationB|escape}" id="{$articleDrugAdministrationD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$drugAdministrationMap selected=$articleDrugs.$i.administration}                                
                        </select>
                    </td>                     
                </tr>
                <tr valign="top" id="{$articleDrugOtherAdministrationFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="80%" class="value">{fieldLabel name=$articleDrugOtherAdministrationD required="true" key="common.other"}&nbsp;&nbsp;<input type="text" class="textField" name="{$articleDrugOtherAdministrationB|escape}" id="{$articleDrugOtherAdministrationD|escape}" value="{$articleDrugs.$i.otherAdministration|escape}" size="20" maxlength="90" /></td>                   
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.administration.instruct"}</i></td>
                    </tr>    
                {/if}    
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugFormD required="true" key="proposal.drugInfo.form"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleDrugFormB|escape}" id="{$articleDrugFormD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$drugFormMap selected=$articleDrugs.$i.form}                                
                        </select>
                    </td>                     
                </tr>
                <tr valign="top" id="{$articleDrugOtherFormFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="80%" class="value">{fieldLabel name=$articleDrugOtherFormD required="true" key="common.other"}&nbsp;&nbsp;<input type="text" class="textField" name="{$articleDrugOtherFormB|escape}" id="{$articleDrugOtherFormD|escape}" value="{$articleDrugs.$i.otherForm|escape}" size="20" maxlength="90" /></td>                   
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.form.instruct"}</i></td>
                    </tr>    
                {/if}    
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugStrengthD required="true" key="proposal.drugInfo.strength"}</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="{$articleDrugStrengthB|escape}" id="{$articleDrugStrengthD|escape}" value="{$articleDrugs.$i.strength|escape}" size="50" maxlength="255" /></td>                   
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.strength.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugStorageD required="true" key="proposal.drugInfo.storage"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleDrugStorageB|escape}" id="{$articleDrugStorageD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$drugStorageMap selected=$articleDrugs.$i.storage}                                
                        </select>
                    </td>                     
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.storage.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugPharmaClassD required="true" key="proposal.drugInfo.pharmaClass"}</td>
                    <td width="80%" class="value">
                        <select name="{$articleDrugPharmaClassB|escape}" id="{$articleDrugPharmaClassD|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$drugPharmaClasses selected=$articleDrugs.$i.pharmaClass}                                
                        </select>
                    </td>                     
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.pharmaClass.instruct"}</i></td>
                    </tr>    
                {/if}    
                <tr valign="top">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugStudyClassesD required="true" key="proposal.drugInfo.studyClasses"}</td>
                    <td width="80%" class="value">
                        {html_checkboxes name=$articleDrugStudyClassesB options=$drugStudyClasses selected=$articleDrugs.$i.studyClasses separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                    </td>                     
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.studyClasses.instruct"}</i></td>
                    </tr>    
                {/if}
            </table><br/>
            {assign var="articleDrugClassIIIOrIVD" value='articleDrugs-'|cat:$i|cat:'-classIIIOrIV'}   
            {assign var="articleDrugAddCountryD" value='articleDrugs-'|cat:$i|cat:'-addCountry'}      
            {assign var="articleDrugConditionsOfUseB" value='articleDrugs['|cat:$i|cat:'][conditionsOfUse]'}
            {assign var="articleDrugConditionsOfUseD" value='articleDrugs-'|cat:$i|cat:'-conditionsOfUse'}                 
            <table width="100%" class="data" id="{$articleDrugClassIIIOrIVD|escape}">
                {foreach from=$articleDrugs.$i.countries key=j item=country}
                    {assign var="articleDrugCountryB" value='articleDrugs['|cat:$i|cat:'][country]['|cat:$j|cat:']'}
                    {assign var="articleDrugCountryD" value='articleDrugs-'|cat:$i|cat:'-country-'|cat:$j}     
                    {assign var="articleDrugCountryTrD" value='articleDrugs-'|cat:$i|cat:'-countryTr-'|cat:$j}  
                    {assign var="articleDrugCountryClassSuppD" value='countrySupp-'|cat:$i}                      
                    <tr valign="bottom" id="{$articleDrugCountryTrD|escape}" {if $j > 0}class="{$articleDrugCountryClassSuppD|escape}"{/if}>
                        <td width="20%">&nbsp;</td>
                        <td width="20%" class="countryTitle" {if $j > 0}style="display: none;"{/if}>{fieldLabel name=$articleDrugStudyClassesD required="true" key="proposal.drugInfo.countries"}</td>
                        <td width="20%" class="noCountryTitle" {if $j == 0}style="display: none;"{/if}>&nbsp;</td>                        
                        <td width="60%" class="value">
                            <select name="{$articleDrugCountryB|escape}" id="{$articleDrugCountryD|escape}" class="selectMenu">
                                <option value=""></option>
                                {html_options options=$coutryList selected=$articleDrugs.$i.countries.$j}
                            </select>     
                            <a class="removeCountry" style="{if $j == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                        </td>                     
                    </tr>
                {/foreach}
                <tr valign="middle">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>                        
                    <td width="60%" class="value">
                        <a class="addAnotherCountryClick" id="{$articleDrugAddCountryD|escape}" style="cursor: pointer;">{translate key="proposal.drugInfo.countries.add"}</a>
                    </td>                     
                </tr>
                <tr valign="middle">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugConditionsOfUseD required="true" key="proposal.drugInfo.conditionsOfUse"}</td>                        
                    <td width="60%" class="value">
                        {html_radios name=$articleDrugConditionsOfUseB options=$yesNoMap selected=$articleDrugs.$i.conditionsOfUse separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                    </td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="60%" class="value"><i>[?] {translate key="proposal.drugInfo.conditionsOfUse.instruct"}</i></td>
                    </tr>    
                {/if}
            </table>
            <table width="100%" class="data">
                {assign var="articleDrugCPRB" value='articleDrugs['|cat:$i|cat:'][cpr]'}
                {assign var="articleDrugCPRD" value='articleDrugs-'|cat:$i|cat:'-cpr'}     
                {assign var="articleDrugRegistrationNumberB" value='articleDrugs['|cat:$i|cat:'][drugRegistrationNumber]'}
                {assign var="articleDrugRegistrationNumberD" value='articleDrugs-'|cat:$i|cat:'-drugRegistrationNumber'}     
                {assign var="articleDrugRegistrationNumberFieldD" value='articleDrugs-'|cat:$i|cat:'-drugRegistrationNumberField'}     
                {assign var="articleDrugImportedQuantityB" value='articleDrugs['|cat:$i|cat:'][importedQuantity]'}
                {assign var="articleDrugImportedQuantityD" value='articleDrugs-'|cat:$i|cat:'-importedQuantity'}                
                <tr valign="middle">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugCPRD required="true" key="proposal.drugInfo.cpr"}</td>                        
                    <td width="80%" colspan="2" class="value">
                        {html_radios name=$articleDrugCPRB options=$yesNoMap selected=$articleDrugs.$i.cpr separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                    </td>
                </tr>
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.drugInfo.cpr.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="middle" id="{$articleDrugRegistrationNumberFieldD|escape}">
                    <td width="20%">&nbsp;</td>
                    <td width="20%">{fieldLabel name=$articleDrugRegistrationNumberD required="true" key="proposal.drugInfo.drugRegistrationNumber"}</td>                        
                    <td width="60%" class="value"><input type="text" class="textField" name="{$articleDrugRegistrationNumberB|escape}" id="{$articleDrugRegistrationNumberD|escape}" value="{$articleDrugs.$i.drugRegistrationNumber|escape}" size="20" maxlength="90" /></td>                                           
                </tr>
                <tr valign="middle">
                    <td width="20%">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugImportedQuantityD key="proposal.drugInfo.importedQuantity"}</td>                        
                    <td width="80%" colspan="2" class="value">
                        <input type="text" class="textField" name="{$articleDrugImportedQuantityB|escape}" id="{$articleDrugImportedQuantityD|escape}" value="{$articleDrugs.$i.importedQuantity|escape}" size="30" maxlength="90" />
                    </td>                                           
                </tr>     
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.drugInfo.importedQuantity.instruct"}</i></td>
                    </tr>    
                {/if}
            </table>
            {foreach from=$articleDrugs.$i.manufacturers key=k item=manufacturer} 
                {if $articleDrugs.$i.manufacturers.$k.id}<input type="hidden" class="hiddenInputs" name="articleDrugs[{$i|escape}][manufacturers][{$k|escape}][id]" value="{$articleDrugs.$i.manufacturers.$k.id|escape}" />{/if}
                {assign var="articleDrugManufacturerTitleD" value='articleDrugs-'|cat:$i|cat:'-manufacturer-'|cat:$k}   
                {assign var="articleDrugManufacturerNameB" value='articleDrugs['|cat:$i|cat:'][manufacturer]['|cat:$k|cat:'][name]'}
                {assign var="articleDrugManufacturerNameD" value='articleDrugs-'|cat:$i|cat:'-manufacturer-'|cat:$k|cat:'-name'}                
                {assign var="articleDrugManufacturerAddressB" value='articleDrugs['|cat:$i|cat:'][manufacturer]['|cat:$k|cat:'][address]'}
                {assign var="articleDrugManufacturerAddressD" value='articleDrugs-'|cat:$i|cat:'-manufacturer-'|cat:$k|cat:'-address'}   
                {assign var="articleDrugManufacturerClassSuppD" value='manufacturerSupp-'|cat:$i}                      
                <table width="100%" id="{$articleDrugManufacturerTitleD|escape}" {if $k > 0}class="{$articleDrugManufacturerClassSuppD|escape}"{/if}>
                    <tr valign="top">
                        <td width="20%" class="manufacturerTitle" {if $k > 0}style="display: none;"{/if}>{if $i==0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$articleDrugManufacturerTitleD required="true" key="proposal.drugInfo.manufacturers"}</td>
                        <td width="20%" class="noManufacturerTitle" {if $k == 0}style="display: none;"{/if}>&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleDrugManufacturerNameD required="true" key="proposal.drugInfo.manufacturer.name"}</td>                        
                        <td width="70%" class="value">
                            <input type="text" class="textField" name="{$articleDrugManufacturerNameB|escape}" id="{$articleDrugManufacturerNameD|escape}" value="{$articleDrugs.$i.manufacturers.$k.name|escape}" size="30" maxlength="255" />
                            <a class="removeManufacturer" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                        </td>                                           
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>                        
                        <td width="10%">{fieldLabel name=$articleDrugManufacturerAddressD required="true" key="proposal.drugInfo.manufacturer.address"}</td>                        
                        <td width="70%" class="value"><input type="text" class="textField" name="{$articleDrugManufacturerAddressB|escape}" id="{$articleDrugManufacturerAddressD|escape}" value="{$articleDrugs.$i.manufacturers.$k.address|escape}" size="30" maxlength="255" /></td>                                           
                    </tr>
                    {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.drugInfo.manufacturers.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr><td colspan="3">&nbsp;</td></tr>
            </table>
            {/foreach}
            <table width="100%" class="data">
                {assign var="articleDrugAddManufacturerD" value='articleDrugs-'|cat:$i|cat:'-addManufacturer'}                
                <tr valign="top">
                    <td width="20%">&nbsp;</td>
                    <td width="80%" class="value"><a class="addAnotherManufacturerClick" id="{$articleDrugAddManufacturerD|escape}" style="cursor: pointer;">{translate key="proposal.drugInfo.manufacturers.add"}</a></td>
                </tr>
            </table>
            <br/><br/>
        </div>
    {/foreach}

    <p>
        <input type="button" value="{translate key="proposal.drugInfo.add"}" class="button" id="addDrugInfoClick" />        
        <input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> 
        <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" />
    </p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep3.tpl"}