<br /><br /><br /><br />
 <h1>{'USER_MENU'|onapp_string}</h1>
    <table width="100%" class="table_buttons" cellpadding="0" cellspacing="10">
        <tr>
            <td class="action_edit"><a href="{$_ALIASES["users_and_groups"]}?action=details&amp;id={$user_id}">{'OVERVIEW_'|onapp_string}</a></td>
            <td class="action_edit"><a href="{$_ALIASES["users_and_groups"]}?action=payments&amp;id={$user_id}">{'PAYMENTS_'|onapp_string}</a></td>
            <!--TODO Ticket # <td class="action_edit"><a href="{$_ALIASES["users_and_groups"]}?action=billing_plan&amp;id={$user_id}">{'BILLING_PLAN'|onapp_string}</a></td> -->
            <td class="action_edit"><a href="{$_ALIASES["users_and_groups"]}?action=white_list&amp;id={$user_id}">{'WHITE_LIST'|onapp_string}</a></td>
            <td class="action_edit"><a href="{$_ALIASES["users_and_groups"]}?action=edit&amp;id={$user_id}">{'EDIT_PROFILE'|onapp_string}</a></td>
        </tr>
    </table>