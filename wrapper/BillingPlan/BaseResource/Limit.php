<?php
class ONAPP_BillingPlan_BaseResource_Limits extends ONAPP{

    /**
     *  amount of Resource that users get for free
     *
     * @var float
     */
    var $_limit_free;

    /**
     *
     * @var total amount of Resource
     */
    var $_limit;
    /**
     *
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_BillingPlan_BaseResource_Limit';

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
            case '2.1':
                $this->_fields = array(
                    'limit_free' => array(
                        ONAPP_FIELD_MAP => '_limit_free',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'limit' => array(
                        ONAPP_FIELD_MAP => '_limit',
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
