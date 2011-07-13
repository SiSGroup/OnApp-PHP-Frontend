{include file="default/views/header.tpl"}
<h1>{'ENTER_NEW_DISK_SIZE'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="disk_size">{'SIZE_'|onapp_string}</label></dt>
                <dd><input id="disk_size" type="text" name="disk[_disk_size]" value="{$disk_obj->_disk_size}" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "disk[_id]" value="{$disk_obj->_id}" />
        <input type="hidden" name = "virtual_machine_id" value="{$disk_obj->_virtual_machine_id}" />
        <input type="hidden" name = "action" value="disk_edit" />
        <input type="submit" value="{'SAVE_DISK'|onapp_string}" />
    </form>
       
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}