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
            {'EDIT_LOG_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'EDIT_LOG_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>

<h1>{$title|onapp_string}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['log_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'LOG_LEVEL_PHP'|onapp_string}</dt>
            <dd>
                 <select name="log_settings[log_level_php]">
                    {html_options values=$php_error_levels output=$php_error_levels selected=$php_error_levels[$smarty.const.ONAPP_LOG_LEVEL_PHP]}
                </select>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'LOG_LEVEL_FRONTEND'|onapp_string}</dt>
            <dd>
                 <select name="log_settings[log_level_frontend]">
                    {html_options values=$log_levels_frontend output=$log_levels_frontend selected=$log_levels_frontend[$smarty.const.ONAPP_LOG_LEVEL_FRONTEND]}        
                </select>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_DAYS'|onapp_string}</dt>
            <dd>
                <input type="text" name="log_settings[log_rotation_days]" value="{$smarty.const.ONAPP_LOG_ROTATION_DAYS}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_SIZE'|onapp_string} (MB)</dt>
            
            <dd>
                <input type="text" name="log_settings[log_rotation_size]" value="{$smarty.const.ONAPP_LOG_ROTATION_SIZE}" />
            </dd>
        </dl>

        <dl>
            <dt>
                <input type="hidden" name="log_settings[problem_report_debug_log_enable]" value="0">
                <input value="1" name="log_settings[problem_report_debug_log_enable]" type="checkbox"
                    {if $smarty.const.ONAPP_PROBLEM_REPORT_DEBUG_LOG_ENABLE == 1}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'PROBLEM_REPORT_DEBUG_LOG_ENABLE'|onapp_string}
            </dt>

        </dl>

        <dl style="clear:both;">
            <dt>
                <input type="hidden" name="log_settings[third_part_product_report_enable]" value="0">
                <input value="1" name="log_settings[third_part_product_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_THIRD_PART_PRODUCT_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'THIRD_PART_PRODUCT_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>
  
        <dl style="clear:both;">
            <dt>
                 <input type="hidden" name="log_settings[wrapper_log_report_enable]" value="0">
                <input value="1" name="log_settings[wrapper_log_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_WRAPPER_LOG_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'WRAPPER_LOG_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>
 </div>


    <input type="hidden" name="action" value="save" />

    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}