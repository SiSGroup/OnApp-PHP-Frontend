{include file="default/views/header.tpl"}

<h1>{'VIRTUAL_MACHINES_PROPERTIES'|onapp_string}</h1>

<form action='{$_ALIASES["virtual_machines"]}' method="post">

<div class="div_page">

        <dl>
            <dt><label for="virtual_machine_label">{'LABEL_'|onapp_string}</label></dt>
            <dd><input id="virtual_machine_label" type="text" name="virtual_machine[_label]" /></dd>
        </dl>
        <dl>
            <dt><label>{'HOST_NAME'|onapp_string}</label></dt>
            <dd><input type="text" name="virtual_machine[_hostname]" /></dd>
        </dl>
        <dl>
            <dt><label>{'HYPERVISOR_ZONE'|onapp_string}</label></dt>

            <dd><select name="virtual_machine[_hypervisor_group_id]">
                    <option></option>
                        {foreach from=$hypervisor_zones_obj item=v}
                            <option value="{$v->_id}">{$v->_label}</option>
                        {/foreach}
                 </select>
           </dd>

        </dl>
        <dl>
            <dt><label>{'HYPERVISOR_'|onapp_string}</label></dt>
            <dd>
                <select name="virtual_machine[_hypervisor_id]" />
                    <option></option>
                    {foreach from=$hypervisor_obj item=v}
                        <option value="{$v->_id}">{$v->_label}</option>
                    {/foreach}
                 </select>
            </dd>
        </dl>
        <dl>
            <dt><label>{'PASSWORD_'|onapp_string}</label></dt>

            <dd><input type="text" name="virtual_machine[_initial_root_password]" /></dd>
        </dl>
   
</div>

<h1>{'TEMPLATES_'|onapp_string}</h1>

    <div class="div_page">

 <!--************************************************************************************************************************************
       <dl>
                <dt><label>{'OPERATING_SYSTEM'|onapp_string}</label></dt>

                <dd><select name="virtual_machine[_hypervisor_id]" >
                    <option></option>
                    {if is_array($templates_obj)}

                        {foreach from=$templates_obj item=v}
                            <option value="{$v->_id}">{$v->_operating_system}</option>
                        {/foreach}
                    {else}
                        <option value="{$templates_obj->_id}">{$templates_obj->_operating_system}</option>
                    {/if}
                 </select>


             </dd>
        </dl>
        <dl>
            <dt><label>{'DISTRIBUTION'|onapp_string}</label></dt>
            <dd>
                <select name="virtual_machine[_hypervisor_group_id]" >
                    <option></option>
                    {if is_array($templates_obj)}
                        {foreach from=$templates_obj item=v}
                            <option value="{$v->_id}">{$v->_operating_system_distro}</option>
                        {/foreach}
                    {else}
                        <option value="{$templates_obj->_id}">{$templates_obj->_operating_system_distro}</option>
                    {/if}
                 </select>
            </dd>
        </dl>
************************************************************************************************************************************-->

         <dl>
            <dt><label>{'TEMPLATE_'|onapp_string}</label></dt>
            <dd>
                <select name="virtual_machine[_template_id]" >
                    <option></option>
                        {foreach from=$templates_obj item=v}
                            <option value="{$v->_id}">{$v->_label}</option>
                        {/foreach}
                            
                        {foreach from=$user_templates_obj item=v}
                            <option value="{$v->_id}">{$v->_label}</option>
                        {/foreach}
                 </select>
            </dd>
        </dl>


    </div>

<h1>{'RESOURCES_'|onapp_string}</h1>

    <div class="div_page">
            <dl>
                <dt><label>{'RAM_'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_memory]" /></dd>
            </dl>
            <dl>
                <dt><label>{'CPU_CORES'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_cpus]" /></dd>
            </dl>
            <dl>
                <dt><label>{'CPU_PRIORITY'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_cpu_shares]" /></dd>
            </dl>
    </div>

