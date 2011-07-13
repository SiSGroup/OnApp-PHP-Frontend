<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * VM IP Adresses
 *
 * @category  API WRAPPER
 * @package   ONAPP
 * @author    Vitaliy Kondratyuk
 * @copyright 2010 / OnApp
 * @link      http://www.onapp.com/
 * @see       ONAPP
 */

/**
 * requires Base class
 */
require_once dirname( __FILE__ ) . '/../IpAddress.php';

/**
 * VM IP Adresses
 *
 * The ONAPP_VirtualMachine_IpAddress class doesn't support any basic method.
 *
 */
class ONAPP_VirtualMachine_IpAddress extends ONAPP_IpAddress {


    /**
     * the IP Address ID
     *
     * @var integer
     */
    var $_id;

    /**
     * the Ip Address creation date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_created_at;

    /**
     * the IP Address
     *
     * @var string
     */
    var $_address;

    /**
     * the netmask
     *
     * @var string
     */

    var $_netmask;

    /**
     * the broadcast
     *
     * @var string
     */
    var $_broadcast;

    /**
     * the network address
     *
     * @var string
     */
    var $_network_address;

    /**
     * the network ID
     *
     * @var string
     */
    var $_network_id;

    /**
     * the Ip Address update date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

    /**
     * the gateway
     *
     * @var string
     */
    var $_gateway;

    /**
     * is the IP Address free
     *
     * @var boolean
     */
    var $_free;

    /**
     * don't use on guest during build
     *
     * @var boolean
     */
    var $_disallowed_primary;

    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'ip_address';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'ip_addresses';

    /**
     * Virtual Machine Id
     *
     * @var string
     */
    var $_virtual_machine_id;

    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_VirtualMachine_IpAddress';

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
                    'id' => array(
                        ONAPP_FIELD_MAP => '_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
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
                    'address' => array(
                        ONAPP_FIELD_MAP => '_address',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'netmask' => array(
                        ONAPP_FIELD_MAP => '_netmask',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'broadcast' => array(
                        ONAPP_FIELD_MAP => '_broadcast',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'network_address' => array(
                        ONAPP_FIELD_MAP => '_network_address',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'gateway' => array(
                        ONAPP_FIELD_MAP => '_gateway',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'network_id' => array(
                        ONAPP_FIELD_MAP => '_network_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'free' => array(
                        ONAPP_FIELD_MAP => '_free',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                );

                break;
        }

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
            case ONAPP_GETRESOURCE_JOIN:
                $resource = 'virtual_machines/' . $this->_virtual_machine_id . '/' . $this->_resource;
                $this->_loger->debug( "getResource($action): return " . $resource );
                break;
            

            default:
                $resource = parent::getResource( $action );
                break;
        }

        return $resource;
    }
    
    function join( $ip_address_id = NULL, $virtual_machine_id = NULL, $network_interface_id = NULL ){
        if( $virtual_machine_id){
            $this->_virtual_machine_id = $virtual_machine_id;
        }
        if( $network_interface_id){
            $this->_network_interface_id = $network_interface_id;
        }
        if( $ip_address_id){
            $this->_network_interface_id = $network_interface_id;
        }

        switch( $this->options[ ONAPP_OPTION_API_TYPE ] ) {
                  case 'xml':
                      $data = '<?xml version="1.0" encoding="UTF-8"?><ip_address>
                                   <network_interface_id>' . $this->_network_interface_id. '</network_interface_id>
                                   <ip_address_id>'. $this->_id . '</ip_address_id>
                               </ip_address>';

                      break;
                  case 'json':
                      $data = json_encode( 
                          array(
                             'ip_address' => array(
                                                  'network_interface_id' =>  $this->_network_interface_id,
                                                  'ip_address_id'        =>  $this->_id
                          )                  )
                      );
                      break;
                  default:
                      $this->_loger->error(
                          "Can't find serialize and unserialize functions for type (apiVersion => '"
                          . $this->_apiVersion . "').", __FILE__, __LINE__
                      );
                      exit;
                      break;
              }
       
        $this->sendPost( ONAPP_GETRESOURCE_JOIN, $data );

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
            case ONAPP_ACTIVATE_GETLIST:
            case ONAPP_ACTIVATE_LOAD:
            case ONAPP_ACTIVATE_SAVE:
            case ONAPP_ACTIVATE_DELETE:
                die( "Call to undefined method " . __CLASS__ . "::$action_name()" );
                break;
        }
    }
}

?>
