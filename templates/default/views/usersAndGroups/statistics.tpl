{include file="default/views/header.tpl"}

<h1>{$user_obj->_first_name} {$user_obj->_last_name}</h1>
<table style="border-bottom:none" class="form-table" width="50%" cellpadding="0" cellspacing="0" >
    <tr>
        <td class="label">{'BACKUPS_TEMPLATES_COST'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_user_resources_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td>{'BACKUPS_COSTS'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_backup_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td>{'MONITIS_FEE'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_monit_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td>{'STORAGE_DISKS_SIZE_COSTS'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_storage_disk_size_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td>{'TEMPLATES_COSTS'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_template_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td class="label">{'VIRTUAL_MACHINES_COST'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_vm_cost, 2 )|onapp_format_money}</td>
    </tr>
    <tr>
        <td class="label">{'TOTAL_COST'|onapp_string}</td>
        <td>{round( $statistics_obj[0]->_total_cost, 2 )|onapp_format_money}</td>
    </tr>
</table>

     {if $statistics_obj[0]->_vm_stats == null}
    <p class="not_found">No resources found</p>
     {else}
     {foreach from=$statistics_obj[0]->_vm_stats item=stat}
<table class="table_my" cellpadding="0" cellspacing="0" border="0">

    <tr>
        <th>{'VIRTUAL_MACHINE'|onapp_string}</th>
        <th>{'RESOURCES_COST'|onapp_string}</th>
        <th>{'USAGE_COST'|onapp_string}</th>
        <th>{'TOTAL_'|onapp_string}</th>

    </tr>
    <tr>
        <td>
            {if  $vm_labels[$stat->_virtual_machine_id] != '0'}
                 <a href="{$_ALIASES["virtual_machines"]}?action=details&amp;id={$stat->_virtual_machine_id}">
                    {$vm_labels[$stat->_virtual_machine_id]}
                 </a>
            {else}
                {'VM_DELETED'|onapp_string}
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