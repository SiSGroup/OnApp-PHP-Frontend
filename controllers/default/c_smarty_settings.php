<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Smarty_Settings extends Base_Settings
{
    protected $config = array(
        'template'   => 'smartySettings',
        'title'      => 'SMARTY_SETTINGS',
        'info_title' => 'SMARTY_SETTINGS',
        'info_body'  => 'SMARTY_SETTINGS_INFO',
    );
}