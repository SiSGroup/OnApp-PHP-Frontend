<?php
class Hypervisors
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
    
    public function view()
    {
        $id = onapp_get_arg('id');
        $action = onapp_get_arg('action');

        switch ( $action ) {
            case 'hypervisor_details':
                $this->vm_details($id);
                break;
            default:
                $this->show_template_view();
                break;
        }
    }

    private function show_template_view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        onapp_permission(array('hypervisors', 'hypervisors.read'));

        $onapp = $this->get_factory();

        $hypervisor = $onapp->factory('Hypervisor');
        $hypervisor_obj = $hypervisor->getList( );                                   // print('<pre>');print_r($hypervisor_obj); print('</pre>');die();

        $hypervisor_zones = $onapp->factory('HypervisorZone');
        $hypervisor_zones_obj = $hypervisor_zones->getList( );

        $vm = $onapp->factory('VirtualMachine');
        $vm_obj = $vm->getList();

        $hypervisor_vm_count = $this->get_vms_quantity($hypervisor_obj, $vm_obj);    //print('<pre>');print_r($hypervisor_vm_count); print('</pre>');die();

        $hypervisor_xm_info = $this->get_hv_xm_info($hypervisor_obj);               //print('<pre>');print_r($hypervisor_xm_info); print('</pre>');die();

        $params = array(
            'hypervisor_obj'        =>     $hypervisor_obj,
            'hypervisor_vm_count'   =>     $hypervisor_vm_count,
            'hypervisor_zones_obj'  =>     $hypervisor_zones_obj,
            'hypervisor_xm_info'    =>     $hypervisor_xm_info,
            'vm_obj'                =>     $vm_obj,
        );                                                          // print('<pre>');print_r($hypervisor_obj); print('</pre>'); die();
        onapp_show_template( 'hypervisor_view', $params );
    }

    private function get_vms_quantity($hypervisor_obj, $vm_obj)
    {
        foreach($hypervisor_obj as $hv)
        {
            $quantity = 0;
            foreach($vm_obj as $vm)
                if($vm->_hypervisor_id == $hv->_id)
                    $quantity++;
            $hypervisor_vms_quatity[$hv->_id] = $quantity;
        }
        return $hypervisor_vms_quatity;
    }

    private function get_hv_xm_info($hypervisor_obj)
    {
        foreach($hypervisor_obj as $key => $value)
        {
            $xm = explode("\n", $value->_health->xm_info);
            foreach($xm as $key1 => $value1)
            {
                $result = explode(':',$value1);
                $hypervisor_xm_info[$value->_id][trim($result[0])] = trim($result[1]);
            }
        }
        return $hypervisor_xm_info;
    }
       // Don't delete this function please
    /*private function get_hv_xm_info($hypervisor_obj) {
        foreach ( $hypervisor_obj as $hv_id => $hv ) {
            foreach ( $hv->_health as $label => $info ) {
                $xm = explode("\n", $info);
                foreach ( $xm as $key => $value ) {
                    $result = explode( ':', $value);
                    $hypervisor_xm_info['hypervisors'][$hv->_id][$label][trim($result[0])] = trim($result[1]);
                }
            }
        }
        return $hypervisor_xm_info;
    }*/


  /**
  *
  * Checks necessary access to this class
  *
  * @return boolean [true|false]
  *
  */

     static function  access(){
        return onapp_has_permission(array('hypervisors', 'hypervisors.read'));
    }


}