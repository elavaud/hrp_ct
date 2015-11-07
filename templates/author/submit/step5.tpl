{**
 * step5.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Step 5 of author article submission.
 *
 * $Id$
 *}
{assign var="pageTitle" value="author.submit.step5"}
{include file="author/submit/submitHeader.tpl"}

<script type="text/javascript">
    {literal}
        <!--
        function checkSubmissionChecklist(elements) {
            if (elements.type == 'checkbox' && !elements.checked) {
                alert({/literal}'Please confirm that you sent the proposal review fee to the appropriate ethics committee.'{literal});
                return false;
            }
            return true;
        }
        // -->
    {/literal}
</script>

<p>{translate key="author.submit.confirmationDescription" journalTitle=$journal->getLocalizedTitle()}</p>

<form method="post" action="{url op="saveSubmit" path=$submitStep}">
    <input type="hidden" name="articleId" value="{$articleId|escape}" />
    {include file="common/formErrors.tpl"}

    <h1>{translate key="article.metadata"}</h1>
    <p>{$section->getSectionTitle()}&nbsp;&nbsp;&nbsp;<a href="{url op="submit" path="1" articleId=$article->getId()}"><i>{translate key="common.modify"}</i></a></p>


    <div class="separator"></div>


    <br />
    <br />
    
    <div id="fileSummary">

        <h3>{translate key="author.submit.filesSummary"}</h3>
        <table class="listing" width="100%">
            <tr>
                <td colspan="5" class="headseparator">&nbsp;</td>
            </tr>
            <tr class="heading" valign="bottom">
                <!--td width="10%">{translate key="common.id"}</td-->
                <td width="35%">{translate key="common.originalFileName"}</td>
                <td width="25%">{translate key="common.type"}</td>
                <td width="20%" class="nowrap">{translate key="common.fileSize"}</td>
                <td width="10%" class="nowrap">{translate key="common.dateUploaded"}</td>
            </tr>
            <tr>
                <td colspan="5" class="headseparator">&nbsp;</td>
            </tr>
            {foreach from=$files item=file}
                <tr valign="top">
                    <!--td>{$file->getFileId()}</td-->
                    <td><a class="file" href="{url op="download" path=$articleId|to_array:$file->getFileId()}">{$file->getOriginalFileName()|escape}</a></td>
                    <td>{if ($file->getType() == 'supp')}{translate key="article.suppFile"}{elseif ($file->getType() == 'previous')}{translate key="author.submit.previousSubmissionFile"}{else}{translate key="author.submit.submissionFile"}{/if}</td>
                    <td>{$file->getNiceFileSize()}</td>
                    <td>{$file->getDateUploaded()|date_format:$dateFormatTrunc}</td>
                </tr>
            {foreachelse}
                <tr valign="top">
                    <td colspan="5" class="nodata">{translate key="author.submit.noFiles"}</td>
                </tr>
            {/foreach}
        </table>
    </div>
    <div class="separator"></div>

    <br />
    <br />

    <div id="commentsForEditor">
        <h3>{translate key="author.submit.commentsForEditor"}</h3>

        <table width="100%" class="data">
            <tr valign="top">
                <td width="20%" class="label">{fieldLabel name="commentsToEditor" key="author.submit.comments"}</td>
                <td width="80%" class="value"><textarea name="commentsToEditor" id="commentsToEditor" rows="3" cols="40" class="textArea">{$commentsToEditor|escape}</textarea></td>
            </tr>
        </table>
    </div>{* commentsForEditor *}

    <div class="separator"></div>

    {if $authorFees}
        {include file="author/submit/authorFees.tpl" showPayLinks=1}
        {if $currentJournal->getLocalizedSetting('waiverPolicy') != ''}
            {if $manualPayment}
                <p><br/><br/><strong><u>{$section->getLocalizedTitle()}:</u></strong></p>                
                <p>{$bankAccount}</p>
                <table class="data" width="100%">
                    <tr valign="top">
                        <td width="5%" align="left"><input type="checkbox" id="paymentSent" name="paymentSent" value="1" {if $paymentSent}checked="checked"{/if} /></td>
                        <td width="95%">{translate key="payment.agreeToPay"}</td>
                    </tr>
               </table>
            {/if}
        {/if}

        <div class="separator"></div>
    {/if}

    {call_hook name="Templates::Author::Submit::Step5::AdditionalItems"}
    <p><font color=#FF0000>Attention:<br />Before finishing the submission please make sure that all data you entered are correct. Once submitted the proposal can't be modified.</font></p>
    <p><input type="submit" value="{translate key="author.submit.finishSubmission"}" class="button defaultButton" {if $authorFees && $article->getTotalBudget() > 5000} onclick="return checkSubmissionChecklist(document.getElementById('paymentSent'))"{/if} /> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="confirmAction('{url page="author"}', '{translate|escape:"jsparam" key="author.submit.cancelSubmission"}')" /></p>
</form>

{include file="common/footer.tpl"}