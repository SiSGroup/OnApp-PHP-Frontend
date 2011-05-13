<?php

ini_set( "display_errors", 1);

require_once 'functions.php';
require_once 'ONAPP_Controller.php';

onapp_check_configs();
onapp_load_screen_ids();

$controller = new ONAPP_Controller();
$controller->show();
?>
