{include file="default_web20cart/views/header.tpl"}

   
    <div class="info">

       <div class="info_title">
            {'HYPERVISORS_'|onapp_string}
        </div>

       <div class="info_body">
            {'VIRTUAL_MACHINES_DEFAULT_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

    </div>

    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th></th>
            <th>Label</th>
            <th>IP Address</th>
            <th>Type</th>
            <th>Hypervisor zone</th>
            <th>CPU Cores</th>
          <!--  <th>CPU resources used / available</th> -->
            <th>VMs</th>
            <th>RAM</th>
            <th>CPU Mhz</th>    
        </tr>
        {if is_array($hypervisor_obj) && $hypervisor_obj != false}
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
                    <td>{$hypervisor_xm_info[$v->_id]['nr_cpus']}</td>
<!--                <td></td> -->
                    <td>{$hypervisor_vm_count[$v->_id]}</td>
                    <td>
                        {round($hypervisor_xm_info[$v->_id]['total_memory']/1024, 2)} GB
                        {if $v->_online}
                            ( {round($hypervisor_xm_info[$v->_id]['free_memory']/1024, 2)} GB free)
                        {/if}
                    </td>
                    <td>{$hypervisor_xm_info[$v->_id]['cpu_mhz']}</td>
                   
                </tr>
                      
            {/foreach}
        {elseif is_array($hypervisor_obj) == false}    
            
            <tr>
                    <td class="lamp">
                        {if $hypervisor_obj->_online > 0}
                            <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/on.png" />
                        {else}
                            <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/off.png" />
                        {/if}
                    </td>
                    <td><a href="{$_ALIASES["hypervisors"]}?action=hypervisor_details&amp;id={$hypervisor_obj->_id}">{$hypervisor_obj->_label}</a></td>
                    
                    <td>{$hypervisor_obj->_ip_address}</td>
                    <td>{$hypervisor_obj->_hypervisor_type}</td>
                    <td>
                       {if is_array($hypervisor_zones_obj)}
                    
                            {foreach from=$hypervisor_zones_obj item=hz}
                                {if $hypervisor_obj->_hypervisor_group_id == $hz->_id}
                                    {$hz->_label}
                                {/if}
                            {/foreach}
                        
                        {else}
                             {if $hypervisor_obj->_hypervisor_group_id == $hypervisor_zones_obj->_id}
                                    {$hypervisor_zones_obj->_label}
                             {/if} 
                               
                        {/if}
                    </td>
                    <td>{$hypervisor_xm_info[$hypervisor_obj->_id]['nr_cpus']}</td>
<!--                <td></td> -->
                    <td>{$hypervisor_vm_count[$hypervisor_obj->_id]}</td>
                    <td>
                        {round($hypervisor_xm_info[$hypervisor_obj->_id]['total_memory']/1024, 2)} GB
                        {if $v->_online}
                            ( {round($hypervisor_xm_info[$hypervisor_obj->_id]['free_memory']/1024, 2)} GB free)
                        {/if}
                    </td>
                    <td>{$hypervisor_xm_info[$hypervisor_obj->_id]['cpu_mhz']}</td>
                   
                </tr>
            
        {/if}
        
    </table>

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}