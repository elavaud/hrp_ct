{**
 * articleDrugs.tpl
 *
 * Subtemplate defining the submission metadata table for article drugs. Non-form implementation.
 *}

 
{literal}
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.showHideDrugInfoButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().parent().parent().nextAll('.showHideHelpDrugInfoField').first().is(':hidden')) {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpDrugInfoField').first().show();
                } else {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpDrugInfoField').first().hide();
                } 
            });});        
        });
    </script>
{/literal}

{foreach from=$articleDrugs item=articleDrug}
    <h5>{$articleDrug->getName()}</h5>
    <table class="data" width="100%">
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.type"}</td>
            <td width="80%" class="value"><ul><li>{translate key=$articleDrug->getTypeKey()}</li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.name"}</td>
            <td width="80%" class="value"><ul><li>{$articleDrug->getName()|escape}</li></ul></td>
        </tr>        
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.brandName"}</td>
            <td width="80%" class="value"><ul><li>{$articleDrug->getBrandName()|escape}</li></ul></td>
        </tr>        
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.administration"}</td>
            <td width="80%" class="value"><ul><li>
                {if $articleDrug->getOtherAdministration() == 'NA'}
                    {translate key=$articleDrug->getAdministrationKey()}
                {else}
                    {$articleDrug->getOtherAdministration()|escape}
                {/if}
            </li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.form"}</td>
            <td width="80%" class="value"><ul><li>
                {if $articleDrug->getOtherForm() == 'NA'}
                    {translate key=$articleDrug->getFormKey()}
                {else}
                    {$articleDrug->getOtherForm()|escape}
                {/if}                    
            </li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.strength"}</td>
            <td width="80%" class="value"><ul><li>{$articleDrug->getStrength()|escape}</li></ul></td>
        </tr>    
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.storage"}</td>
            <td width="80%" class="value"><ul><li>{translate key=$articleDrug->getStorageKey()}</li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.pharmaClass"}</td>
            <td width="80%" class="value"><ul><li>
                {assign var="pharmaClass" value=$articleDrug->getPharmaClass()}
                {$pharmaClasses.$pharmaClass|escape}
            </li></ul></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.studyClasses"}</td>
            <td width="80%" class="value"><ul><li>
                {assign var="countStudyClasses" value=1}
                {assign var="classIIIOrIV" value=false}
                {foreach from=$articleDrug->getClassesArray() item=class}
                    {if $class == $smarty.const.ARTICLE_DRUG_INFO_CLASS_III || $class == $smarty.const.ARTICLE_DRUG_INFO_CLASS_IV}
                        {assign var="classIIIOrIV" value=true}
                    {/if}
                    {if $countStudyClasses != 1}, {/if}{$drugStudyClasses.$class|escape}
                    {assign var="countStudyClasses" value=$countStudyClasses+1}
                {/foreach}                        
            </li></ul></td>
        </tr>
        {if $classIIIOrIV}
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value">
                    <table class="data" width="100%">
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="40%" class="label">{translate key="proposal.drugInfo.countries"}</td>
                            <td width="50%" class="value">
                                {assign var="countCountries" value=1}
                                {foreach from=$articleDrug->getCountriesArray() item=country}
                                    {if $countCountries != 1}, {/if}{$coutryList.$country|escape}
                                    {assign var="countCountries" value=$countCountries+1}
                                {/foreach}
                            </td>                            
                        </tr>
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="40%" class="label">{translate key="proposal.drugInfo.conditionsOfUse"}</td>
                            <td width="50%" class="value">
                                {translate key=$articleDrug->getDifferentConditionsOfUseKey()}
                            </td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        {/if}
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.drugInfo.cpr"}</td>
            <td width="80%" class="value"><ul><li>{translate key=$articleDrug->getCPRKey()}</li></ul></td>
        </tr>
        {if $articleDrug->getCPR() == $smarty.const.ARTICLE_DRUG_INFO_YES}
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value">
                    <table class="data" width="100%">
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="40%" class="label">{translate key="proposal.drugInfo.drugRegistrationNumber"}</td>
                            <td width="50%" class="value">{$articleDrug->getDrugRegistrationNumber()|escape}</td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        {/if}
        {if $articleDrug->getImportedQuantity() != ""}
            <tr valign="top">
                <td width="20%" class="label">{translate key="proposal.drugInfo.importedQuantity"}</td>
                <td width="80%" class="value"><ul><li>{$articleDrug->getImportedQuantity()|escape}</li></ul></td>
            </tr>
        {/if}
        {assign var="countManufacturers" value=1}
        {foreach from=$articleDrug->getManufacturers() item=manufacturer}
            <tr valign="top">
                <td width="20%" class="label">{if $countManufacturers == 1}{translate key="proposal.drugInfo.manufacturers"}{else}&nbsp;{/if}</td>
                <td width="80%" class="value"><ul><li><a class="showHideDrugInfoButton" style="cursor:pointer;">{$manufacturer->getName()|escape}</a></li></ul></td>
            </tr>
            <tr valign="top" hidden class="showHideHelpDrugInfoField">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value">
                    <table class="data" width="100%">
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="20%" class="label">{translate key="proposal.drugInfo.manufacturer.address"}</td>
                            <td width="70%" class="value">{$manufacturer->getAddress()|escape}</td>                            
                        </tr>
                    </table>
                </td>
            </tr> 
            {assign var="countManufacturers" value=$countManufacturers+1}
        {/foreach}
        {assign var="IBs" value=$articleDrug->getIBs()}
        {assign var="SmPCs" value=$articleDrug->getSmPCs()}
        {if !empty($IBs) || !empty($SmPCs)}
        <tr valign="top">
            <td width="20%" class="label">{translate key="common.file.s"}</td>
            <td width="80%" class="value"><ul><li>            
                {if !empty($IBs)}
                    {foreach from=$IBs item=IB}
                        <a class="file" href="{url op="download" path=$articleId|to_array:$IB->getFileId()}">{translate key="article.suppFile.brochure"}</a> ({$IB->getOriginalFileName()|escape})<br/>
                    {/foreach}                            
                {/if}
                {if !empty($SmPCs)}
                    {foreach from=$SmPCs item=SmPC}
                        <a class="file" href="{url op="download" path=$articleId|to_array:$SmPC->getFileId()}">{translate key="article.suppFile.smpc"}</a> ({$SmPC->getOriginalFileName()|escape})<br/>
                    {/foreach}                                                        
                {/if}            
            </li></ul></td>
        </tr>
        {/if}
    </table>
{/foreach}

