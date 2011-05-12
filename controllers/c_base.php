<?php

class Base {

    function login() {
        if( isset($_POST["login"])
            && isset($_POST["password"])
            && isset($_POST["language"])
            && isset($_POST["host"])) {

                require_once "libs/wrapper/Factory.php";

                $onapp = new ONAPP_Factory(
                    $_POST["host"],
                    $_POST["login"],
                    $_POST["password"]
                );

                if( $onapp->instance->_version && $onapp->instance->_version != '' )
                {
                    $this->_start_session();

                    //or redirect on previos URL saved in SESSION
                    onapp_show_template( 'index', $params);
                } else {
                    $params = array(
                        error_display => 'block',
                        error_message => 'Login, password or hostname incorect!',
                    );

                    onapp_show_template( 'login', $params );
                }
            } else 
                onapp_show_template( 
                    'login',
                     array(
                         error_display => 'block',
                         error_message => 'All fields are required!'
                     )
                );
    }

    function logout() {
        global $_ALIASES;

        session_destroy();
        onapp_redirect( $_ALIASES["login"] );
    }

    function _start_session() {
        session_start();
//        startSession(onapp_get_config_option("SESSION_LIFETIME"));

        $_SESSION['host']     = $_POST["host"];
        $_SESSION['login']    = $_POST["login"];
        $_SESSION['password'] = encryptData($_POST["password"]);
//        $_SESSION['version']  = $onapp->instance->_version;
        $_SESSION['id']       =  session_id();
        $_SESSION['language'] = $_POST["language"];
    }

};

?>
