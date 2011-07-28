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
        <tr>
            <td class="label">{'BILLING_PLAN'|onapp_string}</td>
            <td>
                <a href="{$_ALIASES["users_and_groups"]}?action=billing_plan_base_resources&amp;id={$user_obj->_billing_plan_id}&amp;user_id={$user_obj->_id}">
                    {'BILLING_PLAN_FOR'|onapp_string} {$user_obj->_first_name} {$user_obj->_last_name}
                </a>
            </td>
        </tr>
        <tr>
            <td class="label">{'MONTHLY_FEE'|onapp_string}</td>
            <td>TODO!!!!</td>
        </tr>
        <tr>
            <td class="label">{'OUTSTANDING_AMOUNT'|onapp_string}</td>
            <td>{($user_obj->_total_amount - $user_obj->_payment_amount)|onapp_format_money}</td>
        </tr>
        <tr>
            <td class="label">{'PAYMENTS_'|onapp_string}</td>
            <td>{$user_obj->_payment_amount}</td>
        </tr>
        <tr>
            <td class="label">{'TOTAL_COST'|onapp_string}</td>
            <td>{$user_obj->_total_amount|onapp_format_money}</td>
        </tr>
    </table>

<h1>{'SCHEDULE_LOG'|onapp_string}</h1>
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">

        <tr>
            <th>{'DATE_'|onapp_string}</th>
            <th>{'STATUS_'|onapp_string}</th>
        </tr>
     {if $schedule_obj->_schedule_logs == null}
        <tr><td><p class="not_found">No schedule logs found<p></td></tr>
     {else}
     {foreach from=$schedule_obj->_schedule_logs item=logs}
        <tr>
            <td>
               {str_replace(array('T', 'Z'), ' ', $logs->schedule_log->created_at)}
            </td>
            <td class="{if $logs->schedule_log->status == 'complete'}enabled{else}disabled{/if}">
                {$logs->schedule_log->status}
            </td>
        </tr>
     {/foreach}
     {/if}
        </table>
    
        
    

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}