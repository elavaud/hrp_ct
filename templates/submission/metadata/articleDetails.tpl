{**
 * articleDetails.tpl
 *
 * Subtemplate defining the submission metadata table for article details. Non-form implementation.
 *}

{literal}
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.showHideDetailsButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().parent().parent().nextAll('.showHideHelpDetailsField').first().is(':hidden')) {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpDetailsField').first().show();
                } else {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpDetailsField').first().hide();
                } 
            });});        
        });
    </script>
{/literal}

 <table class="data" width="100%">
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.scientificTitle"}</td>
        <td width="80%" class="value">
            <ul>
                {foreach from=$articleTexts item=articleText key=localeKey}
                    <li>{$articleText->getScientificTitle()|escape} ({$articleTextLocales.$localeKey|escape})</li>
                {/foreach}
            </ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.publicTitle"}</td>
        <td width="80%" class="value">
            <ul>            
                {foreach from=$articleTexts item=articleText key=localeKey}
                    <li>{$articleText->getPublicTitle()|escape} ({$articleTextLocales.$localeKey|escape})</li>
                {/foreach}
            </ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.articleSecId"}</td>
        <td width="80%" class="value">
            <ul>            
                {foreach from=$articleSecIds item=articleSecId}
                    <li>{$articleSecId->getSecId()|escape} ({translate key=$articleSecId->getTypeKey()|escape})</li>
                {/foreach}
            </ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.protocolVersion"}</td>
        <td width="80%" class="value"><ul><li>{$articleDetails->getProtocolVersion()|escape}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.therapeuticArea"}</td>
        <td width="80%" class="value"><ul><li>{$articleDetails->getRightTherapeuticAreaDisplay()|escape}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.icd10s"}</td>
        <td width="80%" class="value">
            <ul>            
                {foreach from=$articleDetails->getHealthCondDiseaseArrayToDisplay() item=healthCond}
                    <li>{$healthCond.code|escape}{if $healthCond.exactCode != ''} ({$healthCond.exactCode|escape}){/if}</li>
                {/foreach}
            </ul>
        </td>
    </tr>
    {assign var="countPurposes" value=1}
    {foreach from=$articlePurposes item=articlePurpose}
        {if $countPurposes == 1}
            <tr valign="top">
                <td width="20%" class="label">{translate key="proposal.purposes"}</td>
            {else}
                <tr valign="top">
                    <td width="20%" class="label">&nbsp;</td>
            {/if}
            {if $articlePurpose->getType() == $smarty.const.ARTICLE_PURPOSE_TYPE_OBS}
                <td width="80%" class="value"><ul><li>{translate key=$articlePurpose->getTypeKey()|escape}</li></ul></td>
            </tr>
            {else}
                <td width="80%" class="value"><ul><li>{translate key="proposal.purpose.type.int"}
                    <table width="100%" class="data">
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">{translate key="proposal.purposes.type"}</td>
                            <td width="80%" colspan="2" class="value">{translate key=$articlePurpose->getTypeKey()|escape}</td>
                        </tr>
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">{translate key="proposal.purposes.ctPhase"}</td>
                            <td width="80%" colspan="2" class="value">{translate key=$articlePurpose->getCTPhaseKey()|escape}</td>
                        </tr>
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">{translate key="proposal.purposes.studyDesign"}</td>
                            <td width="10%" class="label">{translate key="proposal.purposes.allocation"}</td>                            
                            <td width="70%" colspan="2" class="value">{translate key=$articlePurpose->getAllocationKey()|escape}</td>
                        </tr>
                        
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">&nbsp;</td>
                            <td width="10%" class="label">{translate key="proposal.purposes.masking"}</td>                            
                            <td width="70%" colspan="2" class="value">{translate key=$articlePurpose->getMaskingKey()|escape}</td>
                        </tr>
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">&nbsp;</td>
                            <td width="10%" class="label">{translate key="proposal.purposes.control"}</td>                            
                            <td width="70%" colspan="2" class="value">{translate key=$articlePurpose->getControlKey()|escape}</td>
                        </tr>
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">&nbsp;</td>
                            <td width="10%" class="label">{translate key="proposal.purposes.assignment"}</td>                            
                            <td width="70%" colspan="2" class="value">{translate key=$articlePurpose->getAssignmentKey()|escape}</td>
                        </tr>
                        <tr valign="top">
                            <td width="5%" class="label">&nbsp;</td>                            
                            <td width="15%" class="label">&nbsp;</td>
                            <td width="10%" class="label">{translate key="proposal.purposes.endpoint"}</td>                            
                            <td width="70%" colspan="2" class="value">{translate key=$articlePurpose->getEndpointKey()|escape}</td>
                        </tr>
                    </table>
                </li></ul></td>
            </tr>
            {/if}
        {assign var="countPurposes" value=$countPurposes+1}
    {/foreach}
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.description"}</td>
        <td width="80%" class="value">
            <ul>                        
                {foreach from=$articleTexts item=articleText key=localeKey}
                    <li>{$articleText->getDescription()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i></li>
                {/foreach}
            </ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.keyInclusionCriteria"}</td>
        <td width="80%" class="value">
            <ul>                        
                {foreach from=$articleTexts item=articleText key=localeKey}
                    <li>{$articleText->getKeyInclusionCriteria()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i></li>
                {/foreach}
            </ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.keyExclusionCriteria"}</td>
        <td width="80%" class="value">
            <ul>                        
                {foreach from=$articleTexts item=articleText key=localeKey}
                    <li>{$articleText->getKeyExclusionCriteria()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i></li>
                {/foreach}
            </ul>
        </td>
    </tr>
    {assign var="countPOutcomes" value=1}
    {foreach from=$articlePrimaryOutcomes item=articleOutcomeLocales}
        <tr valign="top">
            <td width="20%" class="label">{if $countPOutcomes == 1}{translate key="proposal.primaryOutcomes"}{else}&nbsp;{/if}</td>
            <td width="80%" class="value">
                <ul>
                    <li>
                        <a class="showHideDetailsButton" style="cursor:pointer;">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getName()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}                            
                        </a>
                    </li>
                </ul>
            </td>
        </tr>            
        <tr valign="top" hidden class="showHideHelpDetailsField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="20%" class="value">
                <table width="100%" class="data">
                    <tr valign="top">
                        <td width="10%" class="label">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.primaryOutcome.measurement"}</td>
                        <td width="70%" class="value">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getMeasurement()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}
                        </td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%" class="label">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.primaryOutcome.timepoint"}</td>
                        <td width="70%" class="value">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getTimepoint()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}
                        </td>                        
                    </tr>                    
                </table>
            </td>
        </tr>
        {assign var="countPOutcomes" value=$countPOutcomes+1}
    {/foreach}
    {assign var="countSOutcomes" value=1}
    {foreach from=$articleSecondaryOutcomes item=articleOutcomeLocales}
        <tr valign="top">
            <td width="20%" class="label">{if $countSOutcomes == 1}{translate key="proposal.secondaryOutcomes"}{else}&nbsp;{/if}</td>
            <td width="80%" class="label">
                <ul>
                    <li>
                        <a class="showHideDetailsButton" style="cursor:pointer;">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getName()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}                            
                        </a>
                    </li>
                </ul>
            </td>
        </tr>   
        <tr valign="top" hidden class="showHideHelpDetailsField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="20%" class="value">
                <table width="100%" class="data">
                    <tr valign="top">
                        <td width="10%" class="label">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.primaryOutcome.measurement"}</td>
                        <td width="70%" class="value">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getMeasurement()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}
                        </td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%" class="label">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.primaryOutcome.timepoint"}</td>
                        <td width="70%" class="value">
                            {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                {$articleOutcome->getTimepoint()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                            {/foreach}
                        </td>                        
                    </tr>                    
                </table>
            </td>
        </tr>
        {assign var="countSOutcomes" value=$countSOutcomes+1}
    {/foreach}
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.age.minimum"}</td>
        <td width="80%" class="value">
            <ul><li>{$articleDetails->getMinAgeNum()|escape}&nbsp;{translate key=$articleDetails->getMinAgeUnitKey()}</li></ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.age.maximum"}</td>
        <td width="80%" class="value">
            <ul><li>{$articleDetails->getMaxAgeNum()|escape}&nbsp;{translate key=$articleDetails->getMaxAgeUnitKey()}</li></ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.sex"}</td>
        <td width="80%" class="value">
            <ul><li>{translate key=$articleDetails->getSexKey()}</li></ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.healthy"}</td>
        <td width="80%" class="value">
            <ul><li>{translate key=$articleDetails->getYesNoKey($articleDetails->getHealthy())}</li></ul>
        </td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{$coveringArea|escape} {translate key="proposal.localeSampleSize"}</td>
        <td width="80%" class="value">
            <ul><li>{$articleDetails->getLocaleSampleSize()|escape}</li></ul>
        </td>
    </tr>    
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.multinational"} {$coveringArea|escape}</td>
        <td width="80%" class="value">
            <ul><li>{translate key=$articleDetails->getYesNoKey($articleDetails->getMultinational())}
                {if $articleDetails->getMultinational() == $smarty.const.ARTICLE_DETAIL_YES}
                    <br/>
                    {foreach from=$articleDetails->getIntSampleSizeArray() item=countryAndNumberArray}
                        {assign var="country" value=$countryAndNumberArray.country}
                        &nbsp;&nbsp;&nbsp;&nbsp;{$coutryList.$country|escape}: {$countryAndNumberArray.number|escape}<br/>
                    {/foreach}
                {/if}
            </li></ul>
        </td>
    </tr>    
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.expectedDate"}</td>
        <td width="80%" class="label"><ul><li>{translate key="proposal.startDate"}&nbsp;&nbsp;&nbsp;{$articleDetails->getStartDate()|escape}</li><li>{translate key="proposal.endDate"}&nbsp;&nbsp;&nbsp;{$articleDetails->getEndDate()|escape}</li></ul></td>        
    </tr> 
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.recruitment"}</td>
        <td width="80%" class="value">
            <ul>
                <li valign="top">
                    <table width="100%" class="data">
                        <tr valign="top">
                            <td width="20%" class="label">{translate key="proposal.recruitment.status"}</td>
                            <td width="80%" class="value">{translate key=$articleDetails->getRecruitmentStatusKey()}</td>                        
                        </tr>
                        <tr valign="top">
                            <td width="20%" class="label">{translate key="proposal.recruitment.info"}</td>
                            <td width="80%" class="value">
                                {foreach from=$articleTexts item=articleText key=localeKey}
                                    {$articleText->getRecruitmentInfo()|escape}&nbsp;<i>({$articleTextLocales.$localeKey|escape})<i><br/>
                                {/foreach}
                            </td>                        
                        </tr>
                        <tr valign="top">
                            <td width="20%" class="label">{translate key="proposal.recruitment.adScheme"}</td>
                            <td width="80%" class="value">
                                {translate key=$articleDetails->getYesNoKey($articleDetails->getAdvertisingScheme())}
                                {if $showAdvertisements}
                                    {foreach from=$advertisements item=advertisement}
                                        <br/><a class="file" href="{url op="download" path=$articleId|to_array:$advertisement->getFileId()}">{$advertisement->getOriginalFileName()|escape}</a>
                                    {/foreach}
                                {/if}
                            </td>                        
                        </tr>
                    </table>                    
                </li>
            </ul>
        </td>
    </tr>    
 </table>
