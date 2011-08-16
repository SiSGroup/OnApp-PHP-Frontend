<?php
define( 'ONAPP_DS', DIRECTORY_SEPARATOR );
define( 'ONAPP_PATH', dirname( __FILE__ ) );

function is__writable($path) {

    if ($path{strlen($path)-1}=='/')
        return is__writable($path.uniqid(mt_rand()).'.tmp');

    if (file_exists($path)) {
        if (!($f = @fopen($path, 'r+')))
            return false;
        fclose($f);
        return true;
    }

    if (!($f = @fopen($path, 'w')))
        return false;
    fclose($f);
    unlink($path);
    return true;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>Installation</title>
<style type="text/css">
table{
    width:900px;
    background: #f6f6f6;
    padding:10px;
}

.yes{
    color:green;
    font-weight:bold
}
.red{
    color:red;
    font-weight:bold
}
</style>
</head>
<body>
    <table align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th colspan="2">
                 System Requirements Checks
            </th>
        </tr>
        <tr>
            <td>
                PHP Version
            </td>
            <td>
                <?php echo ( ! version_compare(PHP_VERSION, '5.0.0', '<')) ? '<span class="yes">.......Passed</span>' : '<span class="red">You have to upgrade you php version to 5+ </span>'; ?>
            </td>
        </tr>
        <tr>
            <td>
                mod_rewrite
            </td>
            <td>
                <?php echo ( in_array( 'mod_rewrite', apache_get_modules() ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You have to enable mod_rewrite on your server </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                mod_php5
            </td>
            <td>
                <?php echo ( in_array( 'mod_php5', apache_get_modules() ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You have to enable mod_php5 on your server </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                Curl
            </td>
            <td>
                <?php echo (  in_array( 'curl', get_loaded_extensions() ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You have to install and enable Curl extension on your server </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                Mctypt
            </td>
            <td>
               <?php echo (  in_array( 'mcrypt', get_loaded_extensions() ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You have to install and enable Mcrypt extension on your server </span>';?>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                Permissions Checks
            </th>
        </tr>
        <tr>
            <td> 
                Configuration File
            </td>
            <td>
                <?php echo ( is__writable ( '../config.ini' ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You must set permissions for the config.ini file so it can be written to </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                Logs Directory
            </td>
            <td>
                <?php echo ( is__writable( '../logs/'  ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You must set permissions for the logs/ directory so it can be written to (chmod 777) </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                Templates Directory
            </td>
            <td>
                <?php echo ( is__writable( '../templates_c/'  ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You must set permissions for the templates_c/ directory so it can be written to (chmod 777) </span>';?>
            </td>
        </tr>
        <tr>
            <td>
                Cache Directory
            </td>
            <td>
               <?php echo ( is__writable( '../cache/'  ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You must set permissions for the cache/ directory so it can be written to (chmod 777) </span>';?>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                .htaccess file
            </th>
        </tr>
        <tr>
            <td>
                .htaccess file
            </td>
            <td>
               <?php echo ( file_exists( '../.htaccess'  ) ) ? '<span class="yes">.......Passed</span>' : '<span class="red">You must miss the .htaccess file </span>';?>
            </td>
        </tr>

    </table>


</body>
</html>

