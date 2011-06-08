<?php

require_once 'functions.php';
require_once 'error_log.php';

Class ONAPP_Controller
{

    public function  __construct()
    {
        global $_SCREEN_IDS, $_ALIASES;

        $route = onapp_get_arg('route');

        onapp_debug("ONAPP_Controller->__construct: route => $route");

        if( onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] == 'login')
            onapp_redirect( ONAPP_BASE_URL.'/'.$_ALIASES[ONAPP_DEFAULT_ALIAS] );
        elseif ( ! onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] != 'login' )
            // TODO save url before redirection for future redirection back after sucess login
            onapp_redirect( ONAPP_BASE_URL.'/'.$_ALIASES['login'] );
    }

    public function access() {
    }

    public function run() {
        global $_ALIASES, $_SCREEN_IDS;

        $route  = onapp_get_arg('route');

        if ( array_key_exists($route, $_SCREEN_IDS) ) {
            $method_name = $_SCREEN_IDS[$route]['method'];
            $class_name = $_SCREEN_IDS[$route]['class'];
        }
        else if(is_null($route))
            onapp_redirect( $_ALIASES["profile"]);
        else
            onapp_redirect(ONAPP_BASE_URL.'/errors/error404.php');

        if ( ! defined('ONAPP_BASE_URL'))
            onapp_error('No direct script access allowed');

        $file_path = 'controllers/'.strtolower('c_'.$class_name.'').'.php';

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
