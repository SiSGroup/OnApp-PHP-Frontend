<?php

/**
*
*
* @todo Add Desctiption *
*/
class Logs_Settings
{
    var $error;

    public function view()
    {
        $action       = onapp_get_arg('action', "GET");
        $log_settings = onapp_get_arg('log_settings');

        switch($action)
        {
            case 'update':
                $this->update($log_settings);
            break;
            default:
                 $this->index();
            break;
        }
    }

    /**
     *
     *
     * @todo Add Desctiption
     *
     */
    private function index()
    {
        $php_error_levels = array(
            30719 => 'E_ALL',
            16384 => 'E_USER_DEPRECATED',
            8192  => 'E_DEPRECATED',
            4096  => 'E_RECOVERABLE_ERROR',
            2048  => 'E_STRICT',
            1024  => 'E_USER_NOTICE',
            512   => 'E_USER_WARNING',
            256   => 'E_USER_ERROR',
            128   => 'E_COMPILE_WARNING',
            64    => 'E_COMPILE_ERROR',
            32    => 'E_CORE_WARNING',
            16    => 'E_CORE_ERROR',
            8     => 'E_NOTICE',
            4     => 'E_PARSE',
            2     => 'E_WARNING',
            1     => 'E_ERROR'
        );

        $frontend_error_levels = array(
            1  => 'ONAPP_E_FATAL',
            2  => 'ONAPP_E_WARN',
            4  => 'ONAPP_E_NOTICE',
            8  => 'ONAPP_E_INFO',
            16 => 'ONAPP_E_DEBUG'
        );

        $params = array(
                  'title'               => 'LOGS_SETTINGS',
                  'log_levels_frontend' => $frontend_error_levels,
                  'php_error_levels'    => $php_error_levels,
                  'error'               => $this->error
        );

        onapp_show_template( 'logsSettings_index', $params );
    }

    /**
     *
     *
     * @todo Add Desctiption
     *
     */
    private function update($log_settings)
    {
        $this->error = "Can't update";
/*
        if( ! isset($log_settings[third_part_product_report_enable]))
            $log_settings[third_part_product_report_enable]=0;

        if( ! isset($log_settings[wrapper_log_report_enable]))
            $log_settings[wrapper_log_report_enable]=0;

        if( ! isset($log_settings[problem_report_debug_log_enable]))
            $log_settings[problem_report_debug_log_enable]=0;

        $result = array_merge($_CONF, $log_settings);

        if( ! $result)
            die('Array merge fail on line '.__LINE__.'file '.__FILE__);

        $updated = $this->config_update($result, 'config.ini');

        if( ! $updated)
            die('Config file update error');
*/
        $this->index();
    }

    static function  access(){
        return onapp_has_permission(array('roles'));
    }
    /**
     *
     *
     * @todo Add Desctiption
     *
     */
/*
    private function config_update($config_array, $path){
       global $_ALIASES;
       $content = "";

       foreach ( $config_array as $key=>$value )
         $content .= "$key=$value"."\n";

       if (!$handle = fopen($path, 'w'))
       {
           onapp_error('COULD_NOT_UPDATE_CONFIG_FILE');
           onapp_redirect(ONAPP_BASE_URL.'/'.$_ALIASES["logs_settings"]);
       }

       if (!fwrite($handle, $content))
       {
           onapp_error('COULD_NOT_UPDATE_CONFIG_FILE');
           onapp_redirect(ONAPP_BASE_URL.'/'.$_ALIASES["logs_settings"]);
       }
       fclose($handle);

       $_SESSION['message'] = 'CONFIGURATIONS_HAVE_BEEN_UPDATED';
       onapp_redirect(ONAPP_BASE_URL.'/' .$_ALIASES["logs_settings"]);
    }
*/
}
?>
