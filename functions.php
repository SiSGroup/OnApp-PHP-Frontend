<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');
define('ONAPP_FRONTEND_VERSION', '0.3.0 beta');

/**
 * Gets list of directories in specified directory
 *
 * @param string directory to get the list from
 * @return array list of directories
 */
function onapp_get_dir_list($dir) {
    onapp_debug("Get directory list of ($dir)");

    $directories = scandir(ONAPP_PATH.ONAPP_DS.$dir);

    foreach( $directories as $directory)
        if (! is_dir($directory) && ! is_file(ONAPP_PATH.ONAPP_DS.$dir.ONAPP_DS.$directory) )
            $result[] = $directory;

    onapp_debug("onapp_get_dir_list ($dir):\nreturn => " . print_r($result, true) );

    return $result;
}


/**
 * Returns a string from language package
 *
 * @param string $string language package constant
 *
 * @return string language package string value
 *
 */
function onapp_string($string = NULL) {
    if( $string == NULL)
        return NULL;
    global $_LANG;

    onapp_debug("Get string" );

    $return = isset($_LANG[$string]) ?
        $_LANG[$string] :
        "String $string not found";

    $return = isset($_LANG[$string]) ?
        $_LANG[$string] :
        "String $string not found";

    onapp_debug("onapp_string: 'string' => '$string', return => $return");

    return $return;
}

/**
 * Returns a value of particular variable from global GET or POST array.
 *
 * @param string $string variable name
 *
 * @param string $method http method [POST|post|GET|get] default = ''
 *
 * @return mixed variable value
 */
function onapp_get_arg($string, $method='') {
    onapp_debug('Get arguments');

    switch($method) {
        case "get":
        case "GET":
            $return = array_key_exists($string, $_GET) ? $_GET[$string] : NULL;
            break;
        case "post":
        case "POST":
            $return = array_key_exists($string, $_POST) ? $_POST[$string] : NULL;
            break;
       case "session":
       case "SESSION":
            $return = $_SESSION;
            break;
        default :
            $value_post = array_key_exists($string, $_POST) ? $_POST[$string] : NULL;
            $value_get  = array_key_exists($string, $_GET) ? $_GET[$string] : NULL;
            $return = $value_post ? $value_post : $value_get;
            break;
    }

    onapp_debug("onapp_get_arg: string => $string, method => $method, return => $return");

    return $return;
}

/**
 * This function is called from controller classes to display proper view and
 * template depends on controller and method. Uses Smarty template engine.
 *
 * @param string $view Name of a Smarty template file to display.
 *
 * @param string $template Name of a particular template. Not realised yet!
 *
 * @param array $params Array consists of variables' keys and values need to be
 * passed to Smarty template view file.
 *
 * @todo  VERIFICATION IF TEMPLATE FILE EXSITS!
 *
 * @return void
 *
 */
function onapp_show_template($view, $params = array()) {
    global $_ALIASES, $_SCREEN_IDS;

    onapp_debug('Show templates');
    onapp_debug("onapp_show_template: view => $view, params => " . print_r($params, true));
    
    $template = ONAPP_PATH.ONAPP_DS.'templates'.ONAPP_DS.ONAPP_TEMPLATE.ONAPP_DS. 'views' .ONAPP_DS.str_replace('_',ONAPP_DS,$view).'.tpl';

    if( ! file_exists($template))
        die("File $template not found");

    $globals = array(
        'navigation'    => $_SCREEN_IDS,
        '_ALIASES'      => $_ALIASES,
        'langs'         => onapp_get_dir_list('lang')
    );

    $smarty_params = is_array($params)
        ? array_merge($params, $globals)
        : $globals;

    require_once ONAPP_PATH.ONAPP_DS.'libs'.ONAPP_DS.'smarty'.ONAPP_DS.'Smarty.class.php';

    $smarty = new Smarty;

    $smarty->template_dir = ONAPP_SMARTY_TEMPLATE_DIR;
    $smarty->compile_dir  = ONAPP_SMARTY_COMPILE_DIR;
    $smarty->cache_dir    = ONAPP_SMARTY_CACHE_DIR;
    $smarty->caching      = ONAPP_SMARTY_CACHING_ENABLE;
    //in seconds
    $smarty->cache_lifetime = ONAPP_SMARTY_CACHING_LIFETIME;
    // set false for best performance when no templates changes needed
    $smarty->compile_check = ONAPP_SMARTY_COMPILE_CHECK;
    // set false for best performance when no templates changes needed
    $smarty->force_compile = ONAPP_SMARTY_FORCE_COMPILE;

    foreach($smarty_params as $key => $value)
        $smarty->assign("$key",$value);

    $smarty->display($template);

    unset($_SESSION['message']);

    onapp_debug('Display Smarty Template');
}

