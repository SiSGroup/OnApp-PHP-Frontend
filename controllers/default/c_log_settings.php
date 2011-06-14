<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Log_Settings
{
    
    public $error_levels = array(
        E_ALL                => 'E_ALL',
        E_USER_DEPRECATED    => 'E_USER_DEPRECATED',
        E_DEPRECATED         => 'E_DEPRECATED',
        E_RECOVERABLE_ERROR  => 'E_RECOVERABLE_ERROR',
        E_STRICT             => 'E_STRICT',
        E_USER_NOTICE        => 'E_USER_NOTICE',
        E_USER_WARNING       => 'E_USER_WARNING',
        E_USER_ERROR         => 'E_USER_ERROR',
        E_COMPILE_WARNING    => 'E_COMPILE_WARNING',
        E_COMPILE_ERROR      => 'E_COMPILE_ERROR',
        E_CORE_WARNING       => 'E_CORE_WARNING',
        E_CORE_ERROR         => 'E_CORE_ERROR',
        E_NOTICE             => 'E_NOTICE',
        E_PARSE              => 'E_PARSE',
        E_WARNING            => 'E_WARNING',
        E_ERROR              => 'E_ERROR'
    );
    
    public $frontend_error_levels = array(
            1  => 'ONAPP_E_FATAL',
            2  => 'ONAPP_E_WARN',
            4  => 'ONAPP_E_NOTICE',
            8  => 'ONAPP_E_INFO',
            16 => 'ONAPP_E_DEBUG'
        );
    public function current_error_levels()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        // unseting constants which are not defined in current PHP version
        foreach($this->error_levels as $key => $value)
            if( ! is_numeric($key))
                unset($this->error_levels[$key]);
        $return = $this->error_levels;
        onapp_debug('$return => '.print_r($return, true));
        return $return; 
    }
    
    /**
    * Main controller function
    *
    * @return void
    */
    public function view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $action   =  onapp_get_arg('action');

        onapp_debug('$action => '.$action);
        
        switch ($action)
        {
            case 'save':
                $this->save();
                break;
            case 'edit':
                $this->show_template_edit();
                break;
            default:
                $this->show_template_view();
                break;
        }
    }
    
     /**
     * Initializes php error levels and frontend error levels arrays
     * Displays index log settings page
     *
     * @param string error message
     * @param string success or other message     
     * @return void
     */
    private function show_template_view($error = NULL, $message = NULL)
    {
     
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
                  'title'               => 'LOG_SETTINGS',
                  'log_levels_frontend' => $this->frontend_error_levels,
                  'php_error_levels'    => $this->current_error_levels(),
                  'error'               => $error,
                  'message'             => $message,
        );

        onapp_show_template( 'logSettings_view', $params );
        unset($_SESSION['message']);
    }

    /**
     * Initializes php error levels and frontend error levels arrays
     * Displays index log settings page
     *
     * @param string error message     
     * @return void
     */
    private function show_template_edit($error = NULL)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
                  'title'               => 'LOG_SETTINGS',
                  'log_levels_frontend' => $this->frontend_error_levels,
                  'php_error_levels'    => $this->current_error_levels(),
                  'error'               => $error,
        );

        onapp_show_template( 'logSettings_edit', $params );
    }

    /**
     * Saves log settings frontend configurations
     *
     * @return void
     *
     */
    private function save()
    { 
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        
        global $_ALIASES;
        $log_settings = onapp_get_arg('log_settings');

        onapp_debug('$log_settings => '. print_r($log_settings, true));
        
        if( ! file_exists(ONAPP_PATH.ONAPP_DS.'config.ini'))
        {
            $error = 'CONFIG_FILE_DOES_NOT_EXISTS';
            $this->show_template_edit($error);
            exit;
        }
        
        $_CONF = parse_ini_file( ONAPP_PATH.ONAPP_DS.'config.ini' );
        onapp_debug('$_CONF => '. print_r($_CONF, true));
    
        $result = array_merge($_CONF, $log_settings);
        
        onapp_debug('$_CONF and $log_settings arrays merge => '. print_r($result, true));
        
        $updated = $this->write_config($result, ONAPP_PATH.ONAPP_DS.'config.ini');
        if( ! $result || ! $updated)
        {
            $error = 'COULD_NOT_UPDATE_CONFIG_FILE';
            $this->show_template_edit($error);
            exit;
        }

        onapp_debug('Update Success');

        $_SESSION['message'] = 'CONFIGURATIONS_HAVE_BEEN_UPDATED';
        onapp_redirect(ONAPP_BASE_URL.'/'.$_ALIASES['log_settings']);
    }
    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function  access(){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $return = onapp_has_permission(array('roles'));
        onapp_debug('return => '.$return);
        return $return;
    }
    /**
     * Writes log settings changes to onapp frontend configuration file
     *
     * @param array onapp frontend configurations array
     * @param string path to onapp frontend configuration file
     * @return boolean true on success
     */
    private function write_config($config_array, $path){
       onapp_debug(__CLASS__.' :: '.__FUNCTION__);
       onapp_debug('params : $config_array => '. print_r($config_array, true). '$path => '.$path );

       $content = "";

       foreach ( $config_array as $key=>$value )
         $content .= "$key=$value"."\n";

       onapp_debug('New config file content => ' .$content );
       if (!$handle = fopen($path, 'w'))
       {
           $error = 'CONFIG_FILE_NOT_WRITABLE';
           $this->show_template_view($error);
           exit;
       }

       if (!fwrite($handle, $content))
       {
           $error = 'CONFIG_FILE_NOT_WRITABLE';
           $this->show_template_view($error);
           exit;
       }
       fclose($handle);

       $return = 1;
       onapp_debug('return => ' .$return );
       return $return;
    }

}
