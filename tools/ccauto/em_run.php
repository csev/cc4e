<!DOCTYPE html>
<?php

use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;

require_once "../config.php";
require_once "../../sandbox/sandbox.php";

$LAUNCH = LTIX::session_start();

$retval = $_SESSION['retval'] ?? null;
if ( $retval == null ) die('retval not in session');
$pause = $CFG->getExtension('emcc_pause', 'false') == 'true';

cc4e_emcc_execute(addSession("index.php"), $retval, $pause);

?>
</body>
</html>
