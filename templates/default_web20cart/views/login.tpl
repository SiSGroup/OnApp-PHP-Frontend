<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset={'CHARSET'|onapp_string}" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/style.css" type="text/css" />
<link rel="stylesheet" href="templates/{$smarty.const.ONAPP_TEMPLATE}/css/uniform.css" type="text/css" />
<link rel="icon" type="image/ico" href="{$smarty.const.ONAPP_BASE_URL}/{$smarty.const.ONAPP_SMARTY_TEMPLATE_DIR}/{$smarty.const.ONAPP_TEMPLATE}/images/favicon.ico" />
<title>{'LOGIN_'|onapp_string}</title>
</head>
<body>
<div id="top_container">
  <div id="top">
    <div id="company_title">Company Name</div>
    <div id="welcome_box">
        Please
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php" title="Login">
            <strong>Login</strong>
        </a> or
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/register.php" title="Register">
            <strong>Register</strong>
        </a>
    </div>
  </div>
</div>
<div id="content_container">
  <div id="content_wrapper">
  <div id="content_left">
    <h1>{'ONAPP_FRONTEND'|onapp_string}</h1>
	<p class="breadcrumb">
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php">{'PORTAL_HOME'|onapp_string}</a>
            >
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php">{'ONAPP_FRONTEND'|onapp_string}</a>
    </p>
    <p>
        You must login to access this page. These login details differ from your websites control panel username and password.
    </p>
    {if isset($error_message)}
        <div id="login_error">
            {$error_message}
        </div>
    {/if}

    <form action="{$_ALIASES.login}" method="post" id="frmlogin">
    <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" border="0" align="center" class="frame">
        <tbody>
    <tr>
      <td><table border="0" align="center" cellpadding="20" cellspacing="0" id="whmcs_login">
          <tr>
            <td width="150" align="right" class="fieldarea">{'LOGIN_'|onapp_string}:</td>
            <td><input type="text" name="login" size="40" value="" /></td>
          </tr>
          <tr>
            <td width="150" align="right" class="fieldarea">{'PASSWORD_'|onapp_string}:</td>
            <td><input type="password" name="password" size="25" value="" /></td>
          </tr>
          <tr>
            <td width="150" align="right" class="fieldarea">{'ONAPP_HOST'|onapp_string}:</td>
            {if $smarty.const.ONAPP_HOSTNAME != ''}
            <td><input type="text" name="host" value="{$smarty.const.ONAPP_HOSTNAME}" disabled="true" /></td>
            {else}
            <td><input type="text" name="host" size="25" value="" /></td>
            {/if}
          </tr>
          <tr>
            <td width="150" align="right" class="fieldarea">{'PASSWORD_'|onapp_string}:</td>
            <td>
                <select name="lang" >
                    {html_options values=$langs output=$langs selected=$smarty.const.ONAPP_DEFAULT_LANGUAGE}
                </select>
            </td>
          </tr>
          
          <tr>
            <td width="150" align="right" class="fieldarea">&nbsp;</td>
            <td><input type="submit" name="submit" value="{'LOGIN_'|onapp_string}" /></td>
          </tr>
        </table></td>
    </tr>
            </tbody>
  </table><br />
</form>


 </div>
  <div id="side_menu">
    <p class="header">{'QUICK_NAVIGATION'|onapp_string}</p>
    <ul>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/support.gif" alt="Portal Home" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php" title="Portal Home">{'PORTAL_HOME'|onapp_string}</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/clientarea.gif" alt="Client Area" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php" title="Client Area">{'CLIENT_AREA'|onapp_string}</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/announcements.php" title="{'ANNOUNCEMENTS_'|onapp_string}">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/announcement.gif" alt="{'ANNOUNCEMENTS_'|onapp_string}" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}announcements.php" title="{'ANNOUNCEMENTS_'|onapp_string}">{'ANNOUNCEMENTS_'|onapp_string}</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php" title="Knowledgebase">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/knowledgebase.gif" alt="Knowledgebase" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php" title="Knowledgebase">{'KNOWLEDGEBASE_'|onapp_string}</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/submitticket.php" title="Submit Ticket">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/submit-ticket.gif" alt="Submit Ticket" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/submitticket.php" title="Support Tickets">{'SUBMIT_TICKET'|onapp_string}</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/downloads.php" title="Downloads">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/downloads.gif" alt="Downloads" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/downloads.php" title="Downloads">{'DOWNLOADS_'|onapp_string}</a></li>
      <li><a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/cart.php" title="Order">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/order.gif" alt="Order" width="16" height="16" border="0" class="absmiddle" />
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/cart.php" title="Order">
              {'ORDER_'|onapp_string}
          </a>
      </li>
    </ul>

  <p class="header">{'SEARCH_'|onapp_string}</p>
<form method="post" action="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php?action=search">
  <p>
    <input name="search" type="text" size="25" /><br />
    <select name="searchin">
      <option value="Knowledgebase">{'KNOWLEDGEBASE_'|onapp_string}</option>
      <option value="Downloads">{'DOWNLOADS_'|onapp_string}</option>
    </select>
    <input type="submit" value="Go" />
  </p>
</form>
  </div>
  <div style="clear:both"></div>
 </div>
    
</div>
</body>
</html>

