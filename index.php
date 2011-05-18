<?php

/*
 * Error reporting level
 */
/*
define('ENVIRONMENT', 'development');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
                        ini_set( "display_errors", 1);
		break;

		case 'testing':
		case 'production':
			error_reporting(0);
                        ini_set( "display_errors", 0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}
*/

require_once 'functions.php';

define('BASEURL', onapp_config('BASE_URL') );//'http://'. $_SERVER['HTTP_HOST'].'/'.basename(dirname($_SERVER["SCRIPT_FILENAME"]));

require_once 'ONAPP_Controller.php';

onapp_check_configs();
onapp_load_screen_ids();
onapp_load_language(onapp_config('DEFAULT_LANGUAGE'));

$controller = new ONAPP_Controller();
$controller->run();

?>
