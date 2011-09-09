{include file="default_web20cart/views/header.tpl"}

<h1>{'PROPERTIES_'|onapp_string}</h1>
    <table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
        <tr>
            <td class="label">{'DATE_'|onapp_string}</td>
            <td>{str_replace(array('T', 'Z'), ' ', $schedule_obj->_created_at)}</td>
        </tr>
        <tr>
            <td class="label">{'TARGET_'|onapp_string}</td>
            <td>#{$schedule_obj->_target_id}</td>
        </tr>
        <tr>
            <td class="label">{'ACTION_'|onapp_string}</td>
            <td>{$schedule_obj->_action}</td>
        </tr>
        <tr>
            <td class="label">{'DURATION_'|onapp_string}</td>
            <td>{$schedule_obj->_duration}</td>
        </tr>
        <tr>
            <td class="label">{'PERIOD_'|onapp_string}</td>
            <td>{$schedule_obj->_period}</td>
        </tr>
        <tr>
            <td class="label">{'NEXT_START'|onapp_string}</td>
            <td>{$schedule_obj->_start_at}</td>
        </tr>
        <tr>
            <td class="label">{'USER_'|onapp_string}</td>
            <td>{$user_first_name} {$user_last_name}</td>
        </tr>
        <tr>
            <td class="label">{'STATUS_'|onapp_string}</td>
            <td>{$schedule_obj->_status}</td>
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
    
        
    

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}