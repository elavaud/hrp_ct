{**
 * step2.tpl
 *
 * Step 2 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step2"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

{literal}
    <style>
        .ui-datepicker-calendar {
            display: none;
        }        
    </style>
{/literal}

<div class="separator"></div>
<br/>
<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}

    <div id="titles">
        <table width="100%" class="data">

            {foreach from=$articleTextLocales item=localeName key=localeKey}

                {assign var="articleText" value=$articleTexts[$localeKey]}
                
                <input type="hidden" name="articleTexts[{$localeKey|escape}][articleTextId]" value="{$articleText.articleTextId|escape}" />

                <tr valign="top" id="scientificTitleField">
                    <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="scientificTitle" required="true" key="proposal.scientificTitle"} ({$localeName})</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="articleTexts[{$localeKey|escape}][scientificTitle]" id="scientificTitle" value="{$articleText.scientificTitle|escape}" size="50" maxlength="255" /></td>
                </tr>
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="80%" class="value"><i>[?] {translate key="proposal.scientificTitle.instruct"}</i></td>
                </tr>
                <tr valign="top" id="publicTitleField">
                    <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="publicTitle" required="true" key="proposal.publicTitle"} ({$localeName})</td>
                    <td width="80%" class="value"><input type="text" class="textField" name="articleTexts[{$localeKey|escape}][publicTitle]" id="publicTitle" value="{$articleText.publicTitle|escape}" size="50" maxlength="255" /></td>
                </tr>
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="80%" class="value"><i>[?] {translate key="proposal.publicTitle.instruct"}</i></td>
                </tr>
            {/foreach}
        </table>
    </div>
    <br/>
    <div id="secIds">
        <table width="100%" class="data">
            {foreach from=$articleSecIds key=i item=secId}
                
                <tr valign="top"  {if $i == 0}id="firstSecId"{else}class="secIdSupp"{/if}>
                    <td width="20%" class="secIdTitle">{if $i == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleSecIds" key="proposal.articleSecId"}{else}&nbsp;{/if}</td>
                    <td width="20%" class="noSecIdTitle" style="display: none;">&nbsp;</td>
                    <td width="5%" align="left">{fieldLabel name="articleSecIds-id" key="proposal.articleSecId.type"}</td>                
                    <td width="25%" class="value">
                        {if $articleSecIds.$i.articleSecIdId}<input type="hidden" class="hiddenInputs" name="articleSecIds[{$i|escape}][articleSecIdId]" value="{$secId.articleSecIdId|escape}" />{/if}
                        <select name="articleSecIds[{$i}][type]" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$articleSecIdTypeList selected=$articleSecIds.$i.type}
                        </select>
                    </td>
                    <td width="5%" class="secIdIdTitle" align="center">{fieldLabel name="articleSecIds-id" key="proposal.articleSecId.id"}</td>
                    <td width="45%" class="value">
                        <input type="text" class="textField" name="articleSecIds[{$i}][id]" value="{$articleSecIds.$i.id|escape}" size="15" maxlength="90" />
                        <a class="removeSecId" style="{if $i == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                    </td>
                </tr>
                {if $i == 0}
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td colspan="4" width="80%" class="value"><i>[?] {translate key="proposal.articleSecId.instruct"}</i></td>
                </tr>
                {/if}
            {/foreach}
            <tr id="addAnotherSecId">
                <td width="20%">&nbsp;</td>
                <td colspan="5"><a id="addAnotherSecIdClick" style="cursor: pointer;">{translate key="proposal.addAnotherSecId"}</a></td>
            </tr>
        </table>
    </div>
    <br/>
    <table width="100%" class="data">
        <tr valign="top" id="protocolVersionField">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-protocolVersion" required="true" key="proposal.protocolVersion"}</td>
            <td width="80%" class="value"><input type="text" class="textField" name="articleDetails[protocolVersion]" id="protocolVersion" value="{$articleDetails.protocolVersion|escape}" size="30" maxlength="90" /></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.protocolVersion.instruct"}</i></td>
        </tr>
        <tr valign="top" id="therapeuticAreaField">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-therapeuticArea" required="true" key="proposal.therapeuticArea"}</td>
            <td width="80%" class="value">
                <select name="articleDetails[therapeuticArea]" id="therapeuticArea" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$articleDetailsTherapeuticAreasList selected=$articleDetails.therapeuticArea}
                </select>
            </td>
        </tr>
        <tr valign="top" id="otherTherapeuticAreaField"  style="display:none">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value">
                {fieldLabel name="articleDetails-otherTherapeuticArea" required="true" key="common.other"}
                <input type="text" class="textField" name="articleDetails[otherTherapeuticArea]" id="otherTherapeuticArea" value="{$articleDetails.otherTherapeuticArea|escape}" size="30" maxlength="90" />
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td colspan="4" width="80%" class="value"><i>[?] {translate key="proposal.therapeuticArea.instruct"}</i></td>
        </tr>        
    </table> 
    <br/>
    <div id="healthConds">
        <table width="100%" class="data">
            {foreach from=$articleDetails.healthConds key=k item=healthCond}
                <tr valign="top"  {if $k == 0}id="firstHealthCond"{else}class="healthCondSupp"{/if}>
                    <td width="20%" class="healthCondTitle">{if $k == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-healthConds" required="true" key="proposal.icd10s"}{else}&nbsp;{/if}</td>
                    <td width="20%" class="noHealthCondTitle" style="display: none;">&nbsp;</td>
                    <td width="80%" class="value">
                        <select name="articleDetails[healthConds][{$k}][code]" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$ICD10List selected=$articleDetails.healthConds.$k.code}
                        </select>
                        <a class="removeHealthCond" style="{if $k == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                        <br/>{translate key="proposal.icd10.exact"}: <input type="text" class="textField" name="articleDetails[healthConds][{$k}][exactCode]" value="{$articleDetails.healthConds.$k.exactCode|escape}" size="7" maxlength="7" />
                    </td>
                </tr>
                {if $k == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%" class="label">&nbsp;</td>
                        <td width="80%" class="value"><i>[?] {translate key="proposal.icd10s.instruct"}</i></td>
                    </tr>                    
                {/if}
            {/foreach}     
            <tr id="addAnotherHealthCond">
                <td width="20%">&nbsp;</td>
                <td width="80%"><a id="addAnotherHealthCondClick" style="cursor: pointer;">{translate key="proposal.addAnotherICD10"}</a></td>
            </tr>
        </table>
    </div>
    <br/>
    <div id="purposes">
        {foreach from=$purposes key=j item=purpose}
            <table width="100%" {if $j == 0}id="firstPurpose"{else}class="purposeSupp"{/if}>
                {if $purposes.$j.id}<input type="hidden" class="hiddenInputs" name="purposes[{$j|escape}][id]" value="{$purpose.id|escape}" />{/if}
                <tr valign="top"><td width="20%"></td><td width="12%"></td><td width="12%"></td><td width="56%"></td></tr>
                <tr valign="top">
                    <td width="20%" class="purposeTitle">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="purposes" required="true" key="proposal.purposes"}{else}&nbsp;{/if}</td>
                    <td width="20%" class="noPurposeTitle" style="display: none;">&nbsp;</td>
                    <td width="80" colspan="3" class="value">
                        {assign var="purposeInterventionalName" value='purposes['|cat:$j|cat:'][interventional]'}
                        {html_radios name=$purposeInterventionalName options=$interventionalRadios selected=$purposes.$j.interventional separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                        <a class="removePurpose" style="{if $j == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                    </td>
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%" class="label">&nbsp;</td>
                        <td width="80%" colspan="3" class="value"><i>[?] {translate key="proposal.purposes.instruct"}</i></td>
                    </tr>    
                {/if}
                <tr valign="top"><td width="20%"></td><td width="12%"></td><td width="12%"></td><td width="56%"></td></tr>
                {assign var="purposeTypeId" value='purposes-'|cat:$j|cat:'-type'}
                <tr valign="top" id="{$purposeTypeId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-type" required="true" key="proposal.purposes.type"}</td> 
                    <td width="68%" colspan="2" class="value">
                        {assign var="purposeTypeName" value='purposes['|cat:$j|cat:'][type]'}
                        <select name="{$purposeTypeName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$purposeTypesList selected=$purposes.$j.type}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="68%" colspan="2" class="value"><i>[?] {translate key="proposal.purposes.type.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="ctPhaseId" value='purposes-'|cat:$j|cat:'-ctPhase'}
                <tr valign="top" id="{$ctPhaseId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-ctPhase" required="true" key="proposal.purposes.ctPhase"}</td> 
                    <td width="68%" colspan="2" class="value">
                        {assign var="purposeCtPhaseName" value='purposes['|cat:$j|cat:'][ctPhase]'}
                        <select name="{$purposeCtPhaseName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$CTPhasesList selected=$purposes.$j.ctPhase}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="68%" colspan="2" class="value"><i>[?] {translate key="proposal.purposes.ctPhase.instruct"}</i></td>
                    </tr>    
                {/if}                
                {assign var="allocationId" value='purposes-'|cat:$j|cat:'-allocation'}
                <tr valign="top" id="{$allocationId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%" class="label">{fieldLabel name="purposes-studyDesign" key="proposal.purposes.studyDesign"}</td> 
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-allocation" required="true" key="proposal.purposes.allocation"}</td>                     
                    <td width="56%" class="value">
                        {assign var="purposeAllocationName" value='purposes['|cat:$j|cat:'][allocation]'}
                        <select name="{$purposeAllocationName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$allocationsList selected=$purposes.$j.allocation}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>                        
                        <td width="56%" class="value"><i>[?] {translate key="proposal.purposes.allocation.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="maskingId" value='purposes-'|cat:$j|cat:'-masking'}
                <tr valign="top" id="{$maskingId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-masking" required="true" key="proposal.purposes.masking"}</td> 
                    <td width="56%" class="value">
                        {assign var="purposeMaskingName" value='purposes['|cat:$j|cat:'][masking]'}
                        <select name="{$purposeMaskingName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$maskingList selected=$purposes.$j.masking}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>                        
                        <td width="56%" class="value"><i>[?] {translate key="proposal.purposes.masking.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="controlId" value='purposes-'|cat:$j|cat:'-control'}
                <tr valign="top" id="{$controlId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-control" required="true" key="proposal.purposes.control"}</td> 
                    <td width="56%" class="value">
                        {assign var="purposeControlName" value='purposes['|cat:$j|cat:'][control]'}
                        <select name="{$purposeControlName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$controlList selected=$purposes.$j.control}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>                        
                        <td width="56%" class="value"><i>[?] {translate key="proposal.purposes.control.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="assignmentId" value='purposes-'|cat:$j|cat:'-assignment'}
                <tr valign="top" id="{$assignmentId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-assignment" required="true" key="proposal.purposes.assignment"}</td> 
                    <td width="56%" class="value">
                        {assign var="purposeAssignmentName" value='purposes['|cat:$j|cat:'][assignment]'}
                        <select name="{$purposeAssignmentName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$assignmentList selected=$purposes.$j.assignment}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>                        
                        <td width="56%" class="value"><i>[?] {translate key="proposal.purposes.assignment.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="endpointId" value='purposes-'|cat:$j|cat:'-endpoint'}
                <tr valign="top" id="{$endpointId|escape}" style="display:none">
                    <td width="20%">&nbsp;</td>
                    <td width="12%">&nbsp;</td>
                    <td width="12%" class="label">{if $j == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="purposes-endpoint" required="true" key="proposal.purposes.endpoint"}</td> 
                    <td width="56%" class="value">
                        {assign var="purposeEndpointName" value='purposes['|cat:$j|cat:'][endpoint]'}
                        <select name="{$purposeEndpointName|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$endpointList selected=$purposes.$j.endpoint}
                        </select>
                    </td>                     
                </tr>
                {if $j == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>
                        <td width="12%" class="label">&nbsp;</td>                        
                        <td width="56%" class="value"><i>[?] {translate key="proposal.purposes.endpoint.instruct"}</i></td>
                    </tr>    
                {/if}
                {assign var="separatorId" value='purposes-'|cat:$j|cat:'-separator'}
                <tr valign="top" id="{$separatorId|escape}" style="display:none"><td colspan="4">&nbsp;</td></tr>
            </table>
        {/foreach}     
        <table width="100%" class="data">
            <tr id="addAnotherPurpose">
                <td width="20%">&nbsp;</td>
                <td width="80%" width="80%"><a id="addAnotherPurposeClick" style="cursor: pointer;">{translate key="proposal.addAnotherPurpose"}</a></td>
            </tr>
        </table>            
    </div>
    <br/>
    <div id="texts">
        <table width="100%" class="data">

            {foreach from=$articleTextLocales item=localeName key=localeKey}

                {assign var="articleText" value=$articleTexts[$localeKey]}

                <tr valign="top" id="descriptionField">
                    <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="description" required="true" key="proposal.description"} ({$localeName})</td>
                    <td width="80%" class="value"><textarea  class="textArea" rows="5" cols="70" name="articleTexts[{$localeKey|escape}][description]" id="description" maxlength="1200">{$articleText.description|escape}</textarea><br/><i>300 {translate key="proposal.xWordsMax"}</i></td>
                </tr>
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="80%" class="value"><i>[?] {translate key="proposal.description.instruct"}</i></td>
                </tr>    
                <tr valign="top" id="keyInclusionCriteriaField">
                    <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="keyInclusionCriteria" required="true" key="proposal.keyInclusionCriteria"} ({$localeName})</td>
                    <td width="80%" class="value"><textarea  class="textArea" rows="5" cols="70" name="articleTexts[{$localeKey|escape}][keyInclusionCriteria]" id="keyInclusionCriteria" maxlength="1200">{$articleText.keyInclusionCriteria|escape}</textarea><br/><i>300 {translate key="proposal.xWordsMax"}</i></td>
                </tr>
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="80%" class="value"><i>[?] {translate key="proposal.keyInclusionCriteria.instruct"}</i></td>
                </tr>                    
                <tr valign="top" id="keyExclusionCriteriaField">
                    <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="keyExclusionCriteria" required="true" key="proposal.keyExclusionCriteria"} ({$localeName})</td>
                    <td width="80%" class="value"><textarea  class="textArea" rows="5" cols="70" name="articleTexts[{$localeKey|escape}][keyExclusionCriteria]" id="keyExclusionCriteria" maxlength="1200">{$articleText.keyExclusionCriteria|escape}</textarea><br/><i>300 {translate key="proposal.xWordsMax"}</i></td>
                </tr>
                <tr valign="top" hidden class="showHideHelpField">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="80%" class="value"><i>[?] {translate key="proposal.keyExclusionCriteria.instruct"}</i></td>
                </tr>                    
                
            {/foreach}
        </table>
    </div>
    <br/>
    <div id="primaryOutcomes">
        {foreach from=$primaryOutcomes key=l item=primaryOutcome}
            {assign var="primaryOutcomeId" value='primaryOutcomes-'|cat:$l}
            <table width="100%" class="data" id="{$primaryOutcomeId|escape}" {if $l != 0}class="primaryOutcomeSupp"{/if}>
                <tr valign="top"><td width="20%"></td><td width="15%"></td><td width="65%"></td></tr>
                {assign var="firstLocale" value=1}
                {foreach from=$articleTextLocales item=localeName key=localeKey}
                    {assign var="primaryOutcomeIdLocaleTitle" value='primaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey}
                    {assign var="primaryOutcomeNameIdLocale" value='primaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-name'}
                    {assign var="primaryOutcomeNameIdLocaleInput" value='primaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][name]'}
                    {assign var="primaryOutcomeMeasurementIdLocale" value='primaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-measurement'}
                    {assign var="primaryOutcomeMeasurementIdLocaleInput" value='primaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][measurement]'}
                    {assign var="primaryOutcomeTimepointIdLocale" value='primaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-timepoint'}
                    {assign var="primaryOutcomeTimepointIdLocaleInput" value='primaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][timepoint]'}
                    <tr valign="top" id="{$primaryOutcomeIdLocaleTitle|escape}">
                        <td width="20%" class="primaryOutcomeTitle" {if $l > 0}style="display: none;"{/if}>{if $firstLocale == 1}{if $l == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name="primaryOutcomes" required="true" key="proposal.primaryOutcomes"}{else}&nbsp;{/if}</td>
                        <td width="20%" class="noPrimaryOutcomeTitle" {if $l == 0}style="display: none;"{/if}>&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$primaryOutcomeNameIdLocale required="true" key="proposal.primaryOutcome.name"}</td>
                        <td width="65%" class="value">
                            {if $primaryOutcomes.$l.$localeKey.primaryOutcomeId}<input type="hidden" class="hiddenInputs" name="primaryOutcomes[{$l|escape}][{$localeKey|escape}][primaryOutcomeId]" value="{$primaryOutcomes.$l.$localeKey.primaryOutcomeId|escape}" />{/if}
                            <input type="text" class="textField" name={$primaryOutcomeNameIdLocaleInput|escape} id={$primaryOutcomeNameIdLocale|escape} value="{$primaryOutcomes.$l.$localeKey.name|escape}" size="40" maxlength="255" />
                            ({$localeName})
                            {if $firstLocale == 1}<a class="removePrimaryOutcome" style="{if $l == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>{/if}
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$primaryOutcomeMeasurementIdLocale required="true" key="proposal.primaryOutcome.measurement"}</td>
                        <td width="65%" class="value">
                            <input type="text" class="textField" name={$primaryOutcomeMeasurementIdLocaleInput|escape} id={$primaryOutcomeMeasurementIdLocale|escape} value="{$primaryOutcomes.$l.$localeKey.measurement|escape}" size="40" maxlength="255" />
                            ({$localeName})
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$primaryOutcomeTimepointIdLocale required="true" key="proposal.primaryOutcome.timepoint"}</td>
                        <td width="65%" class="value">
                            <input type="text" class="textField" name={$primaryOutcomeTimepointIdLocaleInput|escape} id={$primaryOutcomeTimepointIdLocale|escape} value="{$primaryOutcomes.$l.$localeKey.timepoint|escape}" size="40" maxlength="255" />
                            ({$localeName})
                        </td>
                    </tr>
                    {math assign="firstLocale" equation="firstLocale +1" firstLocale=$firstLocale}
                {/foreach}    
                {if $l == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%" class="label">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.primaryOutcomes.instruct"}</i></td>
                    </tr>                    
                {/if}
                <tr valign="top"><td colspan="3">&nbsp;</td></tr>
            </table>
        {/foreach}
        <table width="100%" class="data">
            <tr id="addAnotherPrimaryOutcome">
                <td width="20%">&nbsp;</td>
                <td width="80%" colspan="2"><a id="addAnotherPrimaryOutcomeClick" style="cursor: pointer;">{translate key="proposal.primaryOutcome.add"}</a></td>
            </tr>
        </table>
    </div>
    <br/>
    <div id="secondaryOutcomes">
        {foreach from=$secondaryOutcomes key=l item=secondaryOutcome}
            {assign var="secondaryOutcomeId" value='secondaryOutcomes-'|cat:$l}
            <table width="100%" class="data" id="{$secondaryOutcomeId|escape}" {if $l != 0}class="secondaryOutcomeSupp"{/if}>
                <tr valign="top"><td width="20%"></td><td width="15%"></td><td width="65%"></td></tr>
                {assign var="firstLocale" value=1}
                {foreach from=$articleTextLocales item=localeName key=localeKey}
                    {assign var="secondaryOutcomeIdLocaleTitle" value='secondaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey}
                    {assign var="secondaryOutcomeNameIdLocale" value='secondaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-name'}
                    {assign var="secondaryOutcomeNameIdLocaleInput" value='secondaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][name]'}
                    {assign var="secondaryOutcomeMeasurementIdLocale" value='secondaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-measurement'}
                    {assign var="secondaryOutcomeMeasurementIdLocaleInput" value='secondaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][measurement]'}
                    {assign var="secondaryOutcomeTimepointIdLocale" value='secondaryOutcomes-'|cat:$l|cat:'-'|cat:$localeKey|cat:'-timepoint'}
                    {assign var="secondaryOutcomeTimepointIdLocaleInput" value='secondaryOutcomes['|cat:$l|cat:']['|cat:$localeKey|cat:'][timepoint]'}
                    <tr valign="top" id="{$secondaryOutcomeIdLocaleTitle|escape}">
                        <td width="20%" class="secondaryOutcomeTitle" {if $l > 0}style="display: none;"{/if}>{if $firstLocale == 1}{if $l == 0}<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {/if}{fieldLabel name=$secondaryOutcomeIdLocaleTitle key="proposal.secondaryOutcomes"}{else}&nbsp;{/if}</td>
                        <td width="20%" class="noSecondaryOutcomeTitle" {if $l == 0}style="display: none;"{/if}>&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$secondaryOutcomeNameIdLocale key="proposal.secondaryOutcome.name"}</td>
                        <td width="65%" class="value">
                            {if $primaryOutcomes.$l.$localeKey.secondaryOutcomeId}<input type="hidden" class="hiddenInputs" name="srimaryOutcomes[{$l|escape}][{$localeKey|escape}][secondaryOutcomeId]" value="{$secondaryOutcomes.$l.$localeKey.secondaryOutcomeId|escape}" />{/if}
                            <input type="text" class="textField" name={$secondaryOutcomeNameIdLocaleInput|escape} id={$secondaryOutcomeNameIdLocale|escape} value="{$secondaryOutcomes.$l.$localeKey.name|escape}" size="40" maxlength="255" />
                            ({$localeName})
                            {if $firstLocale == 1}<a class="removeSecondaryOutcome" style="{if $l == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>{/if}
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$secondaryOutcomeMeasurementIdLocale key="proposal.secondaryOutcome.measurement"}</td>
                        <td width="65%" class="value">
                            <input type="text" class="textField" name={$secondaryOutcomeMeasurementIdLocaleInput|escape} id={$secondaryOutcomeMeasurementIdLocale|escape} value="{$secondaryOutcomes.$l.$localeKey.measurement|escape}" size="40" maxlength="255" />
                            ({$localeName})
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="20%">&nbsp;</td>
                        <td width="15%" class="label">{fieldLabel name=$secondaryOutcomeTimepointIdLocale key="proposal.secondaryOutcome.timepoint"}</td>
                        <td width="65%" class="value">
                            <input type="text" class="textField" name={$secondaryOutcomeTimepointIdLocaleInput|escape} id={$secondaryOutcomeTimepointIdLocale|escape} value="{$secondaryOutcomes.$l.$localeKey.timepoint|escape}" size="40" maxlength="255" />
                            ({$localeName})
                        </td>
                    </tr>
                    {math assign="firstLocale" equation="firstLocale +1" firstLocale=$firstLocale}
                {/foreach}     
                {if $l == 0}
                    <tr valign="top" hidden class="showHideHelpField">
                        <td width="20%" class="label">&nbsp;</td>
                        <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.secondaryOutcomes.instruct"}</i></td>
                    </tr>                    
                {/if}                
                <tr valign="top"><td colspan="3">&nbsp;</td></tr>
            </table>
        {/foreach}
        <table width="100%" class="data">
            <tr id="addAnotherSecondaryOutcome">
                <td width="20%">&nbsp;</td>
                <td width="80%" colspan="2"><a id="addAnotherSecondaryOutcomeClick" style="cursor: pointer;">{translate key="proposal.secondaryOutcome.add"}</a></td>
            </tr>
        </table>
    </div>  
    <br/>   
    <div id="ages">
        <table width="100%" class="data">
            <tr valign="middle">
                <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-minAgeNum" required="true" key="proposal.age.minimum"}</td>
                <td width="25%" class="value">
                    <input type="text" class="numField" name="articleDetails[minAgeNum]" value="{$articleDetails.minAgeNum|escape}" size="5" maxlength="9" />
                    &nbsp;<i>{translate key="proposal.age.int"}</i>
                </td>
                <td width="5%" class="label" align="center">{fieldLabel name="articleDetails-minAgeUnit" key="proposal.age.unit"}</td>
                <td width="50%" class="value">
                    <select name="articleDetails[minAgeUnit]" class="selectMenu">
                        {html_options options=$ageUnitList selected=$articleDetails.minAgeUnit}
                    </select>
                </td>
            </tr>
            <tr valign="top" hidden class="showHideHelpField">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" colspan="3" class="value"><i>[?] {translate key="proposal.age.minimum.instruct"}</i></td>
            </tr>               
            <tr valign="middle">
                <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-maxAgeNum" required="true" key="proposal.age.maximum"}</td>
                <td width="25%" class="value">
                    <input type="text" class="numField" name="articleDetails[maxAgeNum]" value="{$articleDetails.maxAgeNum|escape}" size="5" maxlength="9" />
                    &nbsp;<i>{translate key="proposal.age.int"}</i>
                </td>
                <td width="5%" class="label" align="center">{fieldLabel name="articleDetails-maxAgeUnit" key="proposal.age.unit"}</td>
                <td width="50%" class="value">
                    <select name="articleDetails[maxAgeUnit]" class="selectMenu">
                        {html_options options=$ageUnitList selected=$articleDetails.maxAgeUnit}
                    </select>
                </td>
            </tr>
            <tr valign="top" hidden class="showHideHelpField">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" colspan="3" class="value"><i>[?] {translate key="proposal.age.maximum.instruct"}</i></td>
            </tr>               

        </table>
    </div>
    <table width="100%" class="data">
        <tr valign="middle">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-sex" required="true" key="proposal.sex"}</td>
            <td width="80%" class="value">
                <select name="articleDetails[sex]" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$sexList selected=$articleDetails.sex}
                </select>
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.sex.instruct"}</i></td>
        </tr>
        <tr valign="middle">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-healthy" required="true" key="proposal.healthy"}</td>
            <td width="80%" class="value">
                {html_radios name="articleDetails[healthy]" options=$yesNoList selected=$articleDetails.healthy separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.healthy.instruct"}</i></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr valign="middle">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {$coveringArea|escape} {fieldLabel name="articleDetails-localeSampleSize" required="true" key="proposal.localeSampleSize"}</td>
            <td width="80%" class="value">
                <input type="text" class="numField" name="articleDetails[localeSampleSize]" value="{$articleDetails.localeSampleSize|escape}" size="5" maxlength="10" />
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.localeSampleSize.instruct"}</i></td>
        </tr>
        <tr valign="middle">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-multinational" required="true" key="proposal.multinational"} {$coveringArea|escape}</td>
            <td width="80%" class="value">
                {html_radios name="articleDetails[multinational]" options=$yesNoList selected=$articleDetails.multinational separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.multinational.instruct"}</i></td>
        </tr>
    </table>
            
    <div id="intSampleSizeFields">
        {foreach from=$articleDetails.intSampleSize key=m item=countryAndSize}
            {assign var="countryAndSizeId" value='articleDetails-intSampleSize-'|cat:$m}
            <table width="100%" id="{$countryAndSizeId|escape}" {if $m == 0}style="display:none"{else}class="countryAndSizeSupp"{/if}>
                <tr valign="middle">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="10%" class="label" align="right">{fieldLabel name="articleDetails-intSampleSize-"|cat:$m|cat:'-country' required="true" key="common.country"}</td>
                    <td width="70%" class="value">
                        {assign var="countryCode" value='articleDetails[intSampleSize]['|cat:$m|cat:'][country]'}
                        {assign var="countryCodeId" value='articleDetails-intSampleSize-'|cat:$m|cat:'-country'}                        
                        <select name="{$countryCode|escape}" id="{$countryCodeId|escape}" class="selectMenu">
                            <option value=""></option>
                            {html_options options=$coutryList selected=$articleDetails.intSampleSize.$m.country}
                        </select>     
                        <a class="removeIntCountry" style="{if $m == 0}display: none; {/if}cursor: pointer;">{translate key="common.remove"}</a>
                    </td>  
                </tr>
                <tr valign="middle">
                    <td width="20%" class="label">&nbsp;</td>
                    <td width="10%" class="label" align="right">{fieldLabel name="articleDetails-intSampleSize-"|cat:$m|cat:'-number' required="true" key="proposal.multinational.number"}</td>
                    <td width="70%" class="value" align="left">
                        {assign var="countryNumber" value='articleDetails[intSampleSize]['|cat:$m|cat:'][number]'}
                        {assign var="countryNumberId" value='articleDetails-intSampleSize-'|cat:$m|cat:'-number'}                        
                        <input type="text" class="numField" name="{$countryNumber|escape}" id="{$countryNumberId|escape}" value="{$articleDetails.intSampleSize.$m.number|escape}" size="5" maxlength="10" />
                    </td>                      
                </tr> 
                <tr><td colspan="3">&nbsp;</td></tr>
            </table>
        {/foreach}
        <table width="100%" class="data">
            <tr id="addAnotherIntCountry">
                <td width="20%">&nbsp;</td>
                <td width="80%" colspan="2"><a id="addAnotherIntCountryClick" style="cursor: pointer;">{translate key="proposal.multinational.add"}</a></td>
            </tr>
        </table>
    </div>
    <br/>
    <table width="100%" class="data" id="dates">
        <tr valign="top">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-expected" key="proposal.expectedDate"}</td>
            <td width="15%" class="label">{fieldLabel name="articleDetails-startDate" required="true" key="proposal.startDate"}</td>
            <td width="65%" class="value"><input type="text" class="datePickerNoDays" name="articleDetails[startDate]" id="startDate" value="{$articleDetails.startDate|escape}" size="20" maxlength="255" /></td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="15%" class="label">{fieldLabel name="articleDetails-endDate" required="true" key="proposal.endDate"}</td>
            <td width="65%" class="value"><input type="text" class="datePickerNoDays" name="articleDetails[endDate]" id="endDate" value="{$articleDetails.endDate|escape}" size="20" maxlength="255" /></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.expectedDate.instruct"}</i></td>
        </tr>
    </table>  
    <br/>
    <table width="100%" class="data" id="recruitment">
        <tr valign="middle">
            <td width="20%" class="label">{fieldLabel name="articleDetails-recruitStatus" key="proposal.recruitment"}</td>
            <td width="15%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-recruitStatus" required="true" key="proposal.recruitment.status"}</td>
            <td width="65%" class="value">
                <select name="articleDetails[recruitStatus]" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$recruitmentStatusMap selected=$articleDetails.recruitStatus}
                </select>     
            </td>  
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="15%" class="label">&nbsp;</td>
            <td width="65%" class="value"><i>[?] {translate key="proposal.recruitment.status.instruct"}</i></td>
        </tr>
        {foreach from=$articleTextLocales item=localeName key=localeKey}
            {assign var="articleText" value=$articleTexts[$localeKey]}
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="15%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleTexts-"|cat:$localeKey|cat:"-recruitmentInfo" key="proposal.recruitment.info"} ({$localeName})</td>
                <td width="65%" class="value"><textarea  class="textArea" rows="5" cols="50" name="articleTexts[{$localeKey|escape}][recruitmentInfo]" id="keyExclusionCriteria" maxlength="1200">{$articleText.recruitmentInfo|escape}</textarea><br/><i>300 {translate key="proposal.xWordsMax"}</i></td>
            </tr> 
            <tr valign="top" hidden class="showHideHelpField">
                <td width="20%" class="label">&nbsp;</td>
                <td width="15%" class="label">&nbsp;</td>
                <td width="65%" class="value"><i>[?] {translate key="proposal.recruitment.info.instruct"}</i></td>
            </tr>
        {/foreach}
        <tr valign="middle">
            <td width="20%" class="label">&nbsp;</td>
            <td width="15%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-adScheme" required="true" key="proposal.recruitment.adScheme"}</td>
            <td width="65%" class="value">
                {html_radios name="articleDetails[adScheme]" options=$yesNoList selected=$articleDetails.adScheme separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
            </td>
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="15%" class="label">&nbsp;</td>
            <td width="65%" class="value"><i>[?] {translate key="proposal.recruitment.adScheme.instruct"}</i></td>
        </tr>
    </table>
    <p><input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}');" /></p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep2.tpl"}