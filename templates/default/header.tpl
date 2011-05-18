<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_config}" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_config}/css/style.css" type="text/css" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_config}/css/uniform.css" type="text/css" />
<title>{$title|onapp_string}</title>
</head>
<body bgcolor="#ffffff">
<div style="display:{if isset($error_display)}{$error_display}{/if};" id="error">
    {if isset($error_message)}
        {$error_message}
    {/if}
</div>


<div id="header">
<img src="templates/{'TEMPLATE'|onapp_config}/images/OnApp.png" />
<a href="{$_ALIASES.logout}">{'LOGOUT_'|onapp_string}</a>  <!-- {'HELLO_'|onapp_string} {$_session_data["login"]}-->
</div>

<div id="container">
    <div id="wrapper">
        <div style="height:40px;" id="header2"></div>
        <div id="content">
            <div style="display:{if isset($error)}block{/if}" id="onapp_error">{if isset($error)}{$error}{/if}</div>
            <div style="display:{if isset($message)}block{/if}" id="onapp_msg">{if isset($message)}{$message}{/if}</div>
