<?php

// https://blog.dubbelboer.com/2012/08/24/execute-with-timeout.html
function cc4e_pipe($command, $context, $stdin, $cwd, $env)
{
$retval = new \stdClass();
$retval->code = $code;
$retval->input = $input;
$retval->folder = $folder;
$retval->compile_status = false;
$retval->compile_out = false;
$retval->compile_err = false;
$retval->run_status = false;
$retval->run_out = false;
$retval->run_err = false;


$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("pipe", "w") // stderr is a file to write to
);

$cwd = $folder;
$env = array(
    'some_option' => 'aeiou',
    'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
);

// $command = 'gcc -ansi -x c -o a.out -';
$process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

if (is_resource($process)) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // 2 => readable handle connected to child stderr

    // Set the stdout stream to non-blocking.
    stream_set_blocking($pipes[1], 0);

    // Set the stderr stream to non-blocking.
    stream_set_blocking($pipes[2], 0);

    // Turn the timeout into microseconds.
    $timeout = $timeout * 1000000;

    // Output buffer.
    $stdout = '';
    $stderro = '';

    if ( is_string($stdin) ) {
        fwrite($pipes[0], $stdin);
    }
    fclose($pipes[0]);

    // While we have time to wait.
    while ($timeout > 0) {
        $start = microtime(true);

        // Wait until we have output or the timer expired.
        $read  = array($pipes[1]);
        $other = array();
        stream_select($read, $other, $other, 0, $timeout);

        // Get the status of the process.
        // Do this before we read from the stream,
        // this way we can't lose the last bit of output if the process dies between these functions.
        $status = proc_get_status($process);

        // Read the contents from the stdout.
        // This function will always return immediately as the stream is non-blocking.
        $stdout .= stream_get_contents($pipes[1]);
        $stderr .= stream_get_contents($pipes[2]);

        if (!$status['running']) {
            // Break from this loop if the process exited before the timeout.
            break;
        }

        // Subtract the number of microseconds that we waited.
        $timeout -= (microtime(true) - $start) * 1000000;
    }

    // Kill the process in case the timeout expired and it's still running.
    // If the process already exited this won't do anything.
    proc_terminate($process, 9);

    // Close all streams.
    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    // proc_close in order to avoid a deadlock
    $retval->status = proc_close($process);

}

return $retval;
}

