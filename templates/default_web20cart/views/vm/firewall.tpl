{include file="default_web20cart/views/header.tpl"}
<h1>{'ADD_NEW_FIREWALL_RULE'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="period">{'INTERFACE_'|onapp_string}</label></dt>
                <dd>
                    <select id="period"  name="firewall[_network_interface_id]">
                        {foreach from=$network_interface_obj item=network_interface}
                            <option value="{$network_interface->_id}">
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
                        <option value="ACCEPT">ACCEPT</option>
                        <option value="DROP">DROP</option> 
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><label for="address">{'SOURCE_ADDRESS'|onapp_string}</label></dt>
                <dd><input id="address" type="text" name="firewall[_address]" /></dd>
            </dl>
            <dl>
                <dt><label for="address">{'DESTINATION_PORT'|onapp_string}</label></dt>
                <dd><input id="address" type="text" name="firewall[_port]" /></dd>
            </dl>
            <dl>
                <dt><label for="protocol">{'PROTOCOL_'|onapp_string}</label></dt>
                <dd>
                    <select id="command"  name="firewall[_protocol]">
                        <option value="TCP">TCP</option>
                        <option value="UDP">UDP</option>
                    </select>
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$virtual_machine_id}" />
        <input type="hidden" name = "firewall[_virtual_machine_id]" value="{$virtual_machine_id}" />
        <input type="hidden" name = "action" value="firewall_rule_create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>



   {if is_null($firewall_obj)}
       <p class="not_found">No firewall rules found<p>
   {else}
       <table class="table_my" cellpadding="0" cellspacing="0" border="0">
           <tr>
               <th>{'RULE_'|onapp_string} #</th>
               <th>{'SOURCE_ADDRESS'|onapp_string}</th>
               <th>{'DESTINATION_PORT'|onapp_string}</th>
               <th>{'PROTOCOL_'|onapp_string}</th>
               <th>{'COMMAND_'|onapp_string}</th>
               <th></th>
               <th></th>
           </tr>
       {foreach from=$firewall_by_network item=firewall_obj}
           {$firewall_obj_count = count($firewall_obj)} 
              
           {foreach from=$firewall_obj item=firewall}
               <tr>
                   <td>
                      {$network_interface_obj[$firewall->_network_interface_id]->_label} #{$firewall->_position}
                   </td>
                   <td>
                       {$firewall->_address}
                   </td>
                   <td>
                       {$firewall->_port}
                   </td>
                   <td>
                       {$firewall->_protocol}
                   </td>
                   <td>
                       {$firewall->_command}
                   </td>
                   
                   <td class="dark_td">
                       {if $firewall_obj_count == 1}
                           <a>
                               <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow-disabled.png" />
                           </a>
                           <a>
                               <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow-disabled.png" />
                           </a>
                       {elseif $firewall_obj_count == 2}
                           {if $firewall->_position  == 1}
                               <a>
                                   <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow-disabled.png" />
                               </a>
                               <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=down&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'DOWN_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow.png" />
                               </a>
                           {else}
                               <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=up&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'UP_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow.png" />
                               </a>
                               <a>
                                   <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow-disabled.png" />
                               </a>
                               
                           {/if}
                       {else}
                           {if $firewall->_position  == 1}
                                <a>
                                   <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow-disabled.png" />
                               </a>
                               <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=down&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'DOWN_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow.png" />
                               </a>
                           
                           {elseif $firewall->_position == $firewall_obj_count}
                                <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=up&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'UP_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow.png" />
                               </a>
                               <a>
                                   <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow-disabled.png" />
                               </a>
                           {else}
                               <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=up&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'UP_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/up-arrow.png" />
                               </a>
                               <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_move&amp;id={$firewall->_id}&amp;position=down&amp;virtual_machine_id={$virtual_machine_id}">
                                   <img title="{'DOWN_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/down-arrow.png" />
                               </a>
                           {/if}
                       {/if}
                       
                   </td>
                   <td class="dark_td">
                           <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_edit&amp;id={$firewall->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                               <img title="{'EDIT_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                           </a>
                           <a href="{$_ALIASES["virtual_machines"]}?action=firewall_rule_delete&amp;id={$firewall->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                               <img title="{'REMOVE_RULE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                           </a>    
                   </td>
               </tr>
            {/foreach}
        {/foreach}
    {/if}
        </table>
        <h1>{'DEFAULT_FIREWALL_RULES'|onapp_string}</h1>
        <form action='{$_ALIASES["virtual_machines"]}' method="post">
            <div class="div_page">
                <dl>
                    <dt>
                        <label for="virtual_machine_memory">{'INTERFACE_'|onapp_string}</label>
                    </dt>
                    <dd>
                        <label for="virtual_machine_memory">{'COMMAND_'|onapp_string}</label>
                    </dd>
                </dl>
                {foreach from=$network_interface_obj item=network_interface}
                    <dl>
                        <dt>
                            <label for="network">{$network_interface->_label}</label>
                        </dt>
                        <dd>
                            <select id="commands"  name="firewall[{$network_interface->_id}]" >
                                {foreach from=$commands item=command_item}
                                    <option value="{$command_item}" {if $network_interface->_default_firewall_rule == $command_item}selected="true"{/if}>{$command_item}</option>
                                {/foreach}
                            </select>
                        </dd>
                    </dl>    
                {/foreach}
            </div>
            <input type="hidden" name = "id" value="{$virtual_machine_id}" />
            <input type="hidden" name = "action" value="firewall_rule_update_defaults" />
            <input type="submit" value="{'SAVE_'|onapp_string}" />
        </form>
        <h1>&nbsp;</h1>
        
        <form style="float:right" action='{$_ALIASES["virtual_machines"]}' method="post">
            <input type="hidden" name = "id" value="{$virtual_machine_id}" />
            <input type="hidden" name = "action" value="firewall_rules_apply" />
            <input type="submit" value="{'APPLY_FIREWALL_RULES'|onapp_string}" />
        </form>
        
{include file="default_web20cart/views/vm/navigation.tpl"}
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}