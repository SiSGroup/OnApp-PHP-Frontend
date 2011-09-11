    </div>    

    <div id="side_menu">
    <p class="header">Quick Navigation</p>
    <ul>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/support.gif" alt="Portal Home" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/index.php" title="Portal Home">Portal Home</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/clientarea.gif" alt="Client Area" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/clientarea.php" title="Client Area">Client Area</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/announcements.php" title="Announcements">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/announcement.gif" alt="Announcements" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}announcements.php" title="Announcements">Announcements</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php" title="Knowledgebase">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/knowledgebase.gif" alt="Knowledgebase" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php" title="Knowledgebase">Knowledgebase</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/submitticket.php" title="Submit Ticket">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/submit-ticket.gif" alt="Submit Ticket" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/submitticket.php" title="Support Tickets">Submit Ticket</a></li>
      <li>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/downloads.php" title="Downloads">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/downloads.gif" alt="Downloads" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/downloads.php" title="Downloads">Downloads</a></li>
      <li><a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/cart.php" title="Order">
              <img src="templates/{$smarty.const.ONAPP_TEMPLATE}/images/order.gif" alt="Order" width="16" height="16" border="0" class="absmiddle">
          </a>
          <a href="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/cart.php" title="Order">
              Order
          </a>
      </li>
    </ul>
<form method="post" action="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/dologin.php">
  <p class="header">Client Login</p>
  <p><strong>Email</strong><br>
    <input name="username" type="text" size="25">
  </p>
  <p><strong>Password</strong><br>
    <input name="password" type="password" size="25">
  </p>
  <p>
    <input type="checkbox" name="rememberme">
    Remember Me</p>
  <p>
    <input type="submit" class="submitbutton" value="Login">
  </p>
</form>
  <p class="header">Search</p>
<form method="post" action="{$smarty.const.ONAPP_WHMCS_CLIENT_AREA_URL}/knowledgebase.php?action=search">
  <p>
    <input name="search" type="text" size="25"><br>
    <select name="searchin">
      <option value="Knowledgebase">Knowledgebase</option>
      <option value="Downloads">Downloads</option>
    </select>
    <input type="submit" value="Go">
  </p>
</form>
 <br /><br />

<p class="header">{'ONAPP_NAVIGATION'|onapp_string}</p>

        <ul>
            {foreach from=$navigation key=k item=v}
                {if isset($v["title"])}
                   {if $v["show"] > 0}
                        <li class="li_{substr_count($k,'.')}">
    
    
                            <a href="{$k}"> {$v.title|onapp_string}</a>
                        </li>
                    {/if}
                {/if}
            {/foreach}
        </ul>
    </div>
    <div style="clear:both"></div>
    </div>