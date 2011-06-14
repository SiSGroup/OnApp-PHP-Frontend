<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_string}" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/style.css" type="text/css" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/uniform.css" type="text/css" />
<link rel="icon" type="image/ico" href="{$smarty.const.ONAPP_TEMPLATE}/images/favicon.ico" />
<title>{'LOGIN_'|onapp_string}</title>
</head>
<body>

<div id="login">
    <div style="height:5px;"></div>
    <div id="login_logo"></div>
   
     {if isset($error_message)}
        <div id="login_error">
            {$error_message|onapp_string}
        </div>
    {/if}
    
    <div id="in_login">
    
         <form action="{$_ALIASES.login}" method="post">
    
            {'LOGIN_'|onapp_string}:<br />
            <input type="text" name="login" value=""  /><br />
            {'PASSWORD_'|onapp_string}:<br />
            <input type="password" name="password" value="" /><br />
            {'HOST_'|onapp_string}: <br />
            {if $smarty.const.ONAPP_HOSTNAME != ''}
            <input type="text" name="host" value="{$smarty.const.ONAPP_HOSTNAME}" disabled="true" /><br />
            <input type="hidden" name="host" value="{$smarty.const.ONAPP_HOSTNAME}" />
            {else}
            <input type="text" name="host" value=""/><br />
            {/if}
            <input type="hidden" name="action" value="login" />
            {'SELECT_LANG'|onapp_string}:<br />
            <select name="lang">
                    {html_options values=$langs output=$langs selected=$smarty.const.ONAPP_DEFAULT_LANGUAGE}
             </select><br /><br />
            <input type="submit" class="btn-c" name="submit" value="{'LOGIN_'|onapp_string}" />
    
        </form>

    </div>
</div>

</body>
</html>
