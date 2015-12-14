{**
 * articleSites.tpl
 *
 * Subtemplate defining the submission metadata table for article drugs. Non-form implementation.
 *}

{literal}
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.showHideSiteInfoButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().parent().parent().nextAll('.showHideHelpSiteInfoField').first().is(':hidden')) {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpSiteInfoField').first().show();
                } else {
                    $(this).parent().parent().parent().parent().nextAll('.showHideHelpSiteInfoField').first().hide();
                } 
            });});        
        });
    </script>
{/literal}

{foreach from=$articleSites item=articleSite}
    {assign var="trialSiteObject" value=$articleSite->getTrialSiteObject()}    
    <h5>{$trialSiteObject->getName()|escape}</h5>
    <table class="data" width="100%">
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleSite.site"}</td>
            <td width="80%" class="value"><ul><li><a class="showHideSiteInfoButton" style="cursor:pointer;">{$trialSiteObject->getName()|escape}</a></li></ul></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpSiteInfoField">
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
            <td width="20%" class="label">{translate key="proposal.articleSite.authority"}</td>
            <td width="80%" class="value"><ul><li><a class="showHideSiteInfoButton" style="cursor:pointer;">{$articleSite->getAuthority()|escape}</a></li></ul></td>
        </tr>
        <tr valign="top" hidden class="showHideHelpSiteInfoField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value">
                <table class="data" width="100%">
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSite.primaryPhone"}</td>
                        <td width="60%" class="value">{$articleSite->getPrimaryPhone()|escape}</td>
                    </tr>
                    {if $articleSite->getSecondaryPhone() != ''}
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.secondaryPhone"}</td>
                            <td width="60%" class="value">{$articleSite->getSecondaryPhone()|escape}</td>
                        </tr>
                    {/if}
                    {if $articleSite->getFax() != ''}
                        <tr valign="top">
                            <td width="10%">&nbsp;</td>
                            <td width="30%" class="label">{translate key="proposal.articleSite.fax"}</td>
                            <td width="60%" class="value">{$articleSite->getFax()|escape}</td>
                        </tr>
                    {/if}
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="proposal.articleSite.email"}</td>
                        <td width="60%" class="value">{$articleSite->getEmail()|escape}</td>
                    </tr>      
                    <tr valign="top">
                        <td width="10%">&nbsp;</td>
                        <td width="30%" class="label">{translate key="article.suppFile.endorsmentLetter"}</td>
                        <td width="60%" class="value">
                            {assign var="letters" value=$articleSite->getEndorsments()}    
                            {if !empty($letters)}
                                {foreach from=$letters item=letter}
                                    <a class="file" href="{url op="download" path=$articleId|to_array:$letter->getFileId()}">{$letter->getOriginalFileName()|escape}</a><br/>
                                {/foreach}                            
                            {/if}
                        </td>                            
                    </tr>
                </table>
            </td>
        </tr>
        <tr valign="top">
            <td width="20%" class="label">{translate key="proposal.articleSite.subjectsNumber"}</td>
            <td width="80%" class="value"><ul><li>{$articleSite->getSubjectsNumber()|escape}</li></ul></td>
        </tr>
        {assign var="countInvestigators" value=1}    
        {foreach from=$articleSite->getInvestigators() item=investigator}
            <tr valign="top">
                <td width="20%" class="label">
                    {if $countInvestigators == 1}{translate key="user.role.primaryInvestigator"}
                    {elseif $countInvestigators == 2}{translate key="user.role.coinvestigator"}
                    {else} &nbsp;
                    {/if}
                </td>
                <td width="80%" class="label"><ul><li><a class="showHideSiteInfoButton" style="cursor:pointer;">{$investigator->getFullName()|escape}</a></li></ul></td>
            </tr>
            <tr valign="top" hidden class="showHideHelpSiteInfoField">
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
                        {if $countInvestigators == 1}                            
                            <tr valign="top">
                                <td width="10%">&nbsp;</td>
                                <td width="30%" class="label">{translate key="article.suppFile.CV"}</td>
                                <td width="60%" class="value">
                                    {assign var="CVs" value=$articleSite->getCVs()}    
                                    {if !empty($CVs)}
                                        {foreach from=$CVs item=CV}
                                            <a class="file" href="{url op="download" path=$articleId|to_array:$CV->getFileId()}">{$CV->getOriginalFileName()|escape}</a><br/>
                                        {/foreach}                            
                                    {/if}
                                </td>                            
                            </tr>
                        {/if}
                    </table>
                </td>
            </tr>
            {assign var="countInvestigators" value=$countInvestigators+1}    
        {/foreach}
    </table>
{/foreach}

