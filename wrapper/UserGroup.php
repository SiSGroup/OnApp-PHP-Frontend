<?php
/**
 * Managing User Groups
 *
 * User Groups are created to set custom layout to selected users.
 *
 * @category  API WRAPPER
 * @package   ONAPP
 * @author    Lev Bartashevsky
 * @copyright (c) 2011 OnApp
 * @link      http://www.onapp.com/
 * @see       ONAPP
 */

/**
 * requires Base class
 */
require_once 'ONAPP.php';

class ONAPP_UserGroup extends ONAPP {
    /**
     * User Group Label
     *
     * @var string
     */
    var $_label;

    /**
     * User Group creation date in [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_created_at;

    /**
     * User Group update date in [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

    /**
     * the User Group ID
     *
     * @var integer
     */
    var $_id;

    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'user_group';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'user_groups';

    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_UserGroup';

    /**
     * API Fields description
     *
     * @param string $version API version
     *
     * @return array
     */
    function _init_fields( $version = NULL ) {
        if( is_null( $version ) ) {
            $version = $this->_version;
        }

        switch( $version ) {
            case '2.0':
            case '2.1':
                $this->_fields = array(
                    'label' => array(
                        ONAPP_FIELD_MAP => '_label',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => ''
                    ),
                    'created_at' => array(
                        ONAPP_FIELD_MAP => '_created_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'updated_at' => array(
                        ONAPP_FIELD_MAP => '_updated_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'id' => array(
                        ONAPP_FIELD_MAP => '_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                );

                break;
        }

        return $this->_fields;
    }
}