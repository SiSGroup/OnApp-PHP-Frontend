{include file="default_web20cart/views/header.tpl"}

<h1>{$title}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['ssh_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'SSH_HOST'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[ssh_host]" value="{$smarty.const.ONAPP_SSH_HOST}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'SSH_USER'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[ssh_user]" value="{$smarty.const.ONAPP_SSH_USER}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'SSH_PASSWORD'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[ssh_password]" value="{$smarty.const.ONAPP_SSH_PASSWORD}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'SSH_PORT'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[ssh_port]" value="{$smarty.const.ONAPP_SSH_PORT}" />
            </dd>
        </dl>

        
       
 </div>
 
    <input type="hidden" name="action" value="save" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}
