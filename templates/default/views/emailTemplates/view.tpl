{include file="default/views/header.tpl"}

{if $events != NULL} 
   <table class="table_my" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>{'TEMPLATE_NAME'|onapp_string}</th>
            <th>{'EVENT_ASSIGNMENT'|onapp_string}</th>
            <th></th>
        </tr>

   {foreach from=$events key=event item=mails}
       {if $mails != NULL}
           {foreach from=$mails key=file_name item=template_name}
              <tr>
                <td>
                    {$template_name}
                </td>
                <td>
                    {$event}
                </td>
                <td class="dark_td">
                    <a href="{$_ALIASES["email_templates"]}?action=edit&amp;event={$event}&amp;file_name={$file_name}">
                        <img alt="{'EDIT_TEMPLATE'|onapp_string}" title="{'EDIT_TEMPLATE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                    </a>
                    <a href="{$_ALIASES["email_templates"]}?action=delete&amp;event={$event}&amp;file_name={$file_name}">
                        <img alt="{'DELETE_TEMPLATE'|onapp_string}" title="{'DELETE_TEMPLATE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                    </a>
                </td>
            </tr>
           {/foreach}
       {/if}
   {/foreach}
    </table>
{else}
    <p class="not_found">{'NO_TEMPLATES_FOUND'|onapp_string}</p>
{/if}

<div>
    <form style="float:right" action="{$_ALIASES["email_templates"]}" method="post">
        <input type="submit" value="{'ADD_NEW_EMAIL_TEMPLATE'|onapp_string}" />
        <input type="hidden" name="action" value="create" />
    </form>
</div>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}

