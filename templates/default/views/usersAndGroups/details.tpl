{include file="default/views/header.tpl"}

<h1>{'USER_DETAILS'|onapp_string}</h1>
    <table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
        <tr>
            <td class="label">{'FULL_NAME'|onapp_string}</td>
            <td>{$user_obj->_first_name} {$user_obj->_last_name}</td>
        </tr>
        <tr>
            <td class="label">{'LOGIN_'|onapp_string}</td>
            <td>{$user_obj->_login}</td>
        </tr>
        <tr>
            <td class="label">{'E_MAIL'|onapp_string}</td>
            <td>{$user_obj->_email}</td>
        </tr>
        <tr>
            <td class="label">{'TIME_ZONE'|onapp_string}</td>
            <td>{$user_obj->_time_zone}</td>
        </tr>
        <tr>
            <td class="label">{'LOCALE_'|onapp_string}</td>
            <td>{$user_obj->_locale}</td>
        </tr>
    </table>

    <h1>{'BILLING_DETAILS'|onapp_string}</h1>
    <table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
       <!-- <tr>
            <td class="label">{'BILLING_PLAN'|onapp_string}</td>
            <td>
                <a href="{$_ALIASES["users_and_groups"]}?action=billing_plan_base_resources&amp;id={$user_obj->_billing_plan_id}&amp;user_id={$user_obj->_id}">
                    {'BILLING_PLAN_FOR'|onapp_string} {$user_obj->_first_name} {$user_obj->_last_name}
                </a>
            </td>
        </tr>  TODO -->
        <tr>
            <td class="label">{'MONTHLY_FEE'|onapp_string}</td>
            <td>{round( $billing_plan_obj->_monthly_price, 2 )|onapp_format_money} {$billing_plan_obj->_currency_code}</td>
        </tr>
        <tr>
            <td class="label">{'OUTSTANDING_AMOUNT'|onapp_string}</td>
            <td>{round( $user_obj->_total_amount - $user_obj->_payment_amount, 2)|onapp_format_money} {$billing_plan_obj->_currency_code}</td>
        </tr>
        <tr>
            <td class="label">{'PAYMENTS_'|onapp_string}</td>
            <td>{round( $user_obj->_payment_amount, 2)|onapp_format_money} {$billing_plan_obj->_currency_code}</td>
        </tr>
        <tr>
            <td class="label">{'TOTAL_COST'|onapp_string}</td>
            <td>{round( $user_obj->_total_amount, 2)|onapp_format_money} {$billing_plan_obj->_currency_code}</td>
        </tr>
    </table>

<h1>{'USER_ROLES'|onapp_string}</h1>
<table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
    <tr>
        <td>
            {foreach from=$user_obj->_roles item=role}
                {$role->_label} <br />
            {/foreach}
        </td>
    </tr>
</table>

<h1>{'USER_GROUP'|onapp_string}</h1>
<table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
    <tr>
        <td>
            {if $user_group_obj == true}
                {$user_group_obj->_label}
            {else}
                {'UNDEFINED_'|onapp_string}
            {/if}
        </td>
    </tr>
</table>

<h1>{'USER_PAYMENTS'|onapp_string}</h1>
    {if $payment_obj == null}
        <p class="not_found">No payments found</p>
    {else}
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'PAYMENT_DATE'|onapp_string}</th>
            <th>{'INVOICE_NUMBER'|onapp_string}</th>
            <th>{'AMOUNT_'|onapp_string}</th>
            <th></th>
       </tr>
       
     {foreach from=$payment_obj item=payment}
        <tr>
            <td>
               {str_replace(array('T', 'Z'), ' ', $payment->_created_at)}
            </td>
            <td>
                {$payment->_invoice_number}
            </td>
            <td>
                {$payment->_amount|onapp_format_money} {$billing_plan_obj->_currency_code}
            </td>
            <td class="dark_td">
                <a href="{$_ALIASES["users_and_groups"]}?action=payment_edit&amp;id={$payment->_id}&amp;user_id={$user_obj->_id}">
                    <img alt="{'EDIT_PAYMENT'|onapp_string}" title="{'EDIT_PAYMENT'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                </a>
                <a href="{$_ALIASES["users_and_groups"]}?action=payment_delete&amp;id={$payment->_id}&amp;user_id={$user_obj->_id}">
                    <img alt= {'DESTROY_PAYMENT'|onapp_string}"" title="{'DESTROY_PAYMENT'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
            </td>
        </tr>
     {/foreach}
     </table>
     {/if}
        
{include file="default/views/usersAndGroups/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}