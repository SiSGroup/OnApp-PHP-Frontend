<?php
class Screens
{
    var $error;
    var $screen;

    /**
    * Main function
    *
    * @return void
    */
    public function view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

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
     * Show view template
     */
    private function show_template_view() {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
            'title'     => 'SCREENS_',
            'error'     => $this->error,
            'screen_id' => onapp_get_arg('screen_id')
        );

        onapp_show_template( 'screen_view', $params );
    }

    /**
     * Shows Screen Info
     *
     * @param string Screen Id
     * @return void
     */
    private function info($screen_id)
    {
        global $_SCREEN_IDS, $_ALIASES;

        $screen_id   = onapp_get_arg('screen_id');

        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug('$alias => '. $screen);

        if( ! in_array($screen_id, $_ALIASES) || ! is_numeric($screen_id))
        {
            $this->error = 'THERE_IS_NO_SUCH_SCREEN';
            onapp_notice('Screen '.$screen_id.' not found');
            $this->show_template_view();
        } else {
            $this->screen = $_SCREEN_IDS[$screen_id];
            $this->show_template_info();
        }
    }

    /**
     * Show info template
     */
    private function show_template_info() {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $params = array(
                  'title'     => 'SCREENS_',
                  'screen'    => $this->screen,
                  'screen_id' => onapp_get_arg('screen_id')
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
