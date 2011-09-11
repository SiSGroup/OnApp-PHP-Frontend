<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Whmcs_Settings extends Base_Settings
{
    protected $config = array(
        'template'   => 'whmcsSettings',
        'title'      => 'WHMCS_SETTINGS',
        'info_title' => 'WHMCS_SETTINGS',
        'info_body'  => 'WHMCS_SETTINGS_INFO',
    );
}