<?php
/**
 * Returns available language list
 *
 * @return array Language packages available
 *
 */
function onapp_get_languageList(){
    $languages = scandir('language');

    foreach( $languages as $language )
        if (! is_dir($language) && ! is_file("language/$language") )
            $result[] = $language;

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
function onapp_get_string($string) {
    global $_LANG;

    return isset($_LANG[$string]) ?
        $_LANG[$string] :
        "String $string not found";
}

/**
 * Returns config option value
 *
 * @param string $option Name of config option
 *
 * @return string Configuration option value
 *
 */
function onapp_get_config_option($option) {
    global $_CONF;

    if (! isset($_CONF) || is_null($_CONF) )
        if (file_exists('config.ini') )
            $_CONF = parse_ini_file('config.ini');
        else
            die('Config file not found');

    if (isset($_CONF[$option]))
        return $_CONF[$option];
    else
        die("Config option $option not found");
}

/**
 * Returns a value of particular variable from global GET or POST array.
 *
 * @param string @string variable name
 *
 * @param string $method http method [POST|post|GET|get] default = ''
 *
 * @return mixed variable value
 */
function onapp_get_arg($string, $method='') {
    switch($method) {
        case "get":
        case "GET":
            return array_key_exists($string, $_GET) ? $_GET[$string] : NULL;
            break;
        case "post":
        case "POST":
            return array_key_exists($string, $_POST) ? $_POST[$string] : NULL;
            break;
        default :
            $value_post = onapp_get_arg($string,"POST");
            $value_get = onapp_get_arg($string,"GET");

            return $value_post ? $value_post : $value_get;
            break;
    }
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
 * @todo Realise muliple template system.
 *
 * @return void
 *
 */
function onapp_show_template($view, $params = array())
{
    global $_ALIASES, $_SCREEN_IDS;

    require_once "libs/smarty/Smarty.class.php";

    onapp_load_language(onapp_get_config_option('DEFAULT_LANGUAGE'));

    $template = onapp_get_config_option('TEMPLATE');
    $smarty = new Smarty;
    $smarty->force_compile = true;
    $smarty->assign('_session_data', $_SESSION);
    $smarty->assign('navigation', $_SCREEN_IDS);
    $smarty->assign('languages', onapp_get_languageList());
    $smarty->assign( '_ALIASES', $_ALIASES );

    if(is_array($params))
        foreach($params as $key => $value)
            $smarty->assign("$key",$value);

    $smarty->display($template.DIRECTORY_SEPARATOR.str_replace('_',DIRECTORY_SEPARATOR,$view).'.tpl');
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
function onapp_load_language($lang) {
    global $_LANG;
    if(isset($_SESSION["language"]) && $_SESSION["language"] != '')
        $language = $_SESSION["language"];
    else
        $language = $lang;
    if(file_exists('language/'.$language.'/strings.ini'))
        $_LANG = parse_ini_file('language/'.$language.'/strings.ini');
    else
        die( 'Language file not found' );
}

/**
 * Parsing menu xml file. Converts xml dom data to array. Initializes global screen ids arrays.
 *
 * @return void
 *
 */
function onapp_load_screen_ids($SimpleXMLElement = null, $parrent_id = '')
{
    global $_SCREEN_IDS, $_ALIASES;

    if(is_null($SimpleXMLElement))
        $SimpleXMLElement = simplexml_load_file('menu.xml');

    for($id = 1; $id < count($SimpleXMLElement)+1; $id++) {
        $current_id = $parrent_id != '' ? "$parrent_id.$id" : $id;

        foreach($SimpleXMLElement->screen[ $id -1 ]->attributes() as $k=>$v)
            $_SCREEN_IDS["$current_id"][$k] = (String)$v;

        $_ALIASES[$_SCREEN_IDS["$current_id"]["alias"]] = $current_id;

        onapp_load_screen_ids($SimpleXMLElement->screen[ $id -1 ], "$current_id");
    }
}

/**
 * Encrypts data with Mcrypt php extension
 *
 * @param string $value input data to encrypt
 *
 * @return string encrypted
 *
 *
 *
 */
function encryptData($value){
   $key = onapp_get_config_option('SECRET_KEY');
   $text = $value;
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
   return $crypttext;
}

/**
 * Decrypts data with Mcrypt php extension
 *
 * @param string $value encrypted data with encryptData function
 *
 * @return string decrypted
 *
 *
 *
 */
function decryptData($value){
   $key = onapp_get_config_option('SECRET_KEY');
   $crypttext = $value;
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
   return trim($decrypttext);
}

/*
 * TODO add description
 * TODO delete functions decryptData and encryptData
 */
function onapp_cryptData($value, $type) {
   $key = onapp_get_config_option('SECRET_KEY');
   $text = $value;
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

   switch($type) {
      case "encrypt": 
               $text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
          break;
      case "decrypt":
               $text = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv));
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
function onapp_redirect($url){
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
function onapp_check_configs()
{

    session_start();
    if(!$_SESSION)
    {
       // Cheching PHP version
       if (version_compare(PHP_VERSION, '5.0.0', '<'))
          die('You need at least PHP 5.0.0, your current version is '. PHP_VERSION) ;

        // Checking of necessary configuration options
        $config_options = array(
            'SECRET_KEY',
            'SESSION_LIFETIME'
        );

        foreach($config_options as $option)
            onapp_get_config_option ($option);

        // Checking of necessary fuctions
        $necessary_fuctions = array(
            'encryptData',
            'decryptData',
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
function onapp_startSession($time = '3600', $ses = 'MYSES') {
    session_set_cookie_params($time);
    session_name($ses);
    session_start();

    // Reset the expiration time upon page load
    if (isset($_COOKIE[$ses]))
      setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
}

// TODO add desctiption
function onapp_is_auth()
{
//    if( ! isset($_SESSION) )
//        session_start();

    $is_auth = isset($_SESSION["login"])
        && isset($_SESSION["password"])
        && isset($_SESSION["host"])
        && isset($_SESSION["id"]);

    return $is_auth;
}

// TODO add desctiption
function onapp_access()
{
     // Load profile object
      $profile = $this->onapp->factory('Profile');
      $profile_obj = $profile->load();

      $access = false;

      foreach( $profile_obj->_roles as $value )
                    if($value->_permissions->identifier == str_replace( '_', '.', self::called_function ))// $this->called_function = __FUNCITON__;
                            $access = true;
                    else
                        ;
      return $access;
}
