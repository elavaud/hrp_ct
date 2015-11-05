/* 
 * JS file containing all the functions used during the generation or reports
 */

function showOrHideDecisionTable(){
   var value = $('#decisionTableShow').val();
   if (value === "0") {
       $('#decisionTable').show();
       $('#decisionTableShow').val("1");
   } else {
       $('#decisionTable').hide();
       $('#decisionTableShow').val("0");       
       $('#decisionCommittee').val("0");
       $('#decisionType').val(INITIAL_REVIEW);
       $('#decisionStatus').val(SUBMISSION_SECTION_DECISION_APPROVED);
       $('#decisionAfter').val("");
       $("#decisionAfter").datepicker("option","maxDate", '-1 d');
       $('#decisionBefore').val("");
       $("#decisionBefore").datepicker("option","minDate", null);
   }
}

// The decision date "after" can not be after the decision date "before"
function changeDecisionBeforeDate(){
    dayAfter = new Date();
    dayAfter = $("#decisionAfter").datepicker("getDate");
    dayAfter.setDate(dayAfter.getDate() + 1);
    $("#decisionBefore").datepicker("option","minDate", dayAfter);
} 
function changeDecisionAfterDate(){
    dayBefore = new Date();
    dayBefore = $("#decisionBefore").datepicker("getDate");
    dayBefore.setDate(dayBefore.getDate() - 1);
    $("#decisionAfter").datepicker("option","maxDate", dayBefore);
} 

function showSelectedReportType(){
   var value = $('#reportType').val();
   if (value === "0") {
       $('#defaultButton').show();   
       $('#spreadsheetTable').show();
       $('#pieChartTable').hide();       
   } else if (value === "1") {
       $('#defaultButton').show();       
       $('#spreadsheetTable').hide();
       $('#pieChartTable').show();       
   } else if (value === "2") {
       $('#defaultButton').show();       
       $('#spreadsheetTable').hide();
       $('#pieChartTable').show();       
   } else {
       $('#defaultButton').hide();       
       $('#spreadsheetTable').hide();
       $('#pieChartTable').hide();       
   }
}