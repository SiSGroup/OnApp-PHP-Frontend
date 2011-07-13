{include file="default/views/header.tpl"}


{if $template == 'logSettings' || $template == 'configuration'}

    <h1>{'LOG_SETTINGS'|onapp_string}</h1>

        <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

            <tr>
                <td class="label">{'LOG_LEVEL_PHP'|onapp_string}</td>
                <td>
                        {$php_error_levels[$config.log_level_php]}
                </td>
            </tr>

              <tr>
                <td class="label">
                    {'LOG_LEVEL_FRONTEND'|onapp_string}
                </td>
                <td>
                    {$log_levels_frontend[$config.log_level_frontend]}
                </td>
            </tr>

            <tr style="clear:both;">
                <td class="label">
                    {'LOG_ROTATION_DAYS'|onapp_string}
                </td>
                <td>
                    {$config.log_rotation_days} Days
                </td>
            </tr>

            <tr style="clear:both;">
                <td class="label">
                    {'LOG_ROTATION_SIZE'|onapp_string}
                </td>
                <td>
                    {$config.log_rotation_size} MB
                </td>
            </tr>

            <tr>
                <td class="label">
                    {'PROBLEM_REPORT_DEBUG_LOG_ENABLE'|onapp_string}
                </td>
                <td>
                    {if $config.problem_report_debug_log_enable > 0}
                         {'YES_'|onapp_string}
                    {else}
                         {'NO_'|onapp_string}
                    {/if}
                </td>

            </tr>

            <tr>
                <td class="label">
                    {'THIRD_PART_PRODUCT_REPORT_ENABLE'|onapp_string}
                </td>
                <td>
                    {if $config.third_part_product_report_enable > 0}
                        {'YES_'|onapp_string}
                    {else}
                         {'NO_'|onapp_string}
                    {/if}
                </td>

            </tr>

            <tr>
                <td class="label">
                     {'WRAPPER_LOG_REPORT_ENABLE'|onapp_string}
                </td>
                <td>
                    {if $config.wrapper_log_report_enable > 0}
                        {'YES_'|onapp_string}
                    {else}
                         {'NO_'|onapp_string}
                    {/if}
                </td>

            </tr>
            <tr>
                <td>
                    <form action="{$config.base_url}/{$_ALIASES['log_settings']}" method="post">
                        <input type="submit" value="{'EDIT_'|onapp_string}" />
                        <input type="hidden" name="action" value="edit" />
                    </form>
                </td>
            </tr>
    </table>

{/if}

{if $template == 'frontendSettings' || $template == 'configuration'}

<h1>{'FRONTEND_SETTINGS'|onapp_string}</h1>
    
        <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

            <tr>
                <td class="label">{'BASE_URL'|onapp_string}</td>
                <td>

                        {$config.base_url}

                </td>
            </tr>

              <tr>
                <td class="label">{'HOST_NAME'|onapp_string}</td>
                <td>
                        {$config.hostname}
                </td>
            </tr>

            <tr style="clear:both;">
                <td class="label">{'DEFAULT_ALIAS'|onapp_string}</td>
                <td>
                    {$config.default_alias}
                </td>
            </tr>

            <tr style="clear:both;">
                <td class="label">{'SECRET_KEY'|onapp_string}</td>

                <td>
                    {$config.secret_key}
                </td>
            </tr>

            <tr>
                <td class="label">
                    {'SESSION_LIFETIME'|onapp_string}
                </td>
                <td>
                    {round( $config.session_lifetime * 0.000277777778, 1 )} {'HOURS_'|onapp_string}
                </td>

            </tr>

            <tr>
                <td class="label">
                    {'DEFAULT_LANGUAGE'|onapp_string}
                </td>
                <td>
                    {$config.default_language}
                </td>

            </tr>

            <tr>
                <td class="label">
                     {'TEMPLATE_'|onapp_string}
                </td>
                <td>
                    {$config.template}
                </td>
            </tr>

            <tr>
                <td class="label">
                     {'CONTROLLERS_'|onapp_string}
                </td>
                <td>
                    {$config.controllers}
                </td>
            </tr>

            <tr>
                <td class="label">
                     {'LOG_DIRECTORY'|onapp_string}
                </td>
                <td>
                    {$config.log_directory}
                </td>
            </tr>
            <tr>
                <td>
                    <form action="{$config.base_url}/{$_ALIASES['frontend_settings']}" method="post">
                        <input type="submit" value="{'EDIT_'|onapp_string}" />
                        <input type="hidden" name="action" value="edit" />
                    </form>
                </td>
            </tr>
    </table> 

{/if}

{if $template == 'smartySettings' || $template == 'configuration'}

<h1>{'SMARTY_SETTINGS'|onapp_string}</h1>
    
    <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'TEMPLATE_DIRECTORY'|onapp_string}</td>
            <td>
                    {$config.smarty_template_dir}
            </td>
        </tr>

          <tr>
            <td class="label">{'COMPILE_DIRECTORY'|onapp_string}</td>
            <td>
                    {$config.smarty_compile_dir}
            </td>
        </tr>
        
        <tr style="clear:both;">
            <td class="label">{'CACHE_DIRECTORY'|onapp_string}</td>
            <td>
                {$smarty.const.ONAPP_SMARTY_CACHE_DIR}
            </td>
        </tr>

        <tr>
            <td class="label">
                {'CACHING_LIFETIME'|onapp_string}
            </td>
            <td>
                {round( $config.smarty_caching_lifetime * 0.000277777778, 1 )} {'HOURS_'|onapp_string}
            </td>

        </tr>

        <tr style="clear:both;">
            <td class="label">{'ENABLE_CACHING'|onapp_string}</td>

            <td>
                {if $config.smarty_caching_enable > 0}
                        {'YES_'|onapp_string}
                    {else}
                        {'NO_'|onapp_string}
                {/if}
            </td>
        </tr>

        <tr>
            <td class="label">
                {'FORCE_COMPILE'|onapp_string}
            </td>
            <td>
                {if $config.smarty_force_compile > 0}
                        {'YES_'|onapp_string}
                    {else}
                        {'NO_'|onapp_string}
                {/if}
            </td>

        </tr>
  
        <tr>
            <td class="label">
                 {'COMPILE_CHECK'|onapp_string}
            </td>
            <td>
                {if $config.smarty_compile_check > 0}
                        {'YES_'|onapp_string}
                    {else}
                        {'NO_'|onapp_string}
                    {/if}
            </td>
        </tr>
<tr>
    <td>
        <form action="{$config.base_url}/{$_ALIASES['smarty_settings']}" method="post">
            <input type="submit" value="{'EDIT_'|onapp_string}" />
            <input type="hidden" name="action" value="edit" />
        </form>
    </td>
</tr>
</table>

{/if}


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}