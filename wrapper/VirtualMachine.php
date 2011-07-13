<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Managing Virtual Machines
 *
 * When creating a virtual machine, users can select a Hypervisor server with
 * Data Store attached if they wish. If not, the system will find a list of
 * hypervisors with sufficient RAM and available storage and choose the one with
 * the least available RAM.
 *
 * OnApp provides complete management for your virtual machines. You can start,
 * stop, reboot, and delete virtual machines. You can also move VM's between the
 * hypervisors with no downtime. Automatic and manual backups will help you
 * restore the VM’s in case of failure.
 * With OnApp you have an integrated console and complete root access to your
 * virtual machines that provides full control over all files and processes
 * running on the machines.
 *
 * With OnApp you can monitor the CPU usage for each virtual machine and Network
 * Utilization for each network interface. This lets you know when to consider
 * increasing resources available to the system. Also the cloud engine provides
 * the detailed log records of all the tasks which are currently running,
 * pending, failed or completed.
 *
 * @category  API WRAPPER
 * @package   ONAPP
 * @author    Andrew Yatskovets
 * @copyright 2010 / OnApp
 * @link      http://www.onapp.com/
 * @see       ONAPP
 */

/**
 * require Base class
 */
require_once 'ONAPP.php';
require_once 'IpAddress.php';

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_REBOOT', 'reboot' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_SHUTDOWN', 'shutdown' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_CHANGE_OWNER', 'change_owner' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_REBUILD_NETWORK', 'rebuild_network' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_STARTUP', 'startup' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_UNLOCK', 'unlock' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_BUILD', 'build' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_SUSPEND_VM', 'suspend' );

/**
 *
 *
 */
define( 'ONAPP_ACTIVATE_GETLIST_USER', 'getUserVMsList' );

/**
 *
 *
 */
define( 'ONAPP_RESET_ROOT_PASSWORD', 'resetRootPassword' );

/**
 *
 *
 */
define( 'ONAPP_GETRESOURCE_MIGRATE', 'migrate' );



/**
 * Virtual Machines
 *
 * The Virtual Machine class represents the Virtual Machines of the OnAPP installation.
 *
 * The ONAPP_VirtualMachine class uses the following basic methods:
 * {@link load}, {@link save}, {@link delete}, and {@link getList}.
 *
 * <b>Use the following XML API requests:</b>
 *
 * Get the list of virtual machines
 *
 *     - <i>GET onapp.com/virtual_machines.xml</i>
 *
 * Get a particular virtual machine details
 *
 *     - <i>GET onapp.com/virtual_machines/{ID}.xml</i>
 *
 * Add new virtual machine
 *
 *     - <i>POST onapp.com/virtual_machines.xml</i>
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <virtual-machine>
 *     <cpu-shares>{NUMBER}</cpu-shares>
 *     <cpus>{NUMBER}</cpus>
 *     <hostname>{HOSTNAME}</hostname>
 *     <hypervisor-id>{ID}</hypervisor-id>
 *     <initial-root-password>{PASSWORD}</initial-root-password>
 *     <memory>{SIZE}</memory>
 *     <template-id>{ID}</template-id>
 *     <primary-disk-size>{SIZE}</primary-disk-size>
 *     <swap-disk-size>{SIZE}</swap-disk-size>
 * </virtual-machine>
 * </code>
 *
 * Edit existing virtual machine
 *
 *     - <i>PUT onapp.com/virtual_machines/{ID}.xml</i>
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <virtual-machine>
 *     <cpu-shares>{NUMBER}</cpu-shares>
 *     <cpus>{NUMBER}</cpus>
 *     <hostname>{HOSTNAME}</hostname>
 *     <hypervisor-id>{ID}</hypervisor-id>
 *     <initial-root-password>{PASSWORD}</initial-root-password>
 *     <memory>{SIZE}</memory>
 *     <template-id>{ID}</template-id>
 *     <primary-disk-size>{SIZE}</primary-disk-size>
 *     <swap-disk-size>{SIZE}</swap-disk-size>
 * </virtual-machine>
 * </code>
 *
 * Delete virtual machine
 *
 *     - <i>DELETE onapp.com/virtual_machines/{ID}.xml</i>
 *
 * <b>Use the following JSON API requests:</b>
 *
 * Get the list of virtual machines
 *
 *     - <i>GET onapp.com/virtual_machines.json</i>
 *
 * Get a particular virtual machine details
 *
 *     - <i>GET onapp.com/virtual_machines/{ID}.json</i>
 *
 * Add new virtual machine
 *
 *     - <i>POST onapp.com/virtual_machines.json</i>
 *
 * <code>
 * {
 *     virtual-machine: {
 *         cpu-shares:{NUMBER},
 *         cpus:{NUMBER},
 *         hostname:'{HOSTNAME}',
 *         hypervisor-id:{ID},
 *         initial-root-password:'{PASSWORD}',
 *         memory:{SIZE},
 *         template-id:{ID},
 *         primary-disk-size:{SIZE},
 *         swap-disk-size:{SIZE}
 *      }
 * }
 * </code>
 *
 * Edit existing virtual machine
 *
 *     - <i>PUT onapp.com/virtual_machines/{ID}.json</i>
 *
 * <code>
 * {
 *      virtual-machine: {
 *         cpu-shares:{NUMBER},
 *         cpus:{NUMBER},
 *         hostname:'{HOSTNAME}',
 *         hypervisor-id:{ID},
 *         initial-root-password:'{PASSWORD}',
 *         memory:{SIZE},
 *         template-id:{ID},
 *         primary-disk-size:{SIZE},
 *         swap-disk-size:{SIZE}
 *      }
 * }
 * </code>
 *
 * Delete virtual machine
 *
 *     - <i>DELETE onapp.com/virtual_machines/{ID}.json</i>
 */
