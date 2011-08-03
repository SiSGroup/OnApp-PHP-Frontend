{include file="default/views/header.tpl"}

    <h1>{$user_obj->_first_name} {$user_obj->_last_name}</h1>
    <table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
        <tr>
            <td class="label">{'BACKUPS_TEMPLATES_COST'|onapp_string}</td>
            <td>{$statistics_obj[0]->_user_resources_cost}</td>
        </tr>
        <tr>
            <td>{'BACKUPS_COSTS'|onapp_string}</td>
            <td>{$statistics_obj[0]->_backup_cost}</td>
        </tr>
        <tr>
            <td>{'MONITIS_FEE'|onapp_string}</td>
            <td>{$statistics_obj[0]->_monit_cost}</td>
        </tr>
        <tr>
            <td>{'STORAGE_DISKS_SIZE_COSTS'|onapp_string}</td>
            <td>{$statistics_obj[0]->_storage_disk_size_cost}</td>
        </tr>
        <tr>
            <td>{'TEMPLATES_COSTS'|onapp_string}</td>
            <td>{$statistics_obj[0]->_template_cost}</td>
        </tr>
        <tr>
            <td class="label">{'VIRTUAL_MACHINES_COST'|onapp_string}</td>
            <td>{$statistics_obj[0]->_vm_cost}</td>
        </tr>
        <tr>
            <td class="label">{'TOTAL_COST'|onapp_string}</td>
            <td>{$statistics_obj[0]->_total_cost}</td>
        </tr>
    </table>
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">

        <tr>
            <th>{'VIRTUAL_MACHINE'|onapp_string}</th>
            <th>{'RESOURCES_COST'|onapp_string}</th>
            <th>{'USAGE_COST'|onapp_string}</th>
            <th>{'TOTAL_'|onapp_string}</th>

        </tr>
     {if $statistics_obj[0]->_vm_stats == null}
        <p class="not_found">No resources found</p>
     {else}
     {foreach from=$statistics_obj[0]->_vm_stats item=stat}
        <tr>
            <td>
               {if $stat->_virtual_machine_id == 0} 
                   {'VM_DELETED'|onapp_string}
               {else}
                   {if isset($vm_labels[$stat->_virtual_machine_id])}
                       {$vm_labels[$stat->_virtual_machine_id]}
                   {else}
                       ticket#2455
                   {/if}
               {/if}
            </td>
            <td>
                {round( $stat->_vm_resources_cost, 2 )|onapp_format_money} {$currency}
            </td>
            <td>
                {round( $stat->_usage_cost, 2 )|onapp_format_money} {$currency}
            </td>
            <td>
                {round( $stat->_total_cost, 2 )|onapp_format_money} {$currency}
            </td>
        </tr>
     {/foreach}
     {/if}
        </table>
        
    
        
    
{include file="default/views/usersAndGroups/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}