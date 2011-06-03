<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_string}" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/style.css" type="text/css" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/uniform.css" type="text/css" />
<title>{$title|onapp_string}</title>
<link rel="icon" type="image/ico" href="favicon.ico" />
</head>
<body>

<div id="header">
    <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/OnApp.png" />
    <a href="{$_ALIASES.logout}">{'LOGOUT_'|onapp_string}</a>  <!-- {'HELLO_'|onapp_string} {$_session_data["login"]}-->
</div>

<div id="container">
    
    <div style="height:44px;" id="header2"></div>
    
    {if isset($smarty.get.error) && $smarty.get.error != ''}
        <div id="onapp_error">
            {if ! isset($smarty.get.no_error_translate)}
                {$smarty.get.error|onapp_string}
            {else}
                {$smarty.get.error}
            {/if}
        </div>
    {/if}
     
    {if isset($smarty.get.message) && $smarty.get.message != ''}
        <div id="onapp_msg">
            {$smarty.get.message|onapp_string}
        </div>
    {/if}  
       
    <div style="clear:none"></div>
        
    <div id="content">
