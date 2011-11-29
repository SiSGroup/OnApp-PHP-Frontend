<?php
if( !defined( 'ONAPP_PATH' ) ) { die( 'No direct script access allowed' ); }
class Base {
    /**
     * Performs Login actions
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
	function login( ) { 
		global $_ALIASES;
		$login = onapp_get_arg( 'login' );
		$password = onapp_get_arg( 'password' );
		$host = onapp_get_arg( 'host' );
        $submit = onapp_get_arg('submit');

        if ( preg_match('/,/', $host) ) {        
            $host = explode(',', $host  );
                    
            foreach ( $host as $hst ) {  
                $logedin = $this->login_action( $login, $password, trim($hst) );
                if ( $logedin ) {
                    $_SESSION['host'] = trim($hst);
                    $this->after_logedin_action ();
                    exit;
                }
            }
            
            onapp_debug('login failed couldn\'t get APIVersion');
				$params = array(
					'error_message' => onapp_string( 'ERORR_WRONG_LOGIN_DATA' ),
				);
            onapp_show_template( 'login', $params );
            exit;
        }
        if (  is_null( $submit ) ) {

        }
        elseif( ! is_null( $submit ) && $this->login_action( $login, $password, $host  ) ) {
                onapp_debug('Login successfull!');
				$this->after_logedin_action ();
		}
        else {
            onapp_debug('login failed couldn\'t get APIVersion');
            $params = array(
                'error_message' => onapp_string( 'ERORR_WRONG_LOGIN_DATA' ),
            );
        }
            
        if ( ! isset ($params )) $params = NULL;

		onapp_show_template( 'login', $params );
	}

    /**
     * Trying to get APIversion
     *
     * @param string $login login to OnApp
     * @param string $password password to OnApp
     * @param string $host hostname
     * @return boolean true if succeed
     */
    private function login_action ( $login, $password, $host ) {        
        $params = array( );
		if( !is_null( $login ) &&
			!is_null( $password ) &&
			!is_null( $host )
		) {
            onapp_debug('Trying to login : host => ' . $host . 'login => ' . $login . 'password => *******');
			$onapp = new ONAPP_Factory(
				$host,
				$login,
				$password
			);

            onapp_debug( 'VersioinApi => ' . $onapp->getAPIVersion( ));
            if ( ! is_null( $onapp->getAPIVersion( ) ) ) {
                $this->_start_session( );
                $this->_load_profile( $onapp );
                return true;
            }
		}
        return false;
    }

    /**
     * Performs the actions after successful getting of APIversion
     *
     * @return void
     */
    private function after_logedin_action () {
        global $_ALIASES;
        onapp_debug('Login successfull!');

				if(
                    isset( $_SESSION[ 'redirect' ] )
                    && $_SESSION['redirect'] != ONAPP_BASE_URL . '/' . $_ALIASES ['logout']
                    && $_SESSION['redirect'] != ONAPP_BASE_URL. '/'
                ) {
					$redirect_url = $_SESSION[ 'redirect' ];
                    onapp_debug('Redirecting : ' . $_SESSION[ 'redirect' ] );
					onapp_redirect( $redirect_url );
				}
				else {
					onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES[ ONAPP_DEFAULT_ALIAS ] );
				}
			
		onapp_show_template( 'login', $params );
    }

    /**
     * Performs Logout action
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
	function logout( ) {
		global $_ALIASES;
		//session_start( );
		session_regenerate_id( );
		session_destroy( );
		unset( $_SESSION );
		//session_start( );
		onapp_redirect( $_ALIASES[ "login" ] );
	}
	private function _start_session( ) {
        onapp_debug(__METHOD__);
		$_SESSION[ 'id' ] = session_id( );
		$_SESSION[ 'host' ] = onapp_get_arg( 'host' );
		$_SESSION[ 'lang' ] = onapp_get_arg( 'lang' );
		$_SESSION[ 'login' ] = onapp_get_arg( 'login' );
		$_SESSION[ 'password' ] = onapp_cryptData(
			onapp_get_arg( 'password' ),
			'encrypt'
		);
	}

    /**
     * Loads OnApp user profile into the session
     *
     * @param mixed $onapp instance of ONAPP_Factory class
     * @return void
     */
	private function _load_profile( $onapp ) {
		onapp_debug( __METHOD__ );
		$profile = $onapp->factory( 'Profile' );
		$profile_obj = $profile->load( );
       
		foreach( $profile_obj->_roles as $role ) {                              
			foreach( $role->_permissions as $permission ) {                      
				$_SESSION[ 'permissions' ][ ] = $permission->_identifier;
			}
		}
        //http://e-mats.org/2008/07/fatal-error-exception-thrown-without-a-stack-frame-in-unknown-on-line-0/
        unset($profile_obj->_used_ip_addresses);
        $_SESSION ['profile_obj'] = $profile_obj;

        onapp_debug('SESSION[permissions]' . print_r( $_SESSION[ 'permissions' ], true ) );
	}

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function  access(){
        return true;
    }
}