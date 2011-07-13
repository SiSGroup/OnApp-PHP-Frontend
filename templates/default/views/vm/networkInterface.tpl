{include file="default/views/header.tpl"}
    {if $network_interface_obj == false}
        <p class="not_found">{'NO_NETWORK_INTERFACE_FOUND'|onapp_string}<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">

        <tr>
            <th>{'INTERFACE_'|onapp_string}</th>
            <th>{'NETWORK_JOIN'|onapp_string}</th>
            <th>{'PORT_SPEED'|onapp_string}</th>
            <th>{'IF_PRIMARY_INTERFACE'|onapp_string}</th>
            <th></th>
                
        </tr>
    {foreach from=$network_interface_obj item=network_interface}
        <tr>
            <td>
                {$network_interface->_label}
            </td>
            <td>
                {$network_labels[$network_interface->_network_join_id]->_label} ( {$hypervisor_label} )
            </td>
            <td>
                {if $network_interface->_rate_limit == 0}
                    {'UNLIMITED'|onapp_string}
                {else}
                    {$network_interface->_rate_limit}Mbps
                {/if}
            </td>
            <td>
                {if $network_interface->_primary == 1}
                    <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/true.png" />
                {else}
                    <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/false.png" />
                {/if}
            </td>
            <td class="tree_icon_td">
                <a href="{$_ALIASES["virtual_machines"]}?action=interface_usage&amp;id={$network_interface->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                    <img title="{'INTERFACE_USAGE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/chart2.png" />
                </a>
                <a href="{$_ALIASES["virtual_machines"]}?action=network_interface_edit&amp;id={$network_interface->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                    <img title="{'EDIT_INTERFACE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                </a>
                <a href="{$_ALIASES["virtual_machines"]}?action=network_interface_delete&amp;id={$network_interface->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                    <img title="{'DELETE_INTERFACE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
            </td>
        </tr>
    {/foreach}
    
        </table>
    {/if}
        <div>
            <form style="float:right;" action='{$_ALIASES["virtual_machines"]}' method="post">
                <input type="submit" value="{'ADD_NEW_NETWORK_INTERFACE'|onapp_string}" />
                <input type="hidden" name="id" value="{$virtual_machine_id}" />
                <input type="hidden" name="action" value="network_interface_create" />
            </form>
        </div>
    
{include file="default/views/vm/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}