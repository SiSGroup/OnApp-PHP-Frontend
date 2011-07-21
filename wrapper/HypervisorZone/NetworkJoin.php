<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Network Zone Joins
 *
 * @todo Add description
 *
 * @category  API WRAPPER
 * @package   ONAPP
 * @author    Yakubskiy Yuriy
 * @copyright 2011 / OnApp
 * @link      http://www.onapp.com/
 * @see       ONAPP
 */

/**
 * require Base class
 */
require_once dirname( __FILE__ ) . '/../ONAPP.php';

/**
 * ONAPP_Hypervisor_NetworkJoin
 *
 * This class reprsents the Networks for Hypervisor Zone.
 *
 * The ONAPP_Hypervisor_NetworkJoin class uses the following basic methods:
 * {@link save}, {@link delete}, and {@link getList}.
 *
 * <b>Use the following XML API requests:</b>
 *
 * Get the list of Network Zone Joins
 *
 *     - <i>GET onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins.xml</i>
 *
 * Get a particular Network Zone Join details
 *
 *     - <i>GET onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins/{ID}.xml</i>
 *
 * Add new Network Zone Join
 *
 *     - <i>POST onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins.xml</i>
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <network-join>
 *    <network_id>{NETWORK_ID}</network_id>
 *    <interface>{INTERFACE}</interface>
 * </network-join>
 * </code>
 *
 * Delete Network Zone Join
 *
 *     - <i>DELETE onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins/{ID}.xml</i>
 *
 * <b>Use the following JSON API requests:</b>
 *
 * Get the list of Network Zone Joins
 *
 *     - <i>GET onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins.json</i>
 *
 * Get a particular Network Zone Join details
 *
 *     - <i>GET onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins/{ID}.json</i>
 *
 * Add new Network Zone Join
 *
 *     - <i>POST onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins.json</i>
 *
 * <code>
 * {
 *      network-join: {
 *          network_id:{NETWORK_ID},
 *          interface:'{INTERFACE}'
 *      }
 * }
 * </code>
 *
 * Delete Network Zone Join
 *
 *     - <i>DELETE onapp.com/settings/hyrvisor_zones/{HYPERVISOR_ZONE_ID}/network_joins/{ID}.json</i>
 */
class ONAPP_HypervisorZone_NetworkJoin extends ONAPP {

    /**
     * the Network Zone Join ID
     *
     * @var integer
     */
    var $_id;

    /**
     * the Network Zone Join creation date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_created_at;

    /**
     * the Network Zone Join update date was updated in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

    /**
     * the Network ID
     *
     * @var integer
     */
    var $_network_id;

    /**
     * the Interface
     *
     * @var string
     */
    var $_interface;

    /**
     * Hypervisor Zone Id
     *
     * @var integer
     */
    var $_target_join_id;

    /**
     * Target join type
     *
     * @var string
     */
    var $_target_join_type;

    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'network_join';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'network_joins';


    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_HypervisorZone_NetworkJoin';

    /**
     * API Fields description
     *
     * @access private
     * @var    array
     */
    function _init_fields( $version = NULL ) {
        if( !isset( $this->options[ ONAPP_OPTION_API_TYPE ] ) || ( $this->options[ ONAPP_OPTION_API_TYPE ] == 'json' ) ) {
            $this->_tagRoot = 'network_join';
        }

        if( is_null( $version ) ) {
            $version = $this->_version;
        }

        switch( $version ) {
            case '2.0':
                $this->_fields = array(
                    'id' => array(
                        ONAPP_FIELD_MAP => '_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'created_at' => array(
                        ONAPP_FIELD_MAP => '_created_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'updated_at' => array(
                        ONAPP_FIELD_MAP => '_updated_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'network_id' => array(
                        ONAPP_FIELD_MAP => '_network_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'interface' => array(
                        ONAPP_FIELD_MAP => '_interface',
                        ONAPP_FIELD_READ_ONLY => true,
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                );

                break;

            case '2.1':

                $this->_fields = $this->_init_fields('2.0');

                $this->_fields[ 'target_join_id' ] = array(
                    ONAPP_FIELD_MAP => '_target_join_id',
                    ONAPP_FIELD_TYPE => 'integer',
                    ONAPP_FIELD_REQUIRED => true
                );

                $this->_fields[ 'target_join_type' ] = array(
                    ONAPP_FIELD_MAP => '_target_join_type',
                    ONAPP_FIELD_TYPE => 'string',
                    ONAPP_FIELD_REQUIRED => true
                );

                break;
        }
        ;

        return $this->_fields;
    }

    /**
     * Returns the URL Alias of the API Class that inherits the Class ONAPP
     *
     * @param string $action action name
     *
     * @return string API resource
     * @access public
     */
    function getResource( $action = ONAPP_GETRESOURCE_DEFAULT ) {
        switch( $action ) {
            case ONAPP_GETRESOURCE_DEFAULT:

                /**
                 * ROUTE :
                 * @name hypervisor_network_joins
                 * @method GET
                 * @alias  /settings/hyrvisor_zones/:hypervisor_id/network_joins(.:format)
                 * @format  {:controller=>"network_joins", :action=>"index"}
                 */

                /**
                 * ROUTE :
                 * @name
                 * @method POST
                 * @alias  /settings/hyrvisor_zones/:hypervisor_id/network_joins(.:format)
                 * @format  {:controller=>"network_joins", :action=>"create"}
                 */

                /**
                 * ROUTE :
                 * @name  hypervisor_network_join
                 * @method DELETE
                 * @alias /settings/hyrvisor_zones/:hypervisor_id/network_joins/:id(.:format)
                 * @format  {:controller=>"network_joins", :action=>"destroy"}
                 */
                
                $resource = 'settings/hypervisor_zones/' . $this->_target_join_id . '/' . $this->_resource;
                $this->_loger->debug( "getResource($action): return " . $resource );
                break;

            default:
                $resource = parent::getResource( $action );
                break;
        }

        return $resource;
    }
    /**
     * Gets list of network joins to particular hypervisor zone
     *
     * @param integet hypervisor zone id
     * @return array of newtwork join objects
     */
     function getList( $target_join_id = null ) {
        if( is_null( $target_join_id ) && !is_null( $this->_target_join_id ) ) {
            $target_join_id = $this->_target_join_id;
        }

        if( !is_null( $target_join_id ) ) {
            $this->_target_join_id = $target_join_id;

            return parent::getList( );
        }
        else {
            $this->_loger->error(
                'getList: argument _target_join_id not set.',
                __FILE__,
                __LINE__
            );
        }
    }

    /**
     * Activates action performed with object
     *
     * @param string $action_name the name of action
     *
     * @access public
     */
    function activate( $action_name ) {
        switch( $action_name ) {
            case ONAPP_ACTIVATE_LOAD:
                die( "Call to undefined method " . __CLASS__ . "::$action_name()" );
                break;
        }
    }

}

?>
