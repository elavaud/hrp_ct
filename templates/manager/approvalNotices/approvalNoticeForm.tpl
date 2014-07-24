{**
 * approvalNoticeForm.tpl
 *
 * Form to create/modify an approval notice
 *
 * $Id$
 *}
{strip}
	{assign var="pageTitle" value="manager.approvalNotice"}
	{assign var="pageCrumbTitle" value="manager.approvalNotice"}
	{include file="common/header.tpl"}
{/strip}

{literal}
<script type="text/javascript">
    function addCommittee(){
        var committeeHtml = '<tr valign="top" class="committeeSupp">' + $('#firstCommittee').html() + '</tr>';
        if ($("#approvalNoticeForm tr.committeeSupp")[0]){
            $('#approvalNoticeForm tr.committeeSupp:last').after(committeeHtml);
            $('#approvalNoticeForm tr.committeeSupp:last').find('select').attr('selectedIndex', 0);
            $('#approvalNoticeForm tr.committeeSupp:last').find('.removeCommittee').show();
            $('#approvalNoticeForm tr.committeeSupp:last').find('.removeCommittee').click(function(){$(this).closest('tr').remove();});
            $('#approvalNoticeForm tr.committeeSupp:last').find('.committeesTitle').hide();
            $('#approvalNoticeForm tr.committeeSupp:last').find('.noCommitteesTitle').show();
        } else {
            $('#firstCommittee').after(committeeHtml);
            $('#firstCommittee').next().find('select').attr('selectedIndex', 0);
            $('#approvalNoticeForm tr.committeeSupp').find('.removeCommittee').show();
            $('#approvalNoticeForm tr.committeeSupp').find('.removeCommittee').click(function(){$(this).closest('tr').remove();});
            $('#approvalNoticeForm tr.committeeSupp').find('.committeesTitle').hide();
            $('#approvalNoticeForm tr.committeeSupp').find('.noCommitteesTitle').show();
        }
    }

    function addReviewType(){
        var reviewTypeHtml = '<tr valign="top" class="reviewTypeSupp">' + $('#firstReviewType').html() + '</tr>';
        if ($("#approvalNoticeForm tr.reviewTypeSupp")[0]){
            $('#approvalNoticeForm tr.reviewTypeSupp:last').after(reviewTypeHtml);
            $('#approvalNoticeForm tr.reviewTypeSupp:last').find('select').attr('selectedIndex', 0);
            $('#approvalNoticeForm tr.reviewTypeSupp:last').find('.removeReviewType').show();
            $('#approvalNoticeForm tr.reviewTypeSupp:last').find('.removeReviewType').click(function(){$(this).closest('tr').remove();});
            $('#approvalNoticeForm tr.reviewTypeSupp:last').find('.reviewTypesTitle').hide();
            $('#approvalNoticeForm tr.reviewTypeSupp:last').find('.noReviewTypesTitle').show();
        } else {
            $('#firstReviewType').after(reviewTypeHtml);
            $('#firstReviewType').next().find('select').attr('selectedIndex', 0);
            $('#approvalNoticeForm tr.reviewTypeSupp').find('.removeReviewType').show();
            $('#approvalNoticeForm tr.reviewTypeSupp').find('.removeReviewType').click(function(){$(this).closest('tr').remove();});
            $('#approvalNoticeForm tr.reviewTypeSupp').find('.reviewTypesTitle').hide();
            $('#approvalNoticeForm tr.reviewTypeSupp').find('.noReviewTypesTitle').show();
        }
    }
    
    $(document).ready(
            function() {
                $("#addAnotherCommitteeClick").click(addCommittee);
                $('#approvalNoticeForm a.removeCommittee').each(function() {$(this).click(function(){$(this).closest('tr').remove();});});
                $("#addAnotherReviewTypeClick").click(addReviewType);
                $('#approvalNoticeForm a.removeReviewType').each(function() {$(this).click(function(){$(this).closest('tr').remove();});});            }
    );
        
</script>
{/literal}

