{**
 * step6.tpl
 *
 * Step 6 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step6"}
{include file="author/submit/submitHeader.tpl"}

{url|assign:"competingInterestGuidelinesUrl" page="information" op="competingInterestGuidelines"}

<div class="separator"></div>

<form name="submit" method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}
      
    <table width="100%">
        <tr valign="top">
            <td width="20%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="pq" required="true" key="proposal.articleContact.pq"}</td>                        
            <td width="15%">{fieldLabel name="pqName" required="true" key="proposal.articleContact.name"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="pqName" id="pqName" value="{$pqName|escape}" size="30" maxlength="255" /></td>                                           
        </tr> 
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%">&nbsp;</td>
            <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleContact.pq.instruct"}</i></td>
        </tr>            
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqAffiliation" required="true" key="proposal.articleContact.affiliation"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="pqAffiliation" id="pqAffiliation" value="{$pqAffiliation|escape}" size="30" maxlength="90" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqAddress" required="true" key="proposal.articleContact.address"}</td>                        
            <td width="65%" class="value"><textarea  class="textArea" rows="5" cols="70" name="pqAddress" id="pqAddress" maxlength="1200">{$pqAddress|escape}</textarea></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqCountry" required="true" key="proposal.articleContact.country"}</td>                        
            <td width="65%" class="value">
                <select name="pqCountry" id="pqCountry" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$coutryList selected=$pqCountry}                                
                </select>                
            </td>                                           
        </tr>
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqPhone" required="true" key="proposal.articleContact.phone"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="pqPhone" id="pqPhone" value="{$pqPhone|escape}" size="30" maxlength="24" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqFax" key="proposal.articleContact.fax"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="pqFax" id="pqFax" value="{$pqFax|escape}" size="30" maxlength="24" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="pqEmail" required="true" key="proposal.articleContact.email"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="pqEmail" id="pqEmail" value="{$pqEmail|escape}" size="30" maxlength="90" /></td>                                           
        </tr>                
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr valign="top">
            <td width="20%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="sq" required="true" key="proposal.articleContact.sq"}</td>                        
            <td width="15%">{fieldLabel name="sqName" required="true" key="proposal.articleContact.name"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="sqName" id="sqName" value="{$sqName|escape}" size="30" maxlength="255" /></td>                                           
        </tr> 
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%">&nbsp;</td>
            <td width="80%" colspan="2" class="value"><i>[?] {translate key="proposal.articleContact.sq.instruct"}</i></td>
        </tr>            
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqAffiliation" required="true" key="proposal.articleContact.affiliation"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="sqAffiliation" id="sqAffiliation" value="{$sqAffiliation|escape}" size="30" maxlength="90" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqAddress" required="true" key="proposal.articleContact.address"}</td>                        
            <td width="65%" class="value"><textarea  class="textArea" rows="5" cols="70" name="sqAddress" id="sqAddress" maxlength="1200">{$sqAddress|escape}</textarea></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqCountry" required="true" key="proposal.articleContact.country"}</td>                        
            <td width="65%" class="value">
                <select name="sqCountry" id="sqCountry" class="selectMenu">
                    <option value=""></option>
                    {html_options options=$coutryList selected=$sqCountry}                                
                </select>                
            </td>                                           
        </tr>
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqPhone" required="true" key="proposal.articleContact.phone"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="sqPhone" id="sqPhone" value="{$sqPhone|escape}" size="30" maxlength="24" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqFax" key="proposal.articleContact.fax"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="sqFax" id="sqFax" value="{$sqFax|escape}" size="30" maxlength="24" /></td>                                           
        </tr>                
        <tr valign="top">
            <td width="20%">&nbsp;</td>                        
            <td width="15%">{fieldLabel name="sqEmail" required="true" key="proposal.articleContact.email"}</td>                        
            <td width="65%" class="value"><input type="text" class="textField" name="sqEmail" id="sqEmail" value="{$sqEmail|escape}" size="30" maxlength="90" /></td>                                           
        </tr>                
    </table>
    
    <p><input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton"/> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" /></p>

</form>

{include file="common/footer.tpl"}

{include file="common/proposalSubmission/javascriptStep6.tpl"}