class ONAPP_VirtualMachine extends ONAPP {

    /**
     * the virtual machine ID
     *
     * @var integer
     */
    var $_id;

    /**
     * true if booted. Otherwise false
     *
     * @var integer
     */
    var $_booted;

    /**
     * true if built. Otherwise false
     *
     * @var integer
     */
    var $_built;

    /**
     * the number of CPU Shares
     *
     * @var integer
     */
    var $_cpu_shares;

    /**
     * the number of CPUs
     *
     * @var integer
     */
    var $_cpus;

    /**
     * the date when VM was created in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_created_at;

    /**
     * the name of your host
     *
     * @var integer
     */
    var $_hostname;

    /**
     * the ID of the hypervisor used by this VM
     *
     * @var integer
     */
    var $_hypervisor_id;

    /**
     * the VM identifier
     *
     * @var integer
     */
    var $_identifier;

    /**
     * the VM root password
     *
     * @var integer
     */
    var $_initial_root_password;

    /**
     * the VM label
     *
     * @var integer
     */
    var $_label;

    /**
     * The port ID used for console access
     *
     * @var integer
     */
    var $_local_remote_access_port;

    /**
     * true if the VM is locked. Otherwise false
     *
     * @var integer
     */
    var $_locked;

    /**
     * the memory size
     *
     * @var integer
     */
    var $_memory;

    /**
     * the bandwidth used this month
     *
     * @var integer
     */
    var $_monthly_bandwidth_used;

    /**
     * true if recovery mode allowed. Otherwise false
     *
     * @var integer
     */
    var $_recovery_mode;

    /**
     * the password for the remote access
     *
     * @var integer
     */
    var $_remote_access_password;

    /**
     * the ID of the template the VM is based on
     *
     * @var integer
     */
    var $_template_id;

    /**
     * the date when the Virtual Machine was updated in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

    /**
     * the ID of the Xen virtualizing this VM
     *
     * @var integer
     */
    var $_xen_id;

    /**
     * true if swap alowed. Otherwise false
     *
     * @var integer
     */
    var $_allowed_swap;

    /**
     * true if resize without reboot alowed. Otherwise false
     *
     * @var integer
     */
    var $_allow_resize_without_reboot;

    /**
     * the VM IP addresses
     *
     * @var array
     */
    var $_ip_addresses;

    /**
     * the minimal size of the disk
     *
     * @var integer
     */
    var $_min_disk_size;

    /**
     * the Operating System installed with this VM
     *
     * @var string
     */
    var $_operating_system;

    /**
     * the Operating System distribution installed with this VM
     *
     * @var integer
     */
    var $_operating_system_distro;

