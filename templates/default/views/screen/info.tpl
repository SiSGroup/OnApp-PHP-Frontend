{include file="default/views/header.tpl"}

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
                {$screen.alias}
            </td>
        </tr>

        <tr>
            <td class="label">{'SCREEN_CLASS'|onapp_string}</td>
            <td>
                {$screen.class}
            </td>
        </tr>

        <tr>
            <td class="label">{'SCREEN_METHOD'|onapp_string}</td>
            <td>
                {$screen.method}
            </td>
        </tr>

    </table>

    <br/>

<h1>{$title|onapp_string}</h1>

<form action='{$_ALIASES["screens"]}' method="post">

    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'SCREEN_ID'|onapp_string}</td>
            <td>
                <input type="text" name="screen_id" value="{$screen_id}" />
            </td>
        </tr>

    </table>

    <input type="hidden" name="action" value="info" />

    <input type="submit" name="submit" value="{'VIEW_'|onapp_string}" />

</form>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}
