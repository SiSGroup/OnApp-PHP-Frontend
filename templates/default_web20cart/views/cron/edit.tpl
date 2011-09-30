{include file="default_web20cart/views/header.tpl"}

<form id="cron_form" action='{$smarty.const.ONAPP_BASE_URL}/{$_ALIASES['cron_manager']}' method="post">
    <div class="div_page">

        <dl>
            <dt class="label">{'COMMON_SETTINGS'|onapp_string}</dt>
            <dd>
                <select id="filter" name="filter">
                    <option id="common_settings">{'COMMON_SETTINGS'|onapp_string}</option>
                    <option id="every_minute">{'EVERY_MINUTE_'|onapp_string}</option>
                    <option id="once_a_day">{'ONCE_A_DAY'|onapp_string}</option>
                    <option id="once_an_hour">{'ONCE_AN_HOUR'|onapp_string}</option>
                    <option id="twice_an_hour">{'TWICE_AN_HOUR'|onapp_string}</option>
                    <option id="twice_a_day">{'TWICE_A_DAY'|onapp_string}</option>
                    <option id="once_a_month">{'ONCE_A_MONTH'|onapp_string}</option>
                    <option id="every_five_minute">{'EVERY_FIVE_MINUTES'|onapp_string}</option>
                    <option id="once_a_year">{'ONCE_A_YEAR'|onapp_string}</option>
                </select>
            </dd>
        </dl>

          <dl>
            <dt class="label">{'MINUTE_'|onapp_string}</dt>
            <dd>
                <input type="hidden" id="cron_minute_hidden" value='' name="cron[minute]" />
                <select id="cron_minute" name="cron[minute]">
                    {foreach from=$minute_php key=k item=min}
                        <option id="min_{$k}" value="{$k}" {if $k == $cron_jobs_array[0]}selected{/if}>{$min}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'HOUR_'|onapp_string}</dt>
            <dd>
                <input type="hidden" id="cron_hour_hidden" value='*' name="cron[hour]" /> 
                <select id="cron_hour" name="cron[hour]">
                    {foreach from=$hour_php key=k item=hr}
                        <option id="hr_{$k}" value="{$k}" {if $k == $cron_jobs_array[1]}selected{/if}>{$hr}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'DAY_'|onapp_string}</dt>

            <dd>
                <input type="hidden" id="cron_day_hidden" value='*' name="cron[day]" />
                <select id="cron_day" name="cron[day]">
                    {foreach from=$day_php key=k item=_day}
                        <option id="d_{$k}" value="{$k}"  {if $k == $cron_jobs_array[2]}selected{/if}>{$_day}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl style="clear:both;">
            <dt class="label">{'MONTH_'|onapp_string}<br /> </dt>

            <dd>
                <input type="hidden" id="cron_month_hidden" value='*' name="cron[month]" />
                <select id="cron_month" name="cron[month]">
                    {foreach from=$month_php key=k item=_month}
                        <option id="mon_{$k}" value="{$k}" {if $k == $cron_jobs_array[3]}selected{/if}>{$_month}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl>
            <dt class="label">{'WEEK_DAY'|onapp_string}</dt>
            <dd>
                <input type="hidden" id="cron_weekday_hidden" value='*' name="cron[weekday]" />
                 <select name="cron[weekday]">
                    {foreach from=$weekday_php key=k item=_weekday}
                        <option id="wday_{$k}" value="{$k}" {if $k == $cron_jobs_array[4]}selected{/if}>{$_weekday}</option>
                    {/foreach}
                </select>
            </dd>
        </dl>

        <dl>
            <dt class="label">{'COMMAND_'|onapp_string}</dt>
            <dd>
                 <input id="cron_command" type="text" name="cron[command]" value="{$cron_jobs_array[5]}"/>
            </dd>
        </dl>
 </div>

    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="cron_jobs_array" value="{urlencode(json_encode($cron_jobs_array))}" />
    <input type="submit" name="submit" value="{'SAVE_'|onapp_string}" />
    <input type="reset" style="visibility:hidden" class="button" value="Clear" />
</form>

{literal}
    <script type="text/javascript" src="templates/default_web20cart/views/cron/template_filter.js"></script>
{/literal}

{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}