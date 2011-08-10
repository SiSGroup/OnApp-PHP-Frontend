{include file="default/views/header.tpl"}

<h1>{'PROPERTIES_'|onapp_string}</h1>
    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="label_field">{'LABEL_'|onapp_string}</label></dt>
                <dd><input id="label_field" type="text" name="group[_label]" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "action" value="group_create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}