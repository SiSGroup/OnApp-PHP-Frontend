<?php
class Users_and_Groups
{
    private $factory_instance;

    private function get_factory() {
        if ( !isset($this->factory_instance) ) {
            require_once "wrapper/Factory.php";

            $this->factory_instance = new ONAPP_Factory(
                $_SESSION["host"],
                $_SESSION["login"],
                onapp_cryptData($_SESSION["password"], 'decrypt')
            );
       }
       return $this->factory_instance;
   }

   /**
    * Main controller function
    *
    * @return void
    */
    public function view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $id                 = onapp_get_arg('id');
        $action             = onapp_get_arg('action');

        onapp_debug('id => '. $id .' action => ' . $action);

        switch($action)
        {
            case 'details':
                $this->show_template_details( $id );
                break;
            default:
                $this->show_template_view();
                break;
        }
    }

   /**
    * Displays default page with users list
    *
    * @param string error message
    * @return void
    */
    private function show_template_view($error = NULL)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'error => '. $error );

        $onapp = $this->get_factory();

        onapp_permission(array('users', 'users.read.own', 'users.read'));

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->getList();                                               //   print('<pre>'); print_r($user_obj);die();

        foreach ( $user_obj as $user) {
            $user_group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            if( $user->_user_group_id ) {
                $user_group_obj = $user_group->load($user->_user_group_id);
                $user_group_labels[$user->_id] = $user_group_obj->_label;
            }
        }                                                                              //   print('<pre>'); print_r($user_group_labels);die();

       $params = array(
           'user_group_labels' =>    $user_group_labels,
           'user_obj'          =>    $user_obj,
           'title'             =>    onapp_string('USERS_' ),
           'info_title'        =>    onapp_string('USERS_AND_GROUPS'),
           'info_body'         =>    onapp_string('USERS_AND_GROUPS_INFO'),
           'error'             =>    onapp_string( $error ),
           'message'           =>    onapp_string( $message )
       );

       onapp_show_template( 'usersAndGroups_view', $params );
     }
     
   /**
    * Displays particular user details page
    *
    * @param string error message
    * @return void
    */
    private function show_template_details( $id, $error = NULL )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'error => '. $error );

        $onapp = $this->get_factory();

        onapp_permission(array('users', 'users.read.own', 'users.read'));

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load($id);                                              //   print('<pre>'); print_r($user_obj);die();

       $params = array(
           'user_obj'          =>    $user_obj,
           'title'             =>    onapp_string('USER_INFORMATION' ),
           'info_title'        =>    onapp_string('USER_INFORMATION'),
           'info_body'         =>    onapp_string('USER_INFORMATION_INFO'),
           'error'             =>    onapp_string( $error ),
       );

       onapp_show_template( 'usersAndGroups_details', $params );
     }



   /**
     * Checks necessary access to this class
     *
     * @return boolean [true|false]
     */
     static function  access(){
        return onapp_has_permission(array('virtual_machines', 'virtual_machines.read.own'));
    }
}
   
