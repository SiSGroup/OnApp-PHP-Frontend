<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf8" />
    <title>Installation</title>

</head>
<body>
Oops! You virtual host must be set incorrectly, .htaccess file won't work in this directory!<br />

You must change <b>'AllowOverride None'</b> to <b>'AllowOverride All'</b> in you server config file!
<br />

<?php echo '<pre>
DocumentRoot /var/www /:yourhost
        <Directory /var/www/:yourhost>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride <b style="color:red">All</b>
                Order allow,deny
                allow from all
        </Directory>
</pre>'; ?>

<?php $base = (
            ( isset($_SERVER['HTTPS'])
                && strtolower($_SERVER['HTTPS']) !== 'off'
                    ? 'https://'
                    : 'http://'
            ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
        ); 

$base = preg_replace('/1|index.php/', '', $base);?>

<b>Don't forget to restart your server</b> and follow the link  <a href="<?php echo $base ?>" >Link</a>
</body>
</html>