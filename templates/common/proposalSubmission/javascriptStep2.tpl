{**
 * javascriptStep2.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 2 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 *}
 
 <script type="text/javascript" src="{$baseUrl|cat:"/js/proposalSubmissionStep2.js"}"></script>

 {literal}
     <script type="text/javascript">
       var ARTICLE_PURPOSE_TYPE_OBS = "{/literal}{$smarty.const.ARTICLE_PURPOSE_TYPE_OBS}{literal}";
       var ARTICLE_PURPOSE_TYPE_INT = "{/literal}{$smarty.const.ARTICLE_PURPOSE_TYPE_INT}{literal}";
       
       var AGE_NOT_NUMERIC = "{/literal}{translate key="proposal.age.int.alert"}{literal}";
       
       var ARTICLE_DETAIL_NO = "{/literal}{$smarty.const.ARTICLE_DETAIL_NO}{literal}";
       var ARTICLE_DETAIL_YES = "{/literal}{$smarty.const.ARTICLE_DETAIL_YES}{literal}";

        $("#addAnotherSecIdClick").click(addSecId);
        $('#secIds a.removeSecId').each(function() {$(this).click(function(){$(this).closest('tr').remove();});});        

        $("#therapeuticArea").change(showOrHideOherTherapeuticAreaField);
        
        $("#addAnotherHealthCondClick").click(addHealthCond);
        $('#healthConds a.removeHealthCond').each(function() {$(this).click(function(){$(this).closest('tr').remove();});});        

        $("#addAnotherPurposeClick").click(addPurpose);
        $('#purposes a.removePurpose').each(function() {$(this).click(function(){$(this).closest('table').remove();});});  
        $("#purposes input[name*=interventional]").each(function() {$(this).change(showOrHideInterventionalFields);});
        
        $("#addAnotherPrimaryOutcomeClick").click(addPrimaryOutcome);
        $('#primaryOutcomes a.removePrimaryOutcome').each(function() {$(this).click(function(){$(this).closest('table').remove();});});        

        $("#addAnotherSecondaryOutcomeClick").click(addSecondaryOutcome);
        $('#secondaryOutcomes a.removeSecondaryOutcome').each(function() {$(this).click(function(){$(this).closest('table').remove();});});   
        
        $("input.numField").each(function() {$(this).keyup(isNumeric);});
    
        $("#addAnotherIntCountryClick").click(addIntCountry);
        $('#intSampleSizeFields a.removeIntCountry').each(function() {$(this).click(function(){$(this).closest('table').remove();});});    
        $("input[name=articleDetails[multinational]]").each(function() {$(this).change(showOrHideOherIntSampleSizeField);});

        $("a.showHideHelpButton").each(function() {$(this).click(function(){
            if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                $(this).parent().parent().nextAll('.showHideHelpField').first().show();
            } else {
                $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
            } 
        });});

        $( "#startDate" ).datepicker({
            changeMonth: true, 
            changeYear: true, 
            showButtonPanel: true,
            dateFormat: 'M-yy', 
            minDate: '-1 y', 
            onSelect: function(dateText, inst){
                dayAfter = new Date();
                dayAfter = $("#startDate").datepicker("getDate");
                dayAfter.setDate(dayAfter.getDate() + 1);
                $("#endDate").datepicker("option","minDate", dayAfter);
            },
            onClose: function(dateText, inst) { 
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
        $( "#endDate" ).datepicker({
            changeMonth: true, 
            changeYear: true, 
            showButtonPanel: true,
            dateFormat: 'M-yy', 
            minDate: '-1 y',
            onClose: function(dateText, inst) { 
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
        $("#ui-datepicker-div .ui-datepicker-calendar").hide();
        
        $(document).ready(
            function() {
                showOrHideOherTherapeuticAreaField();
                showOrHideInterventionalFields();
                showOrHideOherIntSampleSizeField();
            }
        );  
     </script>
 {/literal}