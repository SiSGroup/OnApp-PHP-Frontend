<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');
require_once 'c_log_settings.php';

class Frontend_Settings
{
    
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
     * 
     * Displays frontend settings page
     * 
     * @param string error message
     * @param string other message
     * @return void
     */
    private function show_template_view($error = NULL, $message = NULL)
    {
     
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
                  'title'               => 'FRONTEND_SETTINGS',
        );

        onapp_show_template( 'frontendSettings_view', $params );
        unset($_SESSION['message']);
    }

    /**
     * Displays frontend settings edit page
     *
     * @param string error message
     * @param string other message
     * @return void
     */
    private function show_template_edit($error = NULL, $message = NULL)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
                  'title'              => 'FRONTEND_SETTINGS',
                  'language_list'      => onapp_get_languageList(),
                  'templates_list'     => onapp_get_templatesList(),
                  'controllers_list'   => onapp_get_controllersList(),
        );

        onapp_show_template( 'frontendSettings_edit', $params );
    }

    /**
     * Saves frontend settings configurations
     *
     * @return void
     *
     */
    private function save()
    { 
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        
        global $_ALIASES;
        $frontend_settings = onapp_get_arg('frontend_settings');

        onapp_debug('$frontend_settings => '. print_r($frontend_settings, true));
        
        if( ! file_exists(ONAPP_PATH.ONAPP_DS.'config.ini'))
        {
            $error = 'CONFIG_FILE_DOES_NOT_EXISTS';
            $this->show_template_edit($error);
            exit;
        }
        
        $_CONF = parse_ini_file( ONAPP_PATH.ONAPP_DS.'config.ini' );
        
        // get constant string names instead of numeric values
        $log_settings = new Log_Settings;
        $current_error_levels = $log_settings->current_error_levels();
        
        foreach ($_CONF as $key => $value)
            if($key == 'log_level_php')
                $_CONF[$key] = $current_error_levels[$value];
            else if($key == 'log_level_frontend')
                $_CONF[$key] = $log_settings->frontend_error_levels[$value];
        
        onapp_debug('$_CONF => '. print_r($_CONF, true));
    
        $result = array_merge($_CONF, $frontend_settings);
        
        onapp_debug('$_CONF and $frontend_settings arrays merge => '. print_r($result, true));
        
        $updated = $this->write_config($result, ONAPP_PATH.ONAPP_DS.'config.ini');
        if( ! $result || ! $updated)
        {
            $error = 'COULD_NOT_UPDATE_CONFIG_FILE';
            $this->show_template_edit($error);
            exit;
        }

        onapp_debug('Update Success');

        $_SESSION['message'] = 'CONFIGURATIONS_HAVE_BEEN_UPDATED';
        onapp_redirect(ONAPP_BASE_URL.'/'.$_ALIASES['frontend_settings']);
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
     * Writes frontend settings changes to onapp frontend configuration file
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
