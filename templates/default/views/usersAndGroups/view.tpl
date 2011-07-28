{include file="default/views/header.tpl"}

   {if is_null($user_obj)}
       <p class="not_found">No Users found<p>
   {else}
       <table class="table_my" cellpadding="0" cellspacing="0" border="0">
           <tr>

               <th>{'USER_'|onapp_string}</th>
               <th>{'LOGIN_'|onapp_string}</th>
               <th>{'E_MAIL'|onapp_string}</th>
               <th>{'ROLES_USER_GROUP'|onapp_string}</th>
               <th></th>
               <th></th>
           </tr>
       {foreach from=$user_obj item=user}
           <tr>
               <td>
                   <a href="{$_ALIASES["users_and_groups"]}?action=details&amp;id={$user->_id}">
                       {$user->_first_name} {$user->_last_name} 
                   </a>
                   <br /> {$user->_status}
               </td>
               <td>
                   {$user->_login}
               </td>
               <td>
                   {$user->_email}
               </td>
               <td>
                   {foreach from=$user->_roles item=roles}
                      ( as {$roles->_label} )&nbsp;
                   {/foreach}
                   <br /> {if $user_group_labels[$user->_id] == true}
                              {$user_group_labels[$user->_id]}
                          {else}
                              {'UNDEFINED_'|onapp_string}
                          {/if}
               </td>
               <td class="blue">
                   <a href="{$_ALIASES["users_and_groups"]}?action=virtual_machines&amp;id={$user->_id}">{'VIRTUAL_MACHINES'|onapp_string}</a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=payments&amp;id={$user->_id}">{'PAYMENTS_'|onapp_string}</a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=billing_plan&amp;id={$user->_id}">{'BILLING_PLAN'|onapp_string}</a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=monthly_bills&amp;id={$user->_id}">{'MONTHLY_BILLS'|onapp_string}</a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=user_statistics&amp;id={$user->_id}">{'USER_STATISTICS'|onapp_string}</a>
               </td>
               <td class="one_icon_td">
                   
                   <a href="{$_ALIASES["users_and_groups"]}?action=edit&amp;id={$user->_id}">
                       <img title="{'EDIT_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                   </a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=delete&amp;id={$user->_id}">
                       <img title="{'DELETE_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                   </a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=suspend&amp;id={$user->_id}">
                       <img title="{'SUSPEND_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/stop.png" />
                   </a>
                   <a href="{$_ALIASES["users_and_groups"]}?action=white_ip_list&amp;id={$user->_id}&amp;virtual_machine_id={$virtual_machine_id}">
                       <img title="{'WHITE_IP_LIST'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/network.png" />
                   </a>
                   
               </td>
           </tr>
        {/foreach}
    {/if}
        </table>
        <form style="float:right" action='{$_ALIASES["users_and_groups"]}' method="post">
            <input type="hidden" name = "action" value="create" />
            <input type="submit" value="{'ADD_A_NEW_USER'|onapp_string}" />
        </form>
           
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
