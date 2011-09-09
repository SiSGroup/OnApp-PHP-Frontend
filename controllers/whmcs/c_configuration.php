<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Configuration extends Base_Settings
{
    protected $config = array(
        'template'   => 'configuration',
        'title'      => 'CONFIGURATION_',
        'info_title' => 'CONFIGURATION_',
        'info_body'  => 'CONFIGURATION_INFO',
    );
}