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
                    <td width="50%"><input type="button"  class="removeDrug" value="{translate key="common.remove"}" style="{if $i == 0}display: none; {/if}" /></td></tr>
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
                {if $i == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.drugInfo.administration.instruct"}</i></td>
                    </tr>    
                {/if}    

            </table><br/><br/>
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