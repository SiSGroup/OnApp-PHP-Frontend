<?php

define( 'ONAPP_DS', DIRECTORY_SEPARATOR );
define( 'ONAPP_PATH', dirname( __FILE__ ) );

require_once ONAPP_PATH . ONAPP_DS . 'wrapper' . ONAPP_DS . 'OnAppInit.php';
require_once ONAPP_PATH . ONAPP_DS . 'functions.php';
require_once ONAPP_PATH . ONAPP_DS . 'error_log.php';
require_once ONAPP_PATH . ONAPP_DS . 'ONAPP_Controller.php';

onapp_init_config( );
onapp_startSession( );
onapp_check_configs( );
onapp_init_log( );
onapp_init_screen_ids( );
onapp_load_language( ONAPP_DEFAULT_LANGUAGE );

$controller = new ONAPP_Controller( );
$controller->run( );
