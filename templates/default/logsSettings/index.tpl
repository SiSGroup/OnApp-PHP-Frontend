{include file="default/header.tpl"}

{if $error}
    {$error}
{/if}
<div class="info">

       <div class="info_title">
            {'LOGS_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'LOGS_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

    </div>

<h1>{$title|onapp_string}</h1>

<form action='{$smarty.const.ONAPP_BASE_URL/$_ALIASES["log_settings"]}?action=update' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'LOG_LEVEL_PHP'|onapp_string}</dt>
            <dd>
                 <select name="log_settings[log_level_php]">
                    <option></option>
                    {html_options values=$php_error_levels output=$php_error_levels selected=$php_error_levels[$smarty.const.ONAPP_LOG_LEVEL_PHP]}
                </select>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'LOG_LEVEL_FRONTEND'|onapp_string}</dt>
            <dd>
                 <select name="log_settings[log_level_frontend]">
                    <option></option>
                    
                    {html_options values=$log_levels_frontend output=$log_levels_frontend selected=$smarty.const.ONAPP_LOG_LEVEL_FRONTEND}
                    
                </select>
            </dd>
        </dl>
        
        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_DAYS'|onapp_string}</dt>
            <dd>
                <input type="number" name="log_settings[log_rotation_days]" value="{$smarty.const.ONAPP_LOG_ROTATION_DAYS}" />
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'LOG_ROTATION_SIZE'|onapp_string}</dt>
            
            <dd>
                <input type="number" name="log_settings[log_rotation_size]" value="{$smarty.const.ONAPP_LOG_ROTATION_SIZE}" />
            </dd>
        </dl>

        <dl>
            <dt>
                <input value="1" name="log_settings[problem_report_debug_log_enable]" type="checkbox"
                    {if $smarty.const.ONAPP_PROBLEM_REPORT_DEBUG_LOG_ENABLE == 1}
                        checked
                    {/if}
                /> &nbsp;&nbsp;&nbsp;{'PROBLEM_REPORT_DEBUG_LOG_ENABLE'|onapp_string}
            </dt>

        </dl>

        <dl style="clear:both;">
            <dt>
                <input value="1" name="log_settings[third_part_product_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_THIRD_PART_PRODUCT_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'THIRD_PART_PRODUCT_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>
  
        <dl style="clear:both;">
            <dt>
                <input value="1" name="log_settings[wrapper_log_report_enable]" type="checkbox"
                {if $smarty.const.ONAPP_WRAPPER_LOG_REPORT_ENABLE == 1}
                    checked
                {/if}
                /> &nbsp;&nbsp;&nbsp;{'WRAPPER_LOG_REPORT_ENABLE'|onapp_string}

            </dt>

        </dl>
 </div>


    <input type="hidden" name="action" value="logs_settings_update" />

    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>
{include file="default/navigation.tpl"}
{include file="default/footer.tpl"}
 
