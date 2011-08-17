<?php require_once 'header.inc';?>
    <table align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th colspan="2">
                Installation
            </th>
        </tr>
        <tr>
            <th colspan="2">
                &nbsp;
            </th>
        </tr>
        <tr>
            <th colspan="2">
                System Requirements Checks
            </th>
        </tr>
        <tr>
            <td>
                PHP Version
            </td>
            <td>
                <?php echo $version_compare_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                mod_rewrite
            </td>
            <td>
                <?php echo $mod_rewrite_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                mod_php5
            </td>
            <td>
                <?php echo $mod_php_txt ?>
            </td>
        </tr>
        <tr>
            <td>
                Curl
            </td>
            <td>
                <?php echo $curl_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                Mctypt
            </td>
            <td>
                <?php echo $mcrypt_txt ?>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                Permissions Checks
            </th>
        </tr>
        <tr>
            <td>
                Configuration File
            </td>
            <td>
                <?php echo $config_file_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                Logs Directory
            </td>
            <td>
                <?php echo $logs_dir_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                Templates Directory
            </td>
            <td>
                <?php echo $templates_dir_txt; ?>
            </td>
        </tr>
        <tr>
            <td>
                Cache Directory
            </td>
            <td>
                <?php echo $cache_dir_txt; ?>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                .htaccess file
            </th>
        </tr>
        <tr>
            <td>
                .htaccess file
            </td>
            <td>
                <?php $htaccess_fite_txt; ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <?php echo $not_passed_txt; ?>


                <form action="" method="post">
                    <input type="submit" value="Install" <?php echo $disabled; ?> />
                    <input type="hidden" name="step" value="2" />
                </form>
            </td>
            <td></td>
        </tr>

    </table>
</body>
</html>