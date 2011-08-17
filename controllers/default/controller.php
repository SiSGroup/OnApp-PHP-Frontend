<?php
if( !defined( 'ONAPP_PATH' ) ) {
	die( 'No direct script access allowed' );
}
class Controller {
	protected $factory_instance;

    protected function get_factory() {
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
    * Gets list of standard objects
    *
    * @param string class name
    * @return mixed standard objects array
    */
   protected function getList( $class_name, $params = NULL, $debug = false ) {
        $onapp = $this->get_factory();

        $obj = $onapp->factory( $class_name, ONAPP_WRAPPER_LOG_REPORT_ENABLE );

        $_obj = $obj->getList( $params[0], $params[1] );

       if ( $debug ) {
          // print('<pre>'); print_r( $obj );
           print('<pre>'); print_r( $_obj );
           die();
       }

       return $_obj;
   }

   /**
    * Loads standard object
    *
    * @param string class name
    * @param integer object id
    * @return mixed standard object
    */
   protected function load( $class_name, $params = NULL, $debug = false ) {
       $onapp = $this->get_factory();

       $obj = $onapp->factory( $class_name, ONAPP_WRAPPER_LOG_REPORT_ENABLE );
       
       $_obj = $obj->load( $params[0], $params[1], $params[2] );

       if ( $debug ) {
           //print('<pre>'); print_r( $obj );
           print('<pre>'); print_r( $_obj );
           die();
       }

       return $_obj;
   }
   
}