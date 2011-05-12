<?php class ONAPP_Profile extends ONAPP 
{
    var $_total_amount;
   
    var $_activated_at;
    
    var $_created_at;
    
    var $_tagRoot = 'profile';
    
    var $_memory_available;
    
    var $_remember_token_expires_at = null;
    
    var $_suspend_at = null;
    
    var $_called_class = 'ONAPP_Profile';
    
    var $_deleted_at = null;
    
    var $_updated_at;
    
    var $_resource = 'profile';
    
    var $_used_ip_addresses = array();
    
    var $_used_disk_size;
    
    var $_used_cpu_shares;
    
    var $_billing_plan_id;
    
    var $_used_cpus;
    
    var $_used_memory;
    
    var $_group_id;
    
    var $_id;
    
    var $_payment_amount;
    
    var $_user_group_id = null;
    
    var $_last_name;
    
    var $_remember_token;
    
    var $_disk_space_available;
    
    var $_image_template_group_id;
    
    var $_locale;
    
    var $_time_zone;
    
    var $_login;
    
    var $_status;
    
    var $_outstanding_amount;
    
    var $_roles = array();
    
    var $_email;
    
    var $_first_name;
    
    var $_fields;
    
    
    /**
     * API Fields description
     *
     * @access private
     * @var    array
     */
    function _init_fields( $version = NULL ) {
        if( is_null( $version ) ) {
            $version = $this->_version;
        }

        switch( $version ) {
            case '2.0':
            case '2.1':

                $this->_fields[ 'group_id' ][ ONAPP_FIELD_REQUIRED ] = false;

                $this->_fields[ '_first_name' ] = array(
                    ONAPP_FIELD_MAP => '_first_name',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );

                $this->_fields[ '_email' ] = array(
                    ONAPP_FIELD_MAP => '_email',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );

                $this->_fields[ '_outstanding_amount' ] = array(
                    ONAPP_FIELD_MAP => '_outstanding_amount',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );

                $this->_fields[ '_status' ] = array(
                    ONAPP_FIELD_MAP => '_status',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_login' ] = array(
                    ONAPP_FIELD_MAP => '_login',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_time_zone' ] = array(
                    ONAPP_FIELD_MAP => '_time_zone',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_locale' ] = array(
                    ONAPP_FIELD_MAP => '_locale',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_image_template_group_id' ] = array(
                    ONAPP_FIELD_MAP => '_image_template_group_id',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_disk_space_available' ] = array(
                    ONAPP_FIELD_MAP => '_disk_space_available',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_remember_token' ] = array(
                    ONAPP_FIELD_MAP => '_remember_token',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_last_name' ] = array(
                    ONAPP_FIELD_MAP => '_last_name',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_payment_amount' ] = array(
                    ONAPP_FIELD_MAP => '_payment_amount',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_id' ] = array(
                    ONAPP_FIELD_MAP => '_id',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_group_id' ] = array(
                    ONAPP_FIELD_MAP => '_group_id',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_used_memory' ] = array(
                    ONAPP_FIELD_MAP => '_used_memory',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
               /* $this->_fields[ '_outstanding_amount' ] = array(
                    ONAPP_FIELD_MAP => '_outstanding_amount',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_outstanding_amount' ] = array(
                    ONAPP_FIELD_MAP => '_outstanding_amount',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );
                
                $this->_fields[ '_outstanding_amount' ] = array(
                    ONAPP_FIELD_MAP => '_outstanding_amount',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_READ_ONLY => true
                );

                $this->_fields[ 'user_group_id' ] = array(
                    ONAPP_FIELD_MAP => '_user_group_id',
                    ONAPP_FIELD_TYPE => 'integer',
                );*/

                break;
        }

        if( is_null( $this->_id ) ) {
            $this->_fields[ "password" ] = array(
                ONAPP_FIELD_MAP => '_password',
                ONAPP_FIELD_REQUIRED => true,
            );
        }

        return $this->_fields;
    }
}

?>