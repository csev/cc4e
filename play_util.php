<?php 

use \Tsugi\Util\U;

function cc4e_play_header($lines)  {
     global $CFG;
?>
    <link href="<?= $CFG->apphome ?>/static/codemirror-5.62.0/lib/codemirror.css" rel="stylesheet"/>
<style>
body {
    font-family: Courier, monospace;
}

.CodeMirror { height: auto; border: 1px solid #ddd; }
/* .CodeMirror-scroll { max-height: <?= intval(($lines/13)*20) ?>em; } */

.pre_text {
    height: auto;
    max-height: 200px;
    overflow: auto;
    /*overflow-y: none;*/
    background-color: #eeeeee;
}
</style>
<?php } ?>

<?php 
function cc4e_play_errors($retval) { 
    global $LOGGED_IN;
    if ( ! $LOGGED_IN ) return false;
    $compiler = $retval->pipe->stderr ?? false;

    if ( is_string($compiler) && strlen($compiler) > 0 ) {
        echo '<pre style="color:red;">'."\n";
        echo "Compiler errors:\n\n";
        echo(htmlentities($compiler, ENT_NOQUOTES));
        echo("</pre>\n");
        return true;
    } else if ( isset($retval->reject) && is_string($retval->reject) ) {
        echo('<p style="color:red;">'.htmlentities($retval->reject).'</p>'."\n");
        return true;
    } else if ( isset($retval->allowed) && $retval->allowed === false ) {
        $disallowed = "";
        if ( isset($retval->disallowed) && is_array($retval->disallowed) && count($retval->disallowed) > 0 ) {
            $disallowed = implode(', ',$retval->disallowed);
        }
        echo('<p style="color:red;">Your program used disallowed function(s) '.htmlentities($disallowed).'</p>'."\n");

        return true;
    } else if ( isset($retval->hasmain) && $retval->hasmain === false ) {
        echo('<p style="color:blue;">Compile only: You need a main() for your code to be run</p>'."\n");
        return true;
    } else if ( isset($retval->pipe->stdout) && strlen($retval->pipe->stdout) > 0 ) {
        return false;
    } else if ( isset($retval->minimum) && $retval->minimum === false ) {
         echo('<p style="color:red;">Your program did not produce any output</p>'."\n");
        return true;
    }
    return false;
}


function cc4e_play_inputs($lines, $code) { 
?>
<p>
<textarea id="mycode" name="code" style="height: auto;">
<?php
if ( is_string($code) ) {
    echo(htmlentities($code));
} else {
?>
#include <stdio.h>

main() {
  printf("Hello World\n");
}
<?php } ?>
</textarea>
<?php }

function cc4e_play_output($retval) {
    global $LOGGED_IN;
?>
</p>
<?php
if ( ! $LOGGED_IN ) return;
// https://stackoverflow.com/questions/3008035/stop-an-input-field-in-a-form-from-being-submitted
if ( isset($retval->pipe->stdout) ) {
    echo '<form style="color: blue;">'."\n";
    echo '<div style="color: blue;">'."\n";
    echo "Output from your program:\n\n";
    // echo '<textarea id="myouput" readonly name="output" style="color: blue; width:100%; border: 1px black solid;">';
    echo('<div id="myoutput" class="xpre_text"><pre>');
    echo(htmlentities($retval->pipe->stdout, ENT_NOQUOTES));
    // echo("</textarea>\n");
    echo("</pre></div>\n");
    echo("</div>\n");
    echo("</form>\n");
}
?>
</p>
<?php 
}

function cc4e_play_debug($retval) { 
    if ( ! is_object($retval) ) return;
?>
<pre style="display:none;" id="debug">
Debug output:
<?php
echo(htmlentities(json_encode($retval, JSON_PRETTY_PRINT), ENT_NOQUOTES));

if ( isset($retval->assembly->stdout) && is_string($retval->assembly->stdout) ) {
    echo("\n\n------ Assembly --------\n");
    echo(htmlentities($retval->assembly->stdout, ENT_NOQUOTES));
}
?>
</pre>
<?php } ?> 

<?php function cc4e_play_footer() { 
     global $CFG, $LOGGED_IN;
?>
<script type="text/javascript" src="<?= $CFG->apphome ?>/static/codemirror-5.62.0/lib/codemirror.js"></script>
<script type="text/javascript" src="<?= $CFG->apphome ?>/static/codemirror-5.62.0/mode/clike/clike.js"></script>
<script>
  var myTextarea = document.getElementById("mycode");
  var editor = CodeMirror.fromTextArea(myTextarea, {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-csrc"
  });
</script>
<?php if ( $LOGGED_IN ) { ?>
<script>
$(document).ready(function() {
   	$('#runcode').attr('disabled' , false);
   	$('#runstatus').html('');
   	$('#editstatus').show();
});
</script>
<?php } ?>
<?php 
}

