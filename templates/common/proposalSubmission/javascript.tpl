{**
 * javascript.tpl
 *
 * This file is used for incorporating all the javascript and jquery functions used during of the Step 2 of author article submission.
 * The javascript use some smarty variables. It's why it is currently in a tpl file.
 *
 * FIX ME: Finding a workaround for including the smarty variable into a real js file, but moreover reorganizing this file in order to use a modern way to call events.
 *
 *}
 
 <script type="text/javascript" src="{$baseUrl|cat:"/js/proposalSubmission.js"}"></script>

 {literal}
     <script type="text/javascript">

      
        $(document).ready(
            function() {
                
            }
        );  
     </script>
 {/literal}