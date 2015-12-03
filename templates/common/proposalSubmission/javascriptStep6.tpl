{**
 * javascriptStep6.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 6 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 *}
 
 {literal}
     <script type="text/javascript">

        $("a.showHideHelpButton").each(function() {$(this).click(function(){
            if ($(this).parent().parent().nextAll('.showHideHelpField').first().is(':hidden')) {
                $(this).parent().parent().nextAll('.showHideHelpField').first().show();
            } else {
                $(this).parent().parent().nextAll('.showHideHelpField').first().hide();
            } 
        });});        
        
        $(document).ready(
            function() {
            }
        );  

     </script>
 {/literal}