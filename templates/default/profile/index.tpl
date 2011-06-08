{include file="default/header.tpl"}


<div class="info">
    <div class="info_title">{'YOUR_PROFILE'|onapp_string}</div>
    <div class="info_body">{'YOUR_PROFILE_INFORMATION'|onapp_string}</div>
    <div class="info_bottom"></div>
</div>
<h1>{'USER_DETAILS'|onapp_string}&nbsp;</h1>
<div class="div_page">
    <dl>
        <dt>{'FULL_NAME'|onapp_string}&nbsp;</dt>
        <dd>{$smarty.session.profile_obj->_first_name} {$smarty.session.profile_obj->_last_name}&nbsp;</dd>
    </dl>

    <dl>
        <dt>{'LOGIN_'|onapp_string}&nbsp;</dt>
        <dd>{$smarty.session.profile_obj->_login}&nbsp;</dd>
    </dl>

    <dl>
        <dt>{'E_MAIL'|onapp_string}&nbsp;</dt>
        <dd>{$smarty.session.profile_obj->_email}&nbsp;</dd>
    </dl>

    <dl>
        <dt>{'TIME_ZONE'|onapp_string}&nbsp;</dt>
        <dd>{$smarty.session.profile_obj->_time_zone}&nbsp;</dd>
    </dl>

    <dl>
        <dt>{'LOCALE_'|onapp_string}&nbsp;</dt>
        <dd>{$smarty.session.profile_obj->_locale}&nbsp;</dd>
    </dl>

</div>

<h1>{'USER_ROLES'|onapp_string}&nbsp;</h1>

<div class="div_page">
    <dl>
        <dt>
            {foreach from=$smarty.session.profile_obj->_roles item=role}
                {$role->_label}<br />
            {/foreach}
        </dt>
    </dl>

</div>

{include file="default/navigation.tpl"}
{include file="default/footer.tpl"}
