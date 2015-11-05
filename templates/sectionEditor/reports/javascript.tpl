{**
* javascript.tpl
*
* Template file realizing the bridge between javascript and template files for the generation of reports. 
**}

{literal}
    <script type="text/javascript">
    
       var PROPOSAL_DETAIL_NO = "{/literal}{$smarty.const.PROPOSAL_DETAIL_NO}{literal}";
       var PROPOSAL_DETAIL_YES = "{/literal}{$smarty.const.PROPOSAL_DETAIL_YES}{literal}";
       var INITIAL_REVIEW = "{/literal}{$smarty.const.INITIAL_REVIEW}{literal}";
       var SUBMISSION_SECTION_DECISION_APPROVED = "{/literal}{$smarty.const.SUBMISSION_SECTION_DECISION_APPROVED}{literal}";
       var OR_STRING = "{/literal}{translate key='common.or'}{literal}";
       var SOURCE_AMOUNT_NUMERIC = "{/literal}{translate key="proposal.source.amount.instruct"}{literal}";

       var RISK_ASSESSMENT_NO = "{/literal}{$smarty.const.RISK_ASSESSMENT_NO}{literal}";
    
       $(document).ready(function() {
            
            $('#showOrHideDecisionTableClick').click(showOrHideDecisionTable);
            
            $('#reportType').change(showSelectedReportType);
            
            showOrHideDecisionTable();
            
            showSelectedReportType();

        });
    </script>
    <!-- Datepicker bug: see http://bugs.jqueryui.com/ticket/5970 -->
    <style type="text/css">
         #ui-datepicker-div { display:none }
    </style>
{/literal}
