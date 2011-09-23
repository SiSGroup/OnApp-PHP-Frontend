{include file="default_web20cart/views/header.tpl"}
    
    {if $cron_jobs == false}
        <p class="not_found">No cronjobs found<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th>{'CRON_JOBS'|onapp_string}</th>
                
                <th></th>
            </tr>
    
            {foreach from=$cron_jobs  item=cron_job}
              <tr>
                <td>
                    <span title="{$cron_job}">{$cron_job}</span>
                </td>
                <td class="dark_td">
                    <a href="{$_ALIASES["cron_manager"]}?action=delete&amp;cron_job={urlencode($cron_job)}">
                        <img alt="{'DELETE_CRON_JOB'|onapp_string}" title="{'DELETE_CRON_JOB'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/delete_icon.png" />
                    </a>
                </td>
            </tr>
           {/foreach}
    
    {/if}
    </table>
    {if !isset($hypervisor_id)}
        <div>
            <form action="{$_ALIASES["virtual_machines"]}" method="post">
                   <input type="submit" value="{'ADD_NEW_CRON_JOB'|onapp_string}" />
                   <input type="hidden" name="action" value="create_page" />
            </form>
        </div>
    {else}
        {include file="default_web20cart/views/hypervisor/details.tpl"}
    {/if}


{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}