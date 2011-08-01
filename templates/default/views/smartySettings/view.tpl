{include file="default/views/header.tpl"}

{if isset($smarty.session.error)}
    <div id="onapp_error">
            {$smarty.session.error|onapp_string}
    </div>
{/if}

{if isset($smarty.session.message)}
    <div id="onapp_msg">
            {$smarty.session.message|onapp_string}
    </div>
{/if}

<div style="clear:both;"></div>
<div class="info">

       <div class="info_title">
            {'SMARTY_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'SMARTY_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>

<h1>{$title|onapp_string}</h1>
    
    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

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

</table> 
<form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['smarty_settings']}" method="post">
    <input type="submit" value="{'EDIT_'|onapp_string}" />
    <input type="hidden" name="action" value="edit" />
</form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
 
