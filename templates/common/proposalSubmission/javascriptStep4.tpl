{**
 * javascriptStep4.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 4 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 *}
 
 <script type="text/javascript" src="{$baseUrl|cat:"/js/proposalSubmissionStep4.js"}"></script>

 {literal}
     <script type="text/javascript">

       var NOT_NUMERIC = "{/literal}{translate key="proposal.age.int.alert"}{literal}";
    
        $("#addSiteClick").click(addSite);
        
        $('.removeSite').each(function() {$(this).click(function(){$(this).closest('div').remove();});});           
        
        $("a.showHideHelpButton").each(function() {$(this).click(function(){
            if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                $(this).parent().parent().nextAll('.showHideHelpField').first().show();
            } else {
                $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
            } 
        });});        
        
        $("select[id*=-siteSelect]").each(
            function () {
                $(this).change(
                    function(e) {
                        var id = e.target.id;
                        showOrHideSiteFields(id);
                    }
                );
            }
        );

        $("a.addAnotherInvestigatorClick").each(
            function () {
                $(this).click(
                    function(e) {
                        var id = e.target.id;
                        addInvestigator(id);
                    }
                );
            }
        );        

        $('a.removeInvestigator').each(function() {$(this).click(function(){$(this).closest('table').remove();});});  
        
        $("input.numField").each(function() {$(this).keyup(isNumeric);});
        
        $(document).ready(
            function() {
                showOrHideAllSiteFields();
            }
        );  

     </script>
 {/literal}