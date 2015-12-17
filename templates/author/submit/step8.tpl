{**
 * step8.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Step 8 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step8"}
{include file="author/submit/submitHeader.tpl"}

{literal}
    <script type="text/javascript">
        
        var SUPP_FILE_ENDORSMENT = "{/literal}{$smarty.const.SUPP_FILE_ENDORSMENT}{literal}";
        var SUPP_FILE_CV = "{/literal}{$smarty.const.SUPP_FILE_CV}{literal}";
        var SUPP_FILE_BROCHURE = "{/literal}{$smarty.const.SUPP_FILE_BROCHURE}{literal}";
        var SUPP_FILE_SMPC = "{/literal}{$smarty.const.SUPP_FILE_SMPC}{literal}";
        var SUPP_FILE_DELEGATION = "{/literal}{$smarty.const.SUPP_FILE_DELEGATION}{literal}";
        
        function checkSize(){
            var fileToUpload = document.getElementById('uploadSuppFile');
            var check = fileToUpload.files[0].fileSize;
            var valueInKb = Math.ceil(check/1024);
            if (check > 5242880){
                    alert ('{/literal}{translate key="common.fileTooBig1"}{literal}'+valueInKb+'{/literal}{translate key="common.fileTooBig2"}{literal}5 Mb.');
                    return false
            }
        }

        function showOrHideSites() {
            if($('#fileType').val() == SUPP_FILE_ENDORSMENT || $('#fileType').val() == SUPP_FILE_CV) {
                $('#articleSiteField').show();
                if($('#articleSite').find('option[value="NA"]').length > 0) {
                    $('#articleSite').find('option[value="NA"]').remove();
                }
                $('#articleDrugForIBField').hide();
                if (!$('#articleDrugForIB').find('option[value="NA"]').length > 0){
                    $('#articleDrugForIB').append('<option value="NA"></option>');
                }
                $('#articleDrugForIB').val('NA');
                $('#articleDrugForSmPCField').hide();
                if (!$('#articleDrugForSmPC').find('option[value="NA"]').length > 0){
                    $('#articleDrugForSmPC').append('<option value="NA"></option>');
                }
                $('#articleDrugForSmPC').val('NA');
                $('#articleCROField').hide();
                if (!$('#articleCRO').find('option[value="NA"]').length > 0){
                    $('#articleCRO').append('<option value="NA"></option>');
                }
                $('#articleCRO').val('NA');                
            } else if($('#fileType').val() == SUPP_FILE_BROCHURE ) {
                $('#articleDrugForIBField').show();
                if($('#articleDrugForIB').find('option[value="NA"]').length > 0) {
                    $('#articleDrugForIB').find('option[value="NA"]').remove();
                }
                $('#articleSiteField').hide();
                if (!$('#articleSite').find('option[value="NA"]').length > 0){
                    $('#articleSite').append('<option value="NA"></option>');
                }
                $('#articleSite').val('NA');
                $('#articleDrugForSmPCField').hide();
                if (!$('#articleDrugForSmPC').find('option[value="NA"]').length > 0){
                    $('#articleDrugForSmPC').append('<option value="NA"></option>');
                }
                $('#articleDrugForSmPC').val('NA');      
                $('#articleCROField').hide();
                if (!$('#articleCRO').find('option[value="NA"]').length > 0){
                    $('#articleCRO').append('<option value="NA"></option>');
                }
                $('#articleCRO').val('NA');                
            } else if($('#fileType').val() == SUPP_FILE_SMPC) {
                $('#articleDrugForSmPCField').show();
                if($('#articleDrugForSmPC').find('option[value="NA"]').length > 0) {
                    $('#articleDrugForSmPC').find('option[value="NA"]').remove();
                }
                $('#articleSiteField').hide();
                if (!$('#articleSite').find('option[value="NA"]').length > 0){
                    $('#articleSite').append('<option value="NA"></option>');
                }
                $('#articleSite').val('NA');
                $('#articleDrugForIBField').hide();
                if (!$('#articleDrugForIB').find('option[value="NA"]').length > 0){
                    $('#articleDrugForIB').append('<option value="NA"></option>');
                }
                $('#articleDrugForIB').val('NA');
                $('#articleCROField').hide();
                if (!$('#articleCRO').find('option[value="NA"]').length > 0){
                    $('#articleCRO').append('<option value="NA"></option>');
                }
                $('#articleCRO').val('NA');                
            } else if($('#fileType').val() == SUPP_FILE_DELEGATION) {
                $('#articleCROField').show();
                if($('#articleCRO').find('option[value="NA"]').length > 0) {
                    $('#articleCRO').find('option[value="NA"]').remove();
                }
                $('#articleDrugForSmPCField').hide();
                if (!$('#articleDrugForSmPC').find('option[value="NA"]').length > 0){
                    $('#articleDrugForSmPC').append('<option value="NA"></option>');
                }
                $('#articleDrugForSmPC').val('NA');                
                $('#articleSiteField').hide();
                if (!$('#articleSite').find('option[value="NA"]').length > 0){
                    $('#articleSite').append('<option value="NA"></option>');
                }
                $('#articleSite').val('NA');
                $('#articleDrugForIBField').hide();
                if (!$('#articleDrugForIB').find('option[value="NA"]').length > 0){
                    $('#articleDrugForIB').append('<option value="NA"></option>');
                }
                $('#articleDrugForIB').val('NA');
            } else {
                $('#articleSiteField').hide();
                if (!$('#articleSite').find('option[value="NA"]').length > 0){
                    $('#articleSite').append('<option value="NA"></option>');
                }
                $('#articleSite').val('NA');
                $('#articleDrugForSmPCField').hide();
                if (!$('#articleDrugForSmPC').find('option[value="NA"]').length > 0){
                    $('#articleDrugForSmPC').append('<option value="NA"></option>');
                }
                $('#articleDrugForSmPC').val('NA');                
                $('#articleDrugForIBField').hide();
                if (!$('#articleDrugForIB').find('option[value="NA"]').length > 0){
                    $('#articleDrugForIB').append('<option value="NA"></option>');
                }
                $('#articleDrugForIB').val('NA');
                $('#articleCROField').hide();
                if (!$('#articleCRO').find('option[value="NA"]').length > 0){
                    $('#articleCRO').append('<option value="NA"></option>');
                }
                $('#articleCRO').val('NA');                
            }        
        }
        
        // To replace the form validator
        function checkTypeAndSite() {
            if ($('#fileType').val() == "") {
                alert('{/literal}{translate key="author.submit.suppFile.typeRequired"}{literal}');
                return false;
            } else if($('#articleSite').val() == "") {
                alert('{/literal}{translate key="author.submit.suppFile.siteRequired"}{literal}');
                return false;                
            } else if($('#articleDrugForIB').val() == "") {
                alert('{/literal}{translate key="author.submit.suppFile.drugRequired"}{literal}');
                return false;                                
            } else if($('#articleDrugForSmPC').val() == "") {
                alert('{/literal}{translate key="author.submit.suppFile.drugRequired"}{literal}');
                return false;                                
            } else if($('#articleCRO').val() == "") {
                alert('{/literal}{translate key="author.submit.suppFile.croRequired"}{literal}');
                return false;                                
            }
        }
        
        $(document).ready(function() {

            $("a.showHideHelpButton").each(function() {$(this).click(function(){
                if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                    $(this).parent().parent().nextAll('.showHideHelpField').first().show();
                } else {
                    $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
                } 
            });});        

           $('#fileType').change(showOrHideSites);
           showOrHideSites();
           
        });

    </script>
{/literal}

