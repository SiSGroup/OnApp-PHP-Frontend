<?php

if (!defined('ONAPP_PATH')) die('No direct script access allowed');

class Email_Templates {

    /**
     * Main controller function
     *
     * @return void
     */
    public function view() {
        onapp_debug(__METHOD__);

        $action = onapp_get_arg('action');

        switch ($action) {
            case 'delete':
                $this->delete( );
                break;
            case 'edit':
                $this->edit( );
                break;
            case 'create':
                $this->create( );
                break;
            default:
                $this->show_template_view( );
                break;
        }
    }

    /**
     * Displays email templates list
     *
     * @return void
     */
    private function show_template_view( $error = NULL ) {
        onapp_debug(__METHOD__);

        $events_directory = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS;

        $events_array = onapp_scan_dir($events_directory);                            // print('<pre>');print_r($events_array); die();

        foreach ($events_array as $event) {
            $events[$event] = onapp_scan_dir($events_directory . $event . ONAPP_DS . 'mail');
            if (!is_null($events[$event])) {
                $not_null = 1;
                foreach ($events[$event] as $key => $mail) {
                    $handle = @fopen($events_directory . $event . ONAPP_DS . 'mail' . ONAPP_DS . $mail, "r");
                    if ($handle) {
                        while (( $buffer = fgets($handle, 4096) ) !== false) {
                            if (preg_match("/^:template_name:/", $buffer)) {
                                $events[$event][$mail] = trim(str_replace(':template_name:', '', $buffer));
                                unset($events[$event][$key]);
                            }
                        }
                    }
                }
            }
        }                                                                                   // print('<pre>');print_r($events); die();

        if ( ! $not_null ) $events = NULL;
            
        $params = array(
            'events' => $events,
            'alias' => 'email_templates',
            'page' => $page,
            'pages_quantity' => $pages_quantity,
            'files_list' => $files_list,
            'title' => onapp_string('EMAIL_TEMPLATES'),
            'info_title' => onapp_string('EMAIL_TEMPLATES'),
            'info_body' => onapp_string('EMAIL_TEMPLATES_INFO'),
            'error' => $error,
        );
        onapp_show_template('emailTemplates_view', $params);
    }

    /**
     * Deletes the email template
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
    private function delete() {
        global $_ALIASES;

        onapp_debug(__METHOD__);
        $event = onapp_get_arg('event');
        $file_name = onapp_get_arg('file_name');

        $events_directory = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS;

        $unlinked = unlink($events_directory . $event . ONAPP_DS . 'mail' . ONAPP_DS . $file_name);

        if ($unlinked) {
            $_SESSION['message'] = 'TEMPLATE_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['email_templates'] . '?action=view');
        } else {
            $error = onapp_string('TEMPLATE_HAS_NOT_BEEN_DELETED_CHECK_EVENTS_FOLDER_PERMISSIONS');
            trigger_error($error);
            $this->show_template_view($error);
        }
    }

    /**
     * Displays mail template edit page
     *
     * @return void
     */
    public function show_template_edit( ) {
        onapp_debug(__METHOD__);

        $event = onapp_get_arg('event');
        $file_name = onapp_get_arg('file_name');

        $events_directory = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS;

        $path = $events_directory . $event . ONAPP_DS . 'mail' . ONAPP_DS . $file_name; 

        $handle = @fopen($path, "r");

        if ($handle) {
            while (( $buffer = fgets($handle, 4096) ) !== false) {
                if (preg_match("/^:from:/", $buffer)) {
                    $template_info['from'] = trim(str_replace(':from:', '', $buffer));
                }
                elseif (preg_match("/^:from_name:/", $buffer)) {
                    $template_info['from_name'] = trim(str_replace(':from_name:', '', $buffer));
                }
                elseif (preg_match("/^:to:/", $buffer)) {
                    $template_info['to'] = trim(str_replace(':to:', '', $buffer));
                }
                elseif (preg_match("/^:subject:/", $buffer)) {
                    $template_info['subject'] = trim(str_replace(':subject:', '', $buffer));
                }
                elseif (!preg_match('/^:/', $buffer)) {
                    $template_info['message'] .= $buffer;
                }
                elseif (preg_match('/^:copy/', $buffer)) {
                    $template_info['copy'] = trim(str_replace(':copy:', '', $buffer));
                }
                elseif (preg_match('/^:template_name/', $buffer)) {
                    $template_info['template_name'] = trim(str_replace(':template_name:', '', $buffer));
                }
            }
        }
        else {
            onapp_die('Unable to open file ' . $path );
        }                                                                           //print('<pre>'); print_r($template_info); die();

        $params = array(
            'events_list' => onapp_scan_dir( $events_directory ),
            'event' => $event,
            'file_name' => $file_name,
            'template_info' => $template_info,
            'title' => onapp_string('EDIT_EMAIL_TEMPLATE'),
            'info_title' => onapp_string('EDIT_EMAIL_TEMPLATE'),
            'info_body' => onapp_string('EDIT_EMAIL_TEMPLATE_INFO'),
        );

        onapp_show_template('emailTemplates_edit', $params);
    }

