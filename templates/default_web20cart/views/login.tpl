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
    <h1>Client Area</h1>
	<p class="breadcrumb">
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php">Portal Home</a>
            >
        <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php">Client Area</a>
    </p>
    <p>
        You must login to access this page. These login details differ from your websites control panel username and password.
    </p>

    <form action="{$_ALIASES.login}" method="post" id="frmlogin">
    <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" border="0" align="center" class="frame">
        <tbody>
    <tr>
      <td><table border="0" align="center" cellpadding="10" cellspacing="0">
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
    <p class="header">Quick Navigation</p>
    <ul>
      <li><a href="templates/{$smarty.const.ONAPP_TEMPLATE}/index.php"><img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/support.gif" alt="Portal Home" width="16" height="16" border="0" class="absmiddle" /></a> <a href="index.php" title="Portal Home">Portal Home</a></li>
      <li><a href="clientarea.php"><img src="templates/portal/images/icons/clientarea.gif" alt="Client Area" width="16" height="16" border="0" class="absmiddle" /></a> <a href="clientarea.php" title="Client Area">Client Area</a></li>
      <li><a href="announcements.php" title="Announcements"><img src="templates/portal/images/icons/announcement.gif" alt="Announcements" width="16" height="16" border="0" class="absmiddle" /></a> <a href="announcements.php" title="Announcements">Announcements</a></li>
      <li><a href="knowledgebase.php" title="Knowledgebase"><img src="templates/portal/images/icons/knowledgebase.gif" alt="Knowledgebase" width="16" height="16" border="0" class="absmiddle" /></a> <a href="knowledgebase.php" title="Knowledgebase">Knowledgebase</a></li>
      <li><a href="submitticket.php" title="Submit Ticket"><img src="templates/portal/images/icons/submit-ticket.gif" alt="Submit Ticket" width="16" height="16" border="0" class="absmiddle" /></a> <a href="submitticket.php" title="Support Tickets">Submit Ticket</a></li>
      <li><a href="downloads.php" title="Downloads"><img src="templates/portal/images/icons/downloads.gif" alt="Downloads" width="16" height="16" border="0" class="absmiddle" /></a> <a href="downloads.php" title="Downloads">Downloads</a></li>
      <li><a href="cart.php" title="Order"><img src="templates/portal/images/icons/order.gif" alt="Order" width="16" height="16" border="0" class="absmiddle" /></a> <a href="cart.php" title="Order">Order</a></li>
    </ul>
<form method="post" action="dologin.php">
  <p class="header">Client Login</p>
  <p><strong>Email</strong><br />
    <input name="username" type="text" size="25" />
  </p>
  <p><strong>Password</strong><br />
    <input name="password" type="password" size="25" />
  </p>
  <p>
    <input type="checkbox" name="rememberme" />
    Remember Me</p>
  <p>
    <input type="submit" class="submitbutton" value="Login" />
  </p>
</form>
  <p class="header">Search</p>
<form method="post" action="knowledgebase.php?action=search">
  <p>
    <input name="search" type="text" size="25" /><br />
    <select name="searchin">
      <option value="Knowledgebase">Knowledgebase</option>
      <option value="Downloads">Downloads</option>
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

