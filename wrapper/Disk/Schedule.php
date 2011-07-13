<?PHP

/**
 * Scheduleds
 *
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
 *
 * Managing Disk Backups Schedules
 *
 * The ONAPP_Disk_Schedule class uses the following basic methods:
 * {@link load}, {@link save}, {@link delete}, and {@link getList}.
 *
 * The ONAPP_Disk_Schedule class represents Disk Backups Schedules.
 * The ONAPP class is a parent of ONAPP_Disk_Schedule class.
 *
 * <b>Use the following XML API requests:</b>
 *
 * Get the list of schedules
 *
 *     - <i>GET onapp.com/schedules.xml</i>
 *
 * Get a particular schedule details
 *
 *     - <i>GET onapp.com/schedules/{ID}.xml</i>
 *
 * Add new software license
 *
 *     - <i>POST onapp.com/schedules.xml</i>
 *
 * <schedules type="array">
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <schedules>
 *  <schedule>
 *           <duration>{DURATION}</duration>
 *           <created_at>{CREATED_AT}</created_at>
 *           <target_id>{TARGET}</target_id>
 *           <updated_at>{UPDATED_AT}</updated_at>
 *           <period>{PERIOD}</period>
 *           <action>{ACTION}</action>
 *           <start_at>{START_AT}</start_at>
 *           <id>{ID}</id>
 *           <user_id>{USER_ID}</user_id>
 *           <schedule_logs>
 *           <schedule_log>
 *                 <created_at>{CREATED_AT}</created_at>
 *                 <updated_at>{UPDATED_AT}</updated_at>
 *                 <schedule_id>{SCHEDULE_ID}</schedule_id>
 *                 <id>{ID}</id>
 *                 <log_output></log_output>
 *                 <status>{STATUS}</status>
 *            </schedule_log>
 *
 *        </schedule_logs>
 *        <params nil="true">{PARAMS}</params>
 *        <failure_count>{FAILURE_COUNT}</failure_count>
 *        <status>{STATUS}</status>
 *        <target_type>{TARGET_TYPE}</target_type>
 *    </schedule>
 *</schedules>
 * </code>
 *
 * Edit existing schedule
 *
 *     - <i>PUT onapp.com/shedules/{ID}.xml</i>
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <schedules>
 *  <schedule>
 *           <duration>{DURATION}</duration>
 *           <created_at>{CREATED_AT}</created_at>
 *           <target_id>{TARGET}</target_id>
 *           <updated_at>{UPDATED_AT}</updated_at>
 *           <period>{PERIOD}</period>
 *           <action>{ACTION}</action>
 *           <start_at>{START_AT}</start_at>
 *           <id>{ID}</id>
 *           <user_id>{USER_ID}</user_id>
 *           <schedule_logs>
 *           <schedule_log>
 *                 <created_at>{CREATED_AT}</created_at>
 *                 <updated_at>{UPDATED_AT}</updated_at>
 *                 <schedule_id>{SCHEDULE_ID}</schedule_id>
 *                 <id>{ID}</id>
 *                 <log_output></log_output>
 *                 <status>{STATUS}</status>
 *            </schedule_log>
 *
 *        </schedule_logs>
 *        <params nil="true">{PARAMS}</params>
 *        <failure_count>{FAILURE_COUNT}</failure_count>
 *        <status>{STATUS}</status>
 *        <target_type>{TARGET_TYPE}</target_type>
 *    </schedule>
 *</schedules>
 * </code>
 *
 * Delete schedule
 *
 *     - <i>DELETE onapp.com/shedules/{ID}.xml</i>
 *
 * <b>Use the following JSON API requests:</b>
 *
 * Get the list of schedules
 *
 *     - <i>GET onapp.com/schedules.json</i>
 *
 * Get a particular schedule
 *
 *     - <i>GET onapp.com/schedules/{ID}.json</i>
 *
 * Add new schedule
 *
 *     - <i>POST onapp.com/schedules.json</i>
 *
 * <code>
 * {
 *      schedules: {
 *          duration:'{DURATION}',
 *          target_id:{TARGET_ID},
 *          target_type:{TARGET_TYPE},
 *          period:{PERIOD},
 *          action:{ACTION},
 *          status:{STATUS}
 *      }
 * }
 * </code>
 *
 * Edit existing group
 *
 *     - <i>PUT onapp.com/schedules/{ID}.json</i>
 *
 * <code>
 * {
 *      software_license: {
 *          duration:'{DURATION}',
 *          period:{PERIOD},
 *          status:{STATUS}
 *      }
 * }
 * </code>
 *
 * Delete group
 *
 *     - <i>DELETE onapp.com/schedules/{ID}.json</i>
 *
 *
 *
 */
/**
 * Initialize the GET LIST BY DISK ID request
 *
 */
define( 'ONAPP_GETRESOURCE_LIST_BY_DISK_ID', 'get list by disk id' );

class ONAPP_Disk_Schedule extends ONAPP {

    /**
     * Schedule ID
     *
     * @var integer
     */
    var $_id;

