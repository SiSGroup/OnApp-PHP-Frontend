{include file="default/views/header.tpl"}

   {if is_null($schedule_obj)}
       <p class="not_found">No schedules found<p>
   {else}
       <table class="table_my" cellpadding="0" cellspacing="0" border="0">
           <tr>
               <th>{'DATE_'|onapp_string}</th>
               <th>{'TARGET_'|onapp_string}</th>
               <th>{'ACTION_'|onapp_string}</th>
               <th>{'DURATION_'|onapp_string}</th>
               <th>{'PERIOD_'|onapp_string}</th>
               <th>{'NEXT_START'|onapp_string}</th>
               <th>{'USER_'|onapp_string}</th>
               <th>{'STATUS_'|onapp_string}</th>
               <th></th>
           </tr>
       {foreach from=$schedule_obj item=schedule}
           <tr>
               <td>
                   <a href="{$_ALIASES["virtual_machines"]}?action=disk_backups_schedule_details&amp;id={$schedule->_id}">
                       {substr( $schedule->_created_at, 0, 10 )}
                   </a>
               </td>
               <td>
                   <a href="#">
                       Disk#{$schedule->_target_id}
                   </a>
               </td>
               <td>
                   {$schedule->_action}
               </td>
               <td>
                   {$schedule->_duration}
               </td>
               <td>
                   {$schedule->_period}
               </td>
               <td>
                   {substr( $schedule->_created_at, 0, 10 )}
               </td>
               <td>
                   #{$schedule->_user_id}
               </td>
               <td class="{if $schedule->_status == 'enabled'}enabled{else}disabled{/if}">
                   {$schedule->_status}
               </td>

               <td class="dark_td">
                   
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_backups_schedule_edit&amp;id={$schedule->_id}">
                           <img title="" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                       </a>
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_backups_schedule_delete&amp;id={$schedule->_id}&amp;disk_id={$schedule->_target_id}">
                           <img title="" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                       </a>
                  
               </td>
           </tr>
        {/foreach}
    {/if}
        </table>
        <form style="float:right" action='{$_ALIASES["virtual_machines"]}' method="post">
            <input type="hidden" name = "id" value="{$disk_id}" />
            <input type="hidden" name = "action" value="disk_backups_schedule_create" />
            <input type="submit" value="{'NEW_SCHEDULE'|onapp_string}" />
        </form>
        
   
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
