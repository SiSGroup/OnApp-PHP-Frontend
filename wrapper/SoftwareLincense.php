<?PHP

/**
 * Software Licenses
 *
 *
 * @category  API WRAPPER
 * @package   ONAPP
 * @author    Andrew Yatskovets
 * @copyright 2011 / OnApp
 * @link      http://www.onapp.com/
 * @see       ONAPP
 */

/**
 * require Base class
 */
require_once 'ONAPP.php';

/**
 *
 * Managing Software Lincenses
 *
 * The ONAPP_SoftwareLincense class uses the following basic methods:
 * {@link load}, {@link save}, {@link delete}, and {@link getList}.
 *
 * The ONAPP_SoftwareLincense class represents Software Lincenses.
 * The ONAPP class is a parent of ONAPP_SoftwareLincense class.
 *
 * <b>Use the following XML API requests:</b>
 *
 * Get the list of software licenses
 *
 *     - <i>GET onapp.com/software_licenses.xml</i>
 *
 * Get a particular software license details
 *
 *     - <i>GET onapp.com/software_licenses/{ID}.xml</i>
 *
 * Add new software license
 *
 *     - <i>POST onapp.com/software_licenses.xml</i>
 *
 * <software_licenses type="array">
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <software_licenses type="array">
 *  <software_license>
 *    <license>{LICENSE}</license>
 *  </software_license>
 * </software_licenses>
 * </code>
 *
 * Edit existing group
 *
 *     - <i>PUT onapp.com/software_licenses/{ID}.xml</i>
 *
 * <?xml version="1.0" encoding="UTF-8"?>
 * <software_licenses type="array">
 *  <software_license>
 *    <license>{LICENSE}</license>
 *  </software_license>
 * </software_licenses>
 * </code>
 *
 * Delete group
 *
 *     - <i>DELETE onapp.com/software_licenses/{ID}.xml</i>
 *
 * <b>Use the following JSON API requests:</b>
 *
 * Get the list of groups
 *
 *     - <i>GET onapp.com/software_licenses.json</i>
 *
 * Get a particular group details
 *
 *     - <i>GET onapp.com/software_licenses/{ID}.json</i>
 *
 * Add new group
 *
 *     - <i>POST onapp.com/software_licenses.json</i>
 *
 * <code>
 * {
 *      software_license: {
 *          license:'{LICENSE}',
 *      }
 * }
 * </code>
 *
 * Edit existing group
 *
 *     - <i>PUT onapp.com/software_licenses/{ID}.json</i>
 *
 * <code>
 * {
 *      software_license: {
 *          license:'{LICENSE}',
 *      }
 * }
 * </code>
 *
 * Delete group
 *
 *     - <i>DELETE onapp.com/software_licenses/{ID}.json</i>
 *
 *
 *
 */

class ONAPP_SoftwareLincense extends ONAPP {

    /**
     * the Software License ID
     *
     * @var integer
     */
    var $_id;

    /**
     * the Software License creation date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_created_at;

    /**
     * the Software License update date in the [YYYY][MM][DD]T[hh][mm]Z format
     *
     * @var string
     */
    var $_updated_at;

   /**
     * Windows OS architecture(x64 or x86)
     *
     * @var string
     */
    var $_arch;
    
    /**
     * the total number of machines allowed by the license
     * (the amount of licenses you bought from Microsoft)
     *
     * @var integer
     */
    var $_total;

    /**
     * Windows OS distribution (2003, 2008, 7)
     *
     * @var string
     */
    var $_distro;

    /**
     * the number of licenses used of a total allowed
     *
     * @var integer
     */
    var $_count;
    
    /**
     * parameter specifies the second edition of Windows OS distribution.
     * If updated, than parameter is R2, otherwise – empty.
     *
     * @var string
     */
    var $_tail;

    /**
     *  Windows OS edition or an array of editions if allowed by the license
     * (STD – Standard, ENT –Enterprise, WEB – web, PRO - Professional and
     *  DC – Data center)
     *
     * @var array
     */
    var $_edition;
    
    /**
     * Windows License key
     *
     * @var string
     */
    var $_license;
    
    /**
     * root tag used in the API request
     *
     * @var string
     */
    var $_tagRoot = 'software_license';

    /**
     * alias processing the object data
     *
     * @var string
     */
    var $_resource = 'software_licenses';

    /**
     * called class name
     *
     * @var string
     */
    var $_called_class = 'ONAPP_SoftwareLincense';

    /**
     * API Fields description
     *
     * @access private
     * @var    array
     */
    function _init_fields( $version = NULL ) {
        if( !isset( $this->options[ ONAPP_OPTION_API_TYPE ] ) || ( $this->options[ ONAPP_OPTION_API_TYPE ] == 'json' ) ) {
            $this->_tagRoot = 'software_license';
        }

        if( is_null( $version ) ) {
            $version = $this->_version;
        }

        switch( $version ) {
            case '2.1':
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
                    'arch' => array(
                        ONAPP_FIELD_MAP => '_arch',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'total' => array(
                        ONAPP_FIELD_MAP => '_total',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'distro' => array(
                        ONAPP_FIELD_MAP => '_distro',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'count' => array(
                        ONAPP_FIELD_MAP => '_count',
                        ONAPP_FIELD_TYPE => 'integer',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'tail' => array(
                        ONAPP_FIELD_MAP => '_tail',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                    'edition' => array(
                         ONAPP_FIELD_MAP => '_edition',
                         ONAPP_FIELD_TYPE => 'string',
                         ONAPP_FIELD_REQUIRED => true,
                    ),
                    'license' => array(
                        ONAPP_FIELD_MAP => '_license',
                        ONAPP_FIELD_TYPE => 'string',
                        ONAPP_FIELD_REQUIRED => true,
                    ),
                );

                break;
        }

        return $this->_fields;

    }

}

?>
