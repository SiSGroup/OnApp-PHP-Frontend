{include file="default/views/header.tpl"}
<h1>{'PROPERTIES_'|onapp_string}</h1>

    <form action='{$_ALIASES["virtual_machines"]}' method="post">
        <div class="div_page">
            <dl>
                <dt><label for="data_store">{'DATA_STORE'|onapp_string}</label></dt>

            <dd>
                <select  name="disk[_data_store_id]">
                    <option></option>
                    {foreach from=$data_store_obj item=data_store}
                        <option value="{$data_store->_id}" >
                            {$data_store->_label}
                        </option>
                    {/foreach}
                </select>
            </dd>
            </dl>
            <dl>
                <dt>
                    <label for="size">{'SIZE_'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="size" type="text" name="disk[_disk_size]" value="" />GB
                </dd>
            </dl>
            <dl>
                <dt>

                </dt>
                <dd>
                    <input type="hidden" name="disk[_is_swap]" value="0" />
                    <input value="1" type="checkbox" name="disk[_is_swap]" />
                    {'SWAP_SPACE'|onapp_string}
                </dd>
            </dl>
            </dl>
            <dl>
                <dt>

                </dt>
                <dd>
                    <input type="hidden" name="disk[_require_format_disk]" value="0" />
                    <input value="1" type="checkbox" name="disk[_require_format_disk]" checked = "true"/>
                    {'REQUIRE_FORMAT_DISK'|onapp_string}
                </dd>
            </dl>
            </dl>
            <dl>
                <dt>

                </dt>
                <dd>
                    <input type="hidden" name="disk[_add_to_linux_fstab]" value="0" />
                    <input value="1" type="checkbox" name="disk[_add_to_linux_fstab]" />
                    {'ADD_TO_LINUX_FSTAB'|onapp_string}
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="size">{'MOUNT_POINT'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="size" type="text" name="disk[_mount_point]" />
                </dd>
            </dl>
        </div>
        
        <input type="submit" value="{'ADD_DISK'|onapp_string}" />
        <input type="hidden" name="id" value="{$virtual_machine_id}" />
        <input type="hidden" name="disk[_virtual_machine_id]" value="{$virtual_machine_id}" />
        <input type="hidden" name="action" value="disk_create" />
    </form>
        
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}