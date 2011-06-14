<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');
require_once 'c_log_settings.php';

class Configuration
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
            default:
                 $this->show_template_view();
                break;
        }
    }
    
     /**
     * 
     * Displays configuration page
     * 
     * @return void
     */
    private function show_template_view($error = NULL, $message = NULL)
    {
     
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $log_settings = new Log_Settings;
        $params = array(
                  'title' => 'CONFIGURATION_',
                  'language_list'      => onapp_get_languageList(),
                  'templates_list'     => onapp_get_templatesList(),
                  'controllers_list'   => onapp_get_controllersList(),
                  'log_levels_frontend' => $log_settings->frontend_error_levels,
                  'php_error_levels'    => $log_settings->current_error_levels(),
        );

        onapp_show_template( 'configuration_view', $params );
    }
}
