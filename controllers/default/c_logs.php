<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Logs
{
    /**
    * Main controller function
    *
    * @return void
    */
    public function view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
/* TODO move to separate functions
        onapp_permission(array(
                 'log_items.read.own',
                 'log_items.list.own',
                 'log_items.delete.own',
                 'transactions.delete.own',
                 'log_items',
                 'schedule_logs.create',
                 'transactions.delete',
                 ));
*/
        require_once "wrapper/Factory.php";
        $onapp = new ONAPP_Factory(
            $_SESSION["host"],
            $_SESSION["login"],
            onapp_cryptData($_SESSION["password"], 'decrypt'
        )
                            );
        $action   =  onapp_get_arg('action');
        $page    =   onapp_get_arg('page');
        onapp_debug('$page => '.$page.' $action => '.$action);

        switch ($action)
        {
            case 'details':
                $this->show_template_details($onapp);
                break;
            default:
                $this->show_template_view($onapp, $page);
                break;
        }
    }

   /**
    * Displays logs list
    *
    * @param object $onapp OnApp object
    * @return void
    */
    private function show_template_view($onapp, $page)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        if(is_null($page))
            $page = 1;
        
        $logs = $onapp->factory('Transaction', ONAPP_WRAPPER_LOG_REPORT_ENABLE);    
        
        $params = array(
            'pages_quantity' =>    $this->get_pages_quantity($logs),
            'logs_obj'       =>    $logs->getList($page),
            'title'          =>    onapp_string('LOGS_' ),
            'info_title'     =>    onapp_string('LOGS_'),
            'info_body'      =>    onapp_string('LOGS_INFO'),
            'page'           =>    $page,
            'alias'          =>    'logs',
        );                                                             
        onapp_show_template( 'logs_view', $params );
    }
  
  /**
   * Displays log details page
   *
   * @param object $onapp OnApp object
   * @return void
   */
    public function show_template_details($onapp)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        
        $id = onapp_get_arg('id');
        onapp_debug('$id => '.$id);
        
        $logs = $onapp->factory('Transaction', ONAPP_WRAPPER_LOG_REPORT_ENABLE);

       $params = array(
           'logs_obj'     =>    $logs->load($id),
           'title'        =>    onapp_string('TRANSACTION_DETAILS' ),
           'info_title'   =>    onapp_string('TRANSACTION_DETAILS'),
           'info_body'    =>    onapp_string('TRANSACTION_DETAILS_INFO'),
       );

       onapp_show_template( 'logs_details', $params );
    }

    /**
     * Gets pages quantity
     *
     * @param object logs object
     * @return pages quantity
     */
    public function get_pages_quantity($logs)
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $max_number = 1024;
        $result = $max_number;
        
        while($max_number > 1) {
            $list = $logs->getList($result);
            $max_number = $max_number / 2;

            if( is_array($list) )
                $result += $max_number;
            else
                $result -= $max_number;
        }

        if ( ! is_array( $logs->getList($result) ) )
                $result--;

        return $result;
    }
}