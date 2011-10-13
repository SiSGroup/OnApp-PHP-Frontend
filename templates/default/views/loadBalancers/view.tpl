{include file="default/views/header.tpl"}
    
    {if $load_balancers_obj == false}
        <p class="not_found">No resources found<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th></th>
                <th>{'LABEL_'|onapp_string}</th>
                <th>{'IP_ADDRESSES'|onapp_string}</th>
                <th>{'POWER_'|onapp_string}</th>
                <th>{'DISK_SIZE'|onapp_string}</th>
                <th>{'RAM_'|onapp_string}</th>
                <th>{'NODES_'|onapp_string}</th>
                <th>{'HYPERVISOR_'|onapp_string}</th>
                <th></th>
            </tr>
    
            {foreach from=$load_balancers_obj key=k item=v}
            <tr>
                <td class="lamp">
                    {if $v->_booted > 0}
                        <img alt="{'ON_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/on.png" />

                    {else}
                        <img alt="{'OFF_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/off.png" />
                    {/if}
                </td>
                <td>
                    <a title="{$v->_label}" href="{$_ALIASES["load_balancers"]}?action=details&amp;id={$v->_id}&amp;cluster={$load_balancing[$v->_id]->_id}">
                        {$v->_label|onapp_table_display}
                    </a>
                </td>
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
                    <a class="power off-inactive" href="{$_ALIASES["load_balancers"]}?action=shutdown&amp;id={$v->_id}">{'OFF_'|onapp_string}</a>
                {elseif $v->_suspended || $v->_built < 1}
                    <a class="power pending">{'PENDING_'|onapp_string}</a>
                {else}
                    <a class="power on-inactive" href="{$_ALIASES["load_balancers"]}?action=startup&amp;id={$v->_id}">{'ON_'|onapp_string}</a>
                    <a class="power off-active" >{'OFF_'|onapp_string}</a>
                {/if}
                </td>
                <td>{$v->_total_disk_size} GB</td>
                <td>{$v->_memory|onapp_file_size}</td>
                <td>{$load_balancing[$v->_id]->_nodes_count}</td>
                <td>{$hypervisors_obj[$v->_hypervisor_id]->_label}</td>
                <td class="dark_td">
                    <a href="{$_ALIASES["load_balancers"]}?action=edit&amp;id={$load_balancing[$v->_id]->_id}">
                        <img alt="{'EDIT_CLUSTER'|onapp_string}" title="{'EDIT_CLUSTER'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                    </a>
                    <a href="{$_ALIASES["load_balancers"]}?action=delete&amp;id={$load_balancing[$v->_id]->_id}">
                        <img alt="{'DESTROY_CLUSTER'|onapp_string}" title="{'EDIT_CLUSTER'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                    </a>
                </td>
            </tr>      
        {/foreach}
    
    {/if}
    </table>
    
    <div>
        <form action="{$_ALIASES["load_balancers"]}" method="post">
               <input type="submit" value="{'ADD_A_NEW_BALANCER'|onapp_string}" />
               <input type="hidden" name="action" value="create_page" />
        </form>
    </div>
    


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}