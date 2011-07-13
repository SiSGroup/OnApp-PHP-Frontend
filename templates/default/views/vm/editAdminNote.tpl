{include file="default/views/header.tpl"}
<h1>{'EDIT_ADMIN_NOTE'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="note">{'NOTE_'|onapp_string}</label></dt>
                <dd>
                    <textarea name="note" rows="10" colums="50" id="note">{$current_admin_note}</textarea>  
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$id}" />
        <input type="hidden" name = "action" value="edit_admin_note" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>
     
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}