    /**
     * the label of the template the VM is based on
     *
     * @var string
     */
    var $_template_label;

    /**
     * The User ID
     *
     * @var integer
     */
    var $_user_id;

    /**
     * the size of the primary disk
     *
     * @var integer
     */
    var $_primary_disk_size;

    /**
     * the size of the swap disk
     *
     * @var integer
     */
    var $_swap_disk_size;

    /**
     * the primary network ID
     *
     * @var integer
     */
    var $_primary_network_id;

    /**
     * true if automatic backup required. Otherwise false
     *
     * @var boolean
     */
    var $_required_automatic_backup;

    /**
     * the rate limit
     *
     * @var integer
     */
    var $_rate_limit;

    /**
     * true if IP address assigment required. Otherwise false
     *
     * @var boolean
     */
    var $_required_ip_address_assignment;

    /**
     * true if VM build after creation required. Otherwise false
     *
     * @var boolean
     */
    var $_required_virtual_machine_build;

    /**
     * show total disks size
     *
     * @var string
     */
    var $_total_disk_size;

    /**
     * shows whether startup is required
     *
     * @var boolean
     */
    var $_required_startup;

    /**
     * consists admin note
     *
     * @var string
     */
    var $_admin_note;

    /**
     * if true
     *
     * @var boolean
     */
    var $_allowed_hot_migrate;

   /**
     * if true
     *
     * @var boolean
     */
    var $_note;

    /**
     * strict virtual machine id
     *
     * @var integer
     */
    var $_strict_virtual_machine_id;

    /**
     * shows whether virtual machine is suspended
     *
     * @var boolean
     */
    var $_suspended;

    /**
     * shows whether autoscale is enabled
     *
     * @var boolean
     */
    var $_enable_autoscale;

    /**
     * shows whether monitis is enabled
     *
     * @var boolean
     */
    var $_enable_monitis;

    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'virtual-machine';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'virtual_machines';

    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_VirtualMachine';

