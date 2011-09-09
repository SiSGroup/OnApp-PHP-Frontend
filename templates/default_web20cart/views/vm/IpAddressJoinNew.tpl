{include file="default_web20cart/views/header.tpl"}

<!-- If javascript disabled hide this block -->
<noscript><div style="display:none"></noscript>
    <h1>{'NETWORK_INTERFACES'|onapp_string}</h1>
    <p class="second_level_description">{'ALLOCATE_NEW_IP_ADDRESS_ASSIGNMENT_INFO_1'|onapp_string}</p>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="virtual_machine_label">{'NETWORK_INTERFACES'|onapp_string}</label></dt>
                <dd>
                    <select id="period"  name="ip_address[_network_interface_id]">
                        <option></option>
                            {foreach from=$network_interface_obj item=network_interface}
                        <option value="{$network_interface->_id}">
                                    {$network_interface->_label}
                        </option>
                            {/foreach}
                    </select>
                </dd>
            </dl>
        </div>

        <h1>{'SELECT_IP_ADDRESS_FROM_IP_POOL'|onapp_string}</h1>
        <p class="second_level_description">{'ALLOCATE_NEW_IP_ADDRESS_ASSIGNMENT_INFO_2'|onapp_string}</p>
        <div class="div_page">
            <dl>
                <dt><label for="ip_address">{'IP_ADDRESS'|onapp_string}</label></dt>
                <dd>
                    <select id="ips"  name="ip_address[_id]">
                        <option></option>
                    </select>
                </dd>
            </dl>
        </div>

        <input type="submit" value="{'ADD_IP_ADDRESS_ASSIGNMENT'|onapp_string}" />
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="ip_address[_virtual_machine_id]" value="{$id}" />
        <input type="hidden" name="action" value="ip_address_join_new" />
    </form>
<noscript></div></noscript>

<noscript>
<form action='{$_ALIASES["virtual_machines"]}'>
<h1>{'SELECT_IP_ADDRESS_FROM_IP_POOL'|onapp_string}</h1>
<p class="second_level_description">{'ALLOCATE_NEW_IP_ADDRESS_ASSIGNMENT_INFO_1'|onapp_string}</p>
<p class="second_level_description">{'ALLOCATE_NEW_IP_ADDRESS_ASSIGNMENT_INFO_2'|onapp_string}</p>
{foreach from=$network_interface_obj item=network_interface}
    
       
       <input value="{$network_interface->_id}" type="radio" name="ip_address[_network_interface_id]" />   {$network_interface->_label} ( <b>{'NETWORK_INTERFACE'|onapp_string}</b> )<br /><br />
  
 
            {foreach from=$ip_addresses_array[$network_interface->_id] key=ip_id item=ip_addr}
                <input value="{$ip_id}" type="radio" name="ip_address[_id]" /> {$ip_addr} <br />
            {/foreach}<br /><br /><br />
   
{/foreach}
        <input type="submit" value="{'ADD_IP_ADDRESS_ASSIGNMENT'|onapp_string}" />
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="ip_address[_virtual_machine_id]" value="{$id}" />
        <input type="hidden" name="action" value="ip_address_join_new" />
</form>
</noscript>

<script type="text/javascript">
        var IPs = {$ip_addresses};
    </script>
{literal}
    <script type="text/javascript" src="templates/default_web20cart/views/vm/ips.js"></script>
{/literal}

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}