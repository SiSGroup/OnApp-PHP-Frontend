{include file="default_web20cart/views/header.tpl"}

{if $files_list != NULL}
   <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'ERROR_IDENTIFIER'|onapp_string}</th>
            <th>{'DATE_'|onapp_string}</th>
            <th>{'SIZE_'|onapp_string}</th>
            <th></th>
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
            <td>
                <a href="{$_ALIASES["debug_logs"]}?action=details&amp;id={$file_id}">
                    {'COMPLETE_DEBUG_INFO'|onapp_string}
                </a>
            </td>
        </tr>
    
    
   {/foreach}
    </table>
{else}
    <p class="not_found">No errors found</p>
{/if}

{if $pages_quantity > 1}
    {include file="default_web20cart/views/pagination.tpl"}
{/if}

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}