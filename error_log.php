<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 0 );

register_shutdown_function( 'onapp_shutdown_function' );
set_error_handler( 'onapp_error_handler' );

/**#@+
 * ERROR constants
 */
define('ONAPP_E_FATAL',  1);
define('ONAPP_E_WARN',   2);
define('ONAPP_E_NOTICE', 4);
define('ONAPP_E_INFO',   8);
define('ONAPP_E_DEBUG', 16);

/**
 * Writes string into file
 *
 * @param string $filename File name
 * @param string $content  Content string
 *
 * @return void
 *
 */
function onapp_file_write($type, $content) {
    $log_directory = ONAPP_LOG_DIRECTORY;

    if (! isset($_SESSION['log_id'] ) )
        return;

    switch ($type) {
        case 'frontend':
            $filename = "$log_directory/frontend.log";
            break;
        case 'wrapper':
        case 'onapp':
            $filename = "$log_directory/wrapper.log";
            break;
        case 'third':
            $filename = "$log_directory/third.log";
            break;
        case 'error':
            if( isset($_SESSION['log_id']) )
                $filename = "$log_directory/error_".$_SESSION['log_id'].'.log';
            else
                return;
            break;
        default:
            return;
            break;
    }

    if (!$handle = fopen($filename, 'a+'))
         die("Cannot create file $filename in file ".__FILE__.' line '.__LINE__);

    if (fwrite($handle, $content."\n") === FALSE)
        die("Cannot write to file $filename");

    fclose($handle);
}

/**
 *
 * Inits log id and logs levels
 *
 * @global array $_LOG_LEVELS_FRONTEND
 *
 * @return void
 *
 */
function onapp_init_log() {
    $_SESSION['log_id'] = substr(md5($_SESSION['id'] . date('d-m-Y H-i-s') ), -10);

    onapp_debug('Initialise frontend loger');
    onapp_debug('onapp_init_log: log_id => ' . $_SESSION['log_id']);
}

/**
 * Adds onapp debug.
 *
 * @param string $message Debug message
 *
 * @param mixed $obj Mixed variable to print
 *
 * @return void
 *
 */
function onapp_debug( $message )
{
    if( ONAPP_LOG_LEVEL_FRONTEND < ONAPP_E_DEBUG )
        return;

    $msg = '['.$_SESSION['log_id']."] : [DEBUG] $message";

    onapp_file_write('frontend', $msg);
}

/**
 * Adds onapp info.
 *
 * @param string $message Information message
 *
 * @param mixed $obj Mixed variable to print
 *
 * @return void
 *
 */
function onapp_info( $message )
{
    if( ONAPP_LOG_LEVEL_FRONTEND < ONAPP_E_INFO )
        return;

    $msg = '['.$_SESSION['log_id']."] : [INFO] $message";

    onapp_file_write('frontend', $msg);
}

/**
 * Adds onapp notice message.
 *
 * @param string $message Warning message
 *
 * @return void
 *
 */
function onapp_notice( $message )
{
    if( ONAPP_LOG_LEVEL_FRONTEND < ONAPP_E_NOTICE )
        return;

    $msg = '['.$_SESSION['log_id']."] : [WARN] $message";

    onapp_file_write('frontend', $msg);
}

/**
 * Adds onapp warning message.
 *
 * @param string $message Warning message
 *
 * @return void
 *
 */
function onapp_warn( $message )
{
    if( ONAPP_LOG_LEVEL_FRONTEND < ONAPP_E_WARN )
        return;

    $msg = '['.$_SESSION['log_id']."] : [WARN] $message";

    onapp_file_write('frontend', $msg);
}


/**
 * Adds onapp die message.
 *
 * @param string $message Warning message
 *
 * @return void
 *
 */
function onapp_die( $message )
{
    $msg = '['.$_SESSION['log_id']."] : [FATAL] $message";

    onapp_file_write('error', $msg);

    onapp_error_handler(E_ERROR, $message);

    die($message);
}

/**
 * Adds onapp fatal message.
 *
 * @param string $message Fatal error message
 *
 * @return void
 *
 */
function onapp_shutdown_function()
{
    $error = error_get_last( );

    onapp_error_reporting($error);

    die();
## TODO show error page with error log file path
}

/**
 * TODO add description
 */
function onapp_error_handler( $type, $message, $file = NULL, $line = NULL, $context = NULL ) {

    $error = array(
        'type'    => $type,
        'message' => $message,
        'file'    => $file,
        'line'    => $line
    );
    onapp_error_reporting($error);

    $last_error = error_get_last( );
    onapp_error_reporting($last_error);
}

/**
 * Adds onapp error message.
 *
 * @param string $message Error message from error_get_last function
 *
 * @return void
 *
 */
function onapp_error_reporting($error) {
    $error_levels = array(
        30719 => 'E_ALL',
        16384 => 'E_USER_DEPRECATED',
        8192  => 'E_DEPRECATED',
        4096  => 'E_RECOVERABLE_ERROR',
        2048  => 'E_STRICT',
        1024  => 'E_USER_NOTICE',
        512   => 'E_USER_WARNING',
        256   => 'E_USER_ERROR',
        128   => 'E_COMPILE_WARNING',
        64    => 'E_COMPILE_ERROR',
        32    => 'E_CORE_WARNING',
        16    => 'E_CORE_ERROR',
        8     => 'E_NOTICE',
        4     => 'E_PARSE',
        2     => 'E_WARNING',
        1     => 'E_ERROR'
    );

    if( ONAPP_LOG_LEVEL_PHP < $error['type'] || is_null($error) )
        return;

    $error_type = in_array($error['type'], array_keys($error_levels) ) ? $error_levels[$error['type']] : "ERROR ID ".$error['type'];

    if( $error !== NULL ) {
        if ( is_null($error['file']) && is_null($error['line']) )
            $msg = '['.$_SESSION['log_id'] . "] : [$error_type] : " . $error['message'] ;
        else
            $msg = '['.$_SESSION['log_id']."] : [$error_type] in " . $error['file'] . ' on line ' . $error['line'] .' \''. $error['message'] . '\'';

        onapp_file_write('frontend', "$msg");
        onapp_file_write('error',    "$msg");
    }
}
