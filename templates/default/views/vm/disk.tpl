{include file="default/views/header.tpl"}
<p class="page_info">{'DISK_SETTINGS_INFO_1'|onapp_string}</p>
   {if is_null($disk_obj)}
       <p class="not_found">No disks for this VM found<p>
   {else}
       <table class="table_my" cellpadding="0" cellspacing="0" border="0">
           <tr>

               <th>{'DISK_'|onapp_string}</th>
               <th>{'SIZE_'|onapp_string}</th>
               <th>{'DATA_STORE'|onapp_string}</th>
               <th>{'VIRTUAL_MACHINE'|onapp_string}</th>
               <th>{'TYPE_'|onapp_string}</th>
               <th>{'IF_BUILT'|onapp_string}</th>
               <th>{'BACKUPS_'|onapp_string}</th>
               <th>{'IF_AUTOBACKUP'|onapp_string}</th>
               <th></th>
           </tr>
       {foreach from=$disk_obj item=disk}
           {$virtual_machine_id=$disk->_virtual_machine_id}
           <tr>
               <td>
                   #{$disk->_id}
               </td>
               <td>
                   {$disk->_disk_size} GB
               </td>
               <td>
                   {$data_store_obj[$disk->_data_store_id]->_label}
               </td>
               <td>
                   {$vm_obj[$disk->_virtual_machine_id]->_label} 
               </td>
               <td>
                   {if $disk->_primary == 1}
                       {'STANDARD_PRIMARY'|onapp_string}
                   {elseif $disk->_is_swap == 1}
                       {'SWAP_'|onapp_string}
                   {else}
                       {'STANDARD_'|onapp_string}
                   {/if}
               </td>
               <td>
                   {if $disk->_built == 1}
                       {'YES_'|onapp_string}
                   {else}
                       {'NO_'|onapp_string}
                   {/if}
               </td>
               <td>
                   {$backup_quantity[$disk->_id]}
               </td>
               <td class="power_td">
                   {if $disk->_is_swap == false}
                       {if $disk->_has_autobackups == true}
                               <a class="power off-inactive" href="{$_ALIASES["virtual_machines"]}?action=autobackup_disable&amp;id={$disk->_id}&amp;virtual_machine_id={$disk->_virtual_machine_id}">{'NO_'|onapp_string}</a>
                               <a class="power on-active" >{'YES_'|onapp_string}</a>
                       {else}
                               <a class="power off-active" >{'NO_'|onapp_string}</a>
                               <a class="power on-inactive" href="{$_ALIASES["virtual_machines"]}?action=autobackup_enable&amp;id={$disk->_id}&amp;virtual_machine_id={$disk->_virtual_machine_id}">{'YES_'|onapp_string}</a>
                       {/if}
                   {else}
                       &nbsp;    
                   {/if}
               </td>
               <td class="five_icon_td">
                   {if $disk->_is_swap != true}
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_edit&amp;id={$disk->_id}">
                           <img alt= "{'EDIT_DISK_PARAMS'|onapp_string}" title="{'EDIT_DISK_PARAMS'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                       </a>
                      <!--TODO <a href="{$_ALIASES["virtual_machines"]}?action=disk_usage&amp;id={$disk->_id}">
                           <img title="{'DISK_USAGE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/chart2.png" />
                       </a> -->
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_backups&amp;id={$disk->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                           <img alt= "{'BACKUPS_LIST'|onapp_string}" title="{'BACKUPS_LIST'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/backup.png" />
                       </a>
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_backups_schedule&amp;id={$disk->_id}">
                           <img alt = "{'SCHEDULE_FOR_BACKUPS'|onapp_string}" title="{'SCHEDULE_FOR_BACKUPS'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/tasks.png" />
                       </a>
                       <a  href="{$_ALIASES["virtual_machines"]}?action=disk_delete&amp;id={$disk->_id}">
                           <img alt = "{'DESTROY_DISK'|onapp_string}" title="{'DESTROY_DISK'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                       </a>
                   {else}
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_edit&amp;id={$disk->_id}">
                           <img alt = "{'EDIT_DISK_PARAMS'|onapp_string}" title="{'EDIT_DISK_PARAMS'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                       </a>
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_usage&amp;id={$disk->_id}">
                           <img alt = "{'DISK_USAGE'|onapp_string}" title="{'DISK_USAGE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/chart2.png" />
                       </a>
                       <a href="{$_ALIASES["virtual_machines"]}?action=disk_delete&amp;id={$disk->_id}&amp;virtual_machine_id={$disk->_virtual_machine_id}">
                           <img alt = "{'DESTROY_DISK'|onapp_string}" title="{'DESTROY_DISK'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                       </a>
                   {/if}
               </td>
           </tr>
        {/foreach}
    {/if}
        </table>

        <form style="float:right" action='{$_ALIASES["virtual_machines"]}' method="post">
            <input type="hidden" name = "id" value="{$virtual_machine_id}" />
            <input type="hidden" name = "action" value="disk_create" />
            <input type="submit" value="{'ADD_NEW_DISK'|onapp_string}" />
        </form>
        
{include file="default/views/vm/navigation.tpl"}    
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
