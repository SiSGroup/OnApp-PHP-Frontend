{include file="default/views/header.tpl"}
        
   <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'REF_'|onapp_string}</th>
            <th>{'DATE_'|onapp_string}</th>
            <th>{'ACTION_'|onapp_string}</th>
            <th>{'STATUS_'|onapp_string}</th>
            <th>{'TARGET_'|onapp_string}</th>
            <th>{'DEPENDENT_'|onapp_string}</th>
        </tr>

    {foreach from=$logs_obj key=k item=v}
        <tr>
            <td>
                <a href="{$_ALIASES["logs"]}?action=details&amp;id={$v->_id}">
                    {$v->_id}
                </a>
            </td>
                
            <td>
                {$v->_created_at}
            </td>

             <td>
                 {$v->_action}
            </td>

            <td class="{if $v->_status == 'complete'}complete{elseif $v->_status == 'failed'}failed{elseif $v->_status == 'running'}running{else}cancelled{/if}">
                 {$v->_status}
            </td>
                 
            <td>
                {$v->_parent_type}#{$v->_parent_id}
            </td>

            <td>
                {$v->_dependent_transaction_id}
            </td>
        </tr>
    
    
   {/foreach}
    </table>
 
{include file="default/views/pagination.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}