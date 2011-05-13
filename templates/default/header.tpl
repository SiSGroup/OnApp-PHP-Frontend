<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_get_config_option}" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_get_config_option}/css/style.css" type="text/css" />
<title>{$title|onapp_get_string}</title>
</head> 
<body bgcolor="#ffffff">
<div style="display:{$error_display};" id="error">
    {if isset($error_message)}
        {$error_message}
    {/if}
</div>
<div id="container">
<div style="display:{$logout_display}" id="login_info">{'HELLO_'|onapp_get_string} {$_session_data["login"]}<a href="{$_ALIASES.logout}">logout</a></div>

<div id="header"><img src="templates/{'TEMPLATE'|onapp_get_config_option}/images/OnApp.png" /></div>

<div id="wrapper">
    <div id="content">
        <div style="display:{if $_GET["error"] != ''}block{/if}" id="onapp_msg" id="onapp_error">{'error'|onapp_get_arg}</div>    
        <div style="display:{if 'msg'|onapp_get_arg!=''}block{/if}" id="onapp_msg">{'msg'|onapp_get_arg}</div>
        
         
