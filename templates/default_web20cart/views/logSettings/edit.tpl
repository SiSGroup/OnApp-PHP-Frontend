{include file="default_web20cart/views/header.tpl"}

<h1>{$title}</h1>
    
<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['log_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'LOG_LEVEL_PHP'|onapp_string}</dt>
            <dd>
                 <select name="settings[log_level_php]">
                    {html_options values=$php_error_levels output=$php_error_levels selected=$php_error_levels[$smarty.const.ONAPP_LOG_LEVEL_PHP]}
                </select>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'LOG_LEVEL_FRONTEND'|onapp_string}</dt>
            <dd>
                 <select name="settings[log_level_frontend]">
                    {html_options values=$log_levels_frontend output=$log_levels_frontend selected=$log_levels_frontend[$smarty.const.ONAPP_LOG_LEVEL_FRONTEND]}        
                </select>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_DAYS'|onapp_string}</dt>
            <dd>
                <input type="text" name="settings[log_rotation_days]" value="{$smarty.const.ONAPP_LOG_ROTATION_DAYS}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_SIZE'|onapp_string} (MB)</dt>
            
            <dd>
                <input type="text" maxlength="21" name="settings[log_rotation_size]" value="{$smarty.const.ONAPP_LOG_ROTATION_SIZE}" />
            </dd>
        </dl>

        <dl>
            <dt>
                <input type="hidden" name="settings[problem_report_debug_log_enable]" value="0">
                <input value="1" name="settings[problem_report_debug_log_enable]" type="checkbox"
                    {if $smarty.const.ONAPP_PROBLEM_REPORT_DEBUG_LOG_ENABLE == 1}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'PROBLEM_REPORT_DEBUG_LOG_ENABLE'|onapp_string}
            </dt>

        </dl>

        <dl style="clear:both;">
            <dt>
                <input type="hidden" name="settings[third_part_product_report_enable]" value="0">
                <input value="1" name="settings[third_part_product_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_THIRD_PART_PRODUCT_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'THIRD_PART_PRODUCT_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>
  
        <dl style="clear:both;">
            <dt>
                 <input type="hidden" name="settings[wrapper_log_report_enable]" value="0">
                <input value="1" name="settings[wrapper_log_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_WRAPPER_LOG_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'WRAPPER_LOG_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>

        <dl style="clear:both;">
            <dt>
                 <input type="hidden" name="settings[show_date_in_logs]" value="0">
                <input value="1" name="settings[show_date_in_logs]" type="checkbox"
                {if $smarty.const.ONAPP_SHOW_DATE_IN_LOGS == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'SHOW_DATE_IN_LOGS'|onapp_string}

            </dt>

        </dl>
 </div>


    <input type="hidden" name="action" value="save" />

    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}
