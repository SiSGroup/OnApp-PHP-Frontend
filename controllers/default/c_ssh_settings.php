<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "c_base_settings.php";

class Ssh_Settings extends Base_Settings
{
    protected $config = array(
        'template'   => 'sshSettings',
        'title'      => 'SSH_SETTINGS',
        'info_title' => 'SSH_SETTINGS',
        'info_body'  => 'SSH_SETTINGS_INFO',
    );
}