<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');
class Screens
{
    var $screen;

    /**
    * Main controller function
    *
    * @return void
    */
    public function view()
    {
        onapp_permission('roles');
        onapp_debug(__CLASS__. ' :: ' .__FUNCTION__);

        $action = onapp_get_arg('action');

        switch ( $action ) {
            case 'info' :
                $this->info();
                break;
            default :
                $this->show_template_view();
                break;
        }
    }

    /**
     * Shows view template
     * 
     * @param string error message
     * @return void
     */
    private function show_template_view($error = null) {
        onapp_debug(__CLASS__. ' :: ' .__FUNCTION__);
        onapp_permission('roles');

        $params = array(
            'title'      => onapp_string('SCREENS_'),
            'error'      => onapp_string( $error ),
            'screen_id'  => onapp_get_arg('screen_id'),
            'info_title' => onapp_string('SCREENS_'),
            'info_body'  => onapp_string('SCREEN_INFO_INFO'),
        );

        onapp_show_template( 'screen_view', $params );
    }

    /**
     * Process Screen Info
     * 
     * @return void
     */
    private function info()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_permission('roles');
        
        global $_SCREEN_IDS, $_ALIASES;

        $screen_id   = onapp_get_arg('screen_id');

        onapp_debug('$alias => '. $screen);

        if( ! in_array($screen_id, $_ALIASES) || ! is_numeric($screen_id))
        {
            $error = 'THERE_IS_NO_SUCH_SCREEN';
            onapp_notice('Screen '.$screen_id.' not found');
            $this->show_template_view($error);
        } else {
            $screen = $_SCREEN_IDS[$screen_id];
            trigger_error ( onapp_string( $error ) );
            $this->show_template_info($error, $screen);
        }
    }

    /**
     * Show info template
     * 
     * @param string error message
     * @param array screen info
     */
    private function show_template_info($error = null, $screen = null) {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_permission('roles');
        $params = array(
                  'title'      => onapp_string('SCREENS_'),
                  'screen'     => $screen,
                  'screen_id'  => onapp_get_arg('screen_id'),
                  'info_title' => onapp_string('SCREEN_INFO'),
                  'info_body'  => onapp_string('SCREEN_INFO_INFO'),
        );

        onapp_show_template( 'screen_info', $params );
    }

    /**
     * Checks role permisions for menu item
     *
     * @return void
     */
    static function  access(){
        $return = onapp_has_permission(array('roles'));
        onapp_debug('return => ' . $return);
        return $return;
    }
}
