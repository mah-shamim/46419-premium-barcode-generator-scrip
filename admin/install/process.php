<?php
/*
 * @author KOVATZ
*/

// Don't crack license checker. It will crash whole website and handle incorrectly!
// If you want to request new purchase code for "localhost" installation and for "development" site (or) Reset old code for your new domain name then contact support!
// For Support, mail to us: codefirmpk@gmail.com [at] gmail.com
error_reporting(1);
define('ROOT_DIR', realpath(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'core' . DIRECTORY_SEPARATOR);
define('CONFIG_DIR', APP_DIR . 'config' . DIRECTORY_SEPARATOR);
define('INSTALL_DIR', ROOT_DIR . 'admin' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR);
$_0c7870277354 = Trim($_POST['data_host']);
$_bcfe0791f707 = Trim($_POST['data_name']);
$_a2f5f1080660 = Trim($_POST['data_user']);
$_782b05a5c97f = Trim($_POST['data_pass']);
$_0966e88b0904 = Trim($_POST['data_sec']);
$_ffd1906765f8 = urlencode($_POST['data_domain']);
$_8ee7d7973f01 = mysqli_connect($_0c7870277354, $_a2f5f1080660, $_782b05a5c97f, $_bcfe0791f707);
if (mysqli_connect_errno())
{
    echo "Database Connection failed";
    die();
}

$_d4482200c060 = '1';
$_71026e533112 = '';
if ($_d4482200c060 == '1')
{
}
elseif ($_d4482200c060 == '0')
{
    echo 'Item purchase code not valid';
    die();
}
elseif ($_d4482200c060 == '2')
{
    echo 'Already code used on another domain! Contact Support';
    die();
}
elseif ($_d4482200c060 == '')
{
    echo 'Unable Connect to Server!';
    die();
}
else
{
    echo 'Item purchase code not valid / banned';
    die();
}
if ($_71026e533112 == '') $_71026e533112 = Md5($_ffd1906765f8);
function configString($_e2deda961c6d)
{
    return str_replace("'", "\'", $_e2deda961c6d);
}
$_ffd1906765f8 = str_replace(array(
    'http://',
    'https://',
    'www.'
) , '', urldecode($_ffd1906765f8));
if (substr($_ffd1906765f8, -1) != '/') $_ffd1906765f8 = $_ffd1906765f8 . '/';
$_698fc217f6b0 = '<?php
defined(\'ROOT_DIR\') or die(header(\'HTTP/1.0 403 Forbidden\'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ PHP Framework
 * @copyright 2024 KOVATZ
 *
 */

// --- Database Settings ---

// Database Hostname
$dbHost = \'' . configString($_0c7870277354) . '\';

// Database Username
$dbUser = \'' . configString($_a2f5f1080660) . '\';

// Database Password
$dbPass = \'' . configString($_782b05a5c97f) . '\';

// Database Name
$dbName = \'' . configString($_bcfe0791f707) . '\';

//Base URL (Without http:// & https://)
$baseURL = \'' . $_ffd1906765f8 . '\';

//Item Purchase Code
$item_purchase_code = \'' . $_0966e88b0904 . '\';

//Domain Security Code
$authCode = \'' . $_71026e533112 . '\';

';
file_put_contents(CONFIG_DIR . 'db.config.php', $_698fc217f6b0);
echo '1';
die();