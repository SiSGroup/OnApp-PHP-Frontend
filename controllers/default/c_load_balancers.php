<?php

require_once( ONAPP_PATH . ONAPP_DS . 'controllers' . ONAPP_DS . ONAPP_CONTROLLERS . ONAPP_DS . 'controller.php');

class Load_Balancers extends Controller {

    /**
     * Main controller function
     *
     * @return void
     */
    public function view() {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        $id = onapp_get_arg('id');
        $action = onapp_get_arg('action');

        switch ($action) {
            case 'details':
                $this->show_template_details( $id );
                break;
            case 'rebuild':
                $this->rebuild( $id );
                break;
            case 'startup':
                $this->startup( $id );
                break;
            case 'delete':
                $this->delete( $id );
                break;
            case 'migrate':
                $this->migrate( $id );
                break;
            case 'edit':
                $this->edit( $id );
                break;
            case 'suspend':
                $this->suspend( $id );
                break;
            case 'monitis':
                $this->monitis( $id );
                break;
            case 'edit_admin_note':
                $this->edit_admin_note( $id );
                break;
            default:
                $this->show_template_view();
                break;
        }
    }

    /**
     * Displays default page with virtual machine list
     *
     * @param string error message
     * @param other message
     * @return void
     */
    private function show_template_view( $error = NULL ) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        onapp_debug('error => ' . $error);

        $onapp = $this -> get_factory();

        onapp_permission(array('load_balancing_clusters', 'load_balancing_clusters.read.own'));

        $load_balancers_obj = $this->getList('LoadBalancer');
        
        $hypervisors = $this->getList('Hypervisor');

        foreach ( $hypervisors as $hypervisor ) {
            $hypervisors_obj[ $hypervisor->_id ] = $hypervisor;
        }

        $load_balancing_clusters = $this->getList('LoadBalancingCluster');        
        foreach ( $load_balancing_clusters as $load_balancing_cluster) {          
            $load_balancing[ $load_balancing_cluster->_load_balancer_id ] = $load_balancing_cluster;
            $load_balancing[ $load_balancing_cluster->_load_balancer_id ]->_nodes_count = count($load_balancing_cluster->_nodes);
        }

        $params = array(
            'hypervisors_obj' => $hypervisors_obj,
            'load_balancers_obj' => $load_balancers_obj,
            'load_balancing' => $load_balancing,
            'title' => onapp_string('LOAD_BALANCERS'),
            'info_title' => onapp_string('LOAD_BALANCERS'),
            'info_body' => onapp_string('LOAD_BALANCERS_INFO'),
            'error' => $error,
        );
        onapp_show_template('loadBalancers_view', $params);
    }

    /**
     * Displays particular load balancer details page
     *
     * @param integer load balancer id
     * @param string error message
     * @return void
     */
    public function show_template_details($id, $error = NULL) {
        onapp_debug(__METHOD__);

        onapp_debug('id => ' . $id . ' error => ' . $error );

        $load_balancer_obj = $this->load('LoadBalancer', array($id));

        $load_balancing_cluster = $this->load( 'LoadBalancingCluster', array(onapp_get_arg( 'cluster' ) ) );

        foreach ( $load_balancing_cluster->_nodes as $node ) {
            $nodes[] = $this->load( 'VirtualMachine', array( $node->_virtual_machine_id ) );
        } 

        $vm_backup_obj = $this->getList('VirtualMachine_Backup', array($id));

        $size_and_quantity = $this->calculateBackups($vm_backup_obj);

        $params = array(
            'virtual_machine_id' => $id,
            'user_obj' => $this->load('User', array($load_balancer_obj->_user_id)),
            'profile_obj' => $_SESSION['profile_obj'],
            'hypervisor_obj' => $this->load('Hypervisor', array($load_balancer_obj->_hypervisor_id) ),
            'load_balancer_obj' => $load_balancer_obj,
            'backups_quantity' => $size_and_quantity['quantity'],
            'backups_total_size' => $size_and_quantity['size'],
            'nodes' => $nodes,
            'title' => onapp_string('LOAD_BALANCER_DETAILS'),
            'info_title' => onapp_string('LOAD_BALANCER_DETAILS'),
            'info_body' => onapp_string('LOAD_BALANCER_DETAILS_INFO'),
            'error' => $error,
        );
        onapp_show_template('loadBalancers_details', $params);
    }
    /**
     * Startups load balancer
     *
     * @global array $_ALIASES menu page aliases
     * @param integer balancer Id
     * @return void
     */
    private function startup( $id ) {
        global $_ALIASES;

        onapp_debug(__METHOD__);

        onapp_debug('id => ' . $id);

        onapp_permission(array('load_balancers', 'load_balancing_clusters', 'load_balancing_clusters.read', 'load_balancing_clusters.read.own'));

        $onapp = $this->get_factory();

        $load_balancer = $onapp->factory('LoadBalancer', ONAPP_WRAPPER_LOG_REPORT_ENABLE);

        $load_balancer->_id = $id;
        $load_balancer->startup();
                
        if (is_null($load_balancer->error)) {
            onapp_event_exec( 'load_balancer_startup', array( $load_balancer->_obj, $this->load( 'User', array( $load_balancer->_obj->_user_id ) ) ) );
            $_SESSION['message'] = 'BALANCER_STARTUP_HAS_BEEN_QUEUED';
            onapp_redirect(ONAPP_BASE_URL . '/' . $_ALIASES['load_balancers'] . '?action=details&id=' . $id);
        }
        else {
            onapp_event_exec( 'load_balancer_startup_failed', array( $load_balancer->_obj, $this->load( 'User', array( $load_balancer->_obj->_user_id ) ) ) );
            trigger_error ( print_r( $load_balancer->error, true ) );
            $this->show_template_view($load_balancer->error);
        }
    }


    /**
     * Calculates backups' quantity and sizes
     *
     * @param object $vm_backup_obj Virtual Machine Backup object
     * @return array Virtual Machine backups' quantity and sizes
     */
    private function calculateBackups($vm_backup_obj) {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);

        $backups_quantity = 0;
        $backups_total_size = 0;
        if ($vm_backup_obj && is_array($vm_backup_obj)) {
            foreach ($vm_backup_obj as $value) {
                $backups_quantity++;
                $backups_total_size += $value->_backup_size;
            }
            $backups_total_size = round($backups_total_size / 1024);
        } else if (count($vm_backup_obj) == 1 && !is_array($vm_backup_obj) && $vm_backup_obj->_id) {
            $backups_quantity = 1;
            $backups_total_size = round($vm_backup_obj->_backup_size / 1024);
        }

        return $size_and_quantity = array(
            'size' => $backups_total_size,
            'quantity' => $backups_quantity
        );
    }

   
    static function access() {
        return onapp_has_permission(array('load_balancing_clusters', 'load_balancing_clusters.read.own'));
    }

}