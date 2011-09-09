{include file="default_web20cart/views/header.tpl"}


<h1>{'USER_DETAILS'|onapp_string}</h1>
    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="login_field">{'LOGIN_'|onapp_string}</label></dt>
                <dd>
                    <input id="login_field_hidden" type="text" name="user[_login]" value="" />
                </dd>
            </dl>
            <dl>
                <dt><label for="first_name">{'FIRST_NAME'|onapp_string}</label></dt>
                <dd><input id="first_name" type="text" name="user[_first_name]" value="" /></dd>
            </dl>
            <dl>
                <dt><label for="last_name">{'LAST_NAME'|onapp_string}</label></dt>
                <dd><input id="last_name" type="text" name="user[_last_name]" value="" /></dd>
            </dl>
            <dl>
                <dt><label for="e_mail">{'E_MAIL'|onapp_string}</label></dt>
                <dd><input id="e_mail" type="text" name="user[_email]" value="" /></dd>
            </dl>
            <dl>
                <dt><label for="user_time_zone">{'TIME_ZONE'|onapp_string}</label></dt>
                <dd>
                    <select id="user_time_zone" name="user[_time_zone]">
                        <option></option>
                    {foreach from=$time_zones key=zone_key item=zone_value}
                        <option value="{$zone_key}">{$zone_value}</option>
                    {/foreach}     
                    </select>
                </dd>
            </dl>
         </div>

<h1>{'LOGIN_PASSWORD'|onapp_string}</h1>
         <div class="div_page">
            <dl>
                <dt><label for="password_field">{'PASSWORD_'|onapp_string}</label></dt>
                <dd><input id="password_field" type="password" name="user[_password]" value="" /></dd>
            </dl>
            <dl>
                <dt><label for="repeat_password">{'REPEAT_PASSWORD'|onapp_string}</label></dt>
                <dd><input id="repeat_password" type="password" name="user[_password_confirmation]" value="" /></dd>
            </dl>
            
         </div>
<h1>{'BILLING_PLAN'|onapp_string}</h1>
        <div class="div_page">
            <dl>
                <dt><label for="billing_plan_field">{'BILLING_PLAN'|onapp_string}</label></dt>
                <dd>
                    <select id="billing_plan_field" name="user[_billing_plan_id]">
                        <option></option>
                    {foreach from=$billing_plans_obj item=plan}
                        <option value="{$plan->_id}">{$plan->_label} [{$plan->_currency_code}]</option>
                    {/foreach}
                    </select>
                </dd>
            </dl>
        </div>

<h1>{'USER_ROLES'|onapp_string}</h1>
         <div class="div_page">
         {foreach from=$role_obj item=role}
             <dl>
                <dt>

                </dt>
                <dd>
                    <input type="hidden" name="user[_role_ids][]" value="0" />
                    <input value="{$role->_id}" type="checkbox" name="user[_role_ids][]"/>
                    {$role->_label}
                </dd>
            </dl>
         {/foreach}
         </div>

<h1>{'USER_GROUP'|onapp_string}</h1>
        <div class="div_page">
            <dl>
                <dt><label for="user_group_select">{'USER_GROUP'|onapp_string}</label></dt>
                <dd>
                    <select id="user_group_select" name="user[_user_group_id]">
                        <option></option>
                    {foreach from=$user_group_obj item=group}
                        <option value="{$group->_id}" >{$group->_label}</option>
                    {/foreach}
                    </select>
                </dd>
            </dl>
        </div>

<!-- TODO autosuspending -->

        <input type="hidden" name = "action" value="create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>


{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}