{**
 * javascriptStep5.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 5 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 *}
 
 <script type="text/javascript" src="{$baseUrl|cat:"/js/proposalSubmissionStep5.js"}"></script>

 {literal}
     <script type="text/javascript">

        var INSTITUTION_NATIONAL = "{/literal}{$smarty.const.INSTITUTION_NATIONAL}{literal}";
        var INSTITUTION_INTERNATIONAL = "{/literal}{$smarty.const.INSTITUTION_INTERNATIONAL}{literal}";     
        var CRO_NATIONAL = "{/literal}{$smarty.const.CRO_NATIONAL}{literal}";
        var CRO_INTERNATIONAL = "{/literal}{$smarty.const.CRO_INTERNATIONAL}{literal}";         
        var ARTICLE_DETAIL_NO = "{/literal}{$smarty.const.ARTICLE_DETAIL_NO}{literal}";
        var ARTICLE_DETAIL_YES = "{/literal}{$smarty.const.ARTICLE_DETAIL_YES}{literal}"; 
        
        

        $("a.showHideHelpButton").each(function() {$(this).click(function(){
            if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                $(this).parent().parent().nextAll('.showHideHelpField').first().show();
            } else {
                $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
            } 
        });});        
        
        $('input:radio[name*="[location]"]').each(
            function () {
                $(this).click(
                    function(e) {
                        var name = e.target.name;
                        showOrHideSourceLocation(name);
                    }
                );
            }
        );

        $("select[id*=-institutionId]").each(
            function () {
                $(this).change(
                    function(e) {
                        var id = e.target.id;
                        showOrHideSourceInfo(id);
                    }
                );
            }
        );

        $("#addFundingSourceClick").click(addFundingSource);
        $('.removeFundingSource').each(function() {$(this).click(function(){$(this).closest('table').remove();});});           

        $("#primarySponsor-institutionId").change(function() {showOrHidePSponsorInfo();});
            
        $('input:radio[name="primarySponsor[location]"]').each(
            function () {
                $(this).click(
                    function() {
                        showOrHidePSponsorLocation();
                    }
                );
            }
        );
    
        $('input:radio[name*="[ssLocation]"]').each(
            function () {
                $(this).click(
                    function(e) {
                        var name = e.target.name;
                        showOrHideSSponsorLocation(name);
                    }
                );
            }
        );

        $("select[id*=-ssInstitutionId]").each(
            function () {
                $(this).change(
                    function(e) {
                        var id = e.target.id;
                        showOrHideSSponsorInfo(id);
                    }
                );
            }
        );

        $("#addSecondarySponsorClick").click(addSecondarySponsor);
        $('.removeSecondarySponsor').each(function() {$(this).click(function(){$(this).closest('table').remove();});});           

        $('input:radio[name*="[croLocation]"]').each(
            function () {
                $(this).click(
                    function(e) {
                        var name = e.target.name;
                        showOrHideCROLocation(name);
                    }
                );
            }
        );

        $('input:radio[name=croInvolved]').each(function () {$(this).click(showOrHideCROInfo);});

        $("#addCROClick").click(addCRO);
        $('.removeCRO').each(function() {$(this).click(function(){$(this).closest('table').remove();});});           

        $(document).ready(
            function() {
                showOrHideSourceLocations();
                showOrHideSourcesInfo();
                showOrHidePSponsorInfo();
                showOrHideSSponsorLocations();
                showOrHideSSponsorsInfo();
                showOrHideCROInfo();
                showOrHideCROsLocations();
            }
        );  

     </script>
 {/literal}