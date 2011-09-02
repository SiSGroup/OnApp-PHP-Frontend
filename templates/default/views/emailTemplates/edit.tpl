{include file="default/views/header.tpl"}
<h1>{'TEMPLATE_DETAILS'|onapp_string}</h1>

    <form action='{$_ALIASES["email_templates"]}' method="post">
        <div class="div_page">
            <dl>
                <dt>
                    <label for="template_name">{'TEMPLATE_NAME'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="template_name" type="text" name="template[_template_name]" value="{$template_info['template_name']}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="from_full_name">{'FROM_FULL_NAME'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="from_full_name" type="text" name="template[_from_name]" value="{$template_info['from_name']}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="from_email">{'FROM_EMAIL'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="from_email" type="text" name="template[_from]" value="{$template_info['from']}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="to_email">{'TO_EMAIL'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="to_email" type="text" name="template[_to]" value="{$template_info['to']}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="copy_email">{'COPY_EMAIL'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="copy_email" type="text" name="template[_copy]" value="{$template_info['copy']}" />
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="subject">{'SUBJECT_'|onapp_string}</label>
                </dt>
                <dd>
                    <input id="subject" type="text" name="template[_subject]" value="{$template_info['subject']}" />
                </dd>
            </dl>
            <dl>
                <dt><label for="message">{'MESSAGE_'|onapp_string}</label></dt>
                <dd>
                    <textarea name="template[_message]" rows="23" cols="50" id="message">{$template_info['message']}</textarea>
                </dd>
            </dl>
             <dl>
                <dt><label for="event_name">{'EVENT_ASSIGNMENT'|onapp_string}</label></dt>
                <dd>
                    <select id="event_name"  name="template[_new_event]">
                        {foreach from=$events_list item=_event}
                            <option value="{$_event}"{if $_event == $event}selected="true"{/if} >
                                {$_event}
                            </option>
                        {/foreach}
                    </select>
                </dd>
            </dl>
        </div>
      
        <input type="submit" value="{'SAVE_'|onapp_string}" />
        <input type="hidden" name="event" value="{$event}" />
        <input type="hidden" name="file_name" value="{$file_name}" />
        <input type="hidden" name="action" value="edit" />
    </form>
      
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}