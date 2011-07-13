{include file="default/views/header.tpl"}
<h1>{'OWNER_'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="user_id">{'CHANGE_A_USER'|onapp_string}</label></dt>
                <dd>
                    <select  name="user_id">
                        {foreach from=$user_obj item=user}
                            <option value="{$user->_id}" {if $user->_id == $vm_obj->_user_id}selected="true"{/if}>
                                {$user->_first_name} {$user->_last_name}
                            </option>
                        {/foreach}
                    </select>
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$vm_obj->_id}" />
        <input type="hidden" name = "action" value="change_owner" />
        <input type="submit" value="{'CHANGE_OWNER'|onapp_string}" />
    </form>
    
  
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}