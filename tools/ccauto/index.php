<?php

require_once './class.Diff.php';
require_once "../config.php";
require_once "../../play_util.php";
require_once "../../sandbox/sandbox.php";
require_once "ccauto_util.php";

use \Tsugi\Util\U;
use \Tsugi\Core\Settings;
use \Tsugi\Core\LTIX;
use \Tsugi\UI\SettingsForm;
use \Tsugi\UI\Lessons;
use \Tsugi\Grades\GradeUtil;

$LAUNCH = LTIX::requireData();
$p = $CFG->dbprefix;

$LOGGED_IN = true;
$RANDOM_CODE = getLinkCode($LAUNCH);

if ( SettingsForm::handleSettingsPost() ) {
    header( 'Location: '.addSession('index.php') ) ;
    return;
}

// All the assignments we support
$assignments = array(
    '1-01-hello.php' => 'Hello world (of course)',
    '1-03-heading.php' => 'Add a header',
);

$oldsettings = Settings::linkGetAll();

$assn = Settings::linkGet('exercise');

$custom = LTIX::ltiCustomGet('exercise');

if ( $assn && isset($assignments[$assn]) ) {
    // Configured
} else if ( strlen($custom) > 0 && isset($assignments[$custom]) ) {
    Settings::linkSet('exercise', $custom);
    $assn = $custom;
}

if ( $assn === false && isset($_GET["inherit"]) && isset($CFG->lessons) ) {
    $l = new Lessons($CFG->lessons);
    if ( $l ) {
        $lti = $l->getLtiByRlid($_GET['inherit']);
        if ( isset($lti->custom) ) foreach($lti->custom as $custom ) {
            if (isset($custom->key) && isset($custom->value) && $custom->key == 'exercise' ) {
                $assn = $custom->value;
                Settings::linkSet('exercise', $assn);
            }
        }
    }
}

// Get any due date information
$dueDate = SettingsForm::getDueDate();

$menu = false;
if ( $LAUNCH->user->instructor ) {
    $menu = new \Tsugi\UI\MenuSet();
    $menu->addLeft(__('Grade Detail'), 'grades.php');
    $menu->addRight(__('Launches'), 'analytics');
    $menu->addRight(__('Settings'), '#', /* push */ false, SettingsForm::attr());
}

// Load up the assignment
if ( $assn && isset($assignments[$assn]) ) {
    include($assn);
    $instructions = ccauto_instructions($LAUNCH);
    $sample = ccauto_sample($LAUNCH);
    $input = ccauto_input($LAUNCH);
    $output = ccauto_output($LAUNCH);
}

$stdout = False;
$stderr = False;

if ( isset($_POST['reset']) ) {
    unset($_SESSION['retval']);
    unset($_SESSION['code']);
    GradeUtil::gradeUpdateJson(json_encode(array("code" => null)));
    header( 'Location: '.addSession('index.php') ) ;
    return;
}

if ( isset($_POST['code']) ) {
    unset($_SESSION['retval']);
    $_SESSION['code'] = U::get($_POST, 'code', false);
    header( 'Location: '.addSession('index.php') ) ;
    return;
}

$code = U::get($_SESSION, 'code');
$retval = U::get($_SESSION, 'retval');


if ( $retval == NULL && is_string($code) && strlen($code) > 0 ) {
   $retval = cc4e_compile($code, $input);
   $_SESSION['retval'] = $retval;
}

$row = GradeUtil::gradeLoad();
$json = array();
if ( $row !== false && isset($row['json'])) {
    $json = json_decode($row['json'], true);
}

if ( !is_string($code) || strlen($code) < 1 ) {
    if ( isset($json["code"]) ) {
        $code = $json["code"];
    } else {
        $code = $sample;
    }
}

$lines = $code ? count(explode("\n", $code)) : 15;
if ( $lines < 10 ) $lines = 10;

// View
$OUTPUT->header();
cc4e_play_header($lines);

// https://code.iamkate.com/php/diff-implementation/
?>
<style>
    .diff table
    {
        table-layout: fixed;
        width: 100px;
    }
      .diff td{
        padding:0 0.667em;
        vertical-align:top;
        white-space:pre;
        white-space:pre-wrap;
        font-family:Consolas,'Courier New',Courier,monospace;
        font-size:1.05em;
        line-height:1.333;
      }
      .diff th{
        padding:0.2em 0.667em;
        vertical-align:top;
        white-space:pre;
        white-space:pre-wrap;
        font-family:Consolas,'Courier New',Courier,monospace;
        font-size:1.05em;
        line-height:1.333;
      }
      .diff td:first-child{
        width: 50%;
        max-width: 200px;
        overflow: hidden;
      }
