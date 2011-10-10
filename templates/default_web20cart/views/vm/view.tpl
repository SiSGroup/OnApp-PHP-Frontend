{include file="default_web20cart/views/header.tpl"}
    
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
                <th>{'WHMCS_MAPPED'|onapp_string}</th>
                <th>{'STATUS_'|onapp_string}</th>

               <!-- <th>{'BACKUPS_'|onapp_string}</th> -->
                <th></th>
            </tr>
    
            {foreach from=$virtual_machines key=k item=v} 
            <tr class="{if $v->_whmcs_maped > 0}maped{/if}">
                <td class="lamp">
                    {if $v->_booted > 0}
                        <img alt="{'ON_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/on.png" />

                    {else}
                        <img alt="{'OFF_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/off.png" />
                    {/if}
                </td>
                <td>
                    {if $v->_whmcs_status == 'Active'}
                        <a title="{$v->_label}" href="{$_ALIASES["virtual_machines"]}?action=details&amp;id={$v->_id}">
                            {$v->_label|onapp_table_display}
                        </a>
                    {else}
                        {$v->_label|onapp_table_display}
                    {/if}
                </td>

                <td>
                    {if isset( $v->_ip_addresses[0] )}
                    {foreach from=$v->_ip_addresses key=k item=val}
                        {$val->_address} <br />
                    {/foreach}
                    {else}
                        {'NO_ADDRESSES'|onapp_string}
                    {/if}
                </td>
                <td class="power_td">
                    {if $v->_whmcs_status == 'Active'}
                        {if $v->_booted == '1'}
                            <a class="power on-active" >{'ON_'|onapp_string}</a>
                            <a class="power off-inactive" href="{$_ALIASES["virtual_machines"]}?action=shutdown&amp;id={$v->_id}">{'OFF_'|onapp_string}</a>
                        {elseif $v->_suspended || $v->_built < 1}
                            <a class="power pending">{'PENDING_'|onapp_string}</a>
                        {else}
                            <a class="power on-inactive" href="{$_ALIASES["virtual_machines"]}?action=startup&amp;id={$v->_id}">{'ON_'|onapp_string}</a>
                            <a class="power off-active" >{'OFF_'|onapp_string}</a>
                        {/if}
                    {else}
                         {if $v->_booted == '1'}
                            <a class="power on-active" >{'ON_'|onapp_string}</a>
                            <a class="power off-inactive">{'OFF_'|onapp_string}</a>
                        {elseif $v->_suspended || $v->_built < 1}
                            <a class="power pending">{'PENDING_'|onapp_string}</a>
                        {else}
                            <a class="power on-inactive" >{'ON_'|onapp_string}</a>
                            <a class="power off-active" >{'OFF_'|onapp_string}</a>
                        {/if}
                    {/if}
                </td>
                <td>{$v->_total_disk_size} GB</td>
                <td>{$v->_memory|onapp_file_size}</td>
                <td>
                    {if $v->_whmcs_maped > 0}
                        {'YES_'|onapp_string}
                    {else}
                        <a href="{$_ALIASES["virtual_machines"]}?action=map&amp;id={$v->_id}">
                            {'MAPPING_ERROR'|onapp_string}
                        </a>
                    {/if}
                </td>
                <td>
                    {if $v->_whmcs_status != 'Active'}
                        <b style="color:red">{$v->_whmcs_status}</b>
                    {else}
                        <b style="color:green">{$v->_whmcs_status}</b>
                    {/if}
                </td>
                <td class="dark_td">
                    {if $v->_whmcs_status == 'Active'}
                    <a href="{$_ALIASES["virtual_machines"]}?action=cpu_usage&amp;id={$v->_id}">
                        <img alt="{'CPU_USAGE'|onapp_string}" title="{'CPU_USAGE'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/chart2.png" />
                    </a>
                    <a href="{$_ALIASES["virtual_machines"]}?action=backup&amp;id={$v->_id}">
                        <img alt="{'BACKUPS_'|onapp_string}" title="{'BACKUPS_'|onapp_string}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/backup.png" />
                    </a>
                    {else}
                        
                    {/if}

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
        {include file="default_web20cart/views/hypervisor/details.tpl"}
    {/if}


{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}