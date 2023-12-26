<!DOCTYPE html>
<?php

use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;

require_once "sandbox/sandbox.php";

if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
require_once "tsugi/config.php";
$LAUNCH = LTIX::session_start();

$retval = $_SESSION['retval'] ?? null;
if ( $retval == null ) die('retval not in session');
$pause = $CFG->getExtension('emcc_pause', 'false') == 'true';

cc4e_emcc_execute("play.php", $retval, $pause);

?>
</body>
</html>
