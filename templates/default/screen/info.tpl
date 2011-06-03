{include file="default/header.tpl"}

<h1>{'SCREEN_INFO'|onapp_string}</h1>
    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'SCREEN_ID'|onapp_string}</td>
            <td>
                {$screen_id}
            </td>
        </tr>

        <tr>
            <td class="label">{'SCREEN_DESCRIPTION'|onapp_string}</td>
            <td>
                {$screen_alias}
            </td>
        </tr>

        <tr>
            <td class="label">{'SCREEN_CLASS'|onapp_string}</td>
            <td>
                {$screen_class}
            </td>
        </tr>

        <tr>
            <td class="label">{'SCREEN_METHOD'|onapp_string}</td>
            <td>
                {$screen_method}
            </td>
        </tr>

    </table>

{include file="default/navigation.tpl"}
{include file="default/footer.tpl"} 