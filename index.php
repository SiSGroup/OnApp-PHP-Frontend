<?php
require_once 'functions.php';

error_reporting( E_ALL );
ini_set( 'display_errors', 0 );

set_error_handler( 'onapp_error_handler' );
register_shutdown_function( 'onapp_fatal' );

require_once 'ONAPP_Controller.php';

onapp_init_config();
onapp_check_configs();
onapp_init_log();
onapp_init_screen_ids();

onapp_load_language(ONAPP_DEFAULT_LANGUAGE);   

$controller = new ONAPP_Controller();
$controller->run();
?>
