<HTML>
<HEAD>
<title> 404 Error Page</title>
</HEAD>
<BODY>
<p align="center">
<h1>Error 404</h1><br>Page Not Found
<p>
<?php
$ip = getenv ("REMOTE_ADDR");
$requri = getenv ("REQUEST_URI");
$servname = getenv ("SERVER_NAME");
$combine = $ip . " tried to load " . $servname . $requri ;
$httpref = getenv ("HTTP_REFERER");
$httpagent = getenv ("HTTP_USER_AGENT");
$today = date("D M j Y g:i:s a T");
$note = "You are in a wrong page!" ;
$message = "$today \n
<br>
$combine <br> \n
User Agent = $httpagent \n
<h2> $note </h2>\n
<br> $httpref ";
$message2 = "$today \n
$combine \n
User Agent = $httpagent \n
$note \n
$httpref ";

echo $message;
?>


<a href="/frontend">Visit our Home Page</a>
</BODY></HTML>