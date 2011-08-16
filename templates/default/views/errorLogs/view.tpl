{include file="default/views/header.tpl"}
        
   <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'ERROR_IDENTIFIER'|onapp_string}</th>
            <th>{'DATE_'|onapp_string}</th>
            <th>{'SIZE_'|onapp_string}</th>
        </tr>

    {foreach from=$files_list key=file_id item=value}
        <tr>
            <td>
                <a href="{$_ALIASES["error_logs"]}?action=details&amp;id={$file_id}">
                    {$file_id}
                </a>
            </td>
            <td>
                {$value.date}
            </td>
            <td>
                {$value.size} bytes
            </td>
        </tr>
    
    
   {/foreach}
    </table>

    
{include file="default/views/pagination.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}