    /**
     * API Fields description
     *
     * @access private
     * @var    array
     */
    function _init_fields( $version = NULL ) {
        if( !isset( $this->options[ ONAPP_OPTION_API_TYPE ] ) || ( $this->options[ ONAPP_OPTION_API_TYPE ] == 'json' ) ) {
            $this->_tagRoot = 'virtual_machine';
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
                    'booted' => array(
                        ONAPP_FIELD_MAP => '_booted',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'built' => array(
                        ONAPP_FIELD_MAP => '_built',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'cpu_shares' => array(
                        ONAPP_FIELD_MAP => '_cpu_shares',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => 1
                    ),
                    'cpus' => array(
                        ONAPP_FIELD_MAP => '_cpus',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => 1
                    ),
                    'created_at' => array(
                        ONAPP_FIELD_MAP => '_created_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'hostname' => array(
                        ONAPP_FIELD_MAP => '_hostname',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_DEFAULT_VALUE => ''
                    ),
                    'hypervisor_id' => array(
                        ONAPP_FIELD_MAP => '_hypervisor_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => ''
                    ),
                    'identifier' => array(
                        ONAPP_FIELD_MAP => '_identifier',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'initial_root_password' => array(
                        ONAPP_FIELD_MAP => '_initial_root_password',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => ''
                    ),
                    'label' => array(
                        ONAPP_FIELD_MAP => '_label',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'local_remote_access_port' => array(
                        ONAPP_FIELD_MAP => '_local_remote_access_port',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'locked' => array(
                        ONAPP_FIELD_MAP => '_locked',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'memory' => array(
                        ONAPP_FIELD_MAP => '_memory',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => 256
                    ),
                    'recovery_mode' => array(
                        ONAPP_FIELD_MAP => '_recovery_mode',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'remote_access_password' => array(
                        ONAPP_FIELD_MAP => '_remote_access_password',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'template_id' => array(
                        ONAPP_FIELD_MAP => '_template_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                        ONAPP_FIELD_DEFAULT_VALUE => ''
                    ),
                    'updated_at' => array(
                        ONAPP_FIELD_MAP => '_updated_at',
                        ONAPP_FIELD_TYPE => 'datetime',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'user_id' => array(
                        ONAPP_FIELD_MAP => '_user_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'xen_id' => array(
                        ONAPP_FIELD_MAP => '_xen_id',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'allowed_swap' => array(
                        ONAPP_FIELD_MAP => '_allowed_swap',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'allow_resize_without_reboot' => array(
                        ONAPP_FIELD_MAP => '_allow_resize_without_reboot',
                        ONAPP_FIELD_TYPE => 'boolean',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'ip_addresses' => array(
                        ONAPP_FIELD_MAP => '_ip_addresses',
                        ONAPP_FIELD_TYPE => 'array',
                        ONAPP_FIELD_READ_ONLY => true,
                        ONAPP_FIELD_CLASS => 'IpAddress',
                    ),
                    'min_disk_size' => array(
                        ONAPP_FIELD_MAP => '_min_disk_size',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'monthly_bandwidth_used' => array(
                        ONAPP_FIELD_MAP => '_monthly_bandwidth_used',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'operating_system' => array(
                        ONAPP_FIELD_MAP => '_operating_system',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'operating_system_distro' => array(
                        ONAPP_FIELD_MAP => '_operating_system_distro',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'template_label' => array(
                        ONAPP_FIELD_MAP => '_template_label',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                    'total_disk_size' => array(
                        ONAPP_FIELD_MAP => '_total_disk_size',
                        ONAPP_FIELD_READ_ONLY => true,
                    ),
                );

                break;

            case '2.1':
                $this->_fields = $this->_init_fields('2.0');

                $this->_fields[ 'admin_note' ] = array(
                    ONAPP_FIELD_MAP => '_admin_note',
                    ONAPP_FIELD_TYPE => 'string',
                );

                $this->_fields[ 'allowed_hot_migrate' ] = array(
                    ONAPP_FIELD_MAP => '_allowed_hot_migrate',
                    ONAPP_FIELD_TYPE => 'boolean',
                    ONAPP_FIELD_REQUIRED => true,
                    ONAPP_FIELD_DEFAULT_VALUE => '0'
                );

                $this->_fields[ 'note' ] = array(
                    ONAPP_FIELD_MAP => '_note',
                    ONAPP_FIELD_TYPE => 'string',
                );

                $this->_fields[ 'strict_virtual_machine_id' ] = array(
                    ONAPP_FIELD_MAP => '_strict_virtual_machine_id',
                    ONAPP_FIELD_TYPE => 'integer',
                );

                $this->_fields[ 'suspended' ] = array(
                    ONAPP_FIELD_MAP => '_suspended',
                    ONAPP_FIELD_TYPE => 'boolean',
                );

                $this->_fields[ 'enable_autoscale' ] = array(
                    ONAPP_FIELD_MAP => '_enable_autoscale',
                    ONAPP_FIELD_TYPE => 'boolean',
                    ONAPP_FIELD_READ_ONLY => true,
                );

                $this->_fields[ 'enable_monitis' ] = array(
                    ONAPP_FIELD_MAP => '_enable_monitis',
                    ONAPP_FIELD_TYPE => 'boolean',
                    ONAPP_FIELD_READ_ONLY => true,
                );

                if ( $this->_release == "0") {
                    unset($this->_fields[ 'enable_autoscale' ]);
                };

                break;
        }

        if( is_null( $this->_id ) ) {
            $this->_fields[ "primary_disk_size" ] = array(
                ONAPP_FIELD_MAP => '_primary_disk_size',
                ONAPP_FIELD_TYPE => 'integer',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => 5
            );
            $this->_fields[ "swap_disk_size" ] = array(
                ONAPP_FIELD_MAP => '_swap_disk_size',
                ONAPP_FIELD_TYPE => 'integer',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => 0
            );
            $this->_fields[ "primary_network_id" ] = array(
                ONAPP_FIELD_MAP => '_primary_network_id',
                ONAPP_FIELD_TYPE => 'integer',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => ''
            );
            $this->_fields[ "required_automatic_backup" ] = array(
                ONAPP_FIELD_MAP => '_required_automatic_backup',
                ONAPP_FIELD_TYPE => 'boolean',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => ''
            );
            $this->_fields[ "rate_limit" ] = array(
                ONAPP_FIELD_MAP => '_rate_limit',
                ONAPP_FIELD_TYPE => 'integer',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => ''
            );
            $this->_fields[ "required_ip_address_assignment" ] = array(
                ONAPP_FIELD_MAP => '_required_ip_address_assignment',
                ONAPP_FIELD_TYPE => 'boolean',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => '1'
            );
            $this->_fields[ "required_virtual_machine_build" ] = array(
                ONAPP_FIELD_MAP => '_required_virtual_machine_build',
                ONAPP_FIELD_TYPE => 'boolean',
                ONAPP_FIELD_REQUIRED => true,
                ONAPP_FIELD_DEFAULT_VALUE => ''
            );
        }

        return $this->_fields;
    }

    function getResource( $action = ONAPP_GETRESOURCE_DEFAULT ) {
        switch( $action ) {
            case ONAPP_GETRESOURCE_REBOOT:

                /**
                 * ROUTE :
                 * @name reboot_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/reboot(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"reboot"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/reboot';
                break;

            case ONAPP_GETRESOURCE_SHUTDOWN:

                /**
                 * ROUTE :
                 * @name shutdown_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/shutdown(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"shutdown"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/shutdown';
                break;
            case ONAPP_GETRESOURCE_CHANGE_OWNER:

                /**
                 * ROUTE :
                 * @name change_owner_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/change_owner(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"change_owner"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/change_owner';
                break;
            case ONAPP_GETRESOURCE_REBUILD_NETWORK:

                /**
                 * ROUTE :
                 * @name rebuild_network_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/rebuild_network(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"rebuild_network"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/rebuild_network';
                break;

            case ONAPP_GETRESOURCE_STARTUP:

                /**
                 * ROUTE :
                 * @name shutdown_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/startup(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"startup"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/startup';
                break;

            case ONAPP_GETRESOURCE_UNLOCK:

                /**
                 * ROUTE :
                 * @name shutdown_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/unlock(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"unlock"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/unlock';
                break;

            case ONAPP_GETRESOURCE_MIGRATE:

                /**
                 * ROUTE :
                 * @name migrate_virtual_machine
                 * @method POST
                 * @alias   /virtual_machines/:id/migrate(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"migrate"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/migrate';
                break;

            case ONAPP_GETRESOURCE_SUSPEND_VM:

                /**
                 * ROUTE :
                 * @name suspend_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/suspend(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"suspend"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/suspend';
                break;

            case ONAPP_GETRESOURCE_BUILD:

                /**
                 * ROUTE :
                 * @name build_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/build(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"build"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/build';
                break;

            case ONAPP_RESET_ROOT_PASSWORD:

                /**
                 * ROUTE :
                 * @name reset_password_virtual_machine
                 * @method POST
                 * @alias  /virtual_machines/:id/reset_password(.:format)
                 * @format {:controller=>"virtual_machines", :action=>"reset_password"}
                 */

                $resource = $this->getResource( ONAPP_GETRESOURCE_LOAD ) . '/reset_password';
                break;

            case ONAPP_ACTIVATE_GETLIST_USER:

                /**
                 * ROUTE :
                 * @name user_virtual_machines
                 * @method POST
                 * @alias  /users/:user_id/virtual_machines(.:format)
                 * @format {:controller=>"virtual_machines", :action=>"index"}
                 */

                $resource = "/users/" . $this->_user_id . "/virtual_machines";
                break;

            default:

                /**
                 * ROUTE :
                 * @name virtual_machines
                 * @method GET
                 * @alias  /virtual_machines(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"index"}
                 */

                /**
                 * ROUTE :
                 * @name virtual_machine
                 * @method GET
                 * @alias  /virtual_machines/:id(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"show"}
                 */

                /**
                 * ROUTE :
                 * @name
                 * @method POST
                 * @alias  /virtual_machines(.:format)
                 * @format   {:controller=>"virtual_machines", :action=>"create"}
                 */

                /**
                 * ROUTE :
                 * @name
                 * @method PUT
                 * @alias  /virtual_machines/:id(.:format)
                 * @format {:controller=>"virtual_machines", :action=>"update"}
                 */

                /**
                 * ROUTE :
                 * @name
                 * @method DELETE
                 * @alias  /virtual_machines/:id(.:format)
                 * @format  {:controller=>"virtual_machines", :action=>"destroy"}
                 */

                $resource = parent::getResource( $action );
                break;
        }

        $actions = array(
            ONAPP_GETRESOURCE_REBOOT,
            ONAPP_GETRESOURCE_SHUTDOWN,
            ONAPP_GETRESOURCE_STARTUP,
            ONAPP_GETRESOURCE_UNLOCK,
            ONAPP_GETRESOURCE_BUILD,
            ONAPP_ACTIVATE_GETLIST_USER,
            ONAPP_GETRESOURCE_SUSPEND_VM,
            ONAPP_RESET_ROOT_PASSWORD
        );
        if( in_array( $action, $actions ) ) {
            $this->_loger->debug( "getResource($action): return " . $resource );
        }

        return $resource;
    }

    /**
     * Reboot Virtual machine
     *
     * @param string $mode reboot mode
     * @access public
     */
    function reboot( $recovery = false ) {
        if ( ! $recovery ) { 
            $this->sendPost( ONAPP_GETRESOURCE_REBOOT );
        } else {
              switch( $this->options[ ONAPP_OPTION_API_TYPE ] ) {
                  case 'xml':
                      $data = '<mode>recovery</mode>';
                      break;
                  case 'json':
                      $data = json_encode( array( 'mode' => 'recovery' ));
                      break;
                  default:
                      $this->_loger->error(
                          "_POSTAction: Can't find serialize and unserialize functions for type (apiVersion => '"
                          . $this->_apiVersion . "').", __FILE__, __LINE__
                      );
                      exit;
                      break;
              }

              $this->sendPost( ONAPP_GETRESOURCE_REBOOT, $data );
          }
    }

    /**
    * Resets Virtual Machine Root Password
    *
    * @access public
    */
    function reset_password( ) {
        $this->sendPost( ONAPP_RESET_ROOT_PASSWORD);
    }

    /**
    * Suspends Virtual Machine
    *
    * @access public
    */
    function suspend( ) {
        $this->sendPost( ONAPP_GETRESOURCE_SUSPEND_VM);
    }

    /**
     * Stop Virtual Machine
     *
     * @access public
     */
    function shutdown( ) {
        $this->sendPost( ONAPP_GETRESOURCE_SHUTDOWN );
    }

    /**
     * Migrates Virtual Machine to the other hypervisor
     *
     * @param integer virtual machine id
     * @param integer destination hypervisor id
     * @access public
     */
    function migrate( $id, $hypervisor_id ) {
        if( $id ){
            $this->_id = $id;
        }

        switch( $this->options[ ONAPP_OPTION_API_TYPE ] ) {
                  case 'xml':
                      $data ="<destination>". $hypervisor_id ."</destination>";
                      break;
                  case 'json':
                      $data = json_encode( array( 'destination' => $hypervisor_id, 'cold_migrate_on_rollback' => 1 ));
                      break;
                  default:
                      $this->_loger->error(
                          "_POSTAction: Can't find serialize and unserialize functions for type (apiVersion => '"
                          . $this->_apiVersion . "').", __FILE__, __LINE__
                      );
                      exit;
                      break;
        }

        $this->sendPost( ONAPP_GETRESOURCE_MIGRATE, $data );
    }

    /**
     * Change Virtual Machine Owner
     *
     * @access public
     *
     * @return response object
     */
    function change_owner( $user_id = false ) {
        if (! $user_id ) {
                $this->sendPost( ONAPP_GETRESOURCE_STARTUP );
        } else {
            switch( $this->options[ ONAPP_OPTION_API_TYPE ] ) {
                case 'xml':
                    $data = '<user_id>'. $user_id . '</user_id>';
                    break;
                case 'json':
                    $data = json_encode( array( 'user_id' => $user_id ));
                    break;
                default:
                    $this->_loger->error( "_POSTAction: Can't find
                    serialize and unserialize functions for type (apiVersion => '"
                    . $this->_apiVersion . "').", __FILE__, __LINE__ );
                    break;
            }
            $this->sendPost( ONAPP_GETRESOURCE_CHANGE_OWNER , $data );
        }
        return $this->_obj;
    }

    /**
     * Rebuilds network for virtual machine
     *
     * @access public
     */
    function rebuild_network( ) {
        $this->sendPost( ONAPP_GETRESOURCE_REBUILD_NETWORK );
    }

    /**
     * Start Virtual machine
     *
     * @access public
     *
     * @return object response object
     */
    function startup( $recovery = false ) {
        if (! $recovery ) {
                $this->sendPost( ONAPP_GETRESOURCE_STARTUP );
        } else {
            switch( $this->options[ ONAPP_OPTION_API_TYPE ] ) {
                case 'xml':
                    $data = '<mode>recovery</mode>';
                    break;
                case 'json':
                    $data = json_encode( array( 'mode' => 'recovery' ));
                    break;
                default:
                    $this->_loger->error( "_POSTAction: Can't find
                    serialize and unserialize functions for type (apiVersion => '"
                    . $this->_apiVersion . "').", __FILE__, __LINE__ );
                    break;
            }
            $this->sendPost( ONAPP_GETRESOURCE_STARTUP, $data );
        }
        return $this->_obj;
    }

    /**
     * Unlock Virtual machine
     *
     * @access public
     */
    function unlock( ) {
        $this->sendPost( ONAPP_GETRESOURCE_UNLOCK );
    }

    /**
     * Build or rebuild Virtual machine
     *
     * @access public
     */
    function build( ) {
        $this->sendPost( ONAPP_GETRESOURCE_BUILD );
    }

    /**
     * Sends an API request to get the Objects. After requesting,
     * unserializes the received response into the array of Objects
     *
     * @return the array of Object instances
     * @access public
     */
    function getList( $user_id = NULL ) {

        if( is_null( $user_id ) ) {
            return parent::getList( );
        }
        else {
            $this->activate( ONAPP_ACTIVATE_GETLIST );

            $this->_loger->add( "getList: Get Transaction list." );

            $this->_user_id = $user_id;

            $this->setAPIResource( $this->getResource( ONAPP_ACTIVATE_GETLIST_USER ) );

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
    }

    /**
     * Save Object into your account.
     */
    function save( ) {
        if( !is_null($this->_id) ) {
            parent::save( );
            return;
        }
            
        $fields = $this->_fields;

        $this->_fields[ "primary_disk_size" ] = array(
            ONAPP_FIELD_MAP => '_primary_disk_size',
            ONAPP_FIELD_TYPE => 'integer',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => 5
        );
        $this->_fields[ "swap_disk_size" ] = array(
            ONAPP_FIELD_MAP => '_swap_disk_size',
            ONAPP_FIELD_TYPE => 'integer',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => 0
        );
        $this->_fields[ "primary_network_id" ] = array(
            ONAPP_FIELD_MAP => '_primary_network_id',
            ONAPP_FIELD_TYPE => 'integer',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => ''
        );
        $this->_fields[ "required_automatic_backup" ] = array(
            ONAPP_FIELD_MAP => '_required_automatic_backup',
            ONAPP_FIELD_TYPE => 'boolean',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => ''
        );
        $this->_fields[ "rate_limit" ] = array(
            ONAPP_FIELD_MAP => '_rate_limit',
            ONAPP_FIELD_TYPE => 'integer',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => ''
        );
        $this->_fields[ "required_ip_address_assignment" ] = array(
            ONAPP_FIELD_MAP => '_required_ip_address_assignment',
            ONAPP_FIELD_TYPE => 'boolean',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => '1'
        );
        $this->_fields[ "required_virtual_machine_build" ] = array(
            ONAPP_FIELD_MAP => '_required_virtual_machine_build',
            ONAPP_FIELD_TYPE => 'boolean',
            ONAPP_FIELD_REQUIRED => true,
            ONAPP_FIELD_DEFAULT_VALUE => ''
        );

        parent::save( );

        $this->_fields = $fields;
    }
    /**
     * Edit Administrator's Note
     *
     * @param integer virtual machine id
     * @param string Administrator's Note
     * @return void
     */
    function editAdminNote( $id, $admin_note ){
        if( $admin_note ){
            $this->_admin_note = $admin_note;
        }
        
        if( $id ){
            $this->_id = $id;
        }

        $this->_fields = null;
        $this->_fields[ 'admin_note' ] = array(
            ONAPP_FIELD_MAP => '_admin_note',
            ONAPP_FIELD_TYPE => 'string',
            ONAPP_FIELD_REQUIRED => true,
        );

        parent::save();

    }
}

?>
