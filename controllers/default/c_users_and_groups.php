<?php

require_once( ONAPP_PATH . ONAPP_DS . 'controllers' . ONAPP_DS . ONAPP_CONTROLLERS . ONAPP_DS . 'controller.php');

class Users_and_Groups extends Controller {

    /**
     * Main controller function
     *
     * @return void
     */
    public function view() {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        $id = onapp_get_arg('id');
        $action = onapp_get_arg('action');

        onapp_debug('id => ' . $id . ' action => ' . $action);

        switch ($action) {
            case 'details':
                $this->show_template_details($id);
                break;
            case 'statistics':
                $this->show_template_statistics($id);
                break;
            case 'payment_edit':
                $this->payment_edit($id);
                break;
            case 'payment_create':
                $this->payment_create($id);
                break;
            case 'payment_delete':
                $this->payment_delete($id);
                break;
            case 'payments':
                $this->show_template_payments($id);
                break;
            case 'billing_plan':
                $this->show_template_billing_plan($id);
                break;
            case 'white_list':
                $this->show_template_white_list($id);
                break;
            case 'white_list_create':
                $this->white_list_create($id);
                break;
            case 'white_list_delete':
                $this->white_list_delete($id);
                break;
            case 'white_list_edit':
                $this->white_list_edit($id);
                break;
            case 'edit':
                $this->edit($id);
                break;
            case 'create':
                $this->create();
                break;
            case 'delete':
                $this->delete($id);
                break;
            case 'suspend':
                $this->suspend($id);
                break;
            case 'activate':
                $this->activate($id);
                break;
            case 'monthly_bills':
                $this->show_template_monthly_bills( $id );
                break;
            case 'groups':
                $this->show_template_groups(  );
                break;
            case 'group_delete':
                $this->group_delete( $id );
                break;
            case 'group_create':
                $this->group_create(  );
                break;
            case 'group_edit':
                $this->group_edit( $id );
                break;
            case 'roles':
                $this->show_template_roles(  );
                break;
            case 'role_edit':
                $this->role_edit( $id );
                break;
            case 'role_delete':
                $this->role_delete( $id );
                break;
            case 'role_create':
                $this->role_create(  );
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
    private function show_template_view( $error = NULL ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug( 'error => ' . print_r( $error, true ) );

        $onapp = $this->get_factory();
         
        onapp_permission(array('users', 'users.read.own', 'users.read'));

        $user_obj = $this->getList('User');

        foreach ($user_obj as $user) {
            $user_group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            if ($user->_user_group_id) {
                $user_group_obj = $user_group->load($user->_user_group_id);
                $user_group_labels[$user->_id] = $user_group_obj->_label;
            }
        }                                                                              

        $params = array(
            'user_group_labels' => $user_group_labels,
            'user_obj' => $user_obj,
            'title' => onapp_string('USERS_'),
            'info_title' => onapp_string('USERS_AND_GROUPS'),
            'info_body' => onapp_string('USERS_AND_GROUPS_INFO'),
            'error' => $error,
        );
        onapp_show_template('usersAndGroups_view', $params);
    }

    /**
     * Displays particular user details page
     *
     * @param string error message
     * @return void
     */
    private function show_template_details($id, $error = NULL) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('error => ' .  print_r( $error, true)  );

        onapp_permission(array('users', 'users.read.own', 'users.read'));

        $user_obj = $this->load('User', array($id) );

        if( $user_obj->_user_group_id ) {
            $user_group_obj = $this->load('UserGroup', array($user_obj->_user_group_id) );
        }
        else {
            $user_group_obj = NULL;
        }
        //TODO Add resource table Ticket #

        $params = array(
            'user_id' => $user_obj->_id,
            'payment_obj' => $this->getList('Payment', array($user_obj->_id)),
            'user_group_obj' => $user_group_obj,
            'user_obj' => $user_obj,
            'billing_plan_obj' => $this->load('BillingPlan', array($user_obj->_billing_plan_id)),
            'title' => onapp_string('USER_INFORMATION'),
            'info_title' => onapp_string('USER_INFORMATION'),
            'info_body' => onapp_string('USER_INFORMATION_INFO'),
            'error' => $error,
        );

        onapp_show_template('usersAndGroups_details', $params);
    }

    /**
     * Shows user payments page
     *
     * @param string error message
     * @return void
     */
    private function show_template_payments($id, $error = NULL) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('error => ' . print_r( $error, true) . 'id  =>' . $id);

        onapp_permission(array('payments', 'payments.read.own', 'payments.read'));

        $user_obj = $this->load('User', array($id));

        $params = array(
            'user_id' => $id,
            'payment_obj' => $this->getList('Payment', array($id)),
            'billing_plan_obj' => $this->load('BillingPlan', array($user_obj->_billing_plan_id)),
            'title' => onapp_string('PAYMENTS_FOR_THIS_USER'),
            'info_title' => onapp_string('PAYMENTS_FOR_THIS_USER'),
            'info_body' => onapp_string('PAYMENTS_FOR_THIS_USER_INFO'),
            'error' => $error,
        );
        onapp_show_template('usersAndGroups_payments', $params);
    }

