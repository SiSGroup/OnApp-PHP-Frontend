{include file="default/views/header.tpl"}

    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >
        <tr>
        <td class="label host_icon">{'HOST_NAME'|onapp_string}:</td>
        <td>{$load_balancer_obj->_hostname}</td>
        <td class="label status_icon">Status:</td>
        {if $load_balancer_obj->_booted == '1'}
            <td class="power_td">
                <a class="power on-active" href="#">ON</a>
                <a class="power off-inactive" href="{$_ALIASES["load_balancers"]}?action=shutdown&amp;id={$load_balancer_obj->_id}">OFF</a>
            </td>

        {elseif $load_balancer_obj->_suspended || $load_balancer_obj->_built < 1}
            <td>
                <a class="power pending">{'PENDING_'|onapp_string}</a>
            </td>
        {else}
            <td class="power_td">
                <a class="power on-inactive" href="{$_ALIASES["load_balancers"]}?action=startup&amp;id={$load_balancer_obj->_id}">ON</a>
                <a class="power off-active" href="#">OFF</a>
            </td>
        {/if}

        </tr>
        <tr>
        <td class="label login_icon">Login:</td>
        <td>root /{$load_balancer_obj->_initial_root_password}</td>
        <td class="label template_icon">Template:</td>
        <td>{$load_balancer_obj->_template_label}</td>
        </tr>

    </table>

    <table class="form-table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="label">Memory:</td>
            <td>{$load_balancer_obj->_memory} MB</td>
            <td class="label">Disk Size:</td>
            <td>{$load_balancer_obj->_total_disk_size} GB</td>
        </tr>
        <tr>
            <td class="label">CPU(s):</td>
            <td>{$load_balancer_obj->_cpus} CPU(s)</td>
            <td class="label">Hypervisor:</td>
            <td>{$hypervisor_obj->_label}</td>
        </tr>
        <tr>
            <td class="label">CPU Priority:</td>
            <td>{$load_balancer_obj->_cpu_shares} %</td>

            <td class="label">Owner:</td>
            <td>
                {$user_obj->_first_name} {$user_obj->_last_name}
            </td>
        </tr>
        <tr>
            <td class="label">IP Addresses: </td>
            <td>
                 {if isset( $load_balancer_obj->_ip_addresses[0] )}
                     {foreach from=$load_balancer_obj->_ip_addresses key=k item=v}
                     {$load_balancer_obj->_ip_addresses[$k]->_address}
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
                {if $load_balancer_obj->_rate_limit == 0}
                    {'UNLIMITED'|onapp_string}
                {else}
                    {$load_balancer_obj->_rate_limit}
                {/if}
            </td>

            <td class="label">&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td class="label">Administrator's Note:</td>
            <td>{$load_balancer_obj->_admin_note}</td>
        </tr>

    </table>

    <h1>{'ACTIONS_'|onapp_string}</h1>

    <table width="100%" class="table_buttons" cellpadding="0" cellspacing="10">

    {if $load_balancer_obj->_suspended != '1'}

        {if $load_balancer_obj->_booted == '1' && $load_balancer_obj->_built == '1'}

            <tr>
                <td class="action_reboot"><a href="{$_ALIASES["load_balancers"]}?action=reboot&amp;id={$load_balancer_obj->_id}">{'REBOOT_BALANCER'|onapp_string}</a></td>
                <td class="action_off"><a href="{$_ALIASES["load_balancers"]}?action=shutdown&amp;id={$load_balancer_obj->_id}">Shut down Virtual Machine</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=migrate&amp;id={$load_balancer_obj->_id}">Migrate Virtual Machine</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=reset_password&amp;id={$load_balancer_obj->_id}">Reset Root Password</a></td>
                <td class="action_rebuild"><a href="{$_ALIASES["load_balancers"]}?action=rebuild&amp;id={$load_balancer_obj->_id}">Rebuild Virtual Machine</a></td>
            </tr>
            <tr>
                <td  class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=firewall&amp;id={$load_balancer_obj->_id}">Edit Firewall Rules</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit&amp;id={$load_balancer_obj->_id}">Adjust Resource Allocation</a></td>
                {if onapp_has_permission( array( 'load_balancers.change_owner' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=change_owner&amp;id={$load_balancer_obj->_id}">Change Owner</a></td>
                {/if}
            </tr>
            <tr>
                {if onapp_has_permission( array( 'load_balancers' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=rebuild_network&amp;id={$load_balancer_obj->_id}">Rebuild Network</a></td>
                {/if}
                <!--TODO <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=segregate&amp;id={$load_balancer_obj->_id}">Segregate Virtual Machine</a></td>-->
                {if onapp_has_permission( array( 'load_balancers', 'load_balancing_clusters' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["load_balancers"]}?action=suspend&amp;id={$load_balancer_obj->_id}">{'SUSPEND_BALANCER'|onapp_string}</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit_admin_note&amp;id={$load_balancer_obj->_id}">Edit Administrator's Note</a></td>
                {/if}
            </tr>

        {elseif $load_balancer_obj->_booted != '1' && $load_balancer_obj->_built == '1'}

             <tr>
                <td class="action_on"><a href="{$_ALIASES["load_balancers"]}?action=startup&amp;id={$load_balancer_obj->_id}">{'STARTUP_BALANCER'|onapp_string}</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=migrate&amp;id={$load_balancer_obj->_id}">{'MIGRATE_BALANCER'|onapp_string}</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit&amp;id={$load_balancer_obj->_id}">{'EDIT_BALANCER'|onapp_string}</a></td>
                
            </tr>
            <tr>
               <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=rebuild&amp;id={$load_balancer_obj->_id}">{'REBUILD_BALANCER'|onapp_string}</a></td>
               {if onapp_has_permission( array( 'load_balancers', 'load_balancing_clusters', 'load_balancers.suspend' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["load_balancers"]}?action=suspend&amp;id={$load_balancer_obj->_id}">{'SUSPEND_BALANCER'|onapp_string}</a></td>
                {/if}
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit_admin_note&amp;id={$load_balancer_obj->_id}">{'EDIT_ADMINS_NOTE'|onapp_string}</a></td>
            </tr>
            <tr>
                <td class="action_delete"><a href="{$_ALIASES["load_balancers"]}?action=delete&amp;id={$load_balancer_obj->_id}">{'DELETE_BALANCER'|onapp_string}</a></td>
                <td class="action_monitis"><a href="{$_ALIASES["load_balancers"]}?action=monitis&amp;id={$load_balancer_obj->_id}">{'MONITIS_MONITORS'|onapp_string}</a></td>
            </tr>
            

        {elseif $load_balancer_obj->_booted != '1' && $load_balancer_obj->_built != '1'}

            <tr>
                <td class="action_build"><a href="{$_ALIASES["load_balancers"]}?action=build&amp;id={$load_balancer_obj->_id}">Build Virtual Machine</a></td>
                <td  class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=firewall&amp;id={$load_balancer_obj->_id}">Edit Firewall Rules</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=network_interfaces&amp;id={$load_balancer_obj->_id}">Manage Network Interfaces</a></td>
            </tr>
            <tr>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit&amp;id={$load_balancer_obj->_id}">Adjust Resource Allocation</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=change_owner&amp;id={$load_balancer_obj->_id}">Change Owner</a></td>
                {if onapp_has_permission( array( 'load_balancers', 'load_balancers.rebuild_network' ) ) == true}
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=rebuild_network&amp;id={$load_balancer_obj->_id}">Rebuild Network</a></td>
                {/if}

            </tr>
            <tr>
                <td class="action_delete"><a href="{$_ALIASES["load_balancers"]}?action=delete&amp;id={$load_balancer_obj->_id}">Delete Virtual Machine</a></td>
                {if onapp_has_permission( array( 'load_balancers', 'load_balancing_clusters', 'load_balancers.suspend' ) ) == true}
                <td class="action_reboot"><a href="{$_ALIASES["load_balancers"]}?action=suspend&amp;id={$load_balancer_obj->_id}">Suspend Virtual Machine</a></td>
                <td class="action_edit"><a href="{$_ALIASES["load_balancers"]}?action=edit_admin_note&amp;id={$load_balancer_obj->_id}">Edit Administrator's Note</a></td>
                {/if}
            </tr>
        {/if}

    {else}

        <tr>
            <td class="action_reboot"><a href="{$_ALIASES["load_balancers"]}?action=suspend&amp;id={$load_balancer_obj->_id}">Unsuspend Virtual Machine</a></td>
        <tr>

    {/if}
    </table>

    <h1>{'CLUSTER_NODES'|onapp_string}</h1>

    <br />

    {if $nodes == false}
        <p class="not_found">No nodes found<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th>{'VIRTUAL_MACHINE'|onapp_string}</th>
                <th>{'IP_ADDRESSES'|onapp_string}</th>
                <th>{'POWER_'|onapp_string}</th>
                <th></th>
            </tr>

            {foreach from=$nodes key=k item=v}
            <tr>
                <td><a title="{$v->_label}" href="{$_ALIASES["virtual_machines"]}?action=details&amp;id={$v->_id}">{$v->_label|onapp_table_display}</a></td>

                <td>
                    {if isset( $v->_ip_addresses[0] )}
                    {foreach from=$v->_ip_addresses key=k item=val}
                        {$val->_address} <br />
                    {/foreach}
                    {else}
                        {'NO_ADDRESSES'|onapp_string}
                    {/if}
                </td>
                <td class="power_td">
                {if $v->_booted == '1'}
                    <a class="power on-active" >{'ON_'|onapp_string}</a>
                    <a class="power off-inactive" href="{$_ALIASES["virtual_machines"]}?action=shutdown&amp;id={$v->_id}">{'OFF_'|onapp_string}</a>
                {elseif $v->_suspended || $v->_built < 1}
                    <a class="power pending">{'PENDING_'|onapp_string}</a>
                {else}
                    <a class="power on-inactive" href="{$_ALIASES["virtual_machines"]}?action=startup&amp;id={$v->_id}">{'ON_'|onapp_string}</a>
                    <a class="power off-active" >{'OFF_'|onapp_string}</a>
                {/if}
                </td>
                <td class="dark_td">
                    <a href="{$_ALIASES["virtual_machines"]}?action=delete&amp;id={$v->_id}">
                        <img alt="{'DESTROY_NODE'|onapp_string}" title="{'DESTROY_NODE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                    </a>
                </td>
            </tr>
        {/foreach}

    {/if}
        </table>
    
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
