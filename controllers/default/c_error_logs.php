<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Error_Logs
{

   /**
    * Main controller function
    *
    * @return void
    */
    public function view()
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $action = onapp_get_arg('action');
        $id = onapp_get_arg('id');

        switch ($action)
        {
            case 'details':
                $this->show_template_details( $id );
                break;
            default:
                $this->show_template_view( );
                break;
        }
    }

   /**
    * Displays frontend logs list
    *
    * @return void
    */
    private function show_template_view( )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $page = onapp_get_arg('page');

        if( ! $page)
            $page = 1;

        $list = onapp_scan_dir( ONAPP_PATH.ONAPP_DS.ONAPP_LOG_DIRECTORY );

        foreach ($list as $file) {
            if( $file != 'frontend.log')
                $files_list[ substr($file, 6, -4) ] = date( 'Y-m-d H:i:s', filemtime( ONAPP_PATH.ONAPP_DS. ONAPP_LOG_DIRECTORY . ONAPP_DS . $file ));
        }
        
        arsort($files_list);

        $items_per_page = 15;

        $pages_quantity = ( integer )( count($files_list) / $items_per_page );

        $j = 0;
        $i = 1;
        foreach($files_list as $key => $value){
            $files_list_array[$i][$key] = $value;
            $j++;
            if($j > $items_per_page){
                $j = 0;
                $i++;
            }
        }
                                                                              //    print('<pre>'); print_r($files_list_array); die();
        $params = array(
            'page'           =>    $page,
            'pages_quantity' =>    $pages_quantity,
            'files_list'     =>    $files_list_array[$page],
            'title'          =>    onapp_string('ERROR_LOGS' ),
            'info_title'     =>    onapp_string('ERROR_LOGS'),
            'info_body'      =>    onapp_string('ERROR_LOGS_INFO'),
        );                                                             
        onapp_show_template( 'errorLogs_view', $params );
    }
  
  /**
   * Displays error log details page
   *
   * @param string error log identifier
   * @return void
   */
    public function show_template_details( $id )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);

        $filename = ONAPP_PATH.ONAPP_DS. ONAPP_LOG_DIRECTORY . ONAPP_DS . 'error_' . $id . '.log';                    // echo $filename; die();
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);

        $params = array(
           'contents'     =>    $contents,
           'title'        =>    onapp_string('ERROR_LOGS_DETAILS' ),
           'info_title'   =>    onapp_string('ERROR_LOGS_DETAILS'),
           'info_body'    =>    onapp_string('ERROR_LOGS_DETAILS_INFO'),
        );

        onapp_show_template( 'errorLogs_details', $params );
    }

}