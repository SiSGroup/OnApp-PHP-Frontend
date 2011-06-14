<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Base {

    function login() {
        global $_ALIASES;

        $login    = onapp_get_arg('login');
        $password = onapp_get_arg('password');
        $host     = onapp_get_arg('host');

        $params = array();

        if( ! is_null($login) &&
            ! is_null($password) &&
            ! is_null($host)
        ) {
            require_once "wrapper/Factory.php";

            $onapp = new ONAPP_Factory(
                $host,
                $login,
                $password
            );

            if( $onapp->instance->_version && $onapp->instance->_version != '' ) {
                $this->_start_session();
                $this->_load_profile($onapp);

                // TODO redirect on previous called URL
                $redirect_url = ONAPP_BASE_URL.'/'.$_ALIASES[ONAPP_DEFAULT_ALIAS];

                onapp_redirect($redirect_url);
            }
            else
                $params = array(
                    'error_message' => onapp_string('ERORR_WRONG_LOGIN_DATA'),
                );
       }

       onapp_show_template('login', $params);
    }

    function logout() {
        global $_ALIASES;

        session_destroy();

        onapp_redirect( $_ALIASES["login"] );
    }

    private function _start_session() {
        $_SESSION['id']       =  session_id();

        $_SESSION['host']     = onapp_get_arg('host');
        $_SESSION['lang']     = onapp_get_arg('lang');
        $_SESSION['login']    = onapp_get_arg('login');
        $_SESSION['password'] = onapp_cryptData(
            onapp_get_arg('password'),
            'encrypt'
        );
    }

    private function _load_profile($onapp) {
        onapp_debug("Load OnApp user profile");

        $profile = $onapp->factory('Profile');

        $profile_obj = $profile->load();

        $_SESSION['profile_obj'] = $profile_obj;

        onapp_debug("_load_profile: profile => " . print_r($profile_obj ,true));
    }
}
