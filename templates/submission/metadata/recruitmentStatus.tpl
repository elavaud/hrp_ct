{**
 * articleDetails.tpl
 *
 * Form for changing the recruitment status of a proposal.
 *}

{strip}

{assign var="pageTitle" value="author.submit.changeRecruitmentStatus"}
{assign var="pageCrumbTitle" value="author.submit.changeRecruitmentStatus.short"}

{include file="common/header.tpl"}
{/strip}

{literal}
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.showHideHelpButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                    $(this).parent().parent().nextAll('.showHideHelpField').first().show();
                } else {
                    $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
                } 
            });});        
        });
    </script>
{/literal}

<form name="submit" method="post" action="{url op="saveRecruitmentStatus"}">
    
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    
    <table width="100%" class="data" id="recruitment">
        
        <tr valign="middle">
            <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleDetails-recruitStatus" required="true" key="proposal.recruitment.status"}</td>
            <td width="80%" class="value">
                <select name="recruitStatus" class="selectMenu">
                    {html_options options=$recruitmentStatusMap selected=$recruitStatus}
                </select>     
            </td>  
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td width="20%" class="label">&nbsp;</td>
            <td width="80%" class="value"><i>[?] {translate key="proposal.recruitment.status.instruct"}</i></td>
        </tr>
        
        {foreach from=$articleTextLocales item=localeName key=localeKey}
            {assign var="recruitmentInfo" value=$articleTexts[$localeKey]}
            <tr valign="top">
                <td width="20%" class="label"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {fieldLabel name="articleTexts-"|cat:$localeKey|cat:"-recruitmentInfo" key="proposal.recruitment.info"} ({$localeName})</td>
                <td width="80%" class="value"><textarea  class="textArea" rows="5" cols="50" name="articleTexts[{$localeKey|escape}]" maxlength="1200">{$recruitmentInfo|escape}</textarea><br/><i>300 {translate key="proposal.xWordsMax"}</i></td>
            </tr> 
            <tr valign="top" hidden class="showHideHelpField">            
                <td width="20%" class="label">&nbsp;</td>
                <td width="80%" class="value"><i>[?] {translate key="proposal.recruitment.info.instruct"}</i></td>
            </tr>
        {/foreach}
        
    </table>

    <p>
        <input type="submit" value="{translate key="common.save"}" class="button defaultButton" id="saveButton" /> 
        <input type="button" value="{translate key="common.cancel"}" class="button" onclick="history.go(-1)" />
    </p>
    
</form>

{include file="common/footer.tpl"}
