<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once 'functions.php';
require_once 'error_log.php';

Class ONAPP_Controller
{

    public function  __construct()
    {
        onapp_debug(__METHOD__);
        global $_SCREEN_IDS, $_ALIASES;

        $route = onapp_get_arg('route');                                            
        onapp_debug('route =>' . $route);
        if( onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] == 'login'){           
            onapp_debug('Redirecting :' . ONAPP_BASE_URL.'/'.$_ALIASES[ONAPP_DEFAULT_ALIAS] );
            onapp_redirect( ONAPP_BASE_URL.'/'.$_ALIASES[ONAPP_DEFAULT_ALIAS] );
        }
        elseif ( ! onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] != 'login' ) {  
            $_SESSION['redirect'] =
                ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ?
                'https://' : 'http://' )
                . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            onapp_debug('Setting after login redirect url => ' . $_SESSION['redirect']);
            onapp_debug('Redirecting :' . ONAPP_BASE_URL.'/'.$_ALIASES['login'] );
            onapp_redirect( ONAPP_BASE_URL.'/'.$_ALIASES['login'] );
        }
    }

    public function access() { }

    public function run() {
        onapp_debug(__METHOD__);

        global $_ALIASES, $_SCREEN_IDS;

        $route  = onapp_get_arg('route');

        onapp_debug( 'route => ' . $route );

        if ( array_key_exists($route, $_SCREEN_IDS) ) {
            $method_name = $_SCREEN_IDS[$route]['method'];
            $class_name = $_SCREEN_IDS[$route]['class'];
        }
        else if(is_null($route)){
            onapp_debug('$route is null!, Redirecting :' . ONAPP_BASE_URL.'/'. $_ALIASES[ ONAPP_DEFAULT_ALIAS ]);
            onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES[ ONAPP_DEFAULT_ALIAS ]);
        }
        else{
            onapp_debug('There is no such page, Redirecting ' .ONAPP_BASE_URL.'/errors/error404.php');
            onapp_redirect(ONAPP_BASE_URL.'/errors/error404.php');
        }

        $file_path = ONAPP_PATH.ONAPP_DS.'controllers'.ONAPP_DS.ONAPP_CONTROLLERS.ONAPP_DS.strtolower('c_'.$class_name.'').'.php';

        if(file_exists($file_path))
            require_once "$file_path";
        else
            onapp_die("Could not find file $file_path");

        onapp_debug("ONAPP_Controller->run: args => " . print_r(
            array(
                'route'  => $route,
                'file'   => $file_path,
                'class'  => $class_name,
                'method' => $method_name
            ), true) );

        $new_class = new $class_name();
        $new_class->$method_name();
    }
}
