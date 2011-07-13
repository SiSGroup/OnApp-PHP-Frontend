{include file="default/views/header.tpl"}
<h1>{'ENTER_NEW_DISK_SIZE'|onapp_string}</h1>
    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="target">{'TARGET_'|onapp_string}</label></dt>
                <dd>Disk#{$schedule_obj->_target_id}</dd>
            </dl>
            <dl>
                <dt><label for="duration">{'DURATION_'|onapp_string}</label></dt>
                <dd><input id="duration" type="text" name="schedule[_duration]" value="{$schedule_obj->_duration}" /></dd>
            </dl>
            <dl>
                <dt><label for="period">{'PERIOD_'|onapp_string}</label></dt>
                <dd>
                    <select id="period"  name="schedule[_period]">
                    {foreach from=$periods key=period_key item=period_item}
                        <option value="{$period_key}" {if $schedule_obj->_period == $period_key}selected="true"{/if}>{$period_item}</option>
                    {/foreach}
                    </select>
                </dd>
            </dl>
            <dl>
                <dt></dt>
                <dd>
                    <input type="hidden" name="schedule[_status]" value="disabled" />
                    <input value="enabled" type="checkbox" name="schedule[_status]" {if $schedule_obj->_status == 'enabled'}checked="true"{/if}/>
                    {'ENABLED_'|onapp_string}
                </dd>
            </dl>
        </div>
        <input type="hidden" name = "id" value="{$schedule_obj->_target_id}" />
        <input type="hidden" name = "schedule[_id]" value="{$schedule_obj->_id}" />
        <input type="hidden" name = "action" value="disk_backups_schedule_edit" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>
      
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}