{include file="default/views/header.tpl"}

    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >
        <tr>
        <td class="label host_icon">{'HOST_NAME'|onapp_string}:</td>
        <td>{$vm_obj->_hostname}</td>
        <td class="label status_icon">Status:</td>
        {if $vm_obj->_booted == '1'}
            <td class="power_td">
                <a class="power on-active" href="#">ON</a>
                <a class="power off-inactive" href="{$_ALIASES["virtual_machines"]}?action=shutdown&amp;id={$vm_obj->_id}">OFF</a>
            </td>

        {elseif $vm_obj->_suspended || $vm_obj->_built < 1}
            <td>
                <a class="power pending">{'PENDING_'|onapp_string}</a>
            </td>
        {else}
            <td class="power_td">
                <a class="power on-inactive" href="{$_ALIASES["virtual_machines"]}?action=startup&amp;id={$vm_obj->_id}">ON</a>
                <a class="power off-active" href="#">OFF</a>
            </td>
        {/if}

        </tr>
        <tr>
        <td class="label login_icon">Login:</td>
        <td>root /{$vm_obj->_initial_root_password}</td>
        <td class="label template_icon">Template:</td>
        <td>{$vm_obj->_template_label}</td>
        </tr>

    </table>

    <table class="form-table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="label">Memory:</td>
            <td>{$vm_obj->_memory} MB</td>
            <td class="label">Disk Size:</td>
            <td>{$vm_obj->_total_disk_size} GB</td>
        </tr>
        <tr>
            <td class="label">CPU(s):</td>
            <td>{$vm_obj->_cpus} CPU(s)</td>
            <td class="label">Hypervisor:</td>
            <td>{$hypervisor_obj->_label}</td>
        </tr>
        <tr>
            <td class="label">CPU Priority:</td>
            <td>{$vm_obj->_cpu_shares} %</td>

            <td class="label">Owner:</td>
            <td>
                {$user_obj->_first_name} {$user_obj->_last_name}
            </td>
        </tr>
        <tr>
            <td class="label">IP Addresses: </td>
            <td>
                 {if isset( $vm_obj->_ip_addresses[0] )}
                     {foreach from=$vm_obj->_ip_addresses key=k item=v}
                     {$vm_obj->_ip_addresses[$k]->_address}
                     {/foreach}
                 {else}
                    {'NO_ADDRESSES'|onapp_string}
                 {/if}
            </td>
            <td class="label">Disk backups:</td>
            <td>{$backups_quantity} / {$backups_total_size} MB</td>
        </tr>
        <tr>
            <td class="label">Network Speed:</td>
            <td>
                {if $vm_obj->_rate_limit == 0}
                    {'UNLIMITED'|onapp_string}
                {else}
                    {$vm_obj->_rate_limit}
                {/if}
            </td>

            <td class="label">&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td class="label">Administrator's Note:</td>
            <td>{$vm_obj->_admin_note}</td>
        </tr>

    </table>

    <h1>Actions</h1>

    <table width="100%" class="table_buttons" cellpadding="0" cellspacing="10">

    {if $vm_obj->_suspended != '1'}

        {if $vm_obj->_booted == '1' && $vm_obj->_built == '1'}

            <tr>
                <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=reboot&amp;id={$vm_obj->_id}">Reboot Virtual Machine</a></td>
                <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=reboot&amp;mode=recovery&amp;id={$vm_obj->_id}">Reboot in Recovery</a></td>
                <td class="action_off"><a href="{$_ALIASES["virtual_machines"]}?action=shutdown&amp;id={$vm_obj->_id}">Shut down Virtual Machine</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=migrate&amp;id={$vm_obj->_id}">Migrate Virtual Machine</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=reset_password&amp;id={$vm_obj->_id}">Reset Root Password</a></td>
                <td class="action_rebuild"><a href="{$_ALIASES["virtual_machines"]}?action=rebuild&amp;id={$vm_obj->_id}">Rebuild Virtual Machine</a></td>
            </tr>
            <tr>
                <td  class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=firewall&amp;id={$vm_obj->_id}">Edit Firewall Rules</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit&amp;id={$vm_obj->_id}">Adjust Resource Allocation</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=change_owner&amp;id={$vm_obj->_id}">Change Owner</a></td>
            </tr>
            <tr>
                {if onapp_has_permission( array( 'virtual_machines' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=rebuild_network&amp;id={$vm_obj->_id}">Rebuild Network</a></td>
                {/if}
                <!--TODO <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=segregate&amp;id={$vm_obj->_id}">Segregate Virtual Machine</a></td>-->
                {if onapp_has_permission( array( 'virtual_machines' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=suspend&amp;id={$vm_obj->_id}">Suspend Virtual Machine</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit_admin_note&amp;id={$vm_obj->_id}">Edit Administrator's Note</a></td>
                {/if}
            </tr>

        {elseif $vm_obj->_booted != '1' && $vm_obj->_built == '1'}

             <tr>
                <td class="action_on"><a href="{$_ALIASES["virtual_machines"]}?action=startup&amp;id={$vm_obj->_id}">Startup Virtual Machine</a></td>
                <td class="action_on"><a href="{$_ALIASES["virtual_machines"]}?action=startup&amp;mode=recovery&amp;id={$vm_obj->_id}">Startup on Recovery</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=migrate&amp;id={$vm_obj->_id}">Migrate Virtual Machine</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=reset_password&amp;id={$vm_obj->_id}">Reset Root Password</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=rebuild&amp;id={$vm_obj->_id}">Rebuild Virtual Machine</a></td>
                <td  class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=firewall&amp;id={$vm_obj->_id}">Edit Firewall Rules</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=network_interfaces&amp;id={$vm_obj->_id}">Manage Network Interfaces</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit&amp;id={$vm_obj->_id}">Adjust Resource Allocation</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=change_owner&amp;id={$vm_obj->_id}">Change Owner</a></td>
            </tr>
            <tr>
                {if onapp_has_permission( array( 'virtual_machines', 'virtual_machines.rebuild_network' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=rebuild_network&amp;id={$vm_obj->_id}">Rebuild Network</a></td>
                {/if}
                <!-- TODO<td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=segregate&amp;id={$vm_obj->_id}">Segregate Virtual Machine</a></td> -->
                <td class="action_delete"><a href="{$_ALIASES["virtual_machines"]}?action=delete&amp;id={$vm_obj->_id}">Delete Virtual Machine</a></td>
                {if onapp_has_permission( array( 'virtual_machines', 'virtual_machines.suspend' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=suspend&amp;id={$vm_obj->_id}">Suspend Virtual Machine</a></td>
                {/if}
            </tr>
            <tr>
                {if onapp_has_permission( array( 'virtual_machines' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit_admin_note&amp;id={$vm_obj->_id}">Edit Administrator's Note</a></td>
                {/if}
            </tr>

        {elseif $vm_obj->_booted != '1' && $vm_obj->_built != '1'}

            <tr>
                <td class="action_build"><a href="{$_ALIASES["virtual_machines"]}?action=build&amp;id={$vm_obj->_id}">Build Virtual Machine</a></td>
                <td  class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=firewall&amp;id={$vm_obj->_id}">Edit Firewall Rules</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=network_interfaces&amp;id={$vm_obj->_id}">Manage Network Interfaces</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit&amp;id={$vm_obj->_id}">Adjust Resource Allocation</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=change_owner&amp;id={$vm_obj->_id}">Change Owner</a></td>
                {if onapp_has_permission( array( 'virtual_machines', 'virtual_machines.rebuild_network' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=rebuild_network&amp;id={$vm_obj->_id}">Rebuild Network</a></td>
                {/if}

            </tr>
            <tr>
               <!--TODO <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=segregate&amp;id={$vm_obj->_id}">Segregate Virtual Machine</a></td> -->
                <td class="action_delete"><a href="{$_ALIASES["virtual_machines"]}?action=delete&amp;id={$vm_obj->_id}">Delete Virtual Machine</a></td>
                {if onapp_has_permission( array( 'virtual_machines', 'virtual_machines.suspend' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=suspend&amp;id={$vm_obj->_id}">Suspend Virtual Machine</a></td>
                <td class="action_edit"><a href="{$_ALIASES["virtual_machines"]}?action=edit_admin_note&amp;id={$vm_obj->_id}">Edit Administrator's Note</a></td>
                {/if}
            </tr>
        {/if}

    {else}

        <tr>
            <td class="action_reboot"><a href="{$_ALIASES["virtual_machines"]}?action=suspend&amp;id={$vm_obj->_id}">Unsuspend Virtual Machine</a></td>
        <tr>

    {/if}
    </table>
    
{include file="default/views/vm/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
