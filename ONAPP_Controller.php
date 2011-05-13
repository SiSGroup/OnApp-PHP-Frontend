<?php

require_once 'functions.php';

Class ONAPP_Controller
{
    public function  __construct() 
    {
        global $_SCREEN_IDS;
        global $_ALIASES;
        if ( ! onapp_is_auth() && $_SCREEN_IDS[onapp_get_arg('route')]["alias"] != "login" )
        {
            //TODO save url before redirection for future redirection back after sucess login
            onapp_redirect( $_ALIASES["login"] );
        }
        
    }

    public function access() {
    }

    public function show() {
        global $_ALIASES, $_SCREEN_IDS;

        $route  = onapp_get_arg('route');

        if ( array_key_exists($route, $_SCREEN_IDS)  ) {
            $method_name = $_SCREEN_IDS[$route]['method'];
            $class_name = $_SCREEN_IDS[$route]['class'];
        } else {
            header("HTTP/1.0 404 Not Found");
            die("HTTP/1.0 404 Not Found");
        };

        $file_path = 'controllers/'.strtolower('c_'.$class_name.'').'.php';

//TODO check is file exist
        require_once "$file_path";

        $new_class = new $class_name();
        $new_class->$method_name();
    }
}

?>
