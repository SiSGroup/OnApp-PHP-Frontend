{include file="default/views/header.tpl"}

{if isset($smarty.session.error)}
    <div class="onapp_error">
            {$smarty.session.error|onapp_string}
    </div>
{/if}

{if isset($smarty.session.message)}
    <div class="onapp_msg">
            {$smarty.session.message|onapp_string}
    </div>
{/if}

<div style="clear:both;"></div>
<div class="info">

       <div class="info_title">
            {'FRONTEND_SETTINGS'|onapp_string}
        </div>

       <div class="info_body">
            {'FRONTEND_SETTINGS_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

</div>

<h1>{$title|onapp_string}</h1>
    
    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

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
</table> 
<form action="{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['frontend_settings']}" method="post">
    <input type="submit" value="{'EDIT_'|onapp_string}" />
    <input type="hidden" name="action" value="edit" />
<form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
 
