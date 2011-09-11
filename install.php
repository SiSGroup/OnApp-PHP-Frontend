<?php
/*
 * Installation check, and check on removal of the install directory.
 */ 
if ( filesize( ONAPP_PATH . ONAPP_DS . 'config.ini' ) < 10 && ! file_exists( ONAPP_PATH . ONAPP_DS . 'install/index.php' )  ) {
    die( 'No configuration file found and no installation code available. Exiting...' );
}
elseif (  filesize ( ONAPP_PATH . ONAPP_DS . 'config.ini' ) < 10 &&  file_exists( ONAPP_PATH. ONAPP_DS .'install/index.php' ) ) {
    header( 'Location: install/index.php' );
    exit;
}
elseif (  filesize ( ONAPP_PATH . ONAPP_DS . 'config.ini' ) > 10 && file_exists( ONAPP_PATH . ONAPP_DS . 'install/index.php' ) ) {
    echo 'You need to delete or rename install directory!';
    exit;
}