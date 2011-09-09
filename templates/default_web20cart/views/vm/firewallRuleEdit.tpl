{include file="default_web20cart/views/header.tpl"}
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="period">{'INTERFACE_'|onapp_string}</label></dt>
                <dd>
                    <select id="period"  name="firewall[_network_interface_id]">
                        <option></option>
                        {foreach from=$network_interface_obj item=network_interface}
                            <option value="{$network_interface->_id}"{if $network_interface->_id == $firewall_obj->_network_interface_id}selected="true"{/if} >
                                {$network_interface->_label}
                            </option>
                        {/foreach}
                    </select>
                </dd>
            </dl>
            
            </dl>
            <dl>
                <dt><label for="command">{'COMMAND_'|onapp_string}</label></dt>
                <dd>
                    <select id="command"  name="firewall[_command]">
                        <option></option>
                        {foreach from=$commands item=command_item}
                            <option value="{$command_item}"{if $command_item == $firewall_obj->_command}selected="true"{/if} >
                                {$command_item}
                            </option>
                        {/foreach} 
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><label for="address">{'SOURCE_ADDRESS'|onapp_string}</label></dt>
                <dd><input id="address" type="text" name="firewall[_address]" value="{$firewall_obj->_address}" /></dd>
            </dl>
            <dl>
                <dt><label for="address">{'DESTINATION_PORT'|onapp_string}</label></dt>
                <dd><input id="address" type="text" name="firewall[_port]" value="{$firewall_obj->_port}" /></dd>
            </dl>
            <dl>
                <dt><label for="protocol">{'PROTOCOL_'|onapp_string}</label></dt>
                <dd>
                    <select id="command"  name="firewall[_protocol]">
                        <option></option>
                        {foreach from=$protocols item=protocol_item}
                            <option value="{$protocol_item}"{if $protocol_item == $firewall_obj->_protocol}selected="true"{/if} >
                                {$protocol_item}
                            </option>
                        {/foreach}
                    </select>
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "virtual_machine_id" value="{$virtual_machine_id}" />
        <input type="hidden" name = "firewall[_virtual_machine_id]" value="{$virtual_machine_id}" />
        <input type="hidden" name = "firewall[_id]" value="{$firewall_obj->_id}" />
        <input type="hidden" name = "action" value="firewall_rule_edit" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>
        
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}