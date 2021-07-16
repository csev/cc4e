<?php
require_once "../config.php";

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Tsugi\UI\SettingsForm;
use \Tsugi\Grades\GradeUtil;
use \Tsugi\UI\Lessons;

// Sanity checks
$LAUNCH = LTIX::requireData();
$p = $CFG->dbprefix;

if ( SettingsForm::handleSettingsPost() ) {
    header( 'Location: '.addSession('index.php?howdysuppress=1') ) ;
    return;
}

$oldsettings = Settings::linkGetAll();

// Get the current user's grade data
$row = GradeUtil::gradeLoad();
$dueDate = SettingsForm::getDueDate();

$menu = false;
if ( $LAUNCH->link && $LAUNCH->user && $LAUNCH->user->instructor ) {
    $menu = new \Tsugi\UI\MenuSet();
    $menu->addLeft('Student Data', 'grades.php');
    if ( $CFG->launchactivity ) {
        $menu->addRight(__('Launches'), 'analytics');
    }
    $menu->addRight(__('Settings'), '#', /* push */ false, SettingsForm::attr());
}

$OUTPUT->header();

$CHECKS = false;
$EX = false;

// Check which exercise we are supposed to do - settings, then custom, then 
// inherit, then GET
if ( isset($oldsettings['exercise']) && $oldsettings['exercise'] != '0' ) {
    $ex = $oldsettings['exercise'];
} else {
    $ex = LTIX::ltiCustomGet('exercise');
}
if ( $ex === false && isset($_GET["inherit"]) && isset($CFG->lessons) ) {
    $l = new Lessons($CFG->lessons);
    if ( $l ) {
        $lti = $l->getLtiByRlid($_GET['inherit']);
        if ( isset($lti->custom) ) foreach($lti->custom as $custom ) {
            if (isset($custom->key) && isset($custom->value) && $custom->key == 'exercise' ) {
                $ex = $custom->value;
                Settings::linkSet('exercise', $ex);
            }
        }
    }
}
if ( $ex === false && isset($_REQUEST["exercise"]) ) {
    $ex = $_REQUEST["exercise"];
    Settings::linkSet('exercise', $ex);
}

// If we are not using settings, update the default settings.
if ( (! isset($oldsettings['exercise'])) || $oldsettings['exercise'] != $ex ) {
    $oldsettings['exercise'] = $ex;
}

$EXERCISES = array("x" => "42");
$EX = false;

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

if ( $USER->instructor ) {
    SettingsForm::start();
    SettingsForm::select('exercise', __('No Exercise - C Code Playground'), array_keys($EXERCISES));
    SettingsForm::dueDate();
    SettingsForm::done();
    SettingsForm::end();

} // end isInstructor() 
?>

<div class="modal fade" id="info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
<?php
if ( isset($LINK->title) ) {
    echo(htmlent_utf8($LINK->title));
} else {
    $OUTPUT->welcomeUserCourse();
}
?></h4>
      </div>
      <div class="modal-body">
<?php if ( $EX === false ) { ?>
        <p>This is an open-ended space for you to write and execute Python programs.
        This page does not check our output and it does not send a grade back.  It is
        here as a place for you to develop small programs and test things out.
        </p>
<?php if ( $RESULT->id !== false ) { ?>
        <p>
        Whatever code you type will be saved and restored when you come back to this
        page.</p>
<?php } ?>
        <p>
Yada 1
        </p>
<?php } else { ?>
<?php if ( isset($LTI['grade']) ) { ?>
        <p style="border: blue 1px solid">Your current grade in this
        exercise is <span id="curgrade"><?php echo($LTI['grade']); ?></span>.</p>
<?php } ?>
        <p>Your goal in this auto grader is to write or paste in a program that implements the specifications
        of the assignment.  You run the program by pressing "Check Code".
        The output of your program is displayed in the "Your Output" section of the screen.
        If your output does not match the "Desired Output", you will not get a score.
        </p><p>
        Even if "Your Output" matches "Desired Output" exactly,
        the autograder still does a few checks of your source code to make sure that you
        implemented the assignment using the expected techniques from the chapter. These messages
        can also help struggling students with clues as to what might be missing.
        </p>
        <p>
        This autograder keeps your highest score, not your last score.  You either get full credit (1.0) or
        no credit (0.0) when you run your code - but if you have a 1.0 score and you do a failed run,
        your score will not be changed.
        </p>
<?php } ?>
<?php
    $identity = __("Logged in as: ").$USER->key;
    if ( strlen($USER->email) > 0 ) {
        $identity .= ' ' . htmlentities($USER->email);
    }
    if ( strlen($USER->displayname) > 0 ) {
        $identity .= ' ' . htmlentities($USER->displayname);
    }
    echo("<p>".$identity."</p>")
?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="overall" style="border: 3px solid black;">
OVERALL

<img id="spinner" src="static/spinner.gif" style="vertical-align: middle;display: none">
<?php
$OUTPUT->footerStart();
if ( $USER->instructor ) {
    echo("<!--\n");
    echo(">Global Tsugi Objects:\n\n");
    var_dump($USER);
    var_dump($CONTEXT);
    var_dump($LINK);
    echo("\n<hr/>\n");
    echo("Session data (low level):\n");
    echo($OUTPUT->safe_var_dump($_SESSION));
    echo("\n-->\n");
}
$OUTPUT->footerEnd();