    /**
     * Shows user roles page
     *
     * @param string error message
     * @return void
     */
    private function show_template_roles( $error = NULL ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('error => ' . print_r( $error, true ) );

        onapp_permission(array('roles', 'roles.read.own', 'roles.read'));

        $params = array(
            'roles_obj' => $this->getList( 'Role' ),
            'title' => onapp_string('ROLES_'),
            'info_title' => onapp_string('ROLES_'),
            'info_body' => onapp_string('ROLES_INFO'),
            'error' => $error,
        );
        onapp_show_template('usersAndGroups_roles', $params);
    }

    /**
     * Shows user payment create page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_payment_create($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('payments', 'payments.create'));

        $params = array(
            'user_obj' => $this->load('User', array($id)),
            'user_id' => $id,
            'title' => onapp_string('ADD_NEW_PAYMENT'),
            'info_title' => onapp_string('ADD_NEW_PAYMENT'),
            'info_body' => onapp_string('ADD_NEW_PAYMENT_INFO'),
        );
        onapp_show_template('usersAndGroups_paymentCreate', $params);
    }

    /**
     * Shows user role create page
     *
     * @return void
     */
    private function show_template_role_create(  ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission( array ( 'roles', 'roles.create' ) );

        $permission_obj = $this->getList( 'Role_Permission' );

        foreach ( $permission_obj as $permission) {
            $permission_array [$permission->_id] = array( '_label' => $permission->_label, 'identifier' => $permission->_identifier, 'id' => $permission->_id ) ;
        }
                                                                                   
        $items_per_page = 15;

        $params = array(
            'checked_role_ids_js' => json_encode( array() ),
            'items_per_page' => $items_per_page,
            'pages_quantity' => round( count( $permission_obj ) / $items_per_page ) ,
            'permission_array' => json_encode( $permission_array ),
            'title' => onapp_string('CREATE_NEW_ROLE'),
            'info_title' => onapp_string('CREATE_NEW_ROLE'),
            'info_body' => onapp_string('CREATE_NEW_ROLE_INFO'),
        );
        onapp_show_template('usersAndGroups_roleCreate', $params);
    }
   

