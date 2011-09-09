{include file="default_web20cart/views/header.tpl"}
<h1>{'VIRTUAL_MACHINE_PROPERTIES'|onapp_string}</h1>

    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt>
                    <label for="virtual_machine_label">{'LABEL_'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="virtual_machine_label" type="text" name="virtual_machine[_label]" value="{$vm_obj->_label}" />
                </dd>
            </dl>
        </div>
        
    <h1>{'RESOURCES_'|onapp_string}</h1>
        <div class="div_page">
            <dl>
                <dt>
                    <label for="virtual_machine_memory">{'RAM_'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="virtual_machine_memory" type="text" name="virtual_machine[_memory]" value="{$vm_obj->_memory}" />
                </dd>
            </dl>
           <dl>
                <dt>
                    <label for="virtual_machine_cpus">{'CPU_CORES'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="virtual_machine_cpus" type="text" name="virtual_machine[_cpus]" value="{$vm_obj->_cpus}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="virtual_machine_cpu_shares">{'CPU_PRIORITY'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="virtual_machine_ram" type="text" name="virtual_machine[_cpu_shares]" value="{$vm_obj->_cpu_shares}" />
                </dd>
            </dl>
        </div>
        <input type="submit" value="{'SAVE_VIRTUAL_MACHINE'|onapp_string}" />
        <input type="hidden" name="virtual_machine[_id]" value="{$vm_obj->_id}" />
        <input type="hidden" name="id" value="{$vm_obj->_id}" />
        <input type="hidden" name="action" value="edit" />
    </form>
      
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}