<?php

/**
 * Returns available language list
 *
 * @return array Language packages available
 *
 */
function onapp_get_languageList() {

    onapp_debug("Get languages list");

    $languages = scandir('lang');

    foreach( $languages as $language )
        if (! is_dir($language) && ! is_file("lang/$language") )
            $result[] = $language;

    onapp_debug("onapp_get_languageList:\nreturn => " . var_export($result, true) );
    
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
function onapp_string($string) {
    global $_LANG;

//    onapp_debug("Get string" );

    $return = isset($_LANG[$string]) ?
        $_LANG[$string] :
        "String $string not found";

    $return = isset($_LANG[$string]) ?
        $_LANG[$string] :
        "String $string not found";

//    onapp_debug("onapp_string: 'string' => '$string', return => $return");

    return $return;
}

/**
 * Returns config option value
 *
 * @param string $option Name of config option
 *
 * @return string Configuration option value
 *
 */
function onapp_config($option) {
    global $_CONF;
## TODO add debug_log
    if (! isset($_CONF) || is_null($_CONF) )
        if (file_exists('config.ini') )
            $_CONF = parse_ini_file('config.ini');
        else
            die('Config file not found');

    if (isset($_CONF[$option])) {
        return $_CONF[$option];
    } else
        die("Config option $option not found");
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

    onapp_debug("Get arguments" );

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

    onapp_debug("onapp_get_arg: string => $string, method => $method, return => $return" );

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

    onapp_debug("Show templates");
    onapp_debug("onapp_show_template: view => $view, params => " . print_r($params, true));

    $template = onapp_config('TEMPLATE').DIRECTORY_SEPARATOR.str_replace('_',DIRECTORY_SEPARATOR,$view).'.tpl';

    $globals = array(
        '_session_data' => $_SESSION,
        'navigation'    => $_SCREEN_IDS,
        '_ALIASES'      => $_ALIASES,
        'langs'         => onapp_get_languageList()
    );

    $smarty_params = is_array($params)
        ? array_merge($params, $globals)
        : $globals;

    require_once "libs/smarty/Smarty.class.php";

    $smarty = new Smarty;
    $smarty->force_compile = true;

    foreach($smarty_params as $key => $value)
        $smarty->assign("$key",$value);

    $smarty->display($template);

    onapp_debug("Display Smarty Template");
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

    if(isset($_SESSION["language"]) && $_SESSION["language"] != '')
        $language = $_SESSION["language"];
    else
        $language = $lang;

    if(file_exists('lang/'.$language.'/strings.php'))
        include 'lang/'.$language.'/strings.php';
    else
        die( 'Language file not found' );
}

/**
 * Parsing menu xml file. Converts xml dom data to array. Initializes global screen ids arrays.
 *
 * @return void
 *
 */
function onapp_load_screen_ids($SimpleXMLElement = null, $parrent_id = '') {
    global $_SCREEN_IDS, $_ALIASES;

    if(is_null($SimpleXMLElement))
        if(file_exists('menu.xml'))
            $SimpleXMLElement = simplexml_load_file('menu.xml');
        else
            die('Could not find file menu.xml');

    for($id = 1; $id < count($SimpleXMLElement)+1; $id++) {
        $current_id = $parrent_id != '' ? "$parrent_id.$id" : $id;

        foreach($SimpleXMLElement->screen[ $id -1 ]->attributes() as $k=>$v)
            $_SCREEN_IDS["$current_id"][$k] = (String)$v;

        if(isset($_SCREEN_IDS["$current_id"]['title'])){
            $file_path = 'controllers/c_'.strtolower($_SCREEN_IDS["$current_id"]['class']).'.php';
            if(file_exists($file_path))
            {
                require_once $file_path;
                    //todo verify if exists class and function
                $_SCREEN_IDS["$current_id"]['show'] = call_user_func(array($_SCREEN_IDS["$current_id"]['class'], $_SCREEN_IDS["$current_id"]['access']));
            }
            else
                die('File '.$file_path.' doesn\'t exists');

        }
        $_ALIASES[$_SCREEN_IDS["$current_id"]["alias"]] = $current_id;

        onapp_load_screen_ids($SimpleXMLElement->screen[ $id -1 ], "$current_id");
    }
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
   $key = onapp_config('SECRET_KEY');
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
              die("Wrong crypt data type $type");
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

    if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header('Location: '.$url); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

/**
 *
 * Checks PHP version, config options, functions and PHP extenssions
 *
 * @return void
 *
 */
function onapp_check_configs() {
    require_once "wrapper/Profile.php";
    onapp_startSession();

    onapp_debug("Check configs");

    if(!$_SESSION)
    {
       // Cheching PHP version
       if (version_compare(PHP_VERSION, '5.0.0', '<'))
          die('You need at least PHP 5.0.0, your current version is '. PHP_VERSION) ;

        // Checking of necessary configuration options
        $config_options = array(
            'SECRET_KEY',
        );

        foreach($config_options as $option)
            onapp_config ($option);

        // Checking of necessary fuctions
        $necessary_fuctions = array(
            'onapp_cryptData'
            );

        foreach($necessary_fuctions as $function_name)
           if(!function_exists($function_name))
               die("Function $function_name not found");

        // Checking of necessary PHP extensions

        // Including manuals

        $enabled_extensions = get_loaded_extensions();
        $require_extensions = array( 'mcrypt' );

        foreach( $require_extensions as $extension_name)
            if( ! in_array($extension_name, $enabled_extensions)) {
                include('manuals/mcrypt.php');
                exit();
            }
    }
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
    $time =  onapp_config('SESSION_LIFETIME');
    session_set_cookie_params($time);
    session_name($ses);
    session_start();

    onapp_debug("Start SESSION");

    // Reset the expiration time upon page load
    if (isset($_COOKIE[$ses]))
      setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
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
 * Writes string into file
 *
 * @param string $filename File name
 * @param string $content  Content string
 *
 * @return void
 *
 */
function onapp_file_write($type, $content) {
    $log_directory = 'logs';

    switch ($type) {
        case 'frontend':
            $filename = "$log_directory/fronted.log";
            break;
        case 'wrapper':
        case 'onapp':
            $filename = "$log_directory/wrapper.log";
            break;
        case 'third':
            $filename = "$log_directory/third.log";
            break;
        case 'error':
            $filename = "$log_directory/errors/error_".$_SESSION['log_id'].'.log';
            break;
        default:
            return;
            break;
    }

    if (!$handle = fopen($filename, 'a+'))
    {
         echo "Cannot open file ($filename)in file ".__FILE__.' line '.__LINE__;
         exit;
    }

    if (fwrite($handle, $content."\n") === FALSE)
    {
        echo "Cannot write to file ($filename)";
        exit;
    }

    fclose($handle);
}

/**
 *
 * Inits log id and logs levels
 *
 * @global array $_LOG_LEVELS
 *
 * @return void
 *
 */
function onapp_init_log()
{
    global $_LOG_LEVELS;

    $_SESSION['log_id'] = substr(md5($_SESSION['id'] . date('d-m-Y H-i-s') ), -10);

    $_LOG_LEVELS = array(
        'FATAL' => 1,
        'ERROR' => 2,
        'WARN'  => 3,
        'INFO'  => 4,
        'DEBUG' => 5
    );

    onapp_debug("Initialise frontend loger");
}

/**
 * Adds onapp debug.
 *
 * @param string $message Debug message
 *
 * @param mixed $obj Mixed variable to print
 *
 * @return void
 *
 */
function onapp_debug( $message )
{
    global $_LOG_LEVELS;

    if( onapp_config('LOG_LEVEL') < $_LOG_LEVELS['DEBUG'] || ! isset( $_SESSION['log_id'] ) )
        return;

    $msg = $_SESSION['log_id']." : [DEBUG] $message";

    onapp_file_write('frontend', $msg);
}

/**
 * Adds onapp info.
 *
 * @param string $message Information message
 *
 * @param mixed $obj Mixed variable to print
 *
 * @return void
 *
 */
function onapp_info( $message )
{
    global $_LOG_LEVELS;

    if( onapp_config('LOG_LEVEL') < $_LOG_LEVELS['INFO'] )
        return;

    $msg = $_SESSION['log_id']." : [INFO] $message";

    onapp_file_write('frontend', $msg);
}

/**
 * Adds onapp warn message.
 *
 * @param string $message Warning message
 *
 * @return void
 *
 */
function onapp_warn( $message )
{
    global $_LOG_LEVELS;

    if( onapp_config('LOG_LEVEL') < $_LOG_LEVELS['WARN'])
        return;

    $msg = $_SESSION['log_id']." : [WARN] $message";

    onapp_file_write('error', $msg);

    die('WARNING');

//    onapp_redirect(BASEURL.'/errors/error500.php?log_id='.$_SESSION['log_id']);
}

/**
 * Adds onapp error message.
 *
 * @param string $message Error message
 *
 * @return void
 *
 */
function onapp_error( $message )
{
    global $_ALIASES, $_LOG_LEVELS;

    if( onapp_config('LOG_LEVEL') < $_LOG_LEVELS['ERROR'] )
        return;

    $msg = $_SESSION['log_id']." : [ERROR] $message";

    onapp_file_write('error', $msg);

    die('ERROR');

//    onapp_redirect(BASEURL.'/'
//                   .($_ALIASES['profile'])
//                   .'?error=ERROR ID - '
//                   .$_SESSION['log_id']
//                   .'&no_error_translate=true');
}

/**
 * Adds onapp fatal message.
 *
 * @param string $message Fatal error message
 *
 * @return void
 *
 */
function onapp_fatal($message)
{
    global $_LOG_LEVELS;

    if( onapp_config('LOG_LEVEL') < $_LOG_LEVELS['FATAL'] )
            return;

    $msg = $_SESSION['log_id']." : [FATAL] $message";

    onapp_file_write('error', $msg);

    die('FATAL');

//    onapp_redirect(BASEURL.'/errors/error500.php?log_id='.$_SESSION['log_id']);
}

/**
 *
 * Checks whether user has permission to perform particular action
 *
 * @param string $permission
 *
 * @return void
 *
 */
function onapp_permission($permissions) {
    global $_ALIASES;
    if(is_array($permissions))
    {
        foreach($permissions as $permission)
            if(in_array($permission, $_SESSION['permissions']))
                return;
    }
    else
        in_array($permissions, $_SESSION['permissions']);

    $error = 'YOU_HAVE_NOT_PERMISSION_FOR_THIS_ACTION';
    onapp_redirect(BASEURL.'/'.($_ALIASES['profile']).'?error='.$error);
}

/**
 * Checks whether user has permission to view particular items
 *
 * @param string $permission
 *
 * @return boolean [true|false]
 *
 */
function onapp_has_permission($permissions) {
    if(is_array($permissions))
    {
           foreach($permissions as $permission)
               if(in_array($permission, $_SESSION['permissions']))
                       return true;

               return false;
    }
    return in_array($permissions, $_SESSION['permissions']);
}
