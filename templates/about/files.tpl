{**
 * files.tpl
 *
 * Display all the public files.
 *
 * $Id$
 *}
 
 <div>
    <h2>{translate key="about.files"}</h2>
    <p>{$aboutFiles}</p>

    {if $countPolicyFiles > 0}
           <div id="policyFiles">
                   <h3>{translate key="common.file.policy"}</h3>
                   <table width="100%">
                           <tr><td colspan="2">&nbsp;</tr>
                           {foreach from=$policyFiles item=policyFile}
                                   <tr>
                                           <td width="5%">&nbsp;</td>
                                           <td width="95%"><a href="{url op="downloadAboutFile" path=$policyFile->getId()}"><b>&#8226;&nbsp;{$policyFile->getLocalizedAboutFileName()|escape}</b></a></td>
                                   </tr>
                           {/foreach}
                   </table>
           </div>
   {/if}

   {if $countUserManuals > 0}
           <div id="userManuals">
                   <h3>{translate key="common.file.usermanuals"}</h3>
                   <table width="100%">
                           <tr><td colspan="2">&nbsp;</tr>
                           {foreach from=$userManuals item=userManual}
                                   <tr>
                                           <td width="5%">&nbsp;</td>
                                           <td width="95%"><a href="{url op="downloadAboutFile" path=$userManual->getId()}"><b>&#8226;&nbsp;{$userManual->getLocalizedAboutFileName()|escape}</b></a></td>
                                   </tr>
                           {/foreach}
                   </table>
           </div>
   {/if}

   {if $countTemplates > 0}
           <div id="templates">
                   <h3>{translate key="common.file.templates"}</h3>
                   <table width="100%">
                           <tr><td colspan="2">&nbsp;</tr>
                           {foreach from=$templates item=template}
                                   <tr>
                                           <td width="5%">&nbsp;</td>
                                           <td width="95%"><a href="{url op="downloadAboutFile" path=$template->getId()}"><b>&#8226;&nbsp;{$template->getLocalizedAboutFileName()|escape}</b></a></td>
                                   </tr>
                           {/foreach}
                   </table>
           </div>
   {/if}

   {if $countMiscellaneousFiles > 0}
           <div id="miscellaneous">
                   <h3>{translate key="common.file.miscellaneous"}</h3>
                   <table width="100%">
                           <tr><td colspan="2">&nbsp;</tr>
                           {foreach from=$miscellaneousFiles item=miscellaneousFile}
                                   <tr>
                                           <td width="5%">&nbsp;</td>
                                           <td width="95%"><a href="{url op="downloadAboutFile" path=$miscellaneousFile->getId()}"><b>&#8226;&nbsp;{$miscellaneousFile->getLocalizedAboutFileName()|escape}</b></a></td>
                                   </tr>
                           {/foreach}
                   </table>
           </div>
   {/if}

</div>