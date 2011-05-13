<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_get_config_option}" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_get_config_option}/css/style.css" type="text/css" />
<title>{$title}</title>
</head>
<body bgcolor="#ffffff">
<div style="display:{$error_display};" id="error">{$error_message}</div>

<div id="login">
     <form action="{$_ALIASES.login}" method="post">
     
    Login:<br />
    <input type="text" name="login" value=""  /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    Host: <br />
    {if 'HOSTNAME'|onapp_get_config_option != ''}
    <input type="text" name="host" value="{'HOSTNAME'|onapp_get_config_option}" disabled="true" /><br />
    <input type="hidden" name="host" value="{'HOSTNAME'|onapp_get_config_option}" />
    {else}
    <input type="text" name="host" value=""/><br />
    {/if}
    <input type="hidden" name="action" value="login" />
    Select lang:<br />
    <select name="lang">
            {html_options values=$langs output=$langs selected='DEFAULT_LANGUAGE'|onapp_get_config_option}
     </select><br /><br />
    <input type="submit" name="submit" value="Login" />
    
    </form>


</div>

</body>
</html>
