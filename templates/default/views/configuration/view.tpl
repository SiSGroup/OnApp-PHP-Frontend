{include file="default/views/header.tpl"}

<div style="clear:both;"></div>
<div class="info">

       <div class="info_title">
            {'CONFIGURATION_'|onapp_string}
        </div>

       <div class="info_body">
            {'CONFIGURATION_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>


<h1>{'SCREENS_'|onapp_string}</h1>

<form action='{$_ALIASES["screens"]}' method="post">
    <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'SCREEN_ID'|onapp_string}</td>
            <td>
                <input type="text" name="screen_id" value="{$screen_id}" />
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="action" value="info" />
                <input type="submit" name="submit" value="{'VIEW_'|onapp_string}" />
            </td>
        </tr>
    </table>

    

</form>


<h1>{'LOG_SETTINGS'|onapp_string}</h1>
    
    <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'LOG_LEVEL_PHP'|onapp_string}</td>
            <td>
                 
                    {$php_error_levels[$smarty.const.ONAPP_LOG_LEVEL_PHP]}
                
            </td>
        </tr>

          <tr>
            <td class="label">{'LOG_LEVEL_FRONTEND'|onapp_string}</td>
            <td>
                    {$log_levels_frontend[$smarty.const.ONAPP_LOG_LEVEL_FRONTEND]}        
            </td>
        </tr>
        
        <tr style="clear:both;">
            <td class="label">{'LOG_ROTATION_DAYS'|onapp_string}</td>
            <td>
                {$smarty.const.ONAPP_LOG_ROTATION_DAYS} Days
            </td>
        </tr>

        <tr style="clear:both;">
            <td class="label">{'LOG_ROTATION_SIZE'|onapp_string}</td>
            
            <td>
                {$smarty.const.ONAPP_LOG_ROTATION_SIZE} MB
            </td>
        </tr>

        <tr>
            <td class="label">
                {'PROBLEM_REPORT_DEBUG_LOG_ENABLE'|onapp_string}
            </td>
            <td>
                {if $smarty.const.ONAPP_PROBLEM_REPORT_DEBUG_LOG_ENABLE == 1}
                     Yes
                {else}
                     No
                {/if}
            </td>

        </tr>

        <tr>
            <td class="label">
                {'THIRD_PART_PRODUCT_REPORT_ENABLE'|onapp_string}
            </td>
            <td>
                {if $smarty.const.ONAPP_THIRD_PART_PRODUCT_REPORT_ENABLE == 1}
                    Yes
                {else}
                    No
                {/if}
            </td>

        </tr>
  
        <tr>
            <td class="label">
                 {'WRAPPER_LOG_REPORT_ENABLE'|onapp_string}
            </td>
            <td>
                {if $smarty.const.ONAPP_WRAPPER_LOG_REPORT_ENABLE == 1}
                    Yes
                {else}
                    No
                {/if}
            </td>

        </tr>
        <tr>
            <td>
                <form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['log_settings']}" method="post">
                    <input type="submit" value="{'EDIT_'|onapp_string}" />
                    <input type="hidden" name="action" value="edit" />
                </form>
            </td>
        </tr>
</table> 

<h1>{'FRONTEND_SETTINGS'|onapp_string}</h1>
    
    <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'BASE_URL'|onapp_string}</td>
            <td>
                 
                    {$smarty.const.ONAPP_BASE_URL}
                
            </td>
        </tr>

          <tr>
            <td class="label">{'HOST_NAME'|onapp_string}</td>
            <td>
                    {$smarty.const.ONAPP_HOSTNAME}
            </td>
        </tr>
        
        <tr style="clear:both;">
            <td class="label">{'DEFAULT_ALIAS'|onapp_string}</td>
            <td>
                {$smarty.const.ONAPP_DEFAULT_ALIAS}
            </td>
        </tr>

        <tr style="clear:both;">
            <td class="label">{'SECRET_KEY'|onapp_string}</td>
            
            <td>
                {$smarty.const.ONAPP_SECRET_KEY}
            </td>
        </tr>

        <tr>
            <td class="label">
                {'SESSION_LIFETIME'|onapp_string}
            </td>
            <td>
                {round( $smarty.const.ONAPP_SESSION_LIFETIME * 0.000277777778, 1 )} {'HOURS_'|onapp_string}
            </td>

        </tr>

        <tr>
            <td class="label">
                {'DEFAULT_LANGUAGE'|onapp_string}
            </td>
            <td>
                {$smarty.const.ONAPP_DEFAULT_LANGUAGE}
            </td>

        </tr>
  
        <tr>
            <td class="label">
                 {'TEMPLATE_'|onapp_string}
            </td>
            <td>
                {$smarty.const.ONAPP_TEMPLATE}
            </td>
        </tr>

        <tr>
            <td class="label">
                 {'CONTROLLERS_'|onapp_string}
            </td>
            <td>
                {$smarty.const.ONAPP_CONTROLLERS}
            </td>
        </tr>
        
        <tr>
            <td class="label">
                 {'LOG_DIRECTORY'|onapp_string}
            </td>
            <td>
                {$smarty.const.ONAPP_LOG_DIRECTORY}
            </td>
        </tr>
        <tr>
            <td>
                <form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['frontend_settings']}" method="post">
                    <input type="submit" value="{'EDIT_'|onapp_string}" />
                    <input type="hidden" name="action" value="edit" />
                </form>
            </td>
        </tr>
</table> 


<h1>{'SMARTY_SETTINGS'|onapp_string}</h1>
    
    <table class="form-table two" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'TEMPLATE_DIRECTORY'|onapp_string}</td>
            <td>
                    {$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}
            </td>
        </tr>

          <tr>
            <td class="label">{'COMPILE_DIRECTORY'|onapp_string}</td>
            <td>
                    {$smarty.const.ONAPP_SMARTY_COMPILE_DIR}
            </td>
        </tr>
        
        <tr style="clear:both;">
            <td class="label">{'CACHE_DIRECTORY'|onapp_string}</td>
            <td>
                {$smarty.const.ONAPP_SMARTY_CACHE_DIR}
            </td>
        </tr>

        <tr style="clear:both;">
            <td class="label">{'ENABLE_CACHING'|onapp_string}</td>
            
            <td>
                {if $smarty.const.ONAPP_SMARTY_CACHING_ENABLE > 0}
                     Yes
                {else}
                     No
                {/if}
            </td>
        </tr>

        <tr>
            <td class="label">
                {'CACHING_LIFETIME'|onapp_string}
            </td>
            <td>
                {round( $smarty.const.ONAPP_SMARTY_CACHING_LIFETIME * 0.000277777778, 1 )} {'HOURS_'|onapp_string}
            </td>

        </tr>

        <tr>
            <td class="label">
                {'FORCE_COMPILE'|onapp_string}
            </td>
            <td>
                {if $smarty.const.ONAPP_SMARTY_FORCE_COMPILE > 0}
                     Yes
                {else}
                     No
                {/if}
            </td>

        </tr>
  
        <tr>
            <td class="label">
                 {'COMPILE_CHECK'|onapp_string}
            </td>
            <td>
                {if $smarty.const.ONAPP_SMARTY_COMPILE_CHECK > 0}
                     Yes
                {else}
                     No
                {/if}
            </td>
        </tr>
<tr>
    <td>
        <form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['smarty_settings']}" method="post">
            <input type="submit" value="{'EDIT_'|onapp_string}" />
            <input type="hidden" name="action" value="edit" />
        </form>
    </td>
</tr>
</table> 


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
 
