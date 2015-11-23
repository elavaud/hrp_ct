{**
 * trialSiteForm.tpl
 *
 * Form to create/modify a trial site
 *
 *}
{strip}
    {assign var="pageTitle" value="trialSite.trialSite"}
    {assign var="pageCrumbTitle" value="trialSite.trialSite"}
    {include file="common/header.tpl"}
{/strip}
 
 <form name="trialSite" method="post" action="{url op="updateTrialSite" path="$trialSiteId"}">

    {include file="common/formErrors.tpl"}
    <div id="trialSiteForm">
        <table class="data" width="100%">
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="name" required="true" key="trialSite.name"}</td>
                <td width="80%" class="value"><input type="text" name="name" value="{$name}" id="name" size="40" maxlength="120" class="textField" /></td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="address" required="true" key="trialSite.address"}</td>
                <td width="80%" class="value"><input type="text" name="address" value="{$address}" id="address" size="20" maxlength="60" class="textField" /></td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="city" required="true" key="trialSite.city"}</td>
                <td width="80%" class="value"><input type="text" name="city" value="{$city}" id="address" size="20" maxlength="60" class="textField" /></td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="region" required="true" key="trialSite.region"}</td>
                <td width="80%" class="value">
                    <select name="region" id="region" class="selectMenu">
                        <option value=""></option>
                        {html_options options=$regions selected=$region}
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="licensure" required="true" key="trialSite.licensure"}</td>
                <td width="80%" class="value"><input type="text" name="licensure" value="{$licensure}" id="licensure" size="20" maxlength="60" class="textField" /></td>
            </tr>
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="accreditation" required="true" key="trialSite.accreditation"}</td>
                <td width="80%" class="value"><input type="text" name="accreditation" value="{$accreditation}" id="accreditation" size="20" maxlength="60" class="textField" /></td>
            </tr>
        </table>
    </div>

<p><input type="submit" value="{translate key="common.save"}" class="button defaultButton" /> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="document.location.href='{url op="trialSites" escape=false}'" /></p>

</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
{include file="common/footer.tpl"}

