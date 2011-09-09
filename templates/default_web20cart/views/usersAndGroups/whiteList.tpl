{include file="default_web20cart/views/header.tpl"}

     {if $white_list_obj == null}
        <p class="not_found">No IPs found</p>
     {else}
    <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'IP_'|onapp_string}</th>
            <th>{'DESCRIPTION_'|onapp_string}</th>
            <th></th>

        </tr>
     
     {foreach from=$white_list_obj item=list}
        <tr>
            <td>
               {$list->_ip}
            </td>
            <td>
                {$list->_description}
            </td>
            <td class="dark_td">
                <a href="{$_ALIASES["users_and_groups"]}?action=white_list_edit&amp;id={$list->_id}&amp;user_id={$user_id}">
                    <img title="{'EDIT_WHITE_LIST_IP'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                </a>
                <a href="{$_ALIASES["users_and_groups"]}?action=white_list_delete&amp;id={$list->_id}&amp;user_id={$user_id}">
                    <img title="{'DESTROY_WHITE_LIST_IP'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                </a>
            </td>
        </tr>
     {/foreach}
    </table>
     {/if}
        
        <form style="float:right" action='{$_ALIASES["users_and_groups"]}' method="post">
            <input type="hidden" name = "id" value="{$user_id}" />
            <input type="hidden" name = "action" value="white_list_create" />
            <input type="submit" value="{'NEW_WHITE_LIST_IP'|onapp_string}" />
        </form>
    
        
    
{include file="default_web20cart/views/usersAndGroups/navigation.tpl"}
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}