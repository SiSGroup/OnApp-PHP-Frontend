{include file="default/views/header.tpl"}

<h1>{$title}</h1>
    <form action='{$_ALIASES["hypervisors"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="label_field">{'LABEL_'|onapp_string}</label></dt>
                <dd>
                    <input id="hypervisor_field" type="text" name="hypervisor[_label]" value="{$hypervisor_obj->_label}"  />
                </dd>
            </dl>
            <dl>
                <dt><label for="ip_address">{'IP_ADDRESS'|onapp_string}</label></dt>
                <dd><input id="ip_address" type="text" name="hypervisor[_ip_address]" value="{$hypervisor_obj->_ip_address}" /></dd>
            </dl>
            <dl>
                <dt><label for="memory_overhead">{'MEMORY_OVERHEAD'|onapp_string}</label></dt>
                <dd><input id="memory_overhead" type="text" name="hypervisor[_memory_overhead]" value="{$hypervisor_obj->_memory_overhead}" /></dd>
            </dl>
            <dl>
                <dt><label for="user_time_zone">{'HYPERVISOR_TYPE'|onapp_string}</label></dt>
                <dd>
                    <select id="hypervisor_type" name="hypervisor[_hypervisor_type]">
                    {foreach from=$hypervisor_types item=type}
                        <option value="{$type}" {if $type == $hypervisor_obj->_hypervisor_type}selected="selected"{/if}>{$type}</option>
                    {/foreach}
                    </select>
                </dd>
            </dl>
            <dl>
                <dt class="dt_checkbox">
                    <input type="hidden" name="hypervisor[_enabled]" value="0">
                    <input value="1" name="hypervisor[_enabled]" type="checkbox"
                        {if $hypervisor_obj->_enabled == true}
                            checked
                        {/if}
                    /> &nbsp;&nbsp;&nbsp;{'ENABLED_'|onapp_string}
                </dt>
            </dl>
           
         </div>
        <input type="hidden" name = "id" value="{$hypervisor_id}" />
        <input type="hidden" name = "action" value="edit" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}