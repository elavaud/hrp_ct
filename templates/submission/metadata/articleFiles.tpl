{**
 * articleFiles.tpl
 *
 * Subtemplate defining the submission metadata table for article files. Non-form implementation.
 *}

<table class="data" width="100%">
    <tr>
        <td width="20%" class="label">{translate key="submission.originalFile"}</td>
        <td width="80%" class="data"><ul><li>
            {if $submissionFile}
                <a href="{url op="downloadFile" path=$articleId|to_array:$submissionFile->getFileId()}" class="file">{$submissionFile->getFileName()|escape}</a>
            {else}
                {translate key="common.none"}
            {/if}
        </li></ul></td>
    </tr>
    {if count($previousFiles) > 1}
        {assign var="count" value=0}
        <tr>
            <td class="label">[?] {translate key="submission.previousProposalFile"}</td>
            <td width="80%" class="value"><ul>
                {foreach name="previousFiles" from=$previousFiles item=previousFile}
                    {assign var="count" value=$count+1}
                    {if $count > 1}
                        <li><a href="{url op="downloadFile" path=$articleId|to_array:$previousFile->getFileId()}" class="file">{$previousFile->getFileName()|escape}</a>&nbsp;&nbsp;({$previousFile->getDateUploaded()|date_format:$datetimeFormatLong})</li>
                    {/if}
                {/foreach}
            </ul></td>
        </tr>
    {/if}
    <tr>
        <td class="label">{translate key="article.suppFilesAbbrev"}</td>
        <td width="80%" class="value"><ul>
            {foreach name="suppFiles" from=$suppFiles item=suppFile}
                <li><a href="{url op="downloadFile" path=$articleId|to_array:$suppFile->getFileId()}" class="file">{$suppFile->getFileName()|escape}</a>&nbsp;&nbsp;({$suppFile->getType()|escape})</li>
            {foreachelse}
                <li>{translate key="common.none"}</li>
            {/foreach}
        </ul></td>
    </tr>
    
    <tr>
        <td class="label">{translate key="article.reports"}</td>
        <td width="80%" class="value"><ul>
            {foreach name="reportFiles" from=$reportFiles item=reportFile}
                <li><a href="{url op="downloadFile" path=$submission->getArticleId()|to_array:$reportFile->getFileId()}" class="file">{$reportFile->getFileName()|escape}</a>&nbsp;&nbsp;({$reportFile->getDateUploaded()|date_format:$datetimeFormatLong})</li>
            {foreachelse}
                <li>{translate key="common.none"}</li>
            {/foreach}
        </ul></td>
    </tr>        

    <tr>
        <td class="label">{translate key="article.sae"}</td>
        <td width="80%" class="value"><ul>
            {foreach name="saeFiles" from=$saeFiles item=saeFile}
                <li><a href="{url op="downloadFile" path=$submission->getArticleId()|to_array:$saeFile->getFileId()}" class="file">{$saeFile->getFileName()|escape}</a>&nbsp;&nbsp;({$saeFile->getDateUploaded()|date_format:$datetimeFormatLong})</li>
            {foreachelse}
                <li>{translate key="common.none"}</li>
            {/foreach}
        </ul></td>
    </tr>
</table>