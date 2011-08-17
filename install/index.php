<?php
define('ONAPP_DS', DIRECTORY_SEPARATOR);

function is__writable($path) {

    if ($path{strlen($path) - 1} == '/')
        return is__writable($path . uniqid(mt_rand()) . '.tmp');

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

$passed = 0;

  /**
   * Writes log settings changes to onapp frontend configuration file
   *
   * @param array onapp frontend configurations array
   * @param string path to onapp frontend configuration file
   * @return boolean true|false
   */
   function write_config($config_array, $path){
       $content = '';
       foreach ( $config_array as $key=>$value )
         $content .= "$key=$value"."\n";

       if ( !$handle = fopen($path, 'w') ){
           return false;
       }
       else if ( ! fwrite($handle, $content) ) {
           return false;
       }
       else {
           fclose($handle);
       }

       return true;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf8" />
    <title>Installation</title>
    <style type="text/css">
        table, .table {
            width:900px;
            background: #f6f6f6;
            padding:10px;
            margin:0 auto;
        }

        .yes{
            color:green;
            font-weight:bold
        }
        .red{
            color:red;

        }
    </style>
</head>
<body>
    <?php
    if ( ! isset( $_POST['step'] ) ) {

        echo '<table align="center" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th colspan="2">
                    Step 1
                </th>
            </tr>
            <tr>
                <th colspan="2">
                     &nbsp;
                </th>
            </tr>
            <tr>
                <th colspan="2">
                     System Requirements Checks
                </th>
            </tr>
            <tr>
                <td>
                    PHP Version
                </td>
                <td>';
        if (!version_compare(PHP_VERSION, '5.0.0', '<')) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You have to upgrade you php version to 5+ </span>';
        }

        echo '    </td>
            </tr>
            <tr>
                <td>
                    mod_rewrite
                </td>
                <td> ';
        if (in_array('mod_rewrite', apache_get_modules())) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You have to enable mod_rewrite on your server </span>';
        }

        echo '      </td>
            </tr>
            <tr>
                <td>
                    mod_php5
                </td>
                <td>';
        if (in_array('mod_php5', apache_get_modules())) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You have to enable mod_php5 on your server </span>';
        }

        echo '      </td>
            </tr>
            <tr>
                <td>
                    Curl
                </td>
                <td>';
        if (extension_loaded('curl')) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You have to install and enable Curl extension on your server </span>';
        }

        echo '     </td>
            </tr>
            <tr>
                <td>
                    Mctypt
                </td>
                <td>';
        if (extension_loaded('mcrypt')) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You have to install and enable Mcrypt extension on your server </span>';
        }

        echo '     </td>
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
                <td>';
        if (is__writable('..' . ONAPP_DS . 'config.ini')) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You must set permissions for the config.ini file so it can be written to (chmod 777) </span>';
        }

        echo '      </td>
            </tr>
            <tr>
                <td>
                    Logs Directory
                </td>
                <td>';
        if (is__writable('..' . ONAPP_DS . 'logs/' . ONAPP_DS)) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You must set permissions for the logs/ directory so it can be written to (chmod 777) </span>';
        }

        echo '     </td>
            </tr>
            <tr>
                <td>
                    Templates Directory
                </td>
                <td>';
        if (is__writable('..' . ONAPP_DS . 'templates_c' . ONAPP_DS)) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You must set permissions for the templates_c/ directory so it can be written to (chmod 777) </span>';
        }
        echo '      </td>
            </tr>
            <tr>
                <td>
                    Cache Directory
                </td>
                <td>';
        if (is__writable('..' . ONAPP_DS . 'cache' . ONAPP_DS)) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You must set permissions for the cache/ directory so it can be written to (chmod 777) </span>';
        }
        echo '      </td>
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
                <td>';
        if (file_exists('..' . ONAPP_DS . '.htaccess')) {
            echo '<span class="yes">.......Passed</span>';
            $passed++;
        } else {
            echo '<span class="red">You must miss the .htaccess file somewhere :) </span>';
            ;
        }
        echo '      </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>';
        if ($passed != 10) {
            echo '<p class="red"> Some of your system parameters doesn\'t meet the requirements you need to fix them in order to continue </p>';
        }
        echo '<form action="" method="post">

                <input type="submit" value="Go Forward"';
        if ($passed != 10) {
            echo 'disabled';
        } echo '/>
                <input type="hidden" name="step" value="2" />
            </form>
                </td>
                <td></td>
            </tr>

        </table>';
    } elseif ($_POST['step'] == 2) {
        echo'
            <div align="center" class="table">
                <b align="center">Step 2</b>
                <form align="left" action="" method="post">
                    
                    <input type="hidden" name="step" value="3" /><br /><br />
                    <input type="submit" value = "Finish Installation"/>
                </form>
            </div>
        ';
    } elseif ( $_POST['step'] == 3 ) {
           $base = ( ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ?
                'https://' : 'http://' )
                . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
           
          $base = str_replace('/install', '', $base );
      
          $settings = array(
            'base_url'  => $base,
            'hostname' => '',
            'default_alias' => 'profile',
            'secret_key' => 'ChZyhSmndC6Qd5VD',
            'session_lifetime' => 3600,
            'default_language' => 'English',
            'template' => 'default',
            'controllers' => 'default',
            'log_directory' => 'logs',
            'debug_file_name' => 'frontend.log',
            'third_part_product_report_enable' => 1,
            'problem_report_debug_log_enable' => 1,
            'wrapper_log_report_enable' => 1,
            'log_level_frontend' => 'ONAPP_E_FATAL',
            'log_level_php' => 'E_ERROR',
            'log_rotation_days' => 30,
            'log_rotation_size' => 1000,
            'smarty_template_dir' => 'templates',
            'smarty_compile_dir' => 'templates_c',
            'smarty_cache_dir' => 'cache',
            'smarty_caching_enable' => 0,
            'smarty_caching_lifetime' => 3600,
            'smarty_force_compile' => 2,
            'smarty_compile_check' => 1,
          );

         // $settings = $_POST[settings] + $default_settings;

          $result = write_config( $settings,  '..' . ONAPP_DS . 'config.ini' );
          if ( $result ) {
              echo '
                  <div align="center" class="table">
                      Congratulation! Configurations have been saved. Installation proccess was finished successfully.<br />
                      <p class="red">Delete or rename install/ directory and follow the link</p><br />
                      <a href="'.$base.'">Login</a>
                  </div>
              ';
          }
          else {
              echo  'Config file isn\'t writable' ;
          }
    }
    ?>

</body>
</html>