    /**
     * Shows user group create page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_group_create( ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission(array('groups', 'groups.create'));

        $params = array(
            'title' => onapp_string('ADD_A_NEW_USER_GROUP'),
            'info_title' => onapp_string('ADD_A_NEW_USER_GROUP'),
            'info_body' => onapp_string('ADD_A_NEW_USER_GROUP_INFO'),
        );
        onapp_show_template('usersAndGroups_groupCreate', $params);
    }

    /**
     * Shows user groups page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_groups( $error =  NULL ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission( array( 'groups', 'groups.read', 'groups.read.own' ) );

        $onapp = $this->get_factory();

        $user_group_obj = $this->getList( 'UserGroup');

        $user =  $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        foreach ( $user_group_obj as $group ) {
            $user_obj = $user->getListByGroupId( $group->_id );   
            if ( $user_obj[0] ) {
                $group_users_quantity [$group->_id] = count($user_obj);
            }
            else {
                $group_users_quantity [$group->_id] = 0;
            }    
        }      
                                                                                       
        $params = array(
           'group_users_quantity' => $group_users_quantity,
           'user_groups_obj' => $user_group_obj,
           'title' => onapp_string('USER_GROUPS'),
           'info_title' => onapp_string('USER_GROUPS'),
           'info_body' => onapp_string('USER_GROUPS_INFO'),
           'error'=> $error,
        );
        onapp_show_template('usersAndGroups_groups', $params);
    }

    /**
     * Shows user white list IP create page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_white_list_create($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.create'));

        $params = array(
            'user_id' => $id,
            'title' => onapp_string('ADD_NEW_WHITE_IP'),
            'info_title' => onapp_string('ADD_NEW_WHITE_IP'),
            'info_body' => onapp_string('ADD_NEW_WHITE_IP_INFO'),
        );
        onapp_show_template('usersAndGroups_whiteListCreate', $params);
    }
    
    /**
     * Shows user monthly bills page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_monthly_bills( $id ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission( array( 'monthly_bills', 'monthly_bills.read.own', 'monthly_bills.read'));

        $monthes = array (
            '1' => 'JANUARY_',
            '2' => 'FABRUARY_',
            '3' => 'MARCH_',
            '4' => 'APRIL_',
            '5' => 'MAY_',
            '6' => 'JUNE_',
            '7' => 'JULY_',
            '8' => 'AUGUST_',
            '9' => 'SEPTEMBER_',
            '10' => 'OCTOBER_',
            '11' => 'NOVEMBER_',
            '12' => 'DECEMBER_',
        );

        $user_obj = $this->load( 'User', array( $id) );

        $monthly_bills_obj = $this->getList( 'User_MonthlyBill', array( $id ) );

        $total_amount = 0;
        foreach ($monthly_bills_obj as $bill) {
            $total_amount += $bill->_cost;
        }                                                   

        $params = array(
            'total_amount' => $total_amount,
            'monthes' => $monthes,
            'user_obj' => $user_obj,
            'user_id' => $id,
            'billing_plan_obj' => $this->load( 'BillingPlan', array( $user_obj->_billing_plan_id ) ),
            'monthly_bills_obj' => $monthly_bills_obj,
            'title' => onapp_string('YEARLY_USER_BILLS_PER_A_MONTH'),
            'info_title' => onapp_string('YEARLY_USER_BILLS_PER_A_MONTH'),
            'info_body' => onapp_string('YEARLY_USER_BILLS_PER_A_MONTH'),
        );
        onapp_show_template('usersAndGroups_monthlyBills', $params);
    }

    /**
     * Shows user payment edit page
     *
     * @param integer user payment id
     * @return void
     */
    private function show_template_payment_edit($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('payments', 'payments.update'));

        $user_id = onapp_get_arg('user_id');

        onapp_debug('user_id => ' . $user_id);

