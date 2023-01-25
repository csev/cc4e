<?php
require_once "../config.php";

use \Tsugi\Core\Settings;
use \Tsugi\Core\LTIX;
use \Tsugi\UI\SettingsForm;
use \Tsugi\UI\Lessons;

$LAUNCH = LTIX::requireData();
if ( $LAUNCH->user && $LAUNCH->user->instructor ) {
   $retval = LTIX::gradeSend(1.0, false);
   $_SESSION['success'] = __('Grade sent');
} else {
    die('Must be instructor');
}
header("Location: ".addSession('index.php'));


