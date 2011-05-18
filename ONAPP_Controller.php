<?php

require_once 'functions.php';

Class ONAPP_Controller
{

    public function  __construct()
    {
        global $_SCREEN_IDS, $_ALIASES;

        $route = onapp_get_arg('route');

        if( onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] == 'login')
            onapp_redirect( BASEURL.'/'.$_ALIASES[onapp_config('DEFAULT_ALIAS')] );
        elseif ( ! onapp_is_auth() && $_SCREEN_IDS[$route]['alias'] != 'login' )
            // TODO save url before redirection for future redirection back after sucess logine
            onapp_redirect( BASEURL.'/'.$_ALIASES['login'] );
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
            onapp_redirect(BASEURL.'/error404.php');

        $file_path = 'controllers/'.strtolower('c_'.$class_name.'').'.php';

        if(file_exists($file_path))
            require_once "$file_path";
        else
            die("Could not find file $file_path");

        $new_class = new $class_name();
        $new_class->$method_name();
    }
}