/**
 * Initializes global language array depends on language pack name.
 * Takes package name from the session.English is default language.
 *
 * @param string $language Name of language package
 *
 * @return void
 *
 */
function onapp_load_language($lang = '') {
    global $_LANG;

    onapp_debug("Load language: lang => '$lang'");

    if(isset($_SESSION["lang"]) && $_SESSION["lang"] != '')
        $language = $_SESSION["lang"];
    else
        $language = $lang;

    $file = ONAPP_PATH.ONAPP_DS.'lang'.ONAPP_DS.$language.ONAPP_DS.'strings.php';

    if(file_exists($file))
        include $file;
    else {
        onapp_die("Language file $file not found");
    }
}

/**
 * Parsing menu xml file. Converts xml dom data to array. Initializes global screen ids arrays.
 *
 * @return void
 *
 */
function onapp_load_screen_ids($SimpleXMLElement = null, $parrent_id = '') {
    onapp_debug(__METHOD__);
    global $_SCREEN_IDS, $_ALIASES;

    if(is_null($SimpleXMLElement))
        if(file_exists(ONAPP_PATH.ONAPP_DS.'templates'. ONAPP_DS . ONAPP_TEMPLATE . ONAPP_DS . 'menu.xml'))
            $SimpleXMLElement = simplexml_load_file(ONAPP_PATH.ONAPP_DS.'templates'. ONAPP_DS . ONAPP_TEMPLATE . ONAPP_DS . 'menu.xml');
        else
            onapp_die('Could not find file menu.xml');

    for($id = 1; $id < count($SimpleXMLElement)+1; $id++) {
        $current_id = $parrent_id != '' ? "$parrent_id.$id" : $id;

        foreach($SimpleXMLElement->screen[ $id -1 ]->attributes() as $k=>$v)
            $_SCREEN_IDS["$current_id"][$k] = (String)$v;

        // Menu permission check necessary only when loged in
        if ( isset( $_SESSION['permissions'] ) ) {
            if(isset($_SCREEN_IDS["$current_id"]['title'])){
                $file_path = 'controllers'. ONAPP_DS .  ONAPP_CONTROLLERS . ONAPP_DS . 'c_'.strtolower($_SCREEN_IDS["$current_id"]['class']).'.php';
                if( file_exists( $file_path ) )
                {
                    require_once $file_path;
                    $_SCREEN_IDS["$current_id"]['show'] = call_user_func( array( $_SCREEN_IDS["$current_id"]['class'], $_SCREEN_IDS["$current_id"]['access'] ) );
                }
                else
                    die('File '.$file_path.' doesn\'t exists');
            }
        }

        $_ALIASES[$_SCREEN_IDS["$current_id"]["alias"]] = $current_id;

        onapp_load_screen_ids($SimpleXMLElement->screen[ $id -1 ], "$current_id");
    }
}

/**
 *
 */
function onapp_init_screen_ids() {
    global $_ALIASES, $_SCREEN_IDS;

    onapp_debug('Load Screen IDs');

    onapp_load_screen_ids();             
    onapp_debug(print_r($_ALIASES, true));
    onapp_debug(print_r($_SCREEN_IDS, true));
}

/**
 * Encrypts and Decrypts data with Mcrypt php extension
 *
 * @param string $value data to be processed with onapp_cryptData function
 *
 * @param string $action action to do with data [encrypt|decrypt]
 *
 * @return string processed data
 *
 */
function onapp_cryptData($value, $action) {
   $key = ONAPP_SECRET_KEY;
   $text = $value;
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

   switch($action) {
      case "encrypt":
               $text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
          break;
      case "decrypt":
               $text = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv));
          break;
      default:
              onapp_die("Wrong crypt data type $type");
          break;
   };

   return $text;
}

/**
 * Redirects to specified url
 *
 * @param string url redirect to
 *
 * @return void
 *
 */
