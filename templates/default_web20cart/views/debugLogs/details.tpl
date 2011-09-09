{include file="default_web20cart/views/header.tpl"}

    <form action='{$_ALIASES["debug_logs"]}' method="post">
        <table class="form-table" width="100%" cellpadding="0" cellspacing="0" >

            <tr>
                <td class="label">{'SESSION_ID'|onapp_string}</td>
                <td>
                    <input type="text" name="id" value="{$id}" />
                </td>
            </tr>

        </table>

        <input type="hidden" name="action" value="details" />

        <input type="submit" name="submit" value="{'VIEW_'|onapp_string}" />

    </form>
<br /><br />
   
   <div id="log_details">
           {if isset($contents)}
               <pre>{$contents}</pre>
           {else}
               <p>No output generated</p>
           {/if}       
   </div>
    
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}