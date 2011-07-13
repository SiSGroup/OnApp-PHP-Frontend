<?php 
class ONAPP_BillingPlan_BaseResource_Price extends ONAPP{
    
    /**
     * Resource switch on price
     * 
     * @var <type> 
     */
    var $_price_on;

    /**
     * Resource switch off price
     *
     * @var <type>
     */
    var $_price_off; 
    /**
     *
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_BillingPlan_BaseResource_Price';
    
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
                $this->_fields = array(
                    'price_on' => array(
                        ONAPP_FIELD_MAP => '_price_on',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'price_off' => array(
                        ONAPP_FIELD_MAP => '_price_off',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                );
                break;

        }

        return $this->_fields;
    }
}
?>
