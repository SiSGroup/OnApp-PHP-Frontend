{include file="default_web20cart/views/header.tpl"}

<h1>{$title}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['whmcs_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'API_FILE_URL'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[whmcs_api_file_url]" value="{$smarty.const.ONAPP_WHMCS_API_FILE_URL}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'CLIENT_AREA_URL'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[whmcs_client_area_url]" value="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'LOGIN_'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[whmcs_login]" value="{$smarty.const.ONAPP_WHMCS_LOGIN}" />
            </dd>
        </dl>
        <dl>
            <dt class="label">{'PASSWORD_'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[whmcs_password]" value="{$smarty.const.ONAPP_WHMCS_PASSWORD}" />
            </dd>
        </dl>

         
       
 </div>
 
    <input type="hidden" name="action" value="save" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}
