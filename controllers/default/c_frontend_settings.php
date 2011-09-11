<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Frontend_Settings extends Base_Settings
{
    protected $config = array(
        'template'   => 'frontendSettings',
        'title'      => 'FRONTEND_SETTINGS',
        'info_title' => 'FRONTEND_SETTINGS',
        'info_body'  => 'FRONTEND_SETTINGS_INFO',
    );
}