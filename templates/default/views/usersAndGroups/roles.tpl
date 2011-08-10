{include file="default/views/header.tpl"}

     {if $roles_obj == null}
        <p class="not_found">No roles found</p>
     {else}
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'DESCRIPTION_'|onapp_string}</th>
            <th></th>

        </tr>
     
     {foreach from=$roles_obj item=role}
        <tr>
            <td>
               {$role->_label}
            </td>
            <td class="dark_td">
                <a href="{$_ALIASES["users_and_groups"]}?action=role_edit&amp;id={$role->_id}">
                    <img title="{'EDIT_PAYMENT'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                </a>
                <a href="{$_ALIASES["users_and_groups"]}?action=role_delete&amp;id={$role->_id}">
                    <img title="{'DESTROY_PAYMENT'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
            </td>
        </tr>
     {/foreach}
    </table>
     {/if}
        
        <form style="float:right" action='{$_ALIASES["users_and_groups"]}' method="post">
            <input type="hidden" name = "action" value="role_create" />
            <input type="submit" value="{'ADD_NEW_ROLE'|onapp_string}" />
        </form>
    
        
    
{include file="default/views/usersAndGroups/navigation_main.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}