<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Base_Settings
{
//    private $template = array(
//        'edit' => 'logSettings_edit',
//        'view' => 'logSettings_view',
//        title   => 'title'
//    );

    /**
     * Main controller function
     *
     * @return void
     */
    public function view()
    {
        onapp_permission('roles');
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
    private function show_template_view($message = NULL)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_permission('roles');

        $params = array(
            'title'               => onapp_string( $this->config['title'] ),
            'log_levels_frontend' => onapp_get_frontend_errors(),
            'php_error_levels'    => onapp_get_php_errors(),
            'message'             => onapp_string( $message ),
            'config'              => parse_ini_file( ONAPP_PATH.ONAPP_DS.'config.ini' ),
            'template'            => $this->config['template'],
            'info_title'          => onapp_string( $this->config['info_title'] ),
            'info_body'           => onapp_string( $this->config['info_body'] ),
            
        );

        if( $this->config['template'] == NULL)
                onapp_die('No config[template] exists');
        onapp_show_template( 'configuration_view', $params );
    }

    /**
     * Initializes php error levels and frontend error levels arrays
     * Displays index log settings page
     *
     * @param string error message
     * @return void
     */
    private function show_template_edit( $error = NULL )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $params = array(
            'title'               => onapp_string( $this->config['title'] ),
            'log_levels_frontend' => onapp_get_frontend_errors(),
            'php_error_levels'    => onapp_get_php_errors(),
            'error'               => onapp_string( $error ),
            'language_list'       => onapp_get_dir_list('lang'),
            'templates_list'      => onapp_get_dir_list(ONAPP_SMARTY_TEMPLATE_DIR),
            'controllers_list'    => onapp_get_dir_list('controllers'),
            'template'            => $this->config['template'],
            'info_title'          => onapp_string( 'EDIT_'.$this->config['info_title'] ),
            'info_body'           => onapp_string( 'EDIT_'.$this->config['info_body'] ),

        );

//TODO check is variable $this->template['edit'] defined
        onapp_show_template( $this->config['template'].'_edit', $params );
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
        
        $settings = onapp_get_arg('settings');

        onapp_debug('save: $settings => '. print_r($settings, true));

        if( file_exists(ONAPP_PATH.ONAPP_DS.'config.ini') )
        {
            $conf = parse_ini_file( ONAPP_PATH.ONAPP_DS.'config.ini' );
            onapp_debug('$conf => '. print_r($conf, true));
            
            // get constant string names instead of numeric values
            $frontend_error_levels = onapp_get_frontend_errors();
            $php_error_levels      = onapp_get_php_errors();
            foreach ($conf as $key => $value)
            if($key == 'log_level_php')
                $conf[$key] = $php_error_levels[$value];
            else if($key == 'log_level_frontend')
                $conf[$key] = $frontend_error_levels[$value];

            $result = array_merge($conf, $settings);

            if ( ! $result )
                $error = 'COULD_NOT_UPDATE_CONFIG_FILE';
            else {
                onapp_debug('$conf and $settings arrays merge => '. print_r($result, true));

                $updated = $this->write_config($result, ONAPP_PATH.ONAPP_DS.'config.ini');

                if ( ! is_null($updated) )
                    $error = $updated;
            }

            if( ! isset( $error ) )
                onapp_debug('Update Success');
        } else {
            $error = 'CONFIG_FILE_DOES_NOT_EXISTS';
        }

        if ( ! isset($error) )
            $this->show_template_view( 'CONFIGURATIONS_HAVE_BEEN_UPDATED' );
        else {
            trigger_error ( onapp_string($error ) );
            $this->show_template_edit( $error );
        }
    }

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function  access(){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $return = onapp_has_permission( array( 'roles' ) );
        onapp_debug( 'return => '.$return );
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

       $content = '';
       foreach ( $config_array as $key=>$value )
         $content .= "$key=$value"."\n";

       onapp_debug('New config file content => ' .$content );

       if ( !$handle = fopen($path, 'w') )
           $error = 'CONFIG_FILE_NOT_WRITABLE';
       else if ( ! fwrite($handle, $content) )
           $error = 'CONFIG_FILE_NOT_WRITABLE';
       else
           fclose($handle);

       if ( isset( $error ) )
           return $error;
    }
}