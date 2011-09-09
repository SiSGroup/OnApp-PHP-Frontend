{include file="default_web20cart/views/header.tpl"}

<h1>{$title}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['frontend_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'BASE_URL'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[base_url]" value="{$smarty.const.ONAPP_BASE_URL}" disabled=true/>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'HOST_NAME'|onapp_string}</dt>
            <dd>
                 <input type="text" name="settings[hostname]" value="{$smarty.const.ONAPP_HOSTNAME}"/>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'DEFAULT_ALIAS'|onapp_string}</dt>
            <dd>
                <input type="text" name="settings[default_alias]" value="{$smarty.const.ONAPP_DEFAULT_ALIAS}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'SECRET_KEY'|onapp_string}</dt>
            
            <dd>
                <input type="text" name="settings[secret_key]" value="{$smarty.const.ONAPP_SECRET_KEY}" />
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'SESSION_LIFETIME'|onapp_string}<br /> (seconds)</dt>
            
            <dd>
                <input type="text" name="settings[session_lifetime]" value="{$smarty.const.ONAPP_SESSION_LIFETIME}" />
            </dd>
        </dl>
        
        <dl>
            <dt class="label">{'DEFAULT_LANGUAGE'|onapp_string}</dt>
            <dd>
                 <select name="settings[default_language]">
                    {html_options values=$language_list output=$language_list selected=$smarty.const.ONAPP_DEFAULT_LANGUAGE}
                </select>
            </dd>
        </dl>
        
        <dl>
            <dt class="label">{'TEMPLATE_'|onapp_string}</dt>
            <dd>
                 <select name="settings[template]">
                    {html_options values=$templates_list output=$templates_list selected=$smarty.const.ONAPP_TEMPLATE}
                </select>
            </dd>
        </dl>
        
        <dl>
            <dt class="label">{'CONTROLLERS_'|onapp_string}</dt>
            <dd>
                 <select name="settings[controllers]">
                    {html_options values=$controllers_list output=$controllers_list selected=$smarty.const.ONAPP_CONTROLLERS}
                </select>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'LOG_DIRECTORY'|onapp_string}</dt>
            
            <dd>
                <input type="text" name="settings[log_directory]" value="{$smarty.const.ONAPP_LOG_DIRECTORY}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'DEBUG_FILE_NAME'|onapp_string}</dt>

            <dd>
                <input type="text" name="settings[debug_file_name]" value="{$smarty.const.ONAPP_DEBUG_FILE_NAME}" />
            </dd>
        </dl>
       
 </div>
 
    <input type="hidden" name="action" value="save" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}
