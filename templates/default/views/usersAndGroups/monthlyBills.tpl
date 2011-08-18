{include file="default/views/header.tpl"}

     {if $monthly_bills_obj == null}
        <p class="not_found">No statistics available</p>
     {else}
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'MONTH_'|onapp_string}</th>
            <th>{'USER_'|onapp_string}</th>
            <th>{'COST_'|onapp_string}</th>
        </tr>
     
     {foreach from=$monthly_bills_obj item=bill}
        <tr>
            <td>
               {($monthes[$bill->_month])|onapp_string}, {date('Y')}
            </td>
            <td>
                {$user_obj->_first_name} {$user_obj->_last_name}
            </td>
            <td>
                {round( $bill->_cost, 2)|onapp_format_money} {$billing_plan_obj->_currency_code}
            </td>
        </tr>
     {/foreach}
    </table>
     {/if}
    <table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
        <tr>
            <td class="label">{'TOTAL_AMOUNT'|onapp_string}</td>
            <td>{round( $total_amount, 2 )|onapp_format_money} {$billing_plan_obj->_currency_code}</td>
        </tr>
    </table>
 
{include file="default/views/usersAndGroups/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}