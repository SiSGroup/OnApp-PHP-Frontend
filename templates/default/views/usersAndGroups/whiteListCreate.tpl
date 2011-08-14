{include file="default/views/header.tpl"}

<h1>{$title}</h1>

    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="ip">{'IP_'|onapp_string}</label></dt>
                <dd><input id="ip" type="text" name="white_list[_ip]" /></dd>
            </dl>
            <dl>
                <dt><label for="description">{'DESCRIPTION_'|onapp_string}</label></dt>
                <dd><input id="description" type="text" name="white_list[_description]" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$user_id}" />
        <input type="hidden" name = "action" value="white_list_create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}