<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Log_Settings extends Base_Settings
{
    protected $template = array(
        'title' => '',
        'edit'  => 'logSettings_edit',
        'view'  => 'logSettings_view'
    );
}
