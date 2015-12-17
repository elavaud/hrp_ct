{**
 * articleContact.tpl
 *
 * Subtemplate defining the submission metadata table for article contact. Non-form implementation.
 *}

<table class="data" width="100%">
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.articleContact.pq"}</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.name"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getPQName()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.affiliation"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getPQAffiliation()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.address"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getPQAddress()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.country"}</td>
        <td width="70%" class="value"><ul><li>
            {assign var="pqCountry" value=$contact->getPQCountry()}
            {$coutryList.$pqCountry|escape}
        </li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.phone"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getPQPhone()}</li></ul></td>
    </tr>
    {if $contact->getPQFax() != ''}
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.fax"}</td>
            <td width="70%" class="value"><ul><li>{$contact->getPQFax()}</li></ul></td>
        </tr>
    {/if}
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.email"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getPQEmail()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">{translate key="proposal.articleContact.sq"}</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.name"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getSQName()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.affiliation"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getSQAffiliation()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.address"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getSQAddress()}</li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.country"}</td>
        <td width="70%" class="value"><ul><li>
            {assign var="sqCountry" value=$contact->getSQCountry()}
            {$coutryList.$sqCountry|escape}
        </li></ul></td>
    </tr>
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.phone"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getSQPhone()}</li></ul></td>
    </tr>
    {if $contact->getPQFax() != ''}
        <tr valign="top">
            <td width="20%" class="label">&nbsp;</td>
            <td width="10%" class="label">{translate key="proposal.articleContact.fax"}</td>
            <td width="70%" class="value"><ul><li>{$contact->getSQFax()}</li></ul></td>
        </tr>
    {/if}
    <tr valign="top">
        <td width="20%" class="label">&nbsp;</td>
        <td width="10%" class="label">{translate key="proposal.articleContact.email"}</td>
        <td width="70%" class="value"><ul><li>{$contact->getSQEmail()}</li></ul></td>
    </tr>
</table>