<form name="submitForm" method="post" action="{url op="saveSubmit" path=$submitStep}" onSubmit="return checkSize()" enctype="multipart/form-data">
<input type="hidden" name="articleId" value="{$articleId|escape}" />
{include file="common/formErrors.tpl"}

<table class="listing" width="100%">
    <tr>
        <td colspan="5" class="headseparator">&nbsp;</td>
    </tr>
    <tr class="heading" valign="bottom">
        <td colspan="2" width="40%">{translate key="common.type"}</td>
        <td width="30%">&nbsp;&nbsp;{translate key="common.originalFileName"}</td>
        <td width="15%" class="nowrap">{translate key="common.dateUploaded"}</td>
        <td width="15%" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{translate key="common.action"}</td>
    </tr>
    <tr>
        <td colspan="5" class="headseparator">&nbsp;</td>
    </tr>
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.impd"}</td>
        {if empty($impds)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$impds item=impd}
                        <tr valign="top">
                            <td width="50%">{$impd->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$impd->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$impd->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.impd.instruct"}</i></td>
    </tr>   
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>    
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.approvalLetter"}</td>
        {if empty($approvalLetters)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$approvalLetters item=approvalLetter}
                        <tr valign="top">
                            <td width="50%">{$approvalLetter->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$approvalLetter->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$approvalLetter->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.approvalLetter.instruct"}</i></td>
    </tr>    
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.informedConsent"}</td>
        {if empty($informedConsents)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$informedConsents item=informedConsent}
                        <tr valign="top">
                            <td width="50%">{$informedConsent->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$informedConsent->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$informedConsent->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.informedConsent.instruct"}</i></td>
    </tr>
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.labels"}</td>
        {if empty($labelss)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$labelss item=labels}
                        <tr valign="top">
                            <td width="50%">{$labels->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$labels->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$labels->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.labels.instruct"}</i></td>
    </tr>
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.gmp"}</td>
        {if empty($gmps)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$gmps item=gmp}
                        <tr valign="top">
                            <td width="50%">{$gmp->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$gmp->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$gmp->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.gmp.instruct"}</i></td>
    </tr>
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.policy"}</td>
        {if empty($policies)}
            <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$policies item=policy}
                        <tr valign="top">
                            <td width="50%">{$policy->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$policy->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$policy->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.policy.instruct"}</i></td>
    </tr>
    {if $showAdvertisements}
        <tr>
            <td colspan="5" class="separator">&nbsp;</td>
        </tr>        
        <tr valign="top">
            <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.advertisements"}</td>
            {if empty($advertisements)}
                <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
            {else}
                <td colspan="3" align="left">
                    <table valign="top" width="100%">
                        {foreach from=$advertisements item=advertisement}
                            <tr valign="top">
                                <td width="50%">{$advertisement->getOriginalFileName()|escape}</td>
                                <td width="25%">&nbsp;{$advertisement->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                <td width="25%" align="right">
                                    <a href="{url op="deleteSubmitSuppFile" path=$advertisement->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </td>
            {/if}
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><i>[?] {translate key="author.submit.suppFile.advertisements.instruct"}</i></td>
        </tr>        
    {/if}
    {foreach from=$CROsArray item=CROArray}
        <tr>
            <td colspan="5" class="separator">&nbsp;</td>
        </tr>        
        <tr valign="top">
            <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.delegation"}: {$CROArray.name|escape}</td>
            {if empty($CROArray.delegations)}
                <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
            {else}
                <td colspan="3" align="left">
                    <table valign="top" width="100%">
                        {foreach from=$CROArray.delegations item=delegation}
                            <tr valign="top">
                                <td width="50%">{$delegation->getOriginalFileName()|escape}</td>
                                <td width="25%">&nbsp;{$delegation->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                <td width="25%" align="right">
                                    <a href="{url op="deleteSubmitSuppFile" path=$delegation->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </td>
            {/if}
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><i>[?] {translate key="author.submit.suppFile.delegation.instruct"}</i></td>
        </tr>  
    {/foreach}
    {foreach from=$drugsArray item=drugArray}
        <tr>
            <td colspan="5" class="separator">&nbsp;</td>
        </tr>                
        <tr valign="top">
            {if $drugArray.ib}
                <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.brochure"}: {$drugArray.name|escape} </td>
                {if empty($drugArray.ibs)}
                    <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
                {else}
                    <td colspan="3">
                        <table valign="top" width="100%">
                            {foreach from=$drugArray.ibs item=ib}
                                <tr valign="top">
                                    <td width="50%">{$ib->getOriginalFileName()|escape}</td>
                                    <td width="25%">&nbsp;{$ib->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                    <td width="25%" align="right">
                                        <a href="{url op="deleteSubmitSuppFile" path=$ib->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>                
                {/if}
            {else}
                <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.smpc"}: {$drugArray.name|escape} </td>
                {if empty($drugArray.smpcs)}
                    <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
                {else}
                    <td colspan="3">
                        <table valign="top" width="100%">
                            {foreach from=$drugArray.smpcs item=smpc}
                                <tr valign="top">
                                    <td width="50%">{$smpc->getOriginalFileName()|escape}</td>
                                    <td width="25%">&nbsp;{$smpc->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                    <td width="25%" align="right">
                                        <a href="{url op="deleteSubmitSuppFile" path=$smpc->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>                
                {/if}
            {/if}
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><i>[?] {if $drugArray.ib}{translate key="author.submit.suppFile.brochure.instruct"}{else}{translate key="author.submit.suppFile.smpc.instruct"}{/if}</i></td>
        </tr>
    {/foreach}
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    {foreach from=$sitesArray item=siteArray}
        <tr valign="top">
            <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$siteArray.name|escape}:</td>
        </tr>
        <tr>
            <td width="10%">&nbsp;</td>
            <td colspan="4" class="separator">&nbsp;</td>
        </tr>                
        <tr valign="top">
            <td width="10%">&nbsp;</td>
            <td width="30%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.endorsmentLetter"}</td>
            {if empty($siteArray.endorsmentLetters)}
                <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
            {else}
                <td colspan="3">
                    <table valign="top" width="100%">
                        {foreach from=$siteArray.endorsmentLetters item=endorsmentLetter}
                            <tr valign="top">
                                <td width="50%">{$endorsmentLetter->getOriginalFileName()|escape}</td>
                                <td width="25%">&nbsp;{$endorsmentLetter->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                <td width="25%" align="right">
                                    <a href="{url op="deleteSubmitSuppFile" path=$endorsmentLetter->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </td>                
            {/if}
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><i>[?] {translate key="author.submit.suppFile.endorsmentLetter.instruct"}</i></td>
        </tr>
        <tr>
            <td width="10%">&nbsp;</td>
            <td colspan="4" class="separator">&nbsp;</td>
        </tr>                
        <tr valign="top">
            <td width="10%">&nbsp;</td>
            <td width="30%"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.CV"}</td>
            {if empty($siteArray.CVs)}
                <td colspan="3" align="center"><font color="red">{translate key="article.suppFile.missing"}</font></td>
            {else}
                <td colspan="3">
                    <table valign="top" width="100%">
                        {foreach from=$siteArray.CVs item=CV}
                            <tr valign="top">
                                <td width="50%">{$CV->getOriginalFileName()|escape}</td>
                                <td width="25%">&nbsp;{$CV->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                                <td width="25%" align="right">
                                    <a href="{url op="deleteSubmitSuppFile" path=$CV->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </td>                
            {/if}
        </tr>
        <tr valign="top" hidden class="showHideHelpField">
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><i>[?] {translate key="author.submit.suppFile.CV.instruct"}</i></td>
        </tr>
    {/foreach}
    <tr>
        <td colspan="5" class="separator">&nbsp;</td>
    </tr>        
    <tr valign="top">
        <td colspan="2"><a class="showHideHelpButton" style="cursor:pointer;">[?]</a> {translate key="author.submit.suppFile.relatedPublications"}</td>
        {if empty($relatedPublications)}
            <td colspan="3" align="center">{translate key="article.suppFile.optional"}</td>
        {else}
            <td colspan="3" align="left">
                <table valign="top" width="100%">
                    {foreach from=$relatedPublications item=relatedPublication}
                        <tr valign="top">
                            <td width="50%">{$relatedPublication->getOriginalFileName()|escape}</td>
                            <td width="25%">&nbsp;{$relatedPublication->getDateSubmitted()|date_format:$dateFormatTrunc}</td>
                            <td width="25%" align="right">
                                <a href="{url op="deleteSubmitSuppFile" path=$relatedPublication->getSuppFileId() articleId=$articleId}" onclick="return confirm('{translate|escape:"jsparam" key="author.submit.confirmDeleteSuppFile"}')" class="action">{translate key="common.delete"}</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
        {/if}
    </tr>
    <tr valign="top" hidden class="showHideHelpField">
        <td colspan="2">&nbsp;</td>
        <td colspan="3"><i>[?] {translate key="author.submit.suppFile.relatedPublications.instruct"}</i></td>
    </tr>
</table>

<div class="separator"></div>
<br/><br/>

<table class="data" width="100%">
    <tr>
	<td width="20%" class="label">{fieldLabel name="fileType" required="true" key="author.submit.suppFileInstruct"}</td>
	<td width="80%" class="value">
            <select name="fileType" id="fileType" class="selectMenu">
                <option value=""></option>
                {html_options options=$typeOptions selected=$fileType}
            </select>
        </td>
    </tr>
    <tr id="articleDrugForIBField">
	<td width="20%" class="label">{fieldLabel name="articleDrugForIB" required="true" key="proposal.drugInfo"}</td>
	<td width="80%" class="value">
            <select name="articleDrugForIB" id="articleDrugForIB" class="selectMenu">
                <option value=""></option>
                {html_options options=$drugsListForIB selected=$articleDrugForIB}
            </select>
        </td>
    </tr>  
    <tr id="articleDrugForSmPCField">
	<td width="20%" class="label">{fieldLabel name="articleDrugForSmPC" required="true" key="proposal.drugInfo"}</td>
	<td width="80%" class="value">
            <select name="articleDrugForSmPC" id="articleDrugForSmPC" class="selectMenu">
                <option value=""></option>
                {html_options options=$drugsListForSMPC selected=$articleDrugForSmPC}
            </select>
        </td>
    </tr>    
    <tr id="articleSiteField">
	<td width="20%" class="label">{fieldLabel name="articleSite" required="true" key="proposal.articleSite"}</td>
	<td width="80%" class="value">
            <select name="articleSite" id="articleSite" class="selectMenu">
                <option value=""></option>
                {html_options options=$sitesList selected=$articleSite}
            </select>
        </td>
    </tr>
    <tr id="articleCROField">
	<td width="20%" class="label">{fieldLabel name="articleCRO" required="true" key="proposal.articleSponsor.croInvolved"}</td>
	<td width="80%" class="value">
            <select name="articleCRO" id="articleCRO" class="selectMenu">
                <option value=""></option>
                {html_options options=$CROsList selected=$articleCRO}
            </select>
        </td>
    </tr>
    <tr>
        <td width="30%" class="label">{fieldLabel required="true" key="author.submit.suppFileUploadInstruct"}</td>
        <td width="70%" class="value" colspan="2">
            <input type="file" name="uploadSuppFile" id="uploadSuppFile"  class="uploadField" />
            <input name="submitUploadSuppFile" type="submit" onclick="return checkTypeAndSite();" class="button" value="{translate key="common.upload"}" /> 
            {if $currentJournal->getSetting('showEnsuringLink')}<a class="action" href="javascript:openHelp('{get_help_id key="editorial.sectionEditorsRole.review.blindPeerReview" url="true"}')">{translate key="reviewer.article.ensuringBlindReview"}</a>{/if}
	</td>
    </tr>
</table>

<p>{if $goToNextStep}<input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton" />{/if} <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" /></p>

</form>

{include file="common/footer.tpl"}

