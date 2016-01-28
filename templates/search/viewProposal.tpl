{strip}
    {assign var=pageTitle value="search.summary"}
    {include file="common/header.tpl"}
{/strip}

{if !$dateFrom}
    {assign var="dateFrom" value="--"}
{/if}

{if !$dateTo}
    {assign var="dateTo" value="--"}
{/if}

<form name="revise" action="{url op="advanced"}" method="post">
    <input type="hidden" name="query" value="{$query|escape}"/>
    <div style="display:none">
        {html_select_date prefix="dateFrom" time=$dateFrom all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
        {html_select_date prefix="dateTo" time=$dateTo all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
    </div>
</form>

<form name="generate" action="{url op="generateCSV"}" method="post">
    <input type="hidden" name="query" value="{$query|escape}"/>
    <div style="display:none">
        {html_select_date prefix="dateFrom" time=$dateFrom all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
        {html_select_date prefix="dateTo" time=$dateTo all_extra="class=\"selectMenu\"" year_empty="" month_empty="" day_empty="" start_year="-5" end_year="+1"}
    </div>
</form>

<div id="downloadCompletionReport">
    {if $status == STATUS_COMPLETED}
        <h3 align="right"><b><a href="{url op="downloadFinalReport" path=$articleId|to_array:$finalReport->getFileId()}" class="file">{translate key="search.downloadFinalReport"}</a></b></h3>
    {/if}
</div>
        
<div id="titleAndAbstract">
    <h4>{translate key="common.queue.short.articleDetails"}</h4>
    <br/>
    <table width="100%" class="data">
        {if $status == 11}
            <tr valign="top">
                <td class="label">&nbsp;</td>
                <td class="value">
                    Completion Report:&nbsp;&nbsp;&nbsp;&nbsp;
                    {foreach name="suppFiles" from=$suppFiles item=suppFile}
                        {if $suppFile->getType() == "Completion Report"}<br/>
                            <a href="{url op="downloadFile" path=$articleId|to_array:$suppFile->getFileId():$suppFile->getSuppFileId()}" class="file">{$suppFile->getFileName()|escape}</a>
                        {/if}
                    {foreachelse}
                        Not available.
                    {/foreach}
                </td>
            </tr>
        {/if}
    	<tr valign="top">
            <td class="label" width="20%">{translate key="proposal.scientificTitle"}</td>
            <td class="value">{$articleText->getScientificTitle()|escape}</td>
    	</tr>
        <tr valign="top">
            <td class="label" width="20%">{translate key="proposal.publicTitle"}</td>
            <td class="value">{$articleText->getPublicTitle()|escape}</td>
    	</tr>
    	<tr valign="top">
            <td class="label" width="20%">{translate key="common.proposalId"}</td>
            <td class="value">{$proposalId|escape}</td>
    	</tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleSecId"}</td>
            <td width="80%" class="value">
                {foreach from=$articleSecIds item=articleSecId}
                    {$articleSecId->getSecId()|escape} ({translate key=$articleSecId->getTypeKey()|escape})<br/>
                {/foreach}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.recruitment"}</td>
            <td width="80%" class="value">
                {translate key=$recruitmentStatusKey}<br/>
                {$articleText->getRecruitmentInfo()|escape}
            </td>
        </tr>    
    </table>
    <br/>
    <table width="100%" class="data">
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.therapeuticArea"}</td>
            <td width="80%" class="value">{$therapeuticArea|escape}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.icd10s"}</td>
            <td width="80%" class="value">
                {foreach from=$icd10s item=healthCond}
                    {$healthCond.code|escape}{if $healthCond.exactCode != ''} ({$healthCond.exactCode|escape}){/if}<br/>
                {/foreach}
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
                    <td width="80%" class="value">{translate key=$articlePurpose->getTypeKey()|escape}</td>
                </tr>
            {else}
                    <td width="80%" class="value">{translate key="proposal.purpose.type.int"}
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
                    </td>
                </tr>
            {/if}
            {assign var="countPurposes" value=$countPurposes+1}
        {/foreach}
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.description"}</td>
            <td width="80%" class="value">{$articleText->getDescription()|escape}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.keyInclusionCriteria"}</td>
            <td width="80%" class="value">{$articleText->getKeyInclusionCriteria()|escape}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.keyExclusionCriteria"}</td>
            <td width="80%" class="value">{$articleText->getKeyExclusionCriteria()|escape}</td>
        </tr>
        {assign var="countPOutcomes" value=1}
        {foreach from=$articlePrimaryOutcomes item=articleOutcomeLocales}
            <tr valign="top">
                <td width="20%" class="label">{if $countPOutcomes == 1}{translate key="proposal.primaryOutcomes"}{else}&nbsp;{/if}</td>
                <td width="80%" class="value">
                    {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                        {if $locale == $localeKey}
                            {$articleOutcome->getName()|escape}
                        {/if}
                    {/foreach}                            
                </td>
            </tr>            
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="20%" class="value">
                    <table width="100%" class="data">
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="20%" class="label">{translate key="proposal.primaryOutcome.measurement"}</td>
                            <td width="70%" class="value">
                                {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                    {if $locale == $localeKey}
                                        {$articleOutcome->getMeasurement()|escape}
                                    {/if}
                                {/foreach}
                            </td>                        
                        </tr>
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="20%" class="label">{translate key="proposal.primaryOutcome.timepoint"}</td>
                            <td width="70%" class="value">
                                {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                    {if $locale == $localeKey}
                                        {$articleOutcome->getTimepoint()|escape}
                                    {/if}
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
                    {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                        {if $locale == $localeKey}
                            {$articleOutcome->getName()|escape}
                        {/if}
                    {/foreach}                            
                </td>
            </tr>   
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="20%" class="value">
                    <table width="100%" class="data">
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="20%" class="label">{translate key="proposal.primaryOutcome.measurement"}</td>
                            <td width="70%" class="value">
                                {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                    {if $locale == $localeKey}
                                        {$articleOutcome->getMeasurement()|escape}
                                    {/if}
                                {/foreach}
                            </td>                        
                        </tr>
                        <tr valign="top">
                            <td width="10%" class="label">&nbsp;</td>
                            <td width="20%" class="label">{translate key="proposal.primaryOutcome.timepoint"}</td>
                            <td width="70%" class="value">
                                {foreach from=$articleOutcomeLocales item=articleOutcome  key=localeKey}
                                    {if $locale == $localeKey}
                                        {$articleOutcome->getTimepoint()|escape}
                                    {/if}
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
                {$minAge|escape}&nbsp;{translate key=$minAgeUnitKey}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.age.maximum"}</td>
            <td width="80%" class="value">
                {$maxAge|escape}&nbsp;{translate key=$maxAgeUnitKey}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.sex"}</td>
            <td width="80%" class="value">
                {translate key=$sexKey}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.healthy"}</td>
            <td width="80%" class="value">
                {translate key=$healthyYesNoKey}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{$coveringArea|escape} {translate key="proposal.localeSampleSize"}</td>
            <td width="80%" class="value">
                {$localeSampleSize|escape}
            </td>
        </tr>    
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.multinational"} {$coveringArea|escape}</td>
            <td width="80%" class="value">
                {translate key=$multinationalYesNoKey}
                {if $multinational == $smarty.const.ARTICLE_DETAIL_YES}
                    <br/>
                    {foreach from=$intSampleSizeArray item=countryAndNumberArray}
                        {assign var="country" value=$countryAndNumberArray.country}
                        &nbsp;&nbsp;&nbsp;&nbsp;{$coutryList.$country|escape}: {$countryAndNumberArray.number|escape}<br/>
                    {/foreach}
                {/if}
            </td>
        </tr>    
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.expectedDate"}</td>
            <td width="80%" class="label">{$startDate|escape}&nbsp;&nbsp;&nbsp; to &nbsp;&nbsp;&nbsp;{$endDate|escape}</td>        
        </tr> 
    </table>
    <br/>
    <table width="100%" class="data">
    </table>
</div>
        
<div id="sites">
    <h4>{translate key="common.queue.short.articleSites"}</h4>
    <br/>
    {foreach from=$articleSites item=articleSite}
        {assign var="trialSiteObject" value=$articleSite->getTrialSiteObject()}    
        <b>{$trialSiteObject->getName()|escape}</b>
        <table class="data" width="100%">
            <tr valign="top">
                <td width="20%" class="label">{translate key="proposal.articleSite.site"}</td>
                <td width="80%" class="value">{$trialSiteObject->getName()|escape}</td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value">
                    <table class="data" width="100%">
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.siteAddress"}</td>
                            <td width="60%" class="value">{$trialSiteObject->getAddress()|escape}</td>                        
                        </tr>
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.siteCity"}</td>
                            <td width="60%" class="value">{$trialSiteObject->getCity()|escape}</td>                        
                        </tr>                    
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.siteRegion"}</td>
                            <td width="60%" class="value">{$trialSiteObject->getRegionText()|escape}</td>                        
                        </tr>                                        
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.siteLicensure"}</td>
                            <td width="60%" class="value">{$trialSiteObject->getLicensure()|escape}</td>                        
                        </tr>                                        
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.siteAccreditation"}</td>
                            <td width="60%" class="value">{$trialSiteObject->getAccreditation()|escape}</td>                        
                        </tr>     
                    </table>                
                </td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{translate key="proposal.articleSite.subjectsNumber"}</td>
                <td width="80%" class="value">{$articleSite->getSubjectsNumber()|escape}</td>
            </tr>
            {assign var="investigator" value=$articleSite->getPrimaryInvestigator()}    
            <tr valign="top">
                <td width="20%" class="label">{translate key="user.role.primaryInvestigator"}</td>
                <td width="80%" class="label">{$investigator->getFullName()|escape}</td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value">
                    <table class="data" width="100%">
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.investigator.expertise"}</td>
                            <td width="60%" class="value">
                                {assign var="expertise" value=$investigator->getExpertise()}    
                                {$expertisesList.$expertise|escape}
                            </td>                            
                        </tr>
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.investigator.iPrimaryPhone"}</td>
                            <td width="60%" class="value">{$investigator->getPrimaryPhoneNumber()|escape}</td>                            
                        </tr>
                        {if $investigator->getSecondaryPhoneNumber() != ''}
                            <tr valign="top">
                                <td width="10%">&nbsp;</td>
                                <td width="30%" class="label">{translate key="proposal.articleSite.investigator.iSecondaryPhone"}</td>
                                <td width="60%" class="value">{$investigator->getSecondaryPhoneNumber()|escape}</td>                            
                            </tr>
                        {/if}
                        {if $investigator->getFaxNumber() != ''}
                            <tr valign="top">
                                <td width="10%">&nbsp;</td>
                                <td width="30%" class="label">{translate key="proposal.articleSite.investigator.iFax"}</td>
                                <td width="60%" class="value">{$investigator->getFaxNumber()|escape}</td>                            
                            </tr>
                        {/if}
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.investigator.iEmail"}</td>
                            <td width="60%" class="value">{$investigator->getEmail()|escape}</td>                            
                        </tr>
                    </table>
                </td>
            </tr>                
        </table>
        <br/>
    {/foreach}
</div>
    
<div id="sites">
    <h4>{translate key="common.queue.short.articleSponsors"}</h4>
    <br/>
    <table class="data" width="100%">
        {assign var="countFSource" value=1}
        {foreach from=$fundingSources item=fundingSource}
            {assign var="institution" value=$fundingSource->getInstitutionObject()}
            <tr valign="top">
                <td width="20%" class="label">{if $countFSource == 1}{translate key="proposal.articleSponsor.fundingSources"}{else}&nbsp;{/if}</td>
                <td width="80%" class="value">{$institution->getInstitutionName()|escape}</td>
            </tr>
            {assign var="countFSource" value=$countFSource+1}
        {/foreach}
        {assign var="institution" value=$pSponsor->getInstitutionObject()}
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleSponsor.primarySponsor"}</td>
            <td width="80%" class="value">{$institution->getInstitutionName()|escape}</td>
        </tr>
        {assign var="countSSponsor" value=1}
        {foreach from=$sSponsors item=sSponsor}
            {assign var="institution" value=$sSponsor->getInstitutionObject()}
            <tr valign="top">
                <td width="20%" class="label">{if $countSSponsor == 1}{translate key="proposal.articleSponsor.secondarySponsors"}{else}&nbsp;{/if}</td>
                <td width="80%" class="value">{$institution->getInstitutionName()|escape}</td>
            </tr>
            {assign var="countSSponsor" value=$countSSponsor+1}
        {/foreach}
    </table>
    <br/>
</div>
    
<div id="contacts">
    <h4>{translate key="common.queue.short.articleContact"}</h4>
    <br/>
    <table class="data" width="100%">
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleContact.pq"}</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.name"}</td>
            <td width="70%" class="value">{$contact->getPQName()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.affiliation"}</td>
            <td width="70%" class="value">{$contact->getPQAffiliation()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.address"}</td>
            <td width="70%" class="value">{$contact->getPQAddress()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.country"}</td>
            <td width="70%" class="value">
                {assign var="pqCountry" value=$contact->getPQCountry()}
                {$coutryList.$pqCountry|escape}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.phone"}</td>
            <td width="70%" class="value">{$contact->getPQPhone()}</td>
        </tr>
        {if $contact->getPQFax() != ''}
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="10%" class="label">{translate key="proposal.articleContact.fax"}</td>
                <td width="70%" class="value">{$contact->getPQFax()}</td>
            </tr>
        {/if}
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.email"}</td>
            <td width="70%" class="value">{$contact->getPQEmail()}</td>
        </tr>
        <tr valign="top">
            <td colspan="3">&nbsp;</td>
        </tr>       
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleContact.sq"}</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.name"}</td>
            <td width="70%" class="value">{$contact->getSQName()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.affiliation"}</td>
            <td width="70%" class="value">{$contact->getSQAffiliation()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.address"}</td>
            <td width="70%" class="value">{$contact->getSQAddress()}</td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.country"}</td>
            <td width="70%" class="value">
                {assign var="sqCountry" value=$contact->getSQCountry()}
                {$coutryList.$sqCountry|escape}
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.phone"}</td>
            <td width="70%" class="value">{$contact->getSQPhone()}</td>
        </tr>
        {if $contact->getPQFax() != ''}
            <tr valign="top">
                <td width="20%" class="label">&nbsp;</td>
                <td width="10%" class="label">{translate key="proposal.articleContact.fax"}</td>
                <td width="70%" class="value">{$contact->getSQFax()}</td>
            </tr>
        {/if}
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.email"}</td>
            <td width="70%" class="value">{$contact->getSQEmail()}</td>
        </tr>        
    </table>
</div>
{include file="common/footer.tpl"}

