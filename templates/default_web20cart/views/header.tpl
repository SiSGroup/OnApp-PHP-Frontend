<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_string}" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link rel="stylesheet" href="{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/css/style.css" type="text/css" />
<link rel="stylesheet" href="{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/css/uniform.css" type="text/css" />
<title>{$title}</title>
<link rel="icon" type="image/ico" href="{$smarty.const.ONAPP_BASE_URL}/{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/images/favicon.ico" />
</head>
<body>
<div id="top_container">
    <div id="top">
        <div id="company_title">Company Name</div>
        <!-- <img alt="LOGO" title="Version {$smarty.const.ONAPP_FRONTEND_VERSION}" src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/OnApp.png" /> -->
       <!-- <a href="{$_ALIASES.logout}">{'LOGOUT_'|onapp_string}</a> -->
        <div id="welcome_box">
            Please <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php" title="Login">
                <strong>Login</strong>
            </a> or
            <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/register.php" title="Register">
                <strong>Register</strong></a>
        </div>
    </div>
</div>



<div id="content_container">
    <div id="content_wrapper">
    

   <!-- <div style="height:44px;" id="header2">
        <div id="header2_left"></div >
        <div id="header2_right">{'HELLO_THERE'|onapp_string}, {$smarty.session.login}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {'HOST_'|onapp_string}: {$smarty.session.host} </div>
    </div> -->
    <div id="content_left">

        <div class="info">
                   <div class="info_title">
                        {$info_title}
                    </div>

                   <div class="info_body">
                        {$info_body}
                   </div>

                   <div class="info_bottom"></div>
        </div>

            {if isset($error)}
        <div class="onapp_error"> <b>{'ERROR_LOG_ID'|onapp_string} {$smarty.session.log_id}</b><br />
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
        <div class="onapp_msg">
            {{$smarty.session.message}|onapp_string}
        </div>
    {/if}

    {if isset($message)}
        <div class="onapp_msg">
            {$message}
        </div>
    {/if}

    
        
        
            