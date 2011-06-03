<?php 
class Screens
{
    public function view()
    {
        $action     = onapp_get_arg('action');
        $screen_id     = onapp_get_arg('screen_id');



        switch($action)
        {
            case 'screen_info': 
                $this->screen_info($screen_id);
            break;
            default:
                 $this->screen_index();
            break;
        }
    }

    private function screen_index()
    {
        $params = array(
                  'title'             =>    'SCREENS_'
        );

        onapp_show_template( 'screen_index', $params );
    }

    private function screen_info($screen_id)
    {
        global $_SCREEN_IDS;
        global $_ALIASES;
        $error = 'THERE_IS_NO_SUCH_SCREEN';
        if( ! in_array($screen_id, $_ALIASES) || ! is_numeric($screen_id))
            onapp_redirect(ONAPP_BASE_URL.'/'.($_ALIASES["screens"]).'?error='.$error.'&message='.$msg);

        $alias = array_search($screen_id, $_ALIASES);
       
        $params = array(
                  'title'             =>    'SCREEN_INFO',
                  'screen_id'         =>    $screen_id,
                  'screen_alias'      =>    $alias,
                  'screen_class'      =>    $_SCREEN_IDS[$screen_id]['class'],
                  'screen_method'     =>    $_SCREEN_IDS[$screen_id]['method'],
        );

        onapp_show_template( 'screen_info', $params );
    }

    static function  access(){
        return onapp_has_permission(array('roles'));
    }
}

?>
