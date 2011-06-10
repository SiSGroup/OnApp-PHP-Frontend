<?php
define( 'ONAPP_PATH', dirname(__FILE__) );
define( 'ONAPP_DS', DIRECTORY_SEPARATOR );

require_once 'functions.php';
require_once 'error_log.php';

onapp_init_config();
onapp_startSession();

onapp_check_configs();
onapp_init_log();

require_once 'ONAPP_Controller.php';

onapp_init_screen_ids();

onapp_load_language(ONAPP_DEFAULT_LANGUAGE);

$controller = new ONAPP_Controller();
$controller->run();
?>
