{include file="default/views/header.tpl"}

   {if is_null($backup_obj)}
       <p class="not_found">No backups for this VM found<p>
   {else}
       <table class="table_my" cellpadding="0" cellspacing="0" border="0">
           <tr>

               <th>{'DATE_TIME'|onapp_string}</th>
               <th>{'DISK_'|onapp_string}</th>
               <th>{'STATUS_'|onapp_string}</th>
               <th>{'BACKUP_SIZE'|onapp_string}</th>
               <th>{'BACKUP_TYPE'|onapp_string}</th>
               <th></th>
               <th></th>
           </tr>
       {foreach from=$backup_obj item=backup}
           <tr>
               <td>
                        {$backup->_created_at}
               </td>
               <td>
                        <a href="{$_ALIASES["virtual_machines"]}?action=disks&amp;id={$backup->_disk_id}">#{$backup->_disk_id}</a>
               </td>
               <td>
                   {if $backup->_built == 1}
                       Built
                   {else}
                       Not Built
                   {/if}
               </td>
               <td>
                   {round($backup->_backup_size/1024)} MB
               </td>
               <td>
                   {$backup->_backup_type}
               </td>
               <td>
                   <a href="{$_ALIASES["virtual_machines"]}?action=backup_convert&amp;id={$backup->_id}">{'CONVERT_TO_TEMPLATE'|onapp_string}</a>
                   <a href="{$_ALIASES["virtual_machines"]}?action=backup_restore&amp;id={$backup->_id}">{'RESTORE_'|onapp_string}</a>
               </td>
               <td class="dark_td">
                   {if $backup->_built == 1}
                       <a href="{$_ALIASES["virtual_machines"]}?action=backup_delete&amp;id={$backup->_id}">
                           <img title="{'DELETE_BACKUP'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                       </a>
                   {/if}
               </td>
           </tr>
        {/foreach}
    {/if}
        </table>
        
{include file="default/views/vm/navigation.tpl"}   
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
