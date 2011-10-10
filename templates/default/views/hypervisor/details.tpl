<table class="table_buttons" width="100%" cellpadding="0" cellspacing="10">

     <tr>
        <td class="action_edit">
            
            <a href="{$_ALIASES["hypervisors"]}?action=edit&amp;id={$hypervisor_id}">
                {'EDIT_HYPERVISOR'|onapp_string}
            </a>
        </td>
        <td class="action_reboot">
            <a href="{$_ALIASES["hypervisors"]}?action=reboot&amp;id={$hypervisor_id}">
                {'REBOOT_HYPERVISOR'|onapp_string}
            </a>
        </td>
    </tr>
    
</table>