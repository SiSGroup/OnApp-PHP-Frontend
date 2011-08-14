<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_string}" />
<link rel="stylesheet" href="{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/css/style.css" type="text/css" />
<link rel="stylesheet" href="{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/css/uniform.css" type="text/css" />
<title>{$title}</title>
<link rel="icon" type="image/ico" href="{$smarty.const.ONAPP_BASE_URL}/{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/images/favicon.ico" />
</head>
<body>

<div id="header">
    <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/OnApp.png" />
    <a href="{$_ALIASES.logout}">{'LOGOUT_'|onapp_string}</a> 
</div>

<div id="container">
    
    <div style="height:44px;" id="header2">
        <div id="header2_left"></div >
        <div id="header2_right">{'HELLO_THERE'|onapp_string}, {$smarty.session.login}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {'HOST_'|onapp_string}: {$smarty.session.host} </div>
    </div>
    <div id="content">

    {if isset($error)}
        <div id="onapp_error">
            {if ! is_array($error)}
                {$error}
            {else}
                {foreach from=$error item=er}
                    {$er}<br />
                {/foreach}
            {/if}
        </div>
    {/if}

    {if isset($smarty.session.message)}
        <div id="onapp_msg">
            {{$smarty.session.message}|onapp_string}
        </div>
    {/if}

    {if isset($message)}
        <div id="onapp_msg">
            {$message}
        </div>
    {/if}

    <div style="clear:none"></div>
        
        <div style="clear:both;"></div>
            <div class="info">
                   <div class="info_title">
                        {$info_title}
                    </div>

                   <div class="info_body">
                        {$info_body}
                   </div>

                   <div class="info_bottom"></div>
            </div>