<h1>{'PRIMARY_DISK'|onapp_string}</h1>

    <div class="div_page">
            <dl>
            <dt><label>{'DATA_STORE_ZONE'|onapp_string}</label></dt>
            <dd>
                <select name="virtual_machine[_data_store_group_primary_id]">
                    <option></option>
                    {if is_array($data_store_zone_obj)}

                        {foreach from=$data_store_zone_obj item=v}
                            <option value="{$v->_id}">{$v->_label}</option>
                        {/foreach}

                    {else}
                        <option value="{$data_store_zone_obj->_id}">{$data_store_zone_obj->_label}</option>

                    {/if}
                 </select>
            </dd>
            </dl>
            <dl>
                <dt><label>{'PRIMARY_DISK_SIZE'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_primary_disk_size]" /></dd>
            </dl>
            
            
    </div>

<h1>{'SWAP_DISK'|onapp_string}</h1>

    <div class="div_page">
            <dl>
            <dt><label>{'DATA_STORE_ZONE'|onapp_string}</label></dt>
            <dd>
                <select name="virtual_machine[_data_store_group_swap_id]">
                    <option></option>
                    {if is_array($data_store_zone_obj)}

                        {foreach from=$data_store_zone_obj item=v}
                            <option value="{$v->_id}">{$v->_label}</option>
                        {/foreach}

                    {else}
                        <option value="{$data_store_zone_obj->_id}">{$data_store_zone_obj->_label}</option>

                    {/if}
                 </select>
            </dd>
            </dl>
            <dl>
                <dt><label>{'SWAP_DISK_SIZE'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_swap_disk_size]" /></dd>
            </dl>


    </div>

<h1>{'NETWORK_CONFIGURATION'|onapp_string}</h1>

    <div class="div_page">
            <dl>
            <dt><label>{'NETWORK_ZONE'|onapp_string}</label></dt>
            <dd>
                <div> 
                    <select name="virtual_machine[_primary_network_group_id]" >
                        <option></option>
                        {if is_array($network_zone_obj)}
    
                            {foreach from=$network_zone_obj item=v}
                                <option value="{$v->_id}">{$v->_label}</option>
                            {/foreach}
    
                        {else}
                            <option value="{$network_zone_obj->_id}">{$network_zone_obj->_label}</option>
    
                        {/if}
                     </select>
                </div>
            </dd>
            </dl>
            <dl>
                <dt><label>{'PORT_SPEED'|onapp_string}</label></dt>
                <dd><input type="text" name="virtual_machine[_rate_limit]" /></dd>
            </dl>
            
            
    </div>

<h1>{'AUTOMATION_SETTINGS'|onapp_string}</h1>

    <div class="div_page">
             <dl>
                <dt>
                     
                </dt>
                <dd>
                    <input type="hidden" name="virtual_machine[_required_automatic_backup]" value="0" />
                    <input value="1" type="checkbox" name="virtual_machine[_required_automatic_backup]" />
                    {'REQUIRED_AUTOMATIC_BACKUP'|onapp_string}
                </dd>
            </dl>
             <dl>
                <dt>
                         
                </dt>
                <dd>
                    <input type="hidden" name="virtual_machine[_required_virtual_machine_build]" value="0" />
                    <input value="1" type="checkbox" name="virtual_machine[_required_virtual_machine_build]" />
                    {'BUILD_VIRTUAL_MACHINE_AUTOMATICALLY'|onapp_string}
                </dd>
            </dl>

    </div>

    

<!--*************************************************************************************
<h1>{'PRICE'|onapp_string}</h1>

<div class="div_page">
    <dl>
        <dd>{'PRICE_PER_HOUR'|onapp_string}: </dd>
        <dd>ON</dd>
        <dd>OFF</dd>
    </dl>
</div>

<div class="info">
    <div class="info_body">{'VIRTUAL_MACHINES_NEW_INFO_2'|onapp_string}</div>
    <div class="info_bottom"></div>

</div>
*****************************************************************************************-->

<input type="submit" value="{'CREATE_VIRTUAL_MACHINE'|onapp_string}" name="submit" />
<input type="hidden" name="action" value="create" />
<input type="hidden" name="virtual_machine[_required_ip_address_assignment]" value="1" />





</form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}