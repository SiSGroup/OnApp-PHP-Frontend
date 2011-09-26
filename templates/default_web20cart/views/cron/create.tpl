{include file="default_web20cart/views/header.tpl"}

<h1>{$title}</h1>

<form action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['frontend_settings']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'COMMON_SETTINGS'|onapp_string}</dt>
            <dd>
                <select onchange="filter()" name="filter">
                    <option id="custom_settings">{'COMMON_SETTINGS'|onapp_string}</option>
                    <option id="every_minute">{'EVERY_MINUTE_'|onapp_string}</option>
                    <option id="once_a_day">{'ONCE_A_DAY'|onapp_string}</option>
                    <option id="once_an_hour">{'ONCE_AN_HOUR'|onapp_string}</option>
                    <option id="twice_an_hour">{'TWICE_AN_HOUR'|onapp_string}</option>
                    <option id="twice_a_day">{'TWICE_A_DAY'|onapp_string}</option>
                    <option id="once_a_month">{'ONCE_A_MONTH'|onapp_string}</option>
                    <option id="every_five_minute">{'EVERY_FIVE_MINUTES'|onapp_string}</option>
                    <option id="once_an_year">{'ONCE_A_YEAR'|onapp_string}</option>
                </select>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'MINUTE_'|onapp_string}</dt>
            <dd>
                <select name="cron[minute]">
                    {foreach from=$minute_php key=k item=min}
                        <option id="min_{$k}" value="{$k}">{$min}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'HOUR_'|onapp_string}</dt>
            <dd>
                <select name="cron[hour]">
                    {foreach from=$hour_php key=k item=hr}
                        <option id="hr_{$k}" value="{$k}">{$hr}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'DAY_'|onapp_string}</dt>

            <dd>
                <select name="cron[day]">
                    {foreach from=$day_php key=k item=_day}
                        <option id="d_{$k}" value="{$k}">{$_day}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'MONTH_'|onapp_string}<br /> </dt>

            <dd>
                <select name="cron[month]">
                    {foreach from=$month_php key=k item=_month}
                        <option id="mon_{$k}" value="{$k}">{$_month}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl>
            <dt class="label">{'WEEK_DAY'|onapp_string}</dt>
            <dd>
                 <select name="cron[weekday]">
                    {foreach from=$weekday_php key=k item=_weekday}
                        <option id="wday_{$k}" value="{$k}">{$_weekday}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl>
            <dt class="label">{'COMMAND_'|onapp_string}</dt>
            <dd>
                 <input type="text" name="cron[command]" value=""/>
            </dd>
        </dl>
 </div>

    <input type="hidden" name="action" value="save" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />

</form>

{literal}
    <script type="text/javascript" src="templates/default_web20cart/views/cron/template_filter.js"></script>
{/literal}

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}
