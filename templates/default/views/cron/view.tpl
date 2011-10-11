{include file="default/views/header.tpl"}
    
    {if $cron_jobs == false}
        <p class="not_found">No cronjobs found<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th>{'MINUTE_'|onapp_string}</th>
                <th>{'HOUR_'|onapp_string}</th>
                <th>{'DAY_'|onapp_string}</th>
                <th>{'MONTH_'|onapp_string}</th>
                <th>{'WEEKDAY_'|onapp_string}</th>
                <th>{'COMMAND_'|onapp_string}</th>
                <th></th>
            </tr>

            {foreach from=$cron_jobs key=k item=cron_job}
              <tr>
                <td>
                    <span title="">{$cron_jobs_array[$k][0]}</span>
                </td>
                <td>
                    <span title="">{$cron_jobs_array[$k][1]}</span>
                </td>
                <td>
                    <span title="">{$cron_jobs_array[$k][2]}</span>
                </td>
                <td>
                    <span title="">{$month_php[$cron_jobs_array[$k][3]]}</span>
                </td>
                <td>
                    <span title="">{$weekday_php[$cron_jobs_array[$k][4]]}</span>
                </td>
                <td>
                    <span title="">{$cron_jobs_array[$k][5]}</span>
                </td>
                <td class="dark_td">
                    <a href="{$_ALIASES["cron_manager"]}?action=edit&amp;cron_job={urlencode($cron_job)}">
                        <img alt="{'EDIT_CRON_JOB'|onapp_string}" title="{'EDIT_CRON_JOB'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/edit.png" />
                    </a>
                    <a href="{$_ALIASES["cron_manager"]}?action=delete&amp;cron_job={urlencode($cron_job)}">
                        <img alt="{'DELETE_CRON_JOB'|onapp_string}" title="{'DELETE_CRON_JOB'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                    </a>
                </td>
            </tr>
           {/foreach}

    {/if}
    </table>
        <div>
            <form action="{$_ALIASES["cron_manager"]}" method="post">
                   <input type="submit" value="{'ADD_NEW_CRON_JOB'|onapp_string}" />
                   <input type="hidden" name="action" value="create" />
            </form>
        </div>

{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}