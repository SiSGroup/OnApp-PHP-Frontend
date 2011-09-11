<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Profile
{
    /**
     * Main controller function
     * 
     * @return void
     */
    public function view()
    {
        $action = onapp_get_arg('action');

        switch($action)
        {
            default:
                $this->show_template_view();
            break;
        }
    }
    /**
     * Shows template view
     * 
     * @return void
     */
    public function show_template_view($error = NULL)
    {
        onapp_show_template(
            'profile_view',
            array(
                'title'      => onapp_string('PROFILE_'),
                'info_title' => onapp_string('PROFILE_'),
                'info_body'  => onapp_string('PROFILE_INFO'),
                'error'      => onapp_string( $error ),
                )
        );
    }

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function  access () {
        return true;
    }
}
