{include file="default/views/header.tpl"}
<h1>{'PROPERTIES_'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="virtual_machine_label">{'LABEL_'|onapp_string}</label></dt>
                <dd><input id="backup_label" type="text" name="label" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$id}" />
        <input type="hidden" name = "action" value="backup_convert" />
        <input type="submit" value="{'CONVERT_BACKUP'|onapp_string}" />
    </form>
     
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}