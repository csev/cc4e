<?php function cc4e_play_header($lines)  {
     global $CFG;
?>
    <link href="<?= $CFG->apphome ?>/static/codemirror-5.62.0/lib/codemirror.css" rel="stylesheet"/>
<style>
body {
    font-family: Courier, monospace;
}

.CodeMirror { height: auto; border: 1px solid #ddd; }
.CodeMirror-scroll { max-height: <?= intval(($lines/13)*20) ?>em; }

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
    $compiler = $retval->assembly->stderr ?? false;
    if ($compiler == false) {
        $compiler = $retval->docker->stderr ?? false;
    }

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
        echo('<p style="color:red;">Your program used a disallowed function</p>'."\n");
        return true;
    } else if ( isset($retval->hasmain) && $retval->hasmain === false ) {
        echo('<p style="color:blue;">Compile only: You need a main() for your code to be run</p>'."\n");
        return true;
    } else if ( isset($retval->minimum) && $retval->minimum === false ) {
         echo('<p style="color:red;">Your program did not produce any output</p>'."\n");
        return true;
    }
    return false;
}


function cc4e_play_inputs($lines, $code) { 
?>
<p>
<textarea id="mycode" name="code" rows="<?= $lines ?>" style="height: <?= $lines ?>em; border: 1px black solid;">
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
if ( isset($retval->docker->stdout) ) {
    echo '<form style="color: blue;">'."\n";
    echo '<div style="color: blue;">'."\n";
    echo "Output from your program:\n\n";
    // echo '<textarea id="myouput" readonly name="output" style="color: blue; width:100%; border: 1px black solid;">';
    echo('<div id="myoutput" class="pre_text"><pre>');
    echo(htmlentities($retval->docker->stdout, ENT_NOQUOTES));
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
<?php if ( isset($CFG->cc4e_no_ping) && $CFG->cc4e_no_ping ) { ?>
   	$('#runcode').attr('disabled' , false);
   	$('#runstatus').html('');
<?php } else { ?>
	$.getJSON( "<?= $CFG->apphome ?>/ping.php", function( data ) { 
    if ( typeof data === "undefined" ) {
      $('#runstatus').html('Compiler unavailable');
      return;
    }

    if ( data.hasOwnProperty('docker') && data.docker.hasOwnProperty('stdout') ) {
    	var output = data.docker.stdout;
    	$('#runcode').attr('disabled' , false);
    	$('#runstatus').html('');
	return;
    }
    $('#runstatus').html('Compiler unavailable');

  }).fail(function() {
    $('#runstatus').html('Unable to contact compiler');
  });
<?php } ?>
});
</script>
<?php } ?>
<?php 
}

