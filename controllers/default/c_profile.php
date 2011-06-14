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
    private function show_template_view()
    {
        onapp_show_template(
            'profile_view',
            array('title' => 'PROFILE_')
        );
    }
}

?>
