<?php
require_once 'functions.php';

error_reporting( E_ALL );
ini_set( 'display_errors', 0 );



register_shutdown_function( 'onapp_error' );
set_error_handler( 'onapp_fatal' );

require_once 'ONAPP_Controller.php';

init_config();
onapp_check_configs();

onapp_init_log();

onapp_debug('Load Screen IDs');
onapp_load_screen_ids();

onapp_debug(print_r($_ALIASES, true));
onapp_debug(print_r($_SCREEN_IDS, true));

onapp_load_language(ONAPP_DEFAULT_LANGUAGE);   

$controller = new ONAPP_Controller();
$controller->run();
?>
