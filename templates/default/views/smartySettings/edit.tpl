{include file="default/views/header.tpl"}

{if isset($error)}
    <div id="onapp_error">
            {$error|onapp_string}
    </div>
{/if}

{if isset($message)}
    <div id="onapp_msg">
            {$message|onapp_string}
    </div>
{/if}

<div style="clear:both;"></div>
<div class="info">

       <div class="info_title">
            {'EDIT_SMARTY_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'EDIT_SMARTY_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>

<h1>{$title|onapp_string}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['smarty_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'TEMPLATE_DIRECTORY'|onapp_string}</dt>
            <dd>
                 <input type="text" name="smarty_settings[smarty_template_dir]" value="{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}" />      
            </dd>
        </dl>

          <dl>
            <dt class="label">{'COMPILE_DIRECTORY'|onapp_string}</dt>
            <dd>
                 <input type="text" name="smarty_settings[smarty_compile_dir]" value="{$smarty.const.ONAPP_SMARTY_COMPILE_DIR}"/>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'CACHE_DIRECTORY'|onapp_string}</dt>
            <dd>
                <input type="text" name="smarty_settings[smarty_cache_dir]" value="{$smarty.const.ONAPP_SMARTY_CACHE_DIR}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'CACHING_LIFETIME'|onapp_string} (seconds)</dt>
            
            <dd>
                <input type="text" name="smarty_settings[smarty_caching_lifetime]" value="{$smarty.const.ONAPP_SMARTY_CACHING_LIFETIME}" />
            </dd>
        </dl>

        <dl>
            <dt class="dt_checkbox">
                <input type="hidden" name="smarty_settings[smarty_caching_enable]" value="0">
                <input value="2" name="smarty_settings[smarty_caching_enable]" type="checkbox"
                    {if $smarty.const.ONAPP_SMARTY_CACHING_ENABLE > 0}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'ENABLE_CACHING'|onapp_string}
            </dt>
        </dl>
        
        <dl>
            <dt class="dt_checkbox">
                <input type="hidden" name="smarty_settings[smarty_force_compile]" value="0">
                <input value="2" name="smarty_settings[smarty_force_compile]" type="checkbox"
                    {if $smarty.const.ONAPP_SMARTY_FORCE_COMPILE > 0}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'FORCE_COMPILE'|onapp_string}
            </dt>
        </dl>
       
        <dl>
            <dt class="dt_checkbox">
                <input type="hidden" name="smarty_settings[smarty_compile_check]" value="0">
                <input value="1" name="smarty_settings[smarty_compile_check]" type="checkbox"
                    {if $smarty.const.ONAPP_SMARTY_COMPILE_CHECK > 0}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'COMPILE_CHECK'|onapp_string}
            </dt>
        </dl>
 </div>
 
    <input type="hidden" name="action" value="save" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}