    /**
     * How often a disk backup is taken
     *
     * @var integer
     */
    var $_duration;

    /**
     * Creation date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var integer
     */
    var $_created_at;

    /**
     * The disk ID for which a backup is taken
     *
     * @var string
     */
    var $_target_id;

    /**
     * Schedule logs array
     *
     * @var string
     */
    var $_schedule_logs;
    
    /**
     * Time period for a backup schedule (days, weeks, months, or years)
     *
     * @var integer
     */
    var $_period;

    /**
     * The date when a schedule was updated in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

    /**
     * Currently, only autobackup action is performed by schedules
     *
     * @var integer
     */
    var $_action;
    
    /**
     * The date when a backup started in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_start_at;

    /**
     * The ID of a user who created this schedule
     *
     * @var array
     */
    var $_user_id;
    
    /**
     * The number of requests processed until the task fails
     *
     * @var string
     */
    var $_failure_count;

    /**
     * Schedule editional params
     *
     * @var integer
     */
    var $_params;

    /**
     * The status of the backup schedule (enabled, disabled, or failed)
     *
     * @var string
     */
    var $_status;

    /**
     * Currently, you can schedule backup of Disks only
     *
     * @var array
     */
    var $_target_type;
    
    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'schedule';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'schedules';

    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_Disk_Schedule';

    /**
     * API Fields description
     *
     * @access private
     * @var    array
     */
    function _init_fields( $version = NULL ) {
        if( !isset( $this->options[ ONAPP_OPTION_API_TYPE ] ) || ( $this->options[ ONAPP_OPTION_API_TYPE ] == 'json' ) ) {
            $this->_tagRoot = 'schedule';
        }

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
                        ONAPP_FIELD_READ_ONLY => true
                    ),
                    'duration' => array(
                        ONAPP_FIELD_MAP => '_duration',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'target_id' => array(
                        ONAPP_FIELD_MAP => '_target_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'schedule_logs' => array(
                        ONAPP_FIELD_MAP => '_schedule_logs',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'period' => array(
                        ONAPP_FIELD_MAP => '_period',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'updated_at' => array(
                        ONAPP_FIELD_MAP => '_updated_at',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'action' => array(
                        ONAPP_FIELD_MAP => '_action',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'start_at' => array(
                        ONAPP_FIELD_MAP => '_start_at',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'user_id' => array(
                        ONAPP_FIELD_MAP => '_user_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'failure_count' => array(
                        ONAPP_FIELD_MAP => '_failure_count',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'params' => array(
                        ONAPP_FIELD_MAP => '_params',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'status' => array(
                        ONAPP_FIELD_MAP => '_status',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => 'enabled',
            
                    ),
                    'target_type' => array(
                        ONAPP_FIELD_MAP => '_target_type',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'created_at' => array(
                        ONAPP_FIELD_MAP => '_created_at',
                        ONAPP_FIELD_TYPE => 'string',
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
        $show_log_msg = true;
        switch( $action ) {
            case ONAPP_GETRESOURCE_LIST_BY_DISK_ID:
                $resource = 'settings/disks/' .$this->_target_id. '/' . $this->_resource ;
                break;
            default:
                $resource = parent::getResource( $action );
                $show_log_msg = false;
                break;
        }

        if( $show_log_msg ) {
            $this->_loger->debug( "getResource($action): return " . $resource );
        }
        
        return $resource;
    }

    /**
     * Sends an API request to get the Objects. After requesting,
     * unserializes the received response into the array of Objects
     *
     * @param integer $disk_id Virtual Machine Disk id
     *
     * @return mixed an array of Object instances on success. Otherwise false
     * @access public
     */
    function getListByDiskId( $disk_id = null ){
        if( $disk_id )
            $this->_target_id = $disk_id;
        
        $this->activate( ONAPP_ACTIVATE_GETLIST );

        $this->_loger->add( "getList: Get Transaction list." );

        $this->setAPIResource( $this->getResource( ONAPP_GETRESOURCE_LIST_BY_DISK_ID ) );
        $response = $this->sendRequest( ONAPP_REQUEST_METHOD_GET );

        if( !empty( $response[ 'errors' ] ) ) {
            $this->error = $response[ 'errors' ];
            return false;
        }

        return $this->castStringToClass(
            $response[ "response_body" ],
            true
        );
    }

    function save( $id ){
        if( $id ) {
            $this->_id = $id;
        }
        
        if($this->_target_id){
            $this->_fields['target_id'][ONAPP_FIELD_REQUIRED] = true;
            $this->_fields['target_type'][ONAPP_FIELD_REQUIRED] = true;
            $this->_fields['target_type'][ONAPP_FIELD_DEFAULT_VALUE] = 'Disk';
            $this->_fields['action'][ONAPP_FIELD_REQUIRED] = true;
            $this->_fields['action'][ONAPP_FIELD_DEFAULT_VALUE] = 'autobackup';
        }
        
        return parent::save( );
    }
}

?>
