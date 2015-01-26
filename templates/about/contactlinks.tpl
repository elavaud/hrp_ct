{**
 * links.tpl
 *
 * Display all the links.
 *
 * $Id$
 *}

<div id="contact">
    <h2>{translate key="about.contacts"}</h2>
    
    <table width="100%">
        <tr>
            <td width="50%" valign="top">
                <h6>{translate key="about.contact.principalContact"}</h6>
                {if $CName != ''}<b>{$CName}</b>{/if}
                {if $CTitle != ''}<br/>{$CTitle}{/if}
                {if $CAffiliation != ''}<br/>{$CAffiliation}{/if}
                {if $CPhone != ''}<br/>{translate key="about.contact.phone"}: {$CPhone}{/if}
                {if $CFax != ''}<br/>{translate key="about.contact.fax"}: {$CFax}{/if}
                {if $CAddress != ''}<br/>{translate key="common.mailingAddress"}: {$CAddress}{/if}
                {if $CEmail != ''}<br/>{translate key="about.contact.email"}: {mailto address=$CEmail|escape encode="hex"}{/if}
            </td>
            <td width="50%" valign="top">
                <h6>{translate key="about.contact.subPrincipalContact"}</h6>
                {if $SName != ''}<b>{$SName}</b>{/if}
                {if $SPhone != ''}<br/>{translate key="about.contact.phone"}: {$SPhone}{/if}
                {if $SEmail != ''}<br/>{translate key="about.contact.email"}: {mailto address=$SEmail|escape encode="hex"}{/if}
            </td>
        </tr>
    </table>


</div>
<br/> 
<div id="links">
    <h2>{translate key="about.links"}<br/></h2>
    <p>{$aboutLinks}</p>

    {if $countNavMenuItems > 0}
       <table width="100%">
           <tr><td colspan="2">&nbsp;</tr>
           {foreach from=$navMenuItems item=navItem}
               {if $navItem.url != '' && $navItem.name != ''}
                   <tr>
                       <td width="5%">&nbsp;</td>
                       <td width="95%"><a href="{if $navItem.isAbsolute}{$navItem.url|escape}{else}{$navItem.url|escape}{/if}"  target="_blank">
                           <b>&#8226;&nbsp;
                               {if $navItem.isLiteral}
                                   {$navItem.name|escape}
                               {else}
                                   {translate key=$navItem.name}
                               {/if}
                           </b>
                       </a>
                       </td>
                   </tr>
               {/if}                
           {/foreach}
       </table>
    {/if}

</div>

