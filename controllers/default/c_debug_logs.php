<?php if ( ! defined('ONAPP_PATH')) die('No direct script access allowed');

class Debug_Logs
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
    * @param string identifier not found error
    * @return void
    */
    private function show_template_view( $error = NULL )
    {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        
        $params = array(
           'id'           =>    onapp_get_arg('id'),
           'error'        =>    onapp_string( $error ),
           'title'        =>    onapp_string('DEBUG_LOGS' ),
           'info_title'   =>    onapp_string('DEBUG_LOGS'),
           'info_body'    =>    onapp_string('DEBUG_LOGS_INFO'),
        );

        onapp_show_template( 'debugLogs_view', $params );

        
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

        $contents = $this->get_debug( $id );
        
        $params = array(
           'id'           =>    onapp_get_arg('id'),
           'contents'     =>    $contents,
           'title'        =>    onapp_string('DEBUG_LOGS_DETAILS' ),
           'info_title'   =>    onapp_string('DEBUG_LOGS_DETAILS'),
           'info_body'    =>    onapp_string('DEBUG_LOGS_DETAILS_INFO'),
        );

        if( ! $contents ){
            $error = 'SESSION_IDENTIFIER_NOT_FOUND_IN_LOG_FILE';
            trigger_error( onapp_string($error ) );
            $this->show_template_view($error);
        }
        else{
            onapp_show_template( 'debugLogs_details', $params );
        }
    }
    /**
     * Gets Debug info
     *
     * @param string Session or error identifier
     * @return mixed debug info if found and false if not found
     */
    private function get_debug( $id ){
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        
        $contents = '';
        
        $found = false;
        
        $handle = @fopen(ONAPP_PATH . ONAPP_DS . ONAPP_LOG_DIRECTORY . ONAPP_DS . ONAPP_DEBUG_FILE_NAME, "r");
        $pattern = "/^\[$id\]/";
        $pattern1 = "/^\[/"; 
        if ( $handle ) {
            while ( ( $buffer = fgets ( $handle, 4096 ) ) !== false) {      
               if ( preg_match ( $pattern ,$buffer ) ) {
                   $contents .= $buffer;
                   $found = true;
               }
               elseif ( preg_match ( $pattern1 , $buffer ) && $found && ! preg_match ( $pattern, $buffer ) ) {
                   break;
               }
               elseif ( ! preg_match ($pattern1 , $buffer) && $found ) {
                   $contents .= $buffer;
               }
           }          
       }
       fclose( $handle );

       if( $found )
           return $contents;
       else
           return false;
    }

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function  access () {
        onapp_debug(__CLASS__.' :: '.__FUNCTION__);
        $return = onapp_has_permission( array( 'roles' ) );
        onapp_debug( 'return => '.$return );
        return $return;
    }
}