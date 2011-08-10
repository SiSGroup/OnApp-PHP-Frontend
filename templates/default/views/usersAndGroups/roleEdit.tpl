{include file="default/views/header.tpl"}

<h1>{'PROPERTIES_'|onapp_string}</h1>

    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="description_field">{'DESCRIPTION_'|onapp_string}</label></dt>
                <dd><input id="description_field" type="text" name="role[_label]" value="{$role_obj->_label}" /></dd>
            </dl>
        </div>

<h1>{'PERMISSIONS_'|onapp_string}</h1>

        <div class="div_page">
         {foreach from=$permission_obj item=permission}
             <dl>
                <dt>

                </dt>
                <dd>
                    <input type="hidden" name="role[_permission_ids][]" value="0" />
                    <input value="{$permission->_id}" type="checkbox" name="role[_permission_ids][]" {if in_array($permission->_id, $checked_role_ids)}checked="true"{/if}/>
                    <span style="font-weight:normal">{$permission->_label}</span> <b>({$permission->_identifier})</b>
                </dd>
            </dl>
         {/foreach}
         </div>

        <input type="hidden" name = "id" value="{$id}" />
        <input type="hidden" name = "action" value="role_edit" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}