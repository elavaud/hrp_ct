{**
 * step4.tpl
 *
 * Step 4 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step4"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

<div class="separator"></div>

<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}
      
    {foreach from=$articleSites key=i item=articleSite}
        {assign var="articleSiteDivId" value='articleSites-'|cat:$i}  
        {assign var="articleSiteTitleId" value='articleSites-'|cat:$i|cat:'-title'}          
        <div id="{$articleSiteDivId|escape}" {if $i != 0}class="siteSupp"{/if}>
            <table width="100%">
                <tr>
                    <td width="50%"><h2>{translate key="proposal.articleSite"} #<span id="{$articleSiteTitleId|escape}">{$i+1|escape}</span></h2></td>
                    <td width="50%"><input type="button"  class="removeSite" value="{translate key="proposal.articleSite.remove"}" style="{if $i == 0}display: none; {/if}" /></td>
                </tr>
            </table>
            {if $articleSites.$i.id}<input type="hidden" class="hiddenInputs" name="articleSites[{$i|escape}][id]" value="{$articleSites.$i.id|escape}" />{/if}
            <table width="100%" class="data">
                
            </table>
        </div>
    {/foreach}
    
    <p>
        <input type="button" value="{translate key="proposal.articleSite.add"}" class="button" id="addSiteClick" />        
        <input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> 
        <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" />
    </p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep4.tpl"}