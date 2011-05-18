{include file="default/header.tpl"}


<div class="instructions"><b>{'YOUR_PROFILE'|onapp_string}</b><br />
    {'YOUR_PROFILE_INFORMATION'|onapp_string}
</div>
<h1>{'USER_DETAILS'|onapp_string}</h1>
<table width="100%" class="table_my" cellpadding="5" cellspacing="5" border="0">
    <tr>
        <td>{'FULL_NAME'|onapp_string}</td>
        <td>{$_session_data["profile_obj"]->_first_name} {$_session_data["profile_obj"]->_last_name}</td>
    </tr>

    <tr>
        <td>{'LOGIN_'|onapp_string}</td>
        <td>{$_session_data["profile_obj"]->_login}</td>
    </tr>

    <tr>
        <td>{'E_MAIL'|onapp_string}</td>
        <td>{$_session_data["profile_obj"]->_email}</td>
    </tr>

    <tr>
        <td>{'TIME_ZONE'|onapp_string}</td>
        <td>{$_session_data["profile_obj"]->_time_zone}</td>
    </tr>

    <tr>
        <td>{'LOCALE_'|onapp_string}</td>
        <td>{$_session_data["profile_obj"]->_locale}</td>
    </tr>

</table>

<h1>{'USER_ROLES'|onapp_string}</h1>

<table width="100%" class="table_my" cellpadding="5" cellspacing="5" border="0">
    <tr>
        <td>
            {foreach from=$_session_data["profile_obj"]->_roles item=role}
                {$role->_label}<br />
            {/foreach}
        </td>
    </tr>

</table>

{include file="default/navigation.tpl"}
{include file="default/footer.tpl"}