    /**
     * Displays mail template edit page
     *
     * @return void
     */
    public function show_template_create ( ) {
        onapp_debug(__METHOD__);

        $params = array(
            'events_list' => onapp_scan_dir( ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS ),
            'title' => onapp_string('СREATE_EMAIL_TEMPLATE'),
            'info_title' => onapp_string('CREATE_EMAIL_TEMPLATE'),
            'info_body' => onapp_string('CREATE_EMAIL_TEMPLATE_INFO'),
        );

        onapp_show_template('emailTemplates_create', $params);
    }

    /**
     * Edits mail template
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
    private function edit( ) {
        global $_ALIASES;

        onapp_debug(__METHOD__);

        $template = onapp_get_arg('template');
        $file_name = onapp_get_arg('file_name');
        $event = onapp_get_arg('event');

        $events_directory = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS;

        if (is_null($template))
            $this->show_template_edit();
        else {
            $content = 
                ":template_name:  " . $template['_template_name'] . "\n".
                ":from: ". $template['_from'] . "\n".
                ":from_name:" . $template['_from_name'] . "\n" .
                ":to:" . $template['_to'] . "\n" .
                ":copy:  " . $template['_copy'] . "\n" .
                ":subject: " . $template['_subject'] . "\n" .
                "". "\n"
                .$template['_message'] . "
            ";

            $path = $events_directory . $event . ONAPP_DS . 'mail' . ONAPP_DS . $file_name;
            chmod( $path, 0666 );
            $unlinked = unlink( $path );

            if ( $unlinked ) {
                $path = $events_directory . $template['_new_event'] . ONAPP_DS . 'mail' . ONAPP_DS .'mail';
                
                $k = 1;
                while ( file_exists( $path. $k ) ) $k++;
                
                $written = onapp_file_write( $content, NULL, $path. $k );
            }

            if ( $written ) {
                $_SESSION['message'] = 'TEMPLATE_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['email_templates'] . '?action=view');
            }
            else {
                $error = onapp_string('TEMPLATE_HAS_NOT_BEEN_UPDATED_CHECK_EVENTS_FOLDER_PERMISSIONS');
                trigger_error($error);
                $this->show_template_view($error);
            }
        }
    }

    /**
     * Creates a new mail template
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
    private function create( ) {
        global $_ALIASES;

        onapp_debug(__METHOD__);

        $template = onapp_get_arg('template');

        if (is_null($template))
            $this->show_template_create( );
        else {
            $content =
                ":template_name:  " . $template['_template_name'] . "\n".
                ":from: ". $template['_from'] . "\n".
                ":from_name:" . $template['_from_name'] . "\n" .
                ":to:" . $template['_to'] . "\n" .
                ":copy:  " . $template['_copy'] . "\n" .
                ":subject: " . $template['_subject'] . "\n" .
                "". "\n"
                .$template['_message'] . "
            ";

            $path = ONAPP_PATH . ONAPP_DS . 'events' . ONAPP_DS . $template['_new_event'] . ONAPP_DS . 'mail' . ONAPP_DS .'mail';

            $k = 1;
            while ( file_exists( $path. $k ) ) $k++;

            $written = onapp_file_write( $content, NULL, $path. $k );

            if ( $written ) {
                $_SESSION['message'] = 'TEMPLATE_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['email_templates'] . '?action=view');
            }
            else {
                $error = onapp_string('TEMPLATE_HAS_NOT_BEEN_CREATED_CHECK_EVENTS_FOLDER_PERMISSIONS');
                trigger_error($error);
                $this->show_template_view($error);
            }
        }
    }

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function access() {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        $return = onapp_has_permission(array('roles'));
        onapp_debug('return => ' . $return);
        return $return;
    }

}