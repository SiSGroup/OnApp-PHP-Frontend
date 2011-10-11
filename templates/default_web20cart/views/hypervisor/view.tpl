{include file="default_web20cart/views/header.tpl"}

   
     <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th></th>
            <th>Label</th>
            <th>IP Address</th>
            <th>Type</th>
            <th>Hypervisor zone</th>
            <th>CPU Cores</th>
            <th>CPU resources used</th>
            <th>VMs</th>
            <th>RAM</th>
            <th>CPU Mhz</th>
        </tr>
            {foreach from=$hypervisor_obj key=k item=v}
                <tr>
                    <td class="lamp">
                        {if $v->_online > 0}
                            <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/on.png" />
                        {else}
                            <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/off.png" />
                        {/if}
                    </td>
                    <td>
                        <a href="{$_ALIASES["virtual_machines"]}?action=vm_default&amp;hypervisor_id={$v->_id}&amp;hypervisor_label={$v->_label}">
                            {$v->_label}
                        </a>
                    </td>

                    <td>{$v->_ip_address}</td>
                    <td>{$v->_hypervisor_type}</td>
                    <td>
                       {if is_array($hypervisor_zones_obj)}

                            {foreach from=$hypervisor_zones_obj item=hz}
                                {if $v->_hypervisor_group_id == $hz->_id}
                                    {$hz->_label}
                                {/if}
                            {/foreach}

                        {else}
                             {if $v->_hypervisor_group_id == $hypervisor_zones_obj->_id}
                                    {$hypervisor_zones_obj->_label}
                             {/if}

                        {/if}
                    </td>
                    <td>{$v->cpu_cores}</td>
                    <td>{$v->used_cpu_resources}% </td>
                    <td>{$hypervisor_vm_count[$v->_id]}</td>
                    <td>
                        {$v->total_memory|onapp_file_size}
                        {if $v->_online}
                           ({$v->free_memory|onapp_file_size} free)
                        {/if}
                    </td>
                    <td>{$hypervisor_xm_info[$v->_id]['cpu_mhz']}</td>

                </tr>

            {/foreach}
    </table>

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}