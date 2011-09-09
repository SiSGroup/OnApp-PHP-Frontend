{include file="default_web20cart/views/header.tpl"}

     {if $user_groups_obj == null}
        <p class="not_found">No groups found</p>
     {else}
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'GROUP_'|onapp_string}</th>
            <th>{'USERS_'|onapp_string}</th>
            <th></th>
        </tr>
     
     {foreach from=$user_groups_obj item=group}
        <tr>
            <td>
               {$group->_label}
            </td>
            <td>
                {$group_users_quantity[$group->_id]}
            </td>
        
            <td class="dark_td">
                <a href="{$_ALIASES["users_and_groups"]}?action=group_edit&amp;id={$group->_id}">
                    <img title="{'EDIT_GROUP'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                </a>
                <a href="{$_ALIASES["users_and_groups"]}?action=group_delete&amp;id={$group->_id}">
                    <img title="{'DESTROY_GROUP'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
           </td>
       </tr>
     {/foreach}
    </table>
     {/if}
        
        <form style="float:right" action='{$_ALIASES["users_and_groups"]}' method="post">
            <input type="hidden" name = "action" value="group_create" />
            <input type="submit" value="{'ADD_NEW_GROUP'|onapp_string}" />
        </form>
    
        
    
{include file="default_web20cart/views/usersAndGroups/navigation_main.tpl"}
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}