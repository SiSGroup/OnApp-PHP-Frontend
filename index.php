<?php

ini_set( "display_errors", 0);

require_once 'ONAPP_Controller.php';

require_once 'functions.php';

check_configs();

onapp_load_screen_ids();

$controller = new ONAPP_Controller(
    onapp_get_arg( 'route' ),
    onapp_get_arg('action')
);

?>
