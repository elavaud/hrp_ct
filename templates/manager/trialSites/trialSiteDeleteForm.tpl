{**
 * trialSiteForm.tpl
 *
 * Form to create/modify a  trial site
 *
 *}
{strip}
    {assign var="pageTitle" value="trialSite.delete"}
    {assign var="pageCrumbTitle" value="trialSite.delete"}
    {include file="common/header.tpl"}
{/strip}

{literal}
     <script type="text/javascript">
         
        var confirmMessage = "{/literal}{translate key="trialSite.delete.replacementWarning"}{literal}";
                
        $(document).ready(
            function() {
                
                $('#replaceTrialSiteMessage').hide();
                $('#replaceTrialSiteWarning').hide();
                $('#replaceTrialSiteField').hide();            
                if (!$('#replacementTrialSite option[value="NA"]').length > 0){
                    $('#replacementTrialSite').append('<option value="NA"></option>');
                }
                $('#replacementTrialSite').val('NA');            
                
                $('#deleteButton').click(function () {return confirm(confirmMessage);});
            }
        );
    </script>
{/literal}

<form name="trialSiteDelete" method="post" action="{url op="deleteTrialSite" path="$trialSiteId"}">
    {include file="common/formErrors.tpl"}
    
    <h3>{$trialSiteToDelete->getTrialSiteName()}&nbsp;({$trialSiteToDelete->getTrialSiteAcronym()})</h3>
    <p><i>{translate key=$trialSiteToDelete->getTrialSiteTypeKey()}<br/>{$trialSiteToDelete->getTrialSiteLocationText()}</i></p>
    
    <div id="trialSiteForm">
        <table class="data" width="100%">
            <tr valign="top"><td colspan="2">&nbsp;</td></tr>
            <tr valign="top"><td colspan="2">&nbsp;</td></tr>
            <tr valign="top" id="replaceTrialSiteMessage">
                <td colspan="2">{translate key="trialSite.delete.replacementMessage"}</td>
            </tr>
            <tr valign="top"><td colspan="2">&nbsp;</td></tr>
            <tr valign="top" id="replaceTrialSiteWarning">
                <td colspan="2"><b><font color="red">{translate key="trialSite.delete.replacementWarning"}</font></b></td>
            </tr>
            <tr valign="top"><td colspan="2">&nbsp;</td></tr>
            <tr valign="top" id="replaceTrialSiteField">
                <td width="20%" class="label">{fieldLabel name="replacementTrialSite" required="true" key="trialSite.replacement"}</td>
                <td width="80%" class="value">
                    <select name="replacementTrialSite" id="replacementTrialSite" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$trialSitesList selected=$replacementTrialSite}
                    </select>
                </td>
            </tr>
        </table>
    </div>

<p><input type="submit" value="{translate key="trialSite.delete"}" id="deleteButton" class="button defaultButton" /> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="document.location.href='{url op="trialSites" escape=false}'" /></p>

</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>

{include file="common/footer.tpl"}