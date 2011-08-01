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
            case 'payment_edit':
                $this->payment_edit( $id );
                break;
            case 'payment_create': 
                $this->payment_create( $id );
                break;
            case 'payment_delete':
                $this->payment_delete( $id );
                break;
            case 'payments':
                $this->show_template_payments( $id );
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
        $user_obj = $user->load($id);                                                 //print('<pre>'); print_r($user_obj);die();

        $user_group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_group_obj = $user_group->load($user_obj->_user_group_id);                                               //  print('<pre>'); print_r($user_group_obj->_label);die();

        $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );       // print('<pre>'); print_r($billing_plan_obj);die();

                                                                                      // print('<pre>');print_r($billing_plan_obj->_base_resources); die();

        $vm = $onapp->factory('VirtualMachine', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $vm_obj = $vm->getList( $user_obj->_id );                                    // print('<pre>'); print_r($vm_obj);die();

        //$billing_statistics = $onapp->factory('User_BillingStatistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);  //print('<pre>'); print_r($billing_statistics);die();
       // $billing_statistics_obj = $billing_statistics->getList( $user_obj->_id );            print('<pre>'); print_r($billing_statistics_obj);print('<pre>'); print_r($billing_statistics);die();

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment_obj = $payment->getList( $user_obj->_id );                          // print('<pre>'); print_r($payment_obj);die();

        $statistics = $onapp->factory('User_Statistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $statistics_obj = $statistics->getList( 1 );                                   print('<pre>'); print_r($statistics_obj);die();
                             
        $params = array(
            'user_id'           =>    $user_obj->_id,
            'payment_obj'       =>    $payment_obj,
            'user_group_obj'    =>    $user_group_obj,
            'user_obj'          =>    $user_obj,
            'billing_plan_obj'  =>    $billing_plan_obj,
            'title'             =>    onapp_string('USER_INFORMATION' ),
            'info_title'        =>    onapp_string('USER_INFORMATION'),
            'info_body'         =>    onapp_string('USER_INFORMATION_INFO'),
            'error'             =>    onapp_string( $error ),
        );

        onapp_show_template( 'usersAndGroups_details', $params );
    }

   /**
    * Shows user payments page
    *
    * @param string error message
    * @return void
    */
    private function show_template_payments( $id, $error = NULL )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'error => '. $error, 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('payments', 'payments.read.own', 'payments.read'));
        
        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load( $id );                                                   //print('<pre>'); print_r($user_obj);die();

        $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );           // print('<pre>'); print_r($billing_plan_obj);die();

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment_obj = $payment->getList( $id );                                           // print('<pre>'); print_r($payment_obj);die();

        $params = array(
            'user_id'           =>    $id,
            'payment_obj'       =>    $payment_obj,
            'billing_plan_obj'  =>    $billing_plan_obj,
            'title'             =>    onapp_string('PAYMENTS_FOR_THIS_USER' ),
            'info_title'        =>    onapp_string('PAYMENTS_FOR_THIS_USER'),
            'info_body'         =>    onapp_string('PAYMENTS_FOR_THIS_USER_INFO'),
            'error'             =>    onapp_string( $error ),
        );

        onapp_show_template( 'usersAndGroups_payments', $params );
    }
    
   /**
    * Shows user payment create page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_payment_create( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('payments', 'payments.create'));
        
        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load( $id );                                                   //print('<pre>'); print_r($user_obj);die();

        $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );           // print('<pre>'); print_r($billing_plan_obj);die();

        $params = array(
            'user_obj'          =>    $user_obj,
            'user_id'           =>    $id,
            'title'             =>    onapp_string('ADD_NEW_PAYMENT' ),
            'info_title'        =>    onapp_string('ADD_NEW_PAYMENT'),
            'info_body'         =>    onapp_string('ADD_NEW_PAYMENT_INFO'),
        );
        
        onapp_show_template( 'usersAndGroups_paymentCreate', $params );
    }

   /**
    * Shows user payment edit page
    *
    * @param integer user payment id
    * @return void
    */
    private function show_template_payment_edit( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('payments', 'payments.update'));

        $user_id = onapp_get_arg( 'user_id' );

        onapp_debug( 'user_id => ' . $user_id );

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment_obj = $payment->load( $id, $user_id );                                          //  print('<pre>'); print_r($payment_obj);die();

        $params = array(
            'id'                =>    $id,
            'payment_obj'       =>    $payment_obj,
            'user_id'           =>    $user_id,
            'title'             =>    onapp_string('EDIT_PAYMENT' ),
            'info_title'        =>    onapp_string('EDIT_PAYMENT'),
            'info_body'         =>    onapp_string('EDIT_PAYMENT_INFO'),
        );

        onapp_show_template( 'usersAndGroups_paymentEdit', $params );
    }


    /**
     * Deletes user payment
     *
     * @param integer user payment id
     * @return void
     */
    private function payment_delete( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission( array('payments', 'payments.delete') );

        global $_ALIASES;

        $user_id = onapp_get_arg( 'user_id' );
        onapp_debug( 'user_id => '. $user_id );
        
        $onapp = $this->get_factory();

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment->_id = $id;
        $payment->_user_id = $user_id;
        $payment->delete( );                                                       //      print('<pre>'); print_r($payment);die();

        if( is_null( $payment->error ))
        {
            $_SESSION['message'] = 'PAYMENT_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $user_id );
        }
        else
            $this->show_template_payments( $payment->error );

    }

    /**
     * Creates new user payment
     *
     * @param integer user id
     * @return void
     */
    private function payment_create( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission( array('payments', 'payments.create') );

        $payment = onapp_get_arg( 'payment' );

        if( is_null ( $payment ) ){
            $this->show_template_payment_create( $id );}
        else
        {                                                                                // print_r($payment); die();
            global $_ALIASES;
            $onapp = $this->get_factory();

            $payment_obj = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $payment as $key => $value )
                $payment_obj->$key = $value;                                                          // print('<pre>');print_r($payment_obj); print('</pre>'); die();

            $payment_obj->_user_id = $id;
            $payment_obj->save( );
                                                                                             // print('<pre>');print_r($payment_obj); print('</pre>'); die();
            if( is_null($payment_obj->error))
            {
                $_SESSION['message'] = 'PAYMENT_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $id  );
            }
            else
                $this->show_template_payments( $id, $payment_obj->error);
        }

    }

    /**
     * Edits user payment
     *
     * @param integer user payment id
     * @return void
     */
    private function payment_edit( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission( array('payments', 'payments.create') );

        $user_id = onapp_get_arg( 'user_id' );
        $payment = onapp_get_arg( 'payment' );

        if( is_null ( $payment ) ){
            $this->show_template_payment_edit( $id );}
        else
        {                                                                                // print_r($payment); die();
            global $_ALIASES;
            $onapp = $this->get_factory();

            $payment_obj = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $payment as $key => $value )
                $payment_obj->$key = $value;
                                                                                        // print('<pre>');print_r($payment_obj); print('</pre>'); die();
            $payment_obj->_user_id = $user_id;
            $payment_obj->_id = $id;
            $payment_obj->save( );
                                                                                             // print('<pre>');print_r($payment_obj); print('</pre>'); die();
            if( is_null($payment_obj->error))
            {
                $_SESSION['message'] = 'PAYMENT_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $user_id  );
            }
            else
                $this->show_template_payments( $user_id, $payment_obj->error);
        }

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
   
