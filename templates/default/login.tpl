<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_config}" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_config}/css/style.css" type="text/css" />
<link rel="stylesheet" href="templates/{'TEMPLATE'|onapp_config}/css/uniform.css" type="text/css" />
<title>{'LOGIN_'|onapp_string}</title>
</head>
<body style="background:url(templates/default/images/bg.png)">
<div style="display:{if isset($error_message)}block{/if};" id="error">{if isset($error_message)}{$error_message}{/if}</div>

<div id="login">
    <div style="height:5px;"></div>
    <div id="login_logo"></div>
    <div id="in_login">

     <form action="{$_ALIASES.login}" method="post">

    {'LOGIN_'|onapp_string}:<br />
    <input type="text" name="login" value=""  /><br />
    {'PASSWORD_'|onapp_string}:<br />
    <input type="password" name="password" value="" /><br />
    {'HOST_'|onapp_string}: <br />
    {if 'HOSTNAME'|onapp_config != ''}
    <input type="text" name="host" value="{'HOSTNAME'|onapp_config}" disabled="true" /><br />
    <input type="hidden" name="host" value="{'HOSTNAME'|onapp_config}" />
    {else}
    <input type="text" name="host" value=""/><br />
    {/if}
    <input type="hidden" name="action" value="login" />
    {'SELECT_LANG'|onapp_string}:<br />
    <select name="lang">
            {html_options values=$langs output=$langs selected='DEFAULT_LANGUAGE'|onapp_config}
     </select><br /><br />
    <input type="submit" class="btn-c" name="submit" value="{'LOGIN_'|onapp_string}" />

    </form>

    </div>
</div>

</body>
</html>
