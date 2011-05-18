<?php

if ( ! defined('BASEURL')) exit('No direct script access allowed');

class Profile
{
    public function view()
    {
        $action = onapp_get_arg('action');

        switch($action)
        {
            default:
                $this->show();
            break;
        }
    }

    private function show()
    {
        onapp_show_template(
            'profile_index',
            array('title' => 'DASHBOARD_')
        );
    }
}

?>
