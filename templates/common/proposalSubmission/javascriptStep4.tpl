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
        
        $("#addSiteClick").click(addSite);
        
        $(document).ready(
            function() {
            }
        );  

     </script>
 {/literal}