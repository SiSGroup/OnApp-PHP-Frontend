<?php
/**
 * Returns available language list
 * 
 * @return array Language packages available
 *
 */
function onapp_get_languageList(){
    $languages = scandir('language');

    foreach( $languages as $k=>$v )
        if(!is_dir($v) && !is_file($v))
            $result[] = $v;

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

    if ( isset($_LANG[$string]) && !isnull($_LANG[$string]) )
        return $_LANG[$string];
    else
        return "String $string not found";
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

    if (!isset($_CONF) || is_null($_CONF) )
        $_CONF = parse_ini_file('config.ini');

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
            return $_GET[$string];
            break;
        case "post":
        case "POST":
            return $_POST[$string];
            break;
        default :
            return isset($_GET[$string]) ?
                $_GET[$string] :
                $_POST[$string];
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
function onapp_show_template($view, $template='default', $params = array()) 
{
    global $_ALIASES;
    global $SCREEN_IDS;

    onapp_load_language();

    require_once "libs/smarty/Smarty.class.php";
  
    $smarty = new Smarty;
    $smarty->force_compile = true;
    $smarty->assign('_session_data', $_SESSION);
    $smarty->assign('navigation', $SCREEN_IDS);
    $smarty->assign('languages', onapp_get_languageList());
    $smarty->assign( '_ALIASES', $_ALIASES );

    if(is_array($params))
        foreach($params as $key => $value)
            $smarty->assign("$key",$value);

    $smarty->display(''.str_replace('_', '/',$view ).'.tpl');
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
function onapp_load_language($language = 'en') {
    global $_LANG;

    if(isset($_SESSION["language"]) && $_SESSION["language"] != '')
        $language = $_SESSION["language"];
    else
        $language = 'en';
// TODO check is file exist && is_file
    $_LANG = parse_ini_file('language/'.$language.'/strings.ini');
}

/**
 * Parsing menu xml file. Converts xml dom data to array. Initializes global screen ids arrays.
 *
 * @return void
 *
 */
function onapp_load_screen_ids($SimpleXMLElement = null, $parrent_id = '')
{
// TODO change SCREEN_IDS name to _SCREEN_IDS
// TODO move menu/menu.xml to menu.xml
    global $SCREEN_IDS;
    global $_ALIASES;
       
    if(is_null($SimpleXMLElement))
        $SimpleXMLElement = simplexml_load_file('menu/menu.xml');

    for($id = 1; $id < count($SimpleXMLElement)+1; $id++) {
        $current_id = $parrent_id != '' ? "$parrent_id.$id" : $id;
        
        foreach($SimpleXMLElement->screen[ $id -1 ]->attributes() as $k=>$v)
                            $SCREEN_IDS["$current_id"][$k] = (String)$v;

       $_ALIASES[$SCREEN_IDS["$current_id"]["alias"]] = $current_id;
        
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

/**
 * Redirects to specified url
 *
 * @param string url redirect to
 *
 * @return void
 *
 */
function redirect($url){
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
function check_configs()
{
    if (version_compare(PHP_VERSION, '5.0.0', '<')) 
        die('You need at least PHP 5.0.0, your current version is '. PHP_VERSION) ;

    session_start();

    if(!$_SESSION)
    {
       // Cheching PHP version

        // Checking of necessary configuration options
        $config_options = array(
            'CHARSET',
            'SECRET_KEY',
            'SESSION_LIFETIME'
        );

        foreach($config_options as $option)
            onapp_get_config_option ($option);

        // Checking of necessary fuctions
        $necessary_fuctions = array(
            'encryptData',
            'decryptData'
        );

        foreach($necessary_fuctions as $function_name)
           if(!function_exists($function_name)) die("Function $function_name not found");

        // Checking of necessary PHP extensions
// TOdo move in to template file
        $mcrypt_man = '<div style="padding:10px; magrin-top:10px;  background:#f6f6f6; border:1px solid #cccccc">
                             <b>PHP Extension<i> Mcrypt </i> not enabled or not installed!</b><br /><br />
                             <b>For Linux Ubuntu:</b><br /><br /> Add a line: <br />
                             extension=php_mcrypt.so <br />
                             to the file /etc/php5/apache2/php.ini <br />
                             and restart network: <br />
                             sudo /etc/init.d/networking restar<br /><br />

                             Also on Ubuntu, make sure you actually have php5-mcrypt installed. You can install it with:<br />
                             sudo apt-get install php5-mcrypt<br /><br />

                             or visit <a href="http://php.net/manual/en/mcrypt.setup.php">link</a> for more info <br />
                      </div>';
        
         $necessary_extensions = array(
            'mcrypt' => $mcrypt_man
        );

        $enabled_extensions = get_loaded_extensions();
        foreach( $necessary_extensions as $extension_name => $manual)
            if(!in_array($extension_name, $enabled_extensions)) die($manual);

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
function startSession($time = '3600', $ses = 'MYSES') {
    session_set_cookie_params($time);
    session_name($ses);
    session_start();

    // Reset the expiration time upon page load
    if (isset($_COOKIE[$ses]))
      setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
}
