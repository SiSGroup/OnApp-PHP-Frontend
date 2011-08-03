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
            case 'statistics':
                $this->show_template_statistics( $id );
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
            case 'billing_plan':
                $this->show_template_billing_plan( $id );
                break;
            case 'white_list':
                $this->show_template_white_list( $id );
                break;
            case 'white_list_create':
                $this->white_list_create( $id );
                break;
            case 'white_list_delete':
                $this->white_list_delete( $id );
                break;
            case 'white_list_edit':
                $this->white_list_edit( $id );
                break;
            case 'edit':
                $this->edit( $id );
                break;
            case 'create':
                $this->create(  );
                break;
            case 'delete':
                $this->delete( $id );
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
        //TODO
        //$billing_statistics = $onapp->factory('User_BillingStatistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);  //print('<pre>'); print_r($billing_statistics);die();
       // $billing_statistics_obj = $billing_statistics->getList( $user_obj->_id );            print('<pre>'); print_r($billing_statistics_obj);print('<pre>'); print_r($billing_statistics);die();

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment_obj = $payment->getList( $user_obj->_id );                          // print('<pre>'); print_r($payment_obj);die();
        
        $statistics = $onapp->factory('User_Statistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $statistics_obj = $statistics->getList( 1 );                                          // print('<pre>'); print_r($statistics_obj);die();
                             
        $params = array(
	    'user_statistics'   =>    $user_statistics,	
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
    * Shows user white list IP create page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_white_list_create( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('user_white_lists', 'user_white_lists.create'));

        $params = array(
            'user_id'           =>    $id,
            'title'             =>    onapp_string('ADD_NEW_WHITE_IP' ),
            'info_title'        =>    onapp_string('ADD_NEW_WHITE_IP'),
            'info_body'         =>    onapp_string('ADD_NEW_WHITE_IP_INFO'),
        );

        onapp_show_template( 'usersAndGroups_whiteListCreate', $params );
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
    * Shows user white list IP edit page
    *
    * @param integer user white list IP id
    * @return void
    */
    private function show_template_white_list_edit( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('user_white_lists', 'user_white_lists.update'));

        $user_id = onapp_get_arg( 'user_id' );

        onapp_debug( 'user_id => ' . $user_id );

        $white_list = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $white_list_obj = $white_list->load( $id, $user_id );                                          //  print('<pre>'); print_r($payment_obj);die();

        $params = array(
            'id'                =>    $id,
            'white_list_obj'    =>    $white_list_obj,
            'user_id'           =>    $user_id,
            'title'             =>    onapp_string('EDIT_WHITE_IP' ),
            'info_title'        =>    onapp_string('EDIT_WHITE_IP'),
            'info_body'         =>    onapp_string('EDIT_WHITE_IP_INFO'),
        );

        onapp_show_template( 'usersAndGroups_whiteListEdit', $params );
    }

   /**
    * Shows user profile edit page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_edit( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('users', 'users.update'));

        onapp_debug( 'user_id => ' . $user_id );

        require_once( ONAPP_PATH . ONAPP_DS . 'constants' . ONAPP_DS . 'time_zones.php');   //print('<pre>');print_r($time_zones); die();

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load( $id );                                            //print('<pre>'); print_r($user_obj);die();
        
        $role = $onapp->factory('Role', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $role_obj = $role->getList(  );                                           // print('<pre>'); print_r($role_obj);die();
        
        $billing_plans = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plans_obj = $billing_plans->getList( );                                           // print('<pre>'); print_r($billing_plans_obj);die();

        $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );                                           // print('<pre>'); print_r($billing_plan_obj);die();

        $user_group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_group_obj = $user_group->getList( );                                           // print('<pre>'); print_r($user_group_obj);die();

        foreach ( $user_obj->_roles as $role ) {
            $user_role_ids[] = $role->_id;
        }                                                                                   //  print('<pre>'); print_r($user_role_ids);die();
        
        $params = array(
            'user_id'           =>    $id,
            'user_group_obj'    =>    $user_group_obj,
            'user_role_ids'     =>    $user_role_ids,
            'role_obj'          =>    $role_obj,
            'billing_plans_obj' =>    $billing_plans_obj,
            'billing_plan_obj'  =>    $billing_plan_obj,
            'time_zones'        =>    $time_zones,
            'user_obj'          =>    $user_obj,
            'user_id'           =>    $id,
            'title'             =>    onapp_string('EDIT_USER' ),
            'info_title'        =>    onapp_string('EDIT_USER'),
            'info_body'         =>    onapp_string('EDIT_USER_INFO'),
        );

        onapp_show_template( 'usersAndGroups_edit', $params );
    }

   /**
    * Shows a new user create page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_create( )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $onapp = $this->get_factory();

        onapp_permission(array('users', 'users.create'));

        require_once( ONAPP_PATH . ONAPP_DS . 'constants' . ONAPP_DS . 'time_zones.php');   //print('<pre>');print_r($time_zones); die();

        $role = $onapp->factory('Role', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $role_obj = $role->getList(  );                                           // print('<pre>'); print_r($role_obj);die();

        $billing_plans = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plans_obj = $billing_plans->getList( );                                           // print('<pre>'); print_r($billing_plans_obj);die();

        $user_group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_group_obj = $user_group->getList( );                                           // print('<pre>'); print_r($user_group_obj);die();

        $params = array(
            'user_group_obj'    =>    $user_group_obj,
            'role_obj'          =>    $role_obj,
            'billing_plans_obj' =>    $billing_plans_obj,
            'time_zones'        =>    $time_zones,
            'title'             =>    onapp_string('ADD_A_NEW_USER' ),
            'info_title'        =>    onapp_string('ADD_A_NEW_USER'),
            'info_body'         =>    onapp_string('ADD_A_NEW_USER_INFO'),
        );

        onapp_show_template( 'usersAndGroups_create', $params );
    }

    /**
    * Shows user statistics page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_statistics( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('vm_stats', 'vm_stats.read', 'vm_stats.read.own'));

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load( $id );                                                   //print('<pre>'); print_r($user_obj);die();
        
        $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );           // print('<pre>'); print_r($billing_plan_obj);die();
        
        $statistics = $onapp->factory('User_Statistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $statistics_obj = $statistics->getList( $user_obj->_id );                                         //  print('<pre>'); print_r($statistics_obj);die();

        $vm = $onapp->factory('VirtualMachine', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        foreach ($statistics_obj[0]->_vm_stats as $v_m) {
            if ( $v_m->_virtual_machine_id != 0 ){
                $vm_obj = $vm->load($v_m->_virtual_machine_id);

                if ( $vm_obj->_label ){
                    $vm_labels[$v_m->_virtual_machine_id] = $vm_obj->_label;
                }      
            }
        }                                                                                          //   print('<pre>'); print_r($vm_labels);die();

        $params = array(
            'currency'          =>    $billing_plan_obj->_currency_code,
            'vm_labels'         =>    $vm_labels,
            'user_obj'          =>    $user_obj,
            'user_id'           =>    $id,
            'statistics_obj'    =>    $statistics_obj,
            'title'             =>    onapp_string('USER_STATISTICS' ),
            'info_title'        =>    onapp_string('USER_STATISTICS'),
            'info_body'         =>    onapp_string('USER_STATISTICS_INFO'),
        );

        onapp_show_template( 'usersAndGroups_statistics', $params );
    }

    /**
    * Shows user billing plan page
    *
    * @param integer user id
    * @return void
    */
    private function show_template_billing_plan( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('billing_plans', 'billing_plans.read', 'billing_plans.read.own'));

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user_obj = $user->load( $id );  //TODO                                                  //print('<pre>'); print_r($user_obj);die();
//**************************** Ask Liova's help ****************************************************
//
    //    $billing_plan = $onapp->factory('BillingPlan', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
    //    $billing_plan_obj = $billing_plan->load( $user_obj->_billing_plan_id );                 //   print('<pre>'); print_r($billing_plan_obj->_base_resources);die();

     //   foreach ($billing_plan_obj->_base_resources as $resource){
     //       print('<pre>');print_r( $resource );echo '<br />';
     //   } die();

//****************************************************************************************************

       // print('<pre>'); print_r($billing_plan_obj->_base_resources);die();

        $white_list = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $white_list_obj = $white_list->load(3, 38 );                   print('<pre>'); print_r($white_list_obj);die();

        $statistics = $onapp->factory('User_Statistics', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $statistics_obj = $statistics->getList( $user_obj->_id );                                         //  print('<pre>'); print_r($statistics_obj);die();

        $vm = $onapp->factory('VirtualMachine', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        foreach ($statistics_obj[0]->_vm_stats as $v_m) {
            if ( $v_m->_virtual_machine_id != 0 ){
                $vm_obj = $vm->load($v_m->_virtual_machine_id);

                if ( $vm_obj->_label ){
                    $vm_labels[$v_m->_virtual_machine_id] = $vm_obj->_label;
                }

            }
        }                                                                                          //   print('<pre>'); print_r($vm_labels);die();

        $params = array(
            'currency'          =>    $billing_plan_obj->_currency_code,
            'vm_labels'         =>    $vm_labels,
            'user_obj'          =>    $user_obj,
            'user_id'           =>    $id,
            'statistics_obj'    =>    $statistics_obj,
            'title'             =>    onapp_string('USER_STATISTICS' ),
            'info_title'        =>    onapp_string('USER_STATISTICS'),
            'info_body'         =>    onapp_string('USER_STATISTICS_INFO'),
        );

        onapp_show_template( 'usersAndGroups_statistics', $params );
    }

    /**
    * Shows user payments page
    *
    * @param string error message
    * @return void
    */
    private function show_template_white_list( $id, $error = NULL )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_debug( 'error => '. $error, 'id  =>' . $id );

        $onapp = $this->get_factory();

        onapp_permission(array('user_white_lists', 'user_white_lists.read.own', 'user_white_lists.read'));

        $white_list = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $white_list_obj = $white_list->getList( $id );                                                   //print('<pre>'); print_r($white_list_obj);die();

        $params = array(
            'user_id'           =>    $id,
            'white_list_obj'    =>    $white_list_obj,
            'title'             =>    onapp_string('WHITE_LIST_IPS_FOR_THIS_USER' ),
            'info_title'        =>    onapp_string('WHITE_LIST_IPS_FOR_THIS_USER'),
            'info_body'         =>    onapp_string('WHITE_LIST_IPS_FOR_THIS_USER_INFO'),
            'error'             =>    onapp_string( $error ),
        );

        onapp_show_template( 'usersAndGroups_whiteList', $params );
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
     * Deletes user (but not erase)
     *
     * @param integer user id
     * @return void
     */
    private function delete( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission( array('users', 'users.delete') );

        global $_ALIASES;

        $onapp = $this->get_factory();

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user->_id = $id;
      
        $user->delete( );                                                            //print('<pre>'); print_r($user);die();

        if( is_null( $user->error ))
        {
            $_SESSION['message'] = 'USER_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=view' );
        }
        else
            $this->show_template_view( $user->error );

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
     * Creates new user white list IP
     *
     * @param integer user id
     * @return void
     */
    private function white_list_create( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission(array('user_white_lists', 'user_white_lists.create'));

        $white_list = onapp_get_arg( 'white_list' );

        if( is_null ( $white_list ) ){
            $this->show_template_white_list_create( $id );}
        else
        {                                                                               //  print_r($white_list); die();
            global $_ALIASES;
            $onapp = $this->get_factory();

            $white_list_obj = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $white_list as $key => $value )
                $white_list_obj->$key = $value;                                                          // print('<pre>');print_r($payment_obj); print('</pre>'); die();

            $white_list_obj->_user_id = $id;
            $white_list_obj->save( );
                                                                                                         // print('<pre>');print_r($payment_obj); print('</pre>'); die();
            if( is_null($white_list_obj->error))
            {
                $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_CREATED';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $id  );
            }
            else
                $this->show_template_payments( $id, $white_list_obj->error);
        }
    }

    /**
     * Deletes user white list IP
     *
     * @param integer white list IP id
     * @return void
     */
    private function white_list_delete( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission(array('user_white_lists', 'user_white_lists.delete'));

        global $_ALIASES;

        $user_id = onapp_get_arg( 'user_id' );
        onapp_debug( 'user_id => '. $user_id );

        $onapp = $this->get_factory();

        $white_list = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $white_list->_id = $id;
        $white_list->_user_id = $user_id;
        $white_list->delete( );                                                       //      print('<pre>'); print_r($white_list);die();

        if( is_null( $white_list->error ))
        {
            $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_DELETED';
            onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $user_id );
        }
        else
            $this->show_template_payments( $white_list->error );

    }

    /**
     * Edits user white list IP
     *
     * @param integer user white list IP id
     * @return void
     */
    private function white_list_edit( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission(array('user_white_lists', 'user_white_lists.update'));

        $user_id = onapp_get_arg( 'user_id' );
        $white_list = onapp_get_arg( 'white_list' );

        if( is_null ( $white_list ) ){
            $this->show_template_white_list_edit( $id );}
        else
        {                                                                                // print_r($white_list); die();
            global $_ALIASES;
            $onapp = $this->get_factory();

            $white_list_obj = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $white_list as $key => $value )
                $white_list_obj->$key = $value;
                                                                                        // print('<pre>');print_r($white_list_obj); print('</pre>'); die();
            $white_list_obj->_user_id = $user_id;
            $white_list_obj->_id = $id;
            $white_list_obj->save( );
                                                                                             // print('<pre>');print_r($payment_obj); print('</pre>'); die();
            if( is_null($white_list_obj->error))
            {
                $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_UPDATED';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $user_id  );
            }
            else
                $this->show_template_payments( $user_id, $white_list_obj->error);
        }
    }

    /**
     * Edits user profile
     *
     * @param integer user id
     * @return void
     */
    private function edit( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission(array('users.update', 'users'));

        $user = onapp_get_arg( 'user' );

        if( is_null ( $user ) ){
            $this->show_template_edit( $id );}
        else
        {
            global $_ALIASES;
            $onapp = $this->get_factory();
                                                                                       //print_r($user); die();
            foreach ($user['_role_ids'] as $key => $field) {
                if ( $field == 0 ) {
                    unset($user['_role_ids'][$key]);
                }
            }                                                                         // print_r($user); die();

            $user['_role_ids'] = array_values( $user['_role_ids'] );
                                                                                        //print_r($user); die();
            $user_obj = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $user as $key => $value )
                $user_obj->$key = $value;
                                                                                      
            $user_obj->_id = $id;                                                           //  print('<pre>');print_r($user_obj); print('</pre>'); die();
            $user_obj->save( );
                                                                                            // print('<pre>');print_r($user_obj); print('</pre>'); die();
            if( is_null( $user_obj->error ) )
            {
                $_SESSION['message'] = 'USER_PROFILE_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=details&id=' . $id );
            }
            else
                $this->show_template_details( $id, $user_obj->error);
        }
    }

    /**
     * Creates a new user
     *
     * @return void
     */
    private function create(  ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        onapp_debug( 'id => '. $id );

        onapp_permission(array('users.create', 'users'));

        $user = onapp_get_arg( 'user' );

        if( is_null ( $user ) ){
            $this->show_template_create( $id );}
        else
        {
            global $_ALIASES;
            $onapp = $this->get_factory();
                                                                                      // print_r($user); die();
            foreach ($user['_role_ids'] as $key => $field) {
                if ( $field == 0 ) {
                    unset($user['_role_ids'][$key]);
                }
            }                                                                         // print_r($user); die();

            $user['_role_ids'] = array_values( $user['_role_ids'] );
                                                                                        //print_r($user); die();

            $user_obj = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach( $user as $key => $value )
                $user_obj->$key = $value;
                                                                           //  print('<pre>');print_r($user_obj); print('</pre>'); die();
            $user_obj->save( );
                                                                                            // print('<pre>');print_r($user_obj); print('</pre>'); die();
            if( is_null( $user_obj->error ) )
            {
                $_SESSION['message'] = 'USER_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect( ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=details&id=' . $user_obj->_id );
            }
            else
                $this->show_template_view( $user_obj->error );
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