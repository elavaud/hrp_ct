{**
 * articleSponsors.tpl
 *
 * Subtemplate defining the submission metadata table for article drugs. Non-form implementation.
 *}

{literal}
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.showHideSponsorButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().parent().parent().nextAll('.showHideHelpSponsorField').first().is(':hidden')) {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpSponsorField').first().show();
                } else {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpSponsorField').first().hide();
                } 
            });});        
        });
    </script>
{/literal}

<table class="data" width="100%">
    {assign var="countFSource" value=1}
    {foreach from=$fundingSources item=fundingSource}
        {assign var="institution" value=$fundingSource->getInstitutionObject()}
        <tr valign="top">
            <td width="20%" class="label">{if $countFSource == 1}{translate key="proposal.articleSponsor.fundingSources"}{else}&nbsp;{/if}</td>
            <td width="80%" class="value"><ul><li><a class="showHideSponsorButton" style="cursor:pointer;">{$institution->getInstitutionName()|escape}</a></li></ul></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpSponsorField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value">
                <table class="data" width="100%">
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.acronym"}</td>
                        <td width="70%" class="value">{$institution->getInstitutionAcronym()|escape}</td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.type"}</td>
                        <td width="70%" class="value">{translate key=$institution->getInstitutionTypeKey()}</td>                        
                    </tr>                    
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.location"}</td>
                        <td width="70%" class="value">{$institution->getInstitutionInternationalText()|escape}</td>                        
                    </tr>   
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{if $institution->getInstitutionInternational() == $smarty.const.INSTITUTION_INTERNATIONAL}{translate key='proposal.articleSponsor.locationInternational'}{else}{translate key='proposal.articleSponsor.locationCountry'}{/if}</td>
                        <td width="70%" class="value">{$institution->getInstitutionLocationText()|escape}</td>                        
                    </tr>                                        
                </table>                
            </td>
        </tr>
        {assign var="countFSource" value=$countFSource+1}
    {/foreach}
    {assign var="institution" value=$pSponsor->getInstitutionObject()}
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.articleSponsor.primarySponsor"}</td>
        <td width="80%" class="value"><ul><li><a class="showHideSponsorButton" style="cursor:pointer;">{$institution->getInstitutionName()|escape}</a></li></ul></td>
    </tr>
    <tr valign="top" hidden class="showHideHelpSponsorField">
        <td width="20%" class="label">&nbsp;</td>
        <td width="80%" class="value">
            <table class="data" width="100%">
                <tr valign="top">
                    <td width="10%">&nbsp;</td>
                    <td width="20%" class="label">{translate key="proposal.articleSponsor.acronym"}</td>
                    <td width="70%" class="value">{$institution->getInstitutionAcronym()|escape}</td>                        
                </tr>
                <tr valign="top">
                    <td width="10%">&nbsp;</td>
                    <td width="20%" class="label">{translate key="proposal.articleSponsor.type"}</td>
                    <td width="70%" class="value">{translate key=$institution->getInstitutionTypeKey()}</td>                        
                </tr>                    
                <tr valign="top">
                    <td width="10%">&nbsp;</td>
                    <td width="20%" class="label">{translate key="proposal.articleSponsor.location"}</td>
                    <td width="70%" class="value">{$institution->getInstitutionInternationalText()|escape}</td>                        
                </tr>   
                <tr valign="top">
                    <td width="10%">&nbsp;</td>
                    <td width="20%" class="label">{if $institution->getInstitutionInternational() == $smarty.const.INSTITUTION_INTERNATIONAL}{translate key='proposal.articleSponsor.locationInternational'}{else}{translate key='proposal.articleSponsor.locationCountry'}{/if}</td>
                    <td width="70%" class="value">{$institution->getInstitutionLocationText()|escape}</td>                        
                </tr>                                        
            </table>                
        </td>
    </tr>
    {assign var="countSSponsor" value=1}
    {foreach from=$sSponsors item=sSponsor}
        {assign var="institution" value=$sSponsor->getInstitutionObject()}
        <tr valign="top">
            <td width="20%" class="label">{if $countSSponsor == 1}{translate key="proposal.articleSponsor.secondarySponsors"}{else}&nbsp;{/if}</td>
            <td width="80%" class="value"><ul><li><a class="showHideSponsorButton" style="cursor:pointer;">{$institution->getInstitutionName()|escape}</a></li></ul></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpSponsorField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value">
                <table class="data" width="100%">
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.acronym"}</td>
                        <td width="70%" class="value">{$institution->getInstitutionAcronym()|escape}</td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.type"}</td>
                        <td width="70%" class="value">{translate key=$institution->getInstitutionTypeKey()}</td>                        
                    </tr>                    
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{translate key="proposal.articleSponsor.location"}</td>
                        <td width="70%" class="value">{$institution->getInstitutionInternationalText()|escape}</td>                        
                    </tr>   
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="20%" class="label">{if $institution->getInstitutionInternational() == $smarty.const.INSTITUTION_INTERNATIONAL}{translate key='proposal.articleSponsor.locationInternational'}{else}{translate key='proposal.articleSponsor.locationCountry'}{/if}</td>
                        <td width="70%" class="value">{$institution->getInstitutionLocationText()|escape}</td>                        
                    </tr>                                        
                </table>                
            </td>
        </tr>
        {assign var="countSSponsor" value=$countSSponsor+1}
    {/foreach}
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.articleSponsor.croInvolved"}</td>
        <td width="80%" class="value"><ul><li>{translate key=$articleDetails->getYesNoKey($articleDetails->getCROInvolved())|escape}</li></ul></td>
    </tr>
    {foreach from=$CROs item=CRO}
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><ul><li><a class="showHideSponsorButton" style="cursor:pointer;">{$CRO->getName()|escape}</a></li></ul></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpSponsorField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value">
                <table class="data" width="100%">
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.location"}</td>
                        <td width="60%" class="value">{$CRO->getInternationalText()|escape}</td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{if $CRO->getInternational() == $smarty.const.CRO_INTERNATIONAL}{translate key="proposal.articleSponsor.locationInternational"}{else}{translate key="proposal.articleSponsor.cro.locationCountry"}{/if}</td>
                        <td width="60%" class="value">{$CRO->getLocationText()|escape}</td>                        
                    </tr>    
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.city"}</td>
                        <td width="60%" class="value">{$CRO->getCity()|escape}</td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.address"}</td>
                        <td width="60%" class="value">{$CRO->getAddress()|escape}</td>                        
                    </tr>
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.primaryPhone"}</td>
                        <td width="60%" class="value">{$CRO->getPrimaryPhone()|escape}</td>                        
                    </tr>
                    {if $CRO->getSecondaryPhone() != ''}
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.secondaryPhone"}</td>
                            <td width="60%" class="value">{$CRO->getSecondaryPhone()|escape}</td>                        
                        </tr>
                    {/if}
                    {if $CRO->getFax() != ''}
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.fax"}</td>
                            <td width="60%" class="value">{$CRO->getFax()|escape}</td>                        
                        </tr>
                    {/if}
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSponsor.cro.email"}</td>
                        <td width="60%" class="value">{$CRO->getEmail()|escape}</td>                        
                    </tr>                    
                </table>                
            </td>
        </tr>
    {/foreach}
    {assign var="delegationFiles" value=$articleDetails->getDelegationFiles()}
    <tr valign="top">
        <td width="20%" class="label">{translate key="article.suppFile.delegation"}</td>
        <td width="80%" class="value">
            <ul>
                {foreach from=$delegationFiles item=delegationFile}
                    <li><a class="file" href="{url op="download" path=$articleId|to_array:$delegationFile->getFileId()}">{$delegationFile->getOriginalFileName()|escape}</a></li>
                {/foreach}
            </ul>
        </td>
    </tr>
</table>