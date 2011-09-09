{include file="default_web20cart/views/header.tpl"}
    {if $ip_address_obj == false}
        <p class="not_found">{'NO_IP_ADDRESSES_FOUND'|onapp_string}<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">

        <tr>
            <th>{'IP_ADDRESS'|onapp_string}</th>
            <th>{'NETMASK_'|onapp_string}</th>
            <th>{'GATEWAY_'|onapp_string}</th>
            <th>{'PHYSICAL_NETWORK'|onapp_string}</th>
            <th></th>
                
        </tr>
    {foreach from=$ip_address_obj item=ip_address}
        <tr>
            <td>
                {$ip_address->_ip_address->ip_address->address}
            </td>
            <td>
                {$ip_address->_ip_address->ip_address->netmask}
            </td>
            <td>
                {$ip_address->_ip_address->ip_address->gateway}
            </td>
            <td>
                {$network_obj[$ip_address->_ip_address->ip_address->network_id]->_label} 
                ( <b>{$hypervisor_label}</b> )
                ( on {$network_interface_obj[$ip_address->_network_interface_id]->_label} interface )
            </td>
            <td>
                <a href="{$_ALIASES["virtual_machines"]}?action=ip_address_delete&amp;id={$ip_address->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                    <img title="{'DELETE_ASSIGNMENT'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
            </td>
        </tr>
    {/foreach}
        </table>
    {/if}
        <div>
            <form style="float:right;" action='{$_ALIASES["virtual_machines"]}' method="post">
                <input type="submit" value="{'ALLOCATE_NEW_IP_ADDRESS_ASSIGNMENT'|onapp_string}" />
                <input type="hidden" name="id" value="{$virtual_machine_id}" />
                <input type="hidden" name="action" value="ip_address_join_new" />
            </form>

            <form style="float:right;" action='{$_ALIASES["virtual_machines"]}' method="post">
                <input type="submit" value="{'REBUILD_NETWORK'|onapp_string}" />
                <input type="hidden" name="id" value="{$virtual_machine_id}" />
                <input type="hidden" name="action" value="rebuild_network" />
            </form>
        </div>
    

{include file="default_web20cart/views/vm/navigation.tpl"}
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}