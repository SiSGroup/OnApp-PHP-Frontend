{include file="default_web20cart/views/header.tpl"}

<h1>{'PROPERTIES_'|onapp_string}</h1>
    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="label_field">{'LABEL_'|onapp_string}</label></dt>
                <dd><input id="label_field" type="text" name="group[_label]" value="{$group_obj->_label}" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$id}" />
        <input type="hidden" name = "action" value="group_edit" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>


{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}