function onapp_redirect($url) { 
    onapp_debug("Redirect: url => '$url'");

    if (!headers_sent()) {
        onapp_debug('Redirectiong with header location');
        header('Location: '.$url); exit;
    } else {
        onapp_debug('Javascript Redirection!');
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
    
}

/*
 * TODO add description
 */

function onapp_init_config() {
    if (file_exists('config.ini') )
        $config = parse_ini_file('config.ini');
    else
        onapp_die('Config file not found');

    foreach( $config as $key => $value)
        define('ONAPP_'.strtoupper($key), $value);
}

/**
 *
 * Checks PHP version, config options, functions and PHP extenssions
 *
 * @return void
 *
 */
function onapp_check_configs() {

    onapp_debug('Check configs');

    // Checking of necessary configuration options
// TODO check is ONAPP_SMARTY_COMPILE_DIR and other config options exists
    $config_options = array(
        'ONAPP_SECRET_KEY',
    );

    foreach($config_options as $option)
        if (! defined($option) )
            onapp_die("Config option $option not found");

    // Checking of necessary fuctions
    $necessary_fuctions = array(
        'onapp_cryptData'
    );

    foreach($necessary_fuctions as $function_name)
       if(!function_exists($function_name))
           onapp_die("Function $function_name not found");

}

/**
 * Handles sessions.
 *
 * @param string $time session lifetime
 *
 * @param string $ses session name
 *
 * @return void
 *
 */
function onapp_startSession($ses = 'MYSES') {
    onapp_debug(__METHOD__);
    if ( ! onapp_is_auth() ) {
        $time =  ONAPP_SESSION_LIFETIME;
        session_set_cookie_params($time);
        session_name($ses);
        session_start();

        onapp_debug('Start SESSION');

        // rotates error log files
        onapp_rotate_error_log();

        // rotates debug log file
        onapp_rotate_debug_log();

        // Reset the expiration time upon page load
        if (isset($_COOKIE[$ses]))
          setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
    }
}

/**
 *
 * Verifies whether user is authorithed
 *
 * @return void
 *
 */
function onapp_is_auth() {
    $is_auth = isset($_SESSION)
        && isset($_SESSION["login"])
        && isset($_SESSION["password"])
        && isset($_SESSION["host"])
        && isset($_SESSION["id"]);
    
    onapp_debug("onapp_is_auth: return => '$is_auth'");

    return $is_auth;
}

/**
 *
 * Checks whether user has permission to perform particular action
 *
 * @param string $permission
 *
 * @return void     
 */
function onapp_permission($permissions) {                                                         
    onapp_debug(__CLASS__.' :: '.__FUNCTION__);
    global $_ALIASES;
    if(is_array($permissions))
    {
        foreach($permissions as $permission)
            if(in_array($permission, $_SESSION['permissions']))
                return;
    }
    else
        if(in_array($permissions, $_SESSION['permissions']))
            return;

    require_once ONAPP_PATH.ONAPP_DS.'controllers'.ONAPP_DS.ONAPP_CONTROLLERS.ONAPP_DS.'c_profile.php';
    $profile = new Profile;
    $profile->show_template_view('YOU_HAVE_NOT_PERMISSION_FOR_THIS_ACTION');
    exit;
}

/**
 * Checks whether user has permission to view particular items
 *
 * @param string $permission
 *
 * @return boolean [true|false]
 *
 */
function onapp_has_permission( $permissions ) { //print('<pre>'); print_r( $_SESSION['permissions'] ); die();
    onapp_debug(__CLASS__.' :: '.__FUNCTION__);
    if( is_array( $permissions ) )
    {
           foreach( $permissions as $permission )
               if( in_array( $permission, $_SESSION['permissions'] ) )
                       return true;

               return false;
    }
    return in_array($permissions, $_SESSION['permissions'] );
}
/**
 * Gets the list of file names in target directory
 *
 * @param string path to directory
 * @return array list of file names in this directory
 */
function onapp_scan_dir( $path ){
    //trigger_error( __METHOD__ . '  => ' .$path );
    onapp_debug(__CLASS__.' :: '.__FUNCTION__);
    if ( $handle = opendir( $path ) ) {
        while (false !== ($file = readdir($handle))) {
            if( ! is_dir($file) && $file != 'index.html' ) {
                $files_list[] = $file;
            }
        }
    }
    else {
        onapp_die('Unable to scan directory =><br /> '. $path . '<br /> Check permissions');
    }
    closedir($handle);
    return $files_list;

}

/**
 * Formats money amounts to usuall view
 *
 * @param mixed $number money amount
 * @param boolean $fractional if fractional
 * @return mixed money amount in usuall format
 */
function onapp_format_money($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}

/**
 * Loads available events and their class names, to use in event manager and
 * email templates.
 *
 * @global array $_EVENT_CLASSES available events and their class names
 * @return void 
 *
 */
function onapp_load_event_classes () {
    global $_EVENT_CLASSES;

    $_EVENT_CLASSES = array (
        'vm_create'                          => array('VirtualMachine', 'User'),
        'vm_create_failed'                   => array('VirtualMachine', 'User'),
        'vm_startup'                         => array('VirtualMachine', 'User'),
        'vm_startup_faild'                   => array('VirtualMachine', 'User' ),
        'vm_reset_password'                  => array('VirtualMachine', 'User'),
        'vm_reset_password_failed'           => array('VirtualMachine', 'User'),
        'vm_reboot'                          => array('VirtualMachine', 'User' ),
        'vm_reboot_failed'                   => array('VirtualMachine', 'User'),
        'vm_delete'                          => array('VirtualMachine', 'User'),
        'vm_delete_failed '                  => array('VirtualMachine', 'User' ),
        'disk_autobackup_disable'            => array('Disk'),
        'disk_autobackup_disable_failed'     => array('Disk'),
        'disk_autobackup_enable'             => array('Disk' ),
        'disk_autobackup_enable_failed'      => array('Disk'),
        'vm_shutdown'                        => array('VirtualMachine', 'User'),
        'vm_shutdown_failed'                 => array('VirtualMachine', 'User' ),
        'vm_suspend'                         => array('VirtualMachine', 'User'),
        'vm_suspend_failed'                  => array('VirtualMachine', 'User'),
        'vm_unsuspend'                       => array('VirtualMachine', 'User'),
        'vm_unsuspend_failed'                => array('VirtualMachine', 'User'),
        'vm_build'                           => array('VirtualMachine', 'User'),
        'vm_build_failed'                    => array('VirtualMachine', 'User'),
        'backup_delete'                      => NULL,
        'backup_delete_failed'               => NULL,
        'backup_take'                        => array('VirtualMachine_Backup'),
        'backup_take_failed'                 => array('VirtualMachine_Backup'),
        'firewall_rule_delete'               => array('VirtualMachine_FirewallRule'),
        'firewall_rule_delete_failed'        => array('VirtualMachine_FirewallRule'),
        'backup_restore'                     => array('VirtualMachine_Backup'),
        'backup_restore_failed'              => array('VirtualMachine_Backup'),
        'backup_convert'                     => array('Template'),
        'backup_convert_failed'              => array('Template'),
        'admin_note_edit'                    => array('VirtualMachine'),
        'admin_note_edit_failed'             => array('VirtualMachine'),
        'disk_edit'                          => array('Disk'),
        'disk_edit_failed'                   => array('Disk'),
        'schedule_edit'                      => array('Disk_Schedule'),
        'schedule_edit_failed'               => array('Disk_Schedule'),
        'firewall_rule_edit'                 => array('VirtualMachine_FirewallRule'),
        'firewall_rule_edit_failed'          => array('VirtualMachine_FirewallRule'),
        'schedule_create'                    => array('Disk_Schedule'),
        'schedule_create_failed'             => array('Disk_Schedule'),
        'firewall_rule_create'               => array('VirtualMachine_FirewallRule'),
        'firewall_rule_create_failed'        => array('VirtualMachine_FirewallRule'),
        'firewall_rule_update'               => array('VirtualMachine_FirewallRule'),
        'firewall_rule_update_failed'        => array('VirtualMachine_FirewallRule'),
        'disk_create'                        => array('Disk'),
        'disk_create_failed'                 => array('Disk'),
        'change_owner'                       => array('VirtualMachine'),
        'change_owner_failed'                => array('VirtualMachine'),
        'firewall_rule_move'                 => array('VirtualMachine_FirewallRule'),
        'firewall_rule_move_failed'          => array('VirtualMachine_FirewallRule'),
        'network_interface_edit'             => array('VirtualMachine_NetworkInterface'),
        'network_interface_edit_failed'      => array('VirtualMachine_NetworkInterface'),
        'vm_edit'                            => array('VirtualMachine'),
        'vm_edit_failed'                     => array('VirtualMachine'),
        'network_interface_create'           => array('VirtualMachine_NetworkInterface'),
        'network_interface_create_failed'    => array('VirtualMachine_NetworkInterface'),
        'ip_address_delete'                  => array('VirtualMachine_IpAddressJoin'),
        'ip_address_delete_failed'           => array('VirtualMachine_IpAddressJoin'),
        'network_interface_delete'           => array('VirtualMachine_NetworkInterface'),
        'network_interface_delete_failed'    => array('VirtualMachine_NetworkInterface'),
        'disk_delete'                        => array('Disk'),
        'disk_delete_failed'                 => array('Disk'),
        'schedule_delete'                    => array('Disk_Schedule'),
        'schedule_delete_failed'             => array('Disk_Schedule'),
        'firewall_rules_apply'               => array('Disk_Schedule'),
        'firewall_rules_apply_failed'        => array('Disk_Schedule'),
        'ip_address_join'                    => array('VirtualMachine_IpAddressJoin'),
        'ip_address_join_failed'             => array('VirtualMachine_IpAddressJoin'),
        'ip_address_join'                    => array('VirtualMachine_IpAddressJoin'),
        'ip_address_join_failed'             => array('VirtualMachine_IpAddressJoin'),
        'vm_migrate'                         => array('VirtualMachine'),
        'vm_migrate_failed'                  => array('VirtualMachine'),
        'payment_delete'                     => array('Payment'),
        'payment_delete_failed'              => array('Payment'),
        'role_delete'                        => array('Role'),
        'role_delete_failed'                 => array('Role'),
        'group_delete'                       => array('UserGroup'),
        'group_delete_failed'                => array('UserGroup'),
        'user_delete'                        => NULL,
        'user_delete_failed'                 => NULL,
        'user_suspend'                       => array('User'),
        'user_suspend_failed'                => array('User'),
        'user_activate'                      => array('User'),
        'user_activate_failed'               => array('User'),
        'payment_create'                     => array('Payment'),
        'payment_create_failed'              => array('Payment'),
        'role_create'                        => array('Role'),
        'role_create_failed'                 => array('Role'),
        'group_create'                       => array('UserGroup'),
        'group_create_failed'                => array('UserGroup'),
        'white_list_create'                  => array('User_WhiteList'),
        'white_list_create_failed'           => array('User_WhiteList'),
        'white_list_delete'                  => array('User_WhiteList'),
        'white_list_delete_failed'           => array('User_WhiteList'),
        'user_edit'                          => array('User'),
        'user_edit_failed'                   => array('User'),
        'user_create'                        => array('User'),
        'user_create_failed'                 => array('User'),
        'payment_edit'                       => array('Payment'),
        'payment_edit_failed'                => array('Payment'),
        'role_edit'                          => array('Role'),
        'role_edit_failed'                   => array('Role'),
        'group_edit'                         => array('UserGroup'),
        'group_edit_failed'                  => array('UserGroup'),
    );
}

/**
 * Event manager function
 * 
 * @param string $event_name Event name
 * @param mixed $objects_array Objects array
 * @param string $url
 */
function onapp_event_exec( $event_name, $objects_array = NULL, $url = NULL) { //print('<pre>'); print_r($_SESSION['profile_obj']); die();
    onapp_debug(__METHOD__);

    $event_directory = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS . $event_name . ONAPP_DS;

    if( ! (count( scandir( $event_directory . 'script') ) == 2 ) ) {

    }

    if(  ! (count( scandir( $event_directory . 'exec') ) == 2) )  {

    }

    if( ! (count( scandir( $event_directory . 'mail') ) == 2) ) {
        $mail_directory = $event_directory . 'mail' . ONAPP_DS;

        $mails = onapp_scan_dir( $mail_directory );                                                 //print('<pre>');print_r($mails); die();
        $content = '';
        $mail_count = 1;
        $mails_array = array();

        foreach ( $mails as $mail ) {
            $handle = @fopen($mail_directory . $mail, "r");

            if ( $handle ) {
                $mails_array[$mail_count]['message'] = '';
                
                while ( ( $buffer = fgets ( $handle, 4096 ) ) !== false) {
                   if ( preg_match ( "/^:from:/" ,$buffer ) ) {
                       $mails_array[$mail_count]['from'] = trim( str_replace( ':from:', '', $buffer ) );
                   }
                   elseif ( preg_match ( "/^:from_name:/" ,$buffer ) ) {
                       $mails_array[$mail_count]['from_name'] = trim( str_replace( ':from_name:', '', $buffer ) );
                   }
                   elseif ( preg_match ( "/^:to:/" ,$buffer ) ) {
                       $mails_array[$mail_count]['to'] = trim( str_replace( ':to:', '', $buffer ) );
                   }
                   elseif ( preg_match ( "/^:subject:/" ,$buffer ) ) {
                       $mails_array[$mail_count]['subject'] = trim( str_replace( ':subject:', '', $buffer ) );
                   }
                   elseif ( ! preg_match ('/^:/' , $buffer) ) {
                       $mails_array[$mail_count]['message'] .= $buffer ;
                   }
                   elseif ( preg_match ('/^:copy/' , $buffer) ) {
                       $mails_array[$mail_count]['copy'] = trim( str_replace( ':copy:', '', $buffer ) ); ;
                   }
               }
            }
            else {
                die( 'Unable to open file ' . $mail_directory . $mail );
            }
            fclose( $handle );
            $mail_count++;
        }                                                                                       // print('<pre>');print_r($mails_array ); die();
                                                                                                        
        require_once ONAPP_PATH.ONAPP_DS.'libs'.ONAPP_DS.'smarty'.ONAPP_DS.'Smarty.class.php';
        $smarty = new Smarty;

        if ( $objects_array ) {
            foreach ( $objects_array as $object ) {                                       // print('<pre>');print_r($object); die();
                if ( $object ) {                                                          // print('<pre>');print_r($object); die();
                    $name = str_replace('OnApp_', '', $object->getClassName());           // echo $name; die();

                    foreach ( $object->getClassFields() as $field => $value ) {
                        $field = '_'.$field;
                        $smarty->assign( $name.$field, $object->$field );                   // $sma[$name][$name . $field] =$object->$field;
                    }
                }
            }
        }
                                                                                       // print('<pre>');print_r($sma); die();
        $profile = $_SESSION['profile_obj'];
        $smarty->assign( 'responsible_name', $profile->_first_name . ' ' . $profile->_last_name );
        $smarty->assign( 'responsible_email', $profile->_email );
                                                                                            //echo $smarty->fetch('string:'. $email['message']); die(); //print(***************************
        foreach ( $mails_array as $email ) {
            try {
                $to_f = $smarty->fetch('string:'. $email['to']);
                $from_f = $smarty->fetch('string:'. $email['from']);
                $subject_f = $smarty->fetch('string:'. $email['subject']);
                $message_f = $smarty->fetch('string:'. $email['message']);
                $from_name_f = $smarty->fetch('string:'. $email['from_name']);
                $copy_f = $smarty->fetch('string:'. $email['copy']);
            }
            catch (Exception $e){
                trigger_error( 'Smarty Syntax Error  in Email Template <br />' . $e, E_USER_ERROR );
                break;
            }
            $sent = onapp_send_email (
                $to_f,
                $from_f,
                $subject_f,
                $message_f,
                $from_name_f,
                $copy_f
            );
            if ( ! $sent ) {
                trigger_error('Failed to send email to'. $email['to']);
            }
        }
    }                                                                                   
 }
/**
 * Sends email
 *
 * @param string $to recipients email address ( could be multiple coma separated )
 * @param string $from sender email
 * @param string $from_name sender name
 * @param string $subject mail subject
 * @param string $message message body
 * @param string $copy email address to send copy to
 * @return boolean if sent true|false
 * @todo fix not to get into spam
 */
function onapp_send_email ( $to, $from, $subject, $message, $from_name = NULL, $copy = NULL ) { 
    $headers =
        'From: '.$from_name.' <'. $from .'>' . "\r\n" .
        'To:' . $to  . "\r\n" .
        'Cc:' . $copy . "\r\n" .
        'X-Mailer: PHP/' . phpversion() . "\r\n" .
        "MIME-Version: 1.0\r\n" .
        "Content-Type: text/html; charset=utf-8\r\n" .
        "Content-Transfer-Encoding: 8bit\r\n\r\n";

    $sent = mail( $to, $subject, $message, $headers );

    return $sent ? true : false;
}