        $params = array(
            'user_obj'=> $this->load( 'User', array( $id ) ),
            'id' => $id,
            'payment_obj' => $this->load('Payment', array($id, $user_id)),
            'user_id' => $user_id,
            'title' => onapp_string('EDIT_PAYMENT'),
            'info_title' => onapp_string('EDIT_PAYMENT'),
            'info_body' => onapp_string('EDIT_PAYMENT_INFO'),
        );
        onapp_show_template('usersAndGroups_paymentEdit', $params);
    }

    /**
     * Shows user role edit page
     *
     * @param integer user role id
     * @return void
     */
    private function show_template_role_edit( $id ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('roles', 'roles.update'));

        $role_obj = $this->load('Role', array( $id ) );                  

        foreach ( $role_obj->_permissions as $permission ) {
            $checked_role_ids [] = $permission->_id;
        }                                                                   

        $permission_obj = $this->getList( 'Role_Permission' );

        foreach ( $permission_obj as $permission) {
            $permission_array [$permission->_id] = array( '_label' => $permission->_label, 'identifier' => $permission->_identifier, 'id' => $permission->_id ) ;
        }
                                                                                  
        $items_per_page = 15;

        $params = array(
            'items_per_page' => $items_per_page,
            'pages_quantity' => round( count( $permission_obj ) / $items_per_page ) ,
            'permission_array' => json_encode( $permission_array ),
            'role_obj' => $role_obj,
            'checked_role_ids_js' => json_encode( $checked_role_ids ),
            'id' => $id,
            'title' => onapp_string('EDIT_ROLE'),
            'info_title' => onapp_string('EDIT_ROLE'),
            'info_body' => onapp_string('EDIT_ROLE_INFO'),
        );
        onapp_show_template('usersAndGroups_roleEdit', $params);
    }

    /**
     * Shows user group edit page
     *
     * @param integer user group id
     * @return void
     */
    private function show_template_group_edit($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('groups', 'groups.update'));

        $params = array(
            'id' => $id,
            'group_obj' => $this->load('UserGroup', array( $id ) ),
            'title' => onapp_string('EDIT_USER_GROUP'),
            'info_title' => onapp_string('EDIT_USER_GROUP'),
            'info_body' => onapp_string('EDIT_USER_GROUP_INFO'),
        );
        onapp_show_template('usersAndGroups_groupEdit', $params);
    }

    /**
     * Shows user white list IP edit page
     *
     * @param integer user white list IP id
     * @return void
     */
    private function show_template_white_list_edit($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.update'));

        $user_id = onapp_get_arg('user_id');

        onapp_debug('user_id => ' . $user_id);

        $params = array(
            'id' => $id,
            'white_list_obj' => $this->load('User_WhiteList', array($id, $user_id)),
            'user_id' => $user_id,
            'title' => onapp_string('EDIT_WHITE_IP'),
            'info_title' => onapp_string('EDIT_WHITE_IP'),
            'info_body' => onapp_string('EDIT_WHITE_IP_INFO'),
        );
        onapp_show_template('usersAndGroups_whiteListEdit', $params);
    }

    /**
     * Shows user profile edit page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_edit($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        onapp_permission(array('users', 'users.update'));

        require_once( ONAPP_PATH . ONAPP_DS . 'constants' . ONAPP_DS . 'time_zones.php');

        $user_obj = $this->load('User', array($id));

        foreach ($user_obj->_roles as $role) {
            $user_role_ids[] = $role->_id;
        }
        
        $params = array(
            'user_id' => $id,
            'user_group_obj' => $this->getList('UserGroup'),
            'user_role_ids' => $user_role_ids,
            'role_obj' => $this->getList('Role'),
            'billing_plans_obj' => $this->getList('BillingPlan'),
            'billing_plan_obj' => $this->load('BillingPlan', array($user_obj->_billing_plan_id)),
            'time_zones' => $time_zones,
            'user_obj' => $user_obj,
            'user_id' => $id,
            'title' => onapp_string('EDIT_USER'),
            'info_title' => onapp_string('EDIT_USER'),
            'info_body' => onapp_string('EDIT_USER_INFO'),
        );
        onapp_show_template('usersAndGroups_edit', $params);
    }

    /**
     * Shows a new user create page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_create() {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission(array('users', 'users.create'));

        require_once( ONAPP_PATH . ONAPP_DS . 'constants' . ONAPP_DS . 'time_zones.php');

        $params = array(
            'user_group_obj' => $this->getList('UserGroup'),
            'role_obj' => $this->getList('Role'),
            'billing_plans_obj' => $this->getList('BillingPlan'),
            'time_zones' => $time_zones,
            'title' => onapp_string('ADD_A_NEW_USER'),
            'info_title' => onapp_string('ADD_A_NEW_USER'),
            'info_body' => onapp_string('ADD_A_NEW_USER_INFO'),
        );
        onapp_show_template('usersAndGroups_create', $params);
    }

    /**
     * Shows user statistics page
     *
     * @param integer user id
     * @return void
     */
    private function show_template_statistics($id) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('id  =>' . $id);

        $onapp = $this->get_factory();

        onapp_permission(array('vm_stats', 'vm_stats.read', 'vm_stats.read.own'));

        $user_obj = $this->load('User', array($id));

        $statistics_obj = $this->getList('User_Statistics', array($id));

        $billing_plan_obj = $this->load('BillingPlan', array($user_obj->_billing_plan_id));

        $user_vms = $this->getList('VirtualMachine', array( $id ) );                          

        foreach ( $user_vms as $virtual_machine ) {
            $vm_ids [$virtual_machine->_id] = $virtual_machine->_label;
        }                                                                                     

        $vm = $onapp->factory('VirtualMachine', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        foreach ($statistics_obj[0]->_vm_stats as $v_m) {
            if ( array_key_exists ( $v_m->_virtual_machine_id, $vm_ids ) ) {
                $vm_labels[$v_m->_virtual_machine_id] = $vm_ids[$v_m->_virtual_machine_id];
            }
            else {
                $vm_labels[$v_m->_virtual_machine_id] = 0;
            }
        }                                                                                   

        $params = array(
            'billing_plan_obj' => $billing_plan_obj,
            'vm_labels' => $vm_labels,
            'user_obj' => $user_obj,
            'user_id' => $id,
            'statistics_obj' => $statistics_obj,
            'title' => onapp_string('USER_STATISTICS'),
            'info_title' => onapp_string('USER_STATISTICS'),
            'info_body' => onapp_string('USER_STATISTICS_INFO'),
        );
        onapp_show_template('usersAndGroups_statistics', $params);
    }

    /**
     * Shows user payments page
     *
     * @global array $_ALIASES menu page aliases
     * @param string error message
     * @return void
     */
    private function show_template_white_list($id, $error = NULL) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('error => ' . print_r( $error, true) . ', id  =>' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.read.own', 'user_white_lists.read'));

        $params = array(
            'user_id' => $id,
            'white_list_obj' => $this->getList('User_WhiteList', array($id)),
            'title' => onapp_string('WHITE_LIST_IPS_FOR_THIS_USER'),
            'info_title' => onapp_string('WHITE_LIST_IPS_FOR_THIS_USER'),
            'info_body' => onapp_string('WHITE_LIST_IPS_FOR_THIS_USER_INFO'),
            'error' => $error,
        );
        onapp_show_template('usersAndGroups_whiteList', $params);
    }

    /**
     * Deletes user payment
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user payment id
     * @return void
     */
    private function payment_delete( $id ) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('payments', 'payments.delete'));

        $user_id = onapp_get_arg('user_id');
        onapp_debug('user_id => ' . $user_id);

        $onapp = $this->get_factory();

        $payment = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $payment->_id = $id;
        $payment->_user_id = $user_id;
        $payment->delete();
        onapp_debug( 'payment =>' . print_r( $payment, true ) );

        if (is_null($payment->error)) {
            $_SESSION['message'] = 'PAYMENT_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $user_id);
        }
        else {
            trigger_error ( print_r( $payment_obj->error, true ) );
            $this->show_template_payments($payment->error);
        }
    }

    /**
     * Deletes user role
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user role id
     * @return void
     */
    private function role_delete( $id ) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('roles', 'roles.delete'));

        $onapp = $this->get_factory();

        $role = $onapp->factory( 'Role', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $role->_id = $id;
        $role->delete();
        onapp_debug( 'role =>' . print_r( $role, true ) );

        if ( is_null( $role->error ) ) {
            $_SESSION['message'] = 'ROLE_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=roles' );
        }
        else {
            trigger_error ( print_r( $role->error, true ) );
            $this->show_template_roles( $role->error );
        }
    }

    /**
     * Deletes user group
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user group id
     * @return void
     */
    private function group_delete ( $id ) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('groups', 'groups.delete'));

        $onapp = $this->get_factory();

        $group = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $group->_id = $id;
        $group->delete();
        onapp_debug( 'group =>' . print_r( $group, true ) );

        if (is_null($group->error)) {
            $_SESSION['message'] = 'GROUP_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=groups' );
        }
        else {
            trigger_error ( print_r( $group->error, true ) );
            $this->show_template_groups($group->error);
        }
    }

    /**
     * Deletes user (erase completly when user for the second time)
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function delete($id) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('users', 'users.delete'));

        $onapp = $this->get_factory();

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user->_id = $id;
        $user->delete();
        onapp_debug( 'user =>' . print_r( $user, true ) );

        if (is_null($user->error)) {
            $_SESSION['message'] = 'USER_HAS_BEEN_DELETED_SUCCESSFULLY';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=view');
        }
        else {
            trigger_error ( print_r( $user->error, true ) );
            $this->show_template_view($user->error);
        }
    }

    /**
     * Suspends user
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function suspend($id) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('users', 'users.suspend'));

        $onapp = $this->get_factory();

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user->_id = $id;
        $user->suspend();
        onapp_debug( 'suspend =>' . print_r( $suspend, true ) );

        if (is_null($user->error)) {
            $_SESSION['message'] = 'USER_STATUS_CHANGED_TO_SUSPENDED';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=view');
        }
        else {
            trigger_error ( print_r( $user->error, true ) );
            $this->show_template_view($user->error);
        }
    }

    /**
     * Activates user
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function activate($id) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('users', 'users.activate'));

        $onapp = $this->get_factory();

        $user = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $user->_id = $id;
        $user->activate_user();
        onapp_debug( 'user =>' . print_r( $user, true ) );

        if (is_null($user->error)) {
            $_SESSION['message'] = 'USER_ACTIVATION_SUCCESSFULL';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=view');
        }
        else {
            trigger_error ( print_r( $user->error, true ) );
            $this->show_template_view($user->error);
        }
    }

    /**
     * Creates new user payment
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function payment_create( $id ) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('payments', 'payments.create'));

        $payment = onapp_get_arg('payment');

        if (is_null($payment)) {
            $this->show_template_payment_create($id);
        } else {                                                                               
            $onapp = $this->get_factory();

            $payment_obj = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($payment as $key => $value)
                $payment_obj->$key = $value;                                                         

            $payment_obj->_user_id = $id;
            $payment_obj->save();
            onapp_debug( 'payment_obj =>' . print_r( $payment_obj, true ) );

            if (is_null($payment_obj->error)) {
                $_SESSION['message'] = 'PAYMENT_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $id);
            }
            else {
                trigger_error ( print_r( $payment_obj->error, true ) );
                $this->show_template_payments($id, $payment_obj->error);
            }
        }
    }

    /**
     * Creates new user role
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
    private function role_create(  ) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission( array( 'roles', 'roles.create' ) );

        $role = onapp_get_arg( 'role' );

        if ( is_null( $role ) ) {
            $this->show_template_role_create(  );
        } else {
            
            foreach ( $role['_permission_ids'] as $key => $field) {
                if ($field == 0) {
                    unset($role['_permission_ids'][$key]);
                }
            }

            $role['_permission_ids'] = array_values( $role['_permission_ids'] );                                                                         
            $onapp = $this->get_factory();

            $role_obj = $onapp->factory('Role', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($role as $key => $value)
                $role_obj->$key = $value;
                                                                                        
            $role_obj->save();
            onapp_debug( 'role_obj =>' . print_r( $role_obj, true ) );
                                                                                              
            if ( is_null($role_obj->error) ) {
                $_SESSION['message'] = 'ROLE_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=roles' );
            }
            else {
                trigger_error ( print_r( $role_obj->error, true ) );
                $this->show_template_roles( $role_obj->error);
            }
        }
    }

    /**
     * Creates new user group
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function group_create(  ) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission(array('groups', 'groups.create'));

        $group = onapp_get_arg('group');

        if (is_null($group)) {
            $this->show_template_group_create( );
        } else {                                                                              
            $onapp = $this->get_factory();

            $group_obj = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($group as $key => $value)
                $group_obj->$key = $value;
            
            //TODO delete this when fixed Ticket #2511
            $group_obj->_tagRoot = 'pack';
            //*****************************
            
            $group_obj->save();
            onapp_debug( 'group_obj =>' . print_r( $group_obj, true ) );

            if (is_null($group_obj->error)) {
                $_SESSION['message'] = 'GROUP_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=groups' );
            }
            else {
                trigger_error ( print_r( $group_obj->error, true ) );
                $this->show_template_groups( $group_obj->error );
            }
        }
    }

    /**
     * Creates new user white list IP
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function white_list_create($id) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.create'));

        $white_list = onapp_get_arg('white_list');

        if (is_null($white_list)) {
            $this->show_template_white_list_create($id);
        } else {                                                                               
            $onapp = $this->get_factory();

            $white_list_obj = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($white_list as $key => $value)
                $white_list_obj->$key = $value;                                                          

            $white_list_obj->_user_id = $id;
            $white_list_obj->save();
            onapp_debug( 'white_list_obj =>' . print_r( $white_list_obj, true ) );
                                                                                                             
            if (is_null($white_list_obj->error)) {
                $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_CREATED';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $id);
            }
            else {
                trigger_error ( print_r( $white_list_obj->error, true ) );
                $this->show_template_white_list($id, $white_list_obj->error);
            }
        }
    }

    /**
     * Deletes user white list IP
     *
     * @global array $_ALIASES menu page aliases
     * @param integer white list IP id
     * @return void
     */
    private function white_list_delete($id) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.delete'));

        $user_id = onapp_get_arg('user_id');
        onapp_debug('user_id => ' . $user_id);

        $onapp = $this->get_factory();

        $white_list = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
        $white_list->_id = $id;
        $white_list->_user_id = $user_id;
        $white_list->delete();
        onapp_debug( 'white_list =>' . print_r( $white_list, true ) );

        if (is_null($white_list->error)) {
            $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_DELETED';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $user_id);
        }
        else {
            trigger_error ( print_r( $white_list->error, true ) );
            $this->show_template_payments($white_list->error);
        }
    }

    /**
     * Edits user white list IP
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user white list IP id
     * @return void
     */
    private function white_list_edit($id) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('user_white_lists', 'user_white_lists.update'));

        $user_id = onapp_get_arg('user_id');
        $white_list = onapp_get_arg('white_list');

        if (is_null($white_list)) {
            $this->show_template_white_list_edit($id);
        } else {                                                                               
            $onapp = $this->get_factory();

            $white_list_obj = $onapp->factory('User_WhiteList', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($white_list as $key => $value)
                $white_list_obj->$key = $value;
                                                                                                    
            $white_list_obj->_user_id = $user_id;
            $white_list_obj->_id = $id;
            $white_list_obj->save();
            onapp_debug( 'white_list_obj =>' . print_r( $white_list_obj, true ) );
                                                                                               
            if (is_null($white_list_obj->error)) {
                $_SESSION['message'] = 'USER_WHITE_IP_WAS_SUCCESSFULLY_UPDATED';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=white_list&id=' . $user_id);
            }
            else {
                trigger_error ( print_r( $white_list_obj->error, true ) );
                $this->show_template_payments($user_id, $white_list_obj->error);
            }
        }
    }

    /**
     * Edits user profile
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user id
     * @return void
     */
    private function edit($id) {
        global $_ALIASES;

        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('users.update', 'users'));

        $user = onapp_get_arg('user');

        if (is_null($user)) {
            $this->show_template_edit($id);
        } else {
            $onapp = $this->get_factory();

            foreach ($user['_role_ids'] as $key => $field) {
                if ($field == 0) {
                    unset($user['_role_ids'][$key]);
                }
            }                                                                         

            $user['_role_ids'] = array_values($user['_role_ids']);
            
            $user_obj = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($user as $key => $value)
                $user_obj->$key = $value;

            $user_obj->_id = $id;                                                           
            $user_obj->save();
            onapp_debug( 'user_obj =>' . print_r( $user_obj, true ) );
                                                                                                
            if (is_null($user_obj->error)) {
                $_SESSION['message'] = 'USER_PROFILE_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=details&id=' . $id);
            }
            else {
                trigger_error ( print_r( $user_obj->error, true ) );
                $this->show_template_details($id, $user_obj->error);
            }
        }
    }

    /**
     * Creates a new user
     *
     * @global array $_ALIASES menu page aliases
     * @return void
     */
    private function create() {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_permission(array('users.create', 'users'));

        $user = onapp_get_arg('user');

        if (is_null($user)) {
            $this->show_template_create( );
        } else {
            $onapp = $this->get_factory();
                                                                                             
            foreach ($user['_role_ids'] as $key => $field) {
                if ($field == 0) {
                    unset($user['_role_ids'][$key]);
                }
            }                                                                         

            $user['_role_ids'] = array_values($user['_role_ids']);
            
            $user_obj = $onapp->factory('User', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($user as $key => $value)
                $user_obj->$key = $value;
           
            $user_obj->save();
            onapp_debug( 'user_obj =>' . print_r( $user_obj, true ) );

            if (is_null($user_obj->error)) {
                $_SESSION['message'] = 'USER_HAS_BEEN_CREATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=details&id=' . $user_obj->_id);
            }
            else {
                trigger_error ( print_r( $user_obj->error, true ) );
                $this->show_template_view($user_obj->error);
            }
        }
    }

    /**
     * Edits user payment
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user payment id
     * @return void
     */
    private function payment_edit($id) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('payments', 'payments.update'));

        $user_id = onapp_get_arg('user_id');
        $payment = onapp_get_arg('payment');

        if (is_null($payment)) {
            $this->show_template_payment_edit($id);
        } else {                                                                                
            $onapp = $this->get_factory();

            $payment_obj = $onapp->factory('Payment', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($payment as $key => $value)
                $payment_obj->$key = $value;
                                                                                               
            $payment_obj->_user_id = $user_id;
            $payment_obj->_id = $id;
            $payment_obj->save();
            onapp_debug( 'payment_obj =>' . print_r( $payment_obj, true ) );
                                                                                                 
            if (is_null($payment_obj->error)) {
                $_SESSION['message'] = 'PAYMENT_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=payments&id=' . $user_id);
            }
            else {
                trigger_error ( print_r( $payment_obj->error, true ) );
                $this->show_template_payments($user_id, $payment_obj->error);
            }
        }
    }
    

    /**
     * Edits user role
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user role id
     * @return void
     */
    private function role_edit( $id ) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('roles', 'roles.update'));
        
        $role = onapp_get_arg( 'role' );

        if ( is_null( $role ) ) {
            $this->show_template_role_edit( $id );
        } else {

            foreach ( $role['_permission_ids'] as $key => $field) {
                if ($field == 0) {
                    unset($role['_permission_ids'][$key]);
                }
            }

            $role['_permission_ids'] = array_values( $role['_permission_ids'] );                                                                          
            $onapp = $this->get_factory();

            $role_obj = $onapp->factory('Role', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($role as $key => $value)
                $role_obj->$key = $value;
                                                                                         
            $role_obj->_id = $id;
            $role_obj->save();
            onapp_debug( 'role_obj =>' . print_r( $role_obj, true ) );
                                                                                             
            if ( is_null($role_obj->error) ) {
                $_SESSION['message'] = 'ROLE_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=roles' );
            }
            else {
                trigger_error ( print_r( $role_obj->error, true ) );
                $this->show_template_roles( $role_obj->error);
            }
        }
    }

    /**
     * Edits user group
     *
     * @global array $_ALIASES menu page aliases
     * @param integer user group id
     * @return void
     */
    private function group_edit( $id ) {
        global $_ALIASES;
        
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        onapp_debug('id => ' . $id);

        onapp_permission(array('groups', 'groups.update'));

        $group = onapp_get_arg('group');

        if ( is_null( $group ) ) {
            $this->show_template_group_edit( $id );
        } else {                                                                               
            $onapp = $this->get_factory();

            $group_obj = $onapp->factory('UserGroup', ONAPP_WRAPPER_LOG_REPORT_ENABLE);
            foreach ($group as $key => $value)
                $group_obj->$key = $value;                                           
            
            $group_obj->_id = $id;

            //TODO delete this when fixed Ticket #2511
            $group_obj->_tagRoot = 'pack';
            //*****************************

            $group_obj->save();
            onapp_debug( 'group_obj =>' . print_r( $group_obj, true ) );
            
            if (is_null($group_obj->error)) {
                $_SESSION['message'] = 'GROUP_HAS_BEEN_UPDATED_SUCCESSFULLY';
                onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['users_and_groups'] . '?action=groups' );
            }
            else {
                trigger_error ( print_r( $group_obj->error, true ) );
                $this->show_template_groups( $group_obj->error );
            }
        }
    }

    /**
     * Checks necessary access to this class
     *
     * @return boolean [true|false]
     */
    static function access() {
        return onapp_has_permission(array('virtual_machines', 'virtual_machines.read.own'));
    }

}