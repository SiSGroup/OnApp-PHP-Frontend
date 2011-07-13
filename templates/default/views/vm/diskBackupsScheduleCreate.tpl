{include file="default/views/header.tpl"}

    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            
            <dl>
                <dt><label for="duration">{'DURATION_'|onapp_string}</label></dt>
                <dd><input id="duration" type="text" name="schedule[_duration]"  /></dd>
            </dl>
            <dl>
                <dt><label for="period">{'PERIOD_'|onapp_string}</label></dt>
                <dd>
                    <select id="period"  name="schedule[_period]">
                        <option value="days">Days</option> 
                        <option value="weeks">Weeks</option> 
                        <option value="months">Months</option> 
                        <option value="years">Years</option>
                    </select>
                </dd>
            </dl>  
        </div>
        <input type="hidden" name = "id" value="{$disk_id}" />
        <input type="hidden" name = "schedule[_target_id]" value="{$disk_id}" />
        <input type="hidden" name = "action" value="disk_backups_schedule_create" />
        <input type="submit" value="{'SAVE_'|onapp_string}" />
    </form>
       
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}