{include file="default/header.tpl"}

<div class="info">

       <div class="info_title">
            {'SCREENS_'|onapp_string}
        </div>

       <div class="info_body">
            {'SCREENS_INFO_INFO'|onapp_string}
        </div>
        <div class="info_bottom"></div>

    </div>

<h1>{$title|onapp_string}</h1>

<form action='{$_ALIASES["screens"]}' method="post">
    <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

        <tr>
            <td class="label">{'SCREEN_ID'|onapp_string}</td>
            <td>
                <input type="text" name="screen_id" />
            </td>
        </tr>

    </table>

    <input type="hidden" name="action" value="screen_info" />

    <input type="submit" name="submit" value="{'VIEW_'|onapp_string}" />

</form>
{include file="default/navigation.tpl"}
{include file="default/footer.tpl"}
 
