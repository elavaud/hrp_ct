{**
 * javascriptStep3.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 3 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 *}
 
 <script type="text/javascript" src="{$baseUrl|cat:"/js/proposalSubmissionStep3.js"}"></script>

 {literal}
     <script type="text/javascript">
        
       var ARTICLE_DRUG_INFO_CLASS_III = "{/literal}{$smarty.const.ARTICLE_DRUG_INFO_CLASS_III}{literal}";
       var ARTICLE_DRUG_INFO_CLASS_IV = "{/literal}{$smarty.const.ARTICLE_DRUG_INFO_CLASS_IV}{literal}";    
       
       var ARTICLE_DRUG_INFO_YES = "{/literal}{$smarty.const.ARTICLE_DRUG_INFO_YES}{literal}";
       var ARTICLE_DRUG_INFO_NO = "{/literal}{$smarty.const.ARTICLE_DRUG_INFO_NO}{literal}";     
    
        $("select[id*=-administration]").each(
            function () {
                $(this).change(
                    function(e) {
                        var id = e.target.id;
                        showOrHideOherAdministrationField(id);
                    }
                );
            }
        );

        $("select[id*=-form]").each(
            function () {
                $(this).change(
                    function(e) {
                        var id = e.target.id;
                        showOrHideOherFormField(id);
                    }
                );
            }
        );

        $("a.addAnotherCountryClick").each(
            function () {
                $(this).click(
                    function(e) {
                        var id = e.target.id;
                        addCountry(id);
                    }
                );
            }
        );        

        $("a.addAnotherManufacturerClick").each(
            function () {
                $(this).click(
                    function(e) {
                        var id = e.target.id;
                        addManufacturer(id);
                    }
                );
            }
        );        

        $("input:checkbox").each(
            function () {
                $(this).click(
                    function(e) {
                        var name = e.target.name;
                        showOrHideCountriesConditionsField(name);
                    }
                );
            }
        );

        $('input:radio[name*="[cpr]"]').each(
            function () {
                $(this).click(
                    function(e) {
                        var name = e.target.name;
                        showOrHideDrugRegistrationNumber(name);
                    }
                );
            }
        );

        $("#addDrugInfoClick").click(addDrugInfo);
        $('.removeDrug').each(function() {$(this).click(function(){$(this).closest('div').remove();});});           

        $('a.removeCountry').each(function() {$(this).click(function(){$(this).closest('tr').remove();});});           

        $('a.removeManufacturer').each(function() {$(this).click(function(){$(this).closest('table').remove();});});           

        $("a.showHideHelpButton").each(function() {$(this).click(function(){
            if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                $(this).parent().parent().nextAll('.showHideHelpField').first().show();
            } else {
                $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
            } 
        });});

        $('form').bind('submit', function () {
            $('#articleDrugs-0-type').removeAttr('disabled');
        });                

    
        $(document).ready(
            function() {
                showOrHideOherAdministrationFields();
                showOrHideOherFormFields();
                showOrHideCountriesConditionsFields();
                showOrHideDrugRegistrationNumbers();                
            }
        );  

     </script>
 {/literal}