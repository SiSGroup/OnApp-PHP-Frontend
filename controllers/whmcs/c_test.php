<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Test
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

        $postfields = array(
            'clientid' => 1,
        );

        $response = onapp_send_whmcs_api_request( ONAPP_WHMCS_LOGIN, ONAPP_WHMCS_PASSWORD, ONAPP_WHMCS_API_FILE_URL, 'getclientsdetails', $postfields );

        print('<pre>'); print_r($response); die();

        onapp_show_template(
            'test_view',
            array(
                'title'      => onapp_string('TEST_'),
                'info_title' => onapp_string('TEST_'),
                'info_body'  => onapp_string('TEST_INFO'),
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
