{include file="default_web20cart/views/header.tpl"}

<h1>{$user_obj->_first_name} {$user_obj->_last_name}</h1>

<h1>{'PROPERTIES_'|onapp_string}</h1>
    <form action='{$_ALIASES["users_and_groups"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="invoice_number">{'INVOICE_NUMBER'|onapp_string}</label></dt>
                <dd><input id="invoice_number" type="text" name="payment[_invoice_number]" /></dd>
            </dl>
            <dl>
                <dt><label for="amount">{'AMOUNT_'|onapp_string}</label></dt>
                <dd><input id="amount" type="text" name="payment[_amount]" /></dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$user_obj->_id}" />
        <input type="hidden" name = "action" value="payment_create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}