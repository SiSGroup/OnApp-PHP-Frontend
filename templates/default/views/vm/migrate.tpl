{include file="default/views/header.tpl"}
<h1>{'CHOSE_A_TARGET_HYPERVISOR'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="hypervisor">{'HYPERVISOR_'|onapp_string}</label></dt>
                <dd>
                    <select id="hypervisor"  name="virtual_machine[_destination_id]">
                    {foreach from=$hypervisors_obj item=hypervisors}
                        {if $hypervisor_obj->_id != $hypervisors->_id && $hypervisors->_online == 1}
                            <option value="{$hypervisors->_id}">{$hypervisors->_label}</option>
                        {/if}
                    {/foreach}
                    </select>
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$virtual_machine_id}" />
        <input type="hidden" name = "action" value="migrate" />
        <input type="submit" value="{'START_MIGRATION'|onapp_string}" />
    </form>
     
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}