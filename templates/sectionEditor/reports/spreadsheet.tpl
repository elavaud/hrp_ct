{**
* spreadsheet.tpl
*
* Generate report - if spreadsheet to generate 
**}

<table width="100%" class="data" id="spreadsheetTable">
    <tr valign="top">
        <td width="25%"></td>
        <td width="25%"></td>
        <td width="25%"></td>
        <td width="25%"></td>
    </tr>
    <tr><td colspan="4">{translate key="editor.reports.spreadsheet.instruct"}</td></tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><i>{translate key="editor.reports.spreadsheet.multiEntries.instruct"}</i></td></tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><input type="checkbox" name="checkShowCriterias"/>{translate key="editor.reports.criterias.check"}</td></tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><b>{translate key="editor.reports.spreadsheet.general"}</b></td></tr>
    <tr>
        <td><input type="checkbox" name="checkProposalId" checked="checked"/>{translate key="common.proposalId"}</td>
        <td><input type="checkbox" name="checkDecisions"/>{translate key="editor.reports.spreadsheet.decisions"}&nbsp;{translate key="editor.reports.spreadsheet.multiEntries"}</td>
        <td><input type="checkbox" name="checkDateSubmitted"/>{translate key="submissions.submit"}</td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><b>{translate key="article.authors"}</b></td></tr>
    <tr>
        <td><input type="checkbox" name="checkName" checked="checked"/>{translate key="common.name"}</td>
        <td><input type="checkbox" name="checkAffiliation" checked="checked"/>{translate key="user.affiliation"}</td>
        <td><input type="checkbox" name="checkEmail"/>{translate key="user.email"}</td>
        <td><input type="checkbox" name="checkAllInvestigators"/>{translate key="editor.reports.spreadsheet.allInvestigators"}&nbsp;{translate key="editor.reports.spreadsheet.multiEntries"}</td>
    </tr>    
</table>
