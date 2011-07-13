{include file="default/views/header.tpl"}
    
    {if $virtual_machines == false}
        <p class="not_found">No virtual machines found<p>
    {else}
        <table class="table_my" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th></th>
                <th>{'LABEL_'|onapp_string}</th>
                <th>{'IP_ADDRESSES'|onapp_string}</th>
                <th>{'POWER_'|onapp_string}</th>
                <th>{'DISK_SIZE'|onapp_string}</th>
                <th>{'RAM_'|onapp_string}</th>
                <th>{'BACKUPS_'|onapp_string}</th>
                <th></th>
            </tr>
    
            {foreach from=$virtual_machines key=k item=v} 
            <tr>
                <td class="lamp">
                    {if $v->_booted > 0}
                        <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/on.png" />

                    {else}
                        <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/off.png" />
                    {/if}
                </td>
                <td><a href="{$_ALIASES["virtual_machines"]}?action=details&amp;id={$v->_id}">{substr($v->_label, 0, 10)}...</a></td>

                <td>
                    {if $v->_ip_addresses[0]->_address != ''}
                        {$v->_ip_addresses[0]->_address}
                    {else}
                        {'NO_ADDRESSES'|onapp_string}
                    {/if}   
                </td>
                <td class="power_td">
                {if $v->_booted == '1'}
                    <a class="power on-active" >{'ON_'|onapp_string}</a>
                    <a class="power off-inactive" href="{$_ALIASES["virtual_machines"]}?action=shutdown&amp;id={$v->_id}">{'OFF_'|onapp_string}</a>
                {elseif $v->_suspended || $v->_built < 1}
                    <a class="power pending">{'PENDING_'|onapp_string}</a>
                {else}
                    <a class="power on-inactive" href="{$_ALIASES["virtual_machines"]}?action=startup&amp;id={$v->_id}">{'ON_'|onapp_string}</a>
                    <a class="power off-active" >{'OFF_'|onapp_string}</a>
                {/if}
                </td>
                <td>{$v->_total_disk_size} GB</td>
                <td>{$v->_memory} MB</td>
                <td> {$vm_backups[$k]["quantity"]} / {$vm_backups[$k]["size"]} MB</td>
                <td class="dark_td">
                    <a href="{$_ALIASES["virtual_machines"]}?action=cpu_usage&amp;id={$v->_id}">
                        <img title="{'CPU_USAGE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/chart2.png" />
                    </a>
                    <a href="{$_ALIASES["virtual_machines"]}?action=backup&amp;id={$v->_id}">
                        <img title="{'BACKUPS_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/backup.png" />
                    </a>
                </td>        
            </tr>      
        {/foreach}
    
    {/if}
    </table>
    {if !isset($hypervisor_id)}
        <div>
            <form action="{$_ALIASES["virtual_machines"]}" method="post">
                   <input type="submit" value="{'ADD_NEW_VIRTUAL_MACHINE'|onapp_string}" />
                   <input type="hidden" name="action" value="create_page" />
            </form>
        </div>
    {else}
        {include file="default/hypervisor/details.tpl"}
    {/if}


{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}