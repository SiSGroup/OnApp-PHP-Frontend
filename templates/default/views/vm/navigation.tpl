<br /><br /><br /><br />
    <h1>{'VIRTUAL_MACHINE_MENU'|onapp_string}</h1>

    <table width="100%" class="table_buttons" cellpadding="0" cellspacing="10">
        <tr>
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=cpu_usage&amp;id={$virtual_machine_id}">{'CPU_USAGE'|onapp_string}</a></td>
            <!-- TODO<td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=billing_statistics&amp;id={$virtual_machine_id}">{'BILLING_STATISTICS'|onapp_string}</a></td> -->
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=network_interfaces&amp;id={$virtual_machine_id}">{'NETWORK_INTERFACES'|onapp_string}</a></td>
{if $vm_obj->_booted == '1'}
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=console&amp;id={$virtual_machine_id}">{'CONSOLE_'|onapp_string}</a></td>
{else}
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=details&amp;id={$virtual_machine_id}">{'VM_DETAILS'|onapp_string}</a></td>
{/if}
        </tr>
        <tr>
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=firewall&amp;id={$virtual_machine_id}">{'FIREWALL_'|onapp_string}</a></td>
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=ip_addresses&amp;id={$virtual_machine_id}">{'IP_ADDRESSES'|onapp_string}</a></td>
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=disks&amp;id={$virtual_machine_id}">{'DISKS_'|onapp_string}</a></td>
        </tr>
        <tr>
            <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=backup&amp;id={$virtual_machine_id}">{'BACKUPS_'|onapp_string}</a></td>
        </tr>
    </table>