<form name="approvalNotice" method="post" action="{url op="updateApprovalNotice" path="$approvalNoticeId"}">

    {include file="common/formErrors.tpl"}
    <div id="approvalNoticeForm">
        <table class="data" width="100%">
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="title" required="true" key="common.title"}</td>
                <td width="80%" class="value"><input type="text" name="title" value="{$title|escape}" id="title" size="40" maxlength="120" class="textField" /></td>
            </tr>
            
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="type" key="manager.approvalNotice.type"}</td>
                <td width="80%" class="value">
                    {html_radios name='type' options=$docTypesMap selected=$type separator='&nbsp;&nbsp;&nbsp;&nbsp;'}
                </td>
            </tr>
            
            {foreach from=$committees key=i item=committee}
                <tr valign="top" {if $i == 0}id="firstCommittee"{else}class="committeeSupp"{/if}>
                    <td width="20%" class="committeesTitle">{if $i == 0}{fieldLabel name="committees" key="manager.approvalNotice.committees.long"}{else}&nbsp;{/if}</td>
                    <td class="noCommitteesTitle" style="display: none;">&nbsp;</td>
                    <td width="80%" class="value">
                        <select name="committees[]" id="committees" class="selectMenu">
                            {html_options options=$committeesList selected=$committees[$i]}
                        </select>
                        <a class="removeCommittee" style="{if $i == 0}display: none; {/if}cursor: pointer;">&nbsp;&nbsp;{translate key="common.remove"}</a>
                    </td>
                </tr>
            {/foreach}      
            <tr id="addAnotherCommittee">
                <td width="20%">&nbsp;</td>
                <td><a id="addAnotherCommitteeClick" style="cursor: pointer;">{translate key="manager.approvalNotice.committee.add"}</a></td>
            </tr> 
            
            {foreach from=$reviewTypes key=i item=type}
                <tr valign="top" {if $i == 0}id="firstReviewType"{else}class="reviewTypeSupp"{/if}>
                    <td width="20%" class="reviewTypesTitle">{if $i == 0}{fieldLabel name="reviewTypes" key="manager.approvalNotice.reviewTypes.long"}{else}&nbsp;{/if}</td>
                    <td class="noReviewTypesTitle" style="display: none;">&nbsp;</td>
                    <td width="80%" class="value">
                        <select name="reviewTypes[]" id="reviewTypes" class="selectMenu">
                            {html_options options=$reviewTypesList selected=$reviewTypes[$i]}
                        </select>
                        <a class="removeReviewType" style="{if $i == 0}display: none; {/if}cursor: pointer;">&nbsp;&nbsp;{translate key="common.remove"}</a>
                    </td>
                </tr>
            {/foreach}      
            <tr id="addAnotherReviewType">
                <td width="20%">&nbsp;</td>
                <td><a id="addAnotherReviewTypeClick" style="cursor: pointer;">{translate key="manager.approvalNotice.reviewTypes.add"}</a></td>
            </tr>
        </table>
        
        <h6>{translate key="manager.approvalNotice.header"}</h6>
        <p>{translate key="manager.approvalNotice.header.description"}</p>

        <p><textarea name="APHeader" id="APHeader" rows="12" cols="100" class="textArea">{$APHeader|escape}</textarea></p>
        
        <h6>{translate key="manager.approvalNotice.body"}</h6>
        <p>{translate key="manager.approvalNotice.body.description"}</p>

        <p><textarea name="APBody" id="APBody" rows="30" cols="100" class="textArea">{$APBody|escape}</textarea></p>
        
        <h6>{translate key="manager.approvalNotice.footer"}</h6>
        <p>{translate key="manager.approvalNotice.footer.description"}</p>

        <p><textarea name="APFooter" id="APFooter" rows="12" cols="100" class="textArea">{$APFooter|escape}</textarea></p>
    </div>


    <div class="separator"></div>

    <p>
    <input type="submit" value="{translate key="common.save"}" class="button defaultButton" /> 
    <input type="button" value="{translate key="common.cancel"}" class="button" onclick="document.location.href='{url op="approvalNotices" escape=false}'" />
    </p>

</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
{include file="common/footer.tpl"}

