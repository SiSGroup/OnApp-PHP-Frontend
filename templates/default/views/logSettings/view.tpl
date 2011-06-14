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
            {'LOG_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'LOG_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>

<h1>{$title|onapp_string}</h1>
    
    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'LOG_LEVEL_PHP'|onapp_string}</td>
            <td>
                 
                    {$php_error_levels[$config.log_level_php]}
                
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
</table> 
<form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['log_settings']}?action=edit">
    <input type="submit" value="{'EDIT_'|onapp_string}" />
    <input type="hidden" name="action" value="edit" />
<form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
 