table td { border-left: 1px solid #000; padding: 2px;}
table th { border-left: 1px solid #000; padding: 2px;}

      .diff span{
        display:block;
        min-height:1.333em;
        margin-top:-1px;
        padding:0 3px;
      }

      * html .diff span{
        height:1.333em;
      }

      .diff span:first-child{
        margin-top:0;
      }

      .diffDeleted span{
        border:1px solid rgb(255,192,192);
        background:rgb(255,224,224);
      }

      .diffInserted span{
        border:1px solid rgb(192,255,192);
        background:rgb(224,255,224);
      }

      #toStringOutput{
        margin:0 2em 2em;
      }
</style>

<?php
$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

SettingsForm::start();
SettingsForm::select("exercise", __('Please select an assignment'),$assignments);
SettingsForm::dueDate();
SettingsForm::done();
SettingsForm::end();

if ( isset($_SESSION['error']) ) {
    $RESULT->setNote($_SESSION['error']);
} else if ( isset($_SESSION['success']) ) {
    $RESULT->setNote($_SESSION['success']);
}

$OUTPUT->flashMessages();

if ( ! $ASSIGNMENT ) {
    if ( $LAUNCH->user->instructor ) {
        echo("<p>Please use settings to select an assignment for this tool.</p>\n");
    } else {
        echo("<p>This tool needs to be configured - please see your instructor.</p>\n");
    }
    $OUTPUT->footer();
    return;
}

echo("<p>Instructions: ".$instructions."</p>\n");
?>
<form method="post">
<p>
<input type="submit" name="run" value="Run Code" disabled id="runcode">
<input type="submit" name="reset" value="Reset Code"
    onclick="return confirm('Do you really want to reset the code to the default?');"
>
<span id="runstatus"><img src="<?= $OUTPUT->getSpinnerUrl() ?>"/></span>
<?php
$errors = cc4e_play_errors($retval);
cc4e_play_inputs($lines, $code);

if ( is_string($input) && strlen($input) > 0 ) {
?>
<p>Input to your program:</p>
<p>
<textarea id="myinput" name="input" readonly style="width:100%; border: 1px black solid;">
<?php
    echo(htmlentities($input));
?>
</textarea>
</p>
<?php } ?>
<?php

    // https://code.iamkate.com/php/diff-implementation/

    GradeUtil::gradeUpdateJson(json_encode(array("code" => $code)));
    $actual = isset($retval->docker->stdout) && strlen($retval->docker->stdout) > 0 ? $retval->docker->stdout : false;
    if ( is_string($actual) && is_string($output) ) {
        if ( trim($actual) == trim($output) ) {
            $grade = 1.0;
            $debug_log = array();
            $graderet = LTIX::gradeSend($grade, false, $debug_log);
            // $OUTPUT->dumpDebugArray($debug_log);
            if ( $graderet == true ) {
                echo('<p style="color:green;">Output match - Grade sent to server</p>'."\n");
            } else if ( is_string($graderet) ) {
                echo('<p style="color:red;">Output match - Grade not sent: '.$graderet."</p>\n");
            } else {
                echo('<p style="color:red;">Internal send error</p>'."\n");
                echo("<pre>\n");
                var_dump($graderet);
                echo("</pre>\n");
            }
        } else {
            echo '<p style="color:red;">Output does not match</p>'."\n";
            $diff = Diff::compare(trim($output), trim($actual));
            echo('<div style="border: 1px solid black;">');
            $table = Diff::toTable($diff);
            $header = '<tr class="header"><th>Expected Output</th><th>Your Output</th></tr>';
            $table = str_replace('<table class="diff">', '<table class="diff" id="difftable">'.$header, $table);
            echo($table);
            echo('</div>');
        }
    }

    echo '<form style="color: blue;">'."\n";
    echo '<div style="color: green;">'."\n";
    echo "Expected output from your program:\n\n";
    echo '<textarea id="myouput" readonly name="expected" style="color: green; width:100%; border: 1px black solid;">';
    echo(htmlentities($output, ENT_NOQUOTES));
    echo("</textarea>\n");
    echo("</div>\n");
    echo("</form>\n");
 cc4e_play_output($retval);
?>
</form>
<?php

cc4e_play_debug($retval);

$OUTPUT->footerStart();
cc4e_play_footer();
?>
<script>
$(document).ready( function() {
    var width = $('#difftable').parent().width();
    console.log('yada', width);
    $('td:first-child').width(width/2);
    // $('.diff td:first-child').each(function(pos, tag) {
    $('.diff td').each(function(pos, tag) {
        var tdw = (width/2)+'px';
        console.log('tag', pos, tag, width, tdw);
        $(tag).css('width', tdw);
        $(tag).css('max-width', tdw);
        $(tag).css('min-width', tdw);
        $(tag).css('overflow', 'hidden');

    });
});
</script>
<?php
$OUTPUT->footerEnd();

