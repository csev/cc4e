<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

// https://blog.dubbelboer.com/2012/08/24/execute-with-timeout.html
function cc4e_pipe($command, $stdin, $cwd, $env, $timeout)
{

    $retval = new \stdClass();
    $retval->stdout = false;
    $retval->stderr = false;
    $retval->status = false;

    $descriptorspec = array(
       0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
       2 => array("pipe", "w") // stderr is a file to write to
    );

    // Pipes is set by proc_open
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
        $stderr = '';

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

        // var_dump($status);
        $retval->status = $status['exitcode'];

        // Close all streams.
        fclose($pipes[1]);
        fclose($pipes[2]);

        // Kill the process in case the timeout expired and it's still running.
        // If the process already exited this won't do anything.
        // $retval->status = proc_get_status($process);
        // $retval->status = proc_terminate($process, 9);

        // proc_close in order to avoid a deadlock
        $retval->stdout = $stdout;
        $retval->stderr = $stderr;

    }

    return $retval;
}

// Linux check:
//     call    puts@PLT
//     call    zap@PLT                     ## External unknown
//     movq    puts@GOTPCREL(%rip), %rax   ## External unknown
//
// Linux OK:
//     call    zap                         ## Internal known
//     leaq    fun(%rip), %rax             ## Internal known

// Mac check:
//  movq    _puts@GOTPCREL(%rip), %rax
//  callq    _printf
//  callq   _zap                        ## Both local and external :(
//
// Mac OK:
// _zap:
//    .cfi_startproc
//  callq   _zap                        ## Both local and external :(
//  leaq    L_.str(%rip), %rdi
//  leaq    _fun(%rip), %rax
function cc4e_compile($code, $input)
{
    global $CFG;

    $now = str_replace('@', 'T', gmdate("Y-m-d@H-i-s"));
    // $folder = sys_get_temp_dir() . '/compile-' . $now . '-' . md5(uniqid());
    // $folder = '/tmp/compile';
    $folder = '/tmp/compile-' . $now . '-' . md5(uniqid());
    // TODO: Figure out why we need this
    if ( is_dir('/zork') ) $folder = '/zork/compile-' . $now . '-' . md5(uniqid());
    if ( file_exists($folder) ) {
            system("rm -rf $folder/*");
    } else {
            mkdir($folder);
    }
    $env = array(
            'some_option' => 'aeiou',
            'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
    );

    $docker_command = $CFG->docker_command ?? 'docker run --network none --rm -i alpine_gcc:latest "-"';

    $retval = new \stdClass();
    $retval->now = $now;
    $retval->code = $code;
    $retval->input = $input;
    $retval->folder = $folder;

    $command = 'rm -rf * ; cat > student.c ; gcc -ansi -Wno-return-type -fno-asm -S student.c ; [ -f student.s ] && cat student.s';

    $pipe1 = cc4e_pipe($command, $code, $folder, $env, 2.0);
    $retval->assembly = $pipe1;
    $retval->docker = false;

    $allowed = false;

    if ( $pipe1->status === 0 ) {
        $assembly = $retval->assembly->stdout;
        $lines = explode("\n", $assembly);
        $newlines = array();

        // Make a symbol table
        $symbol = array();
        foreach ( $lines as $line) {
            $matches = array();
            if ( preg_match('/^(_[a-zA-Z0-9_]+):/', $line, $matches ) ) {
                if ( count($matches) > 1 ) {
                    $match = $matches[1];
                    if ( strpos($match,'_') === 0 && strlen($match) > 1 ) $match = substr($match, 1);
                    $symbol[] = $match;
                }
            }
            if ( preg_match('/\t.comm\t(_[a-zA-Z0-9_]+),/', $line, $matches) ) {
                if ( count($matches) > 1 ) {
                    $match = $matches[1];
                    if ( strpos($match,'_') === 0 && strlen($match) > 1 ) $match = substr($match, 1);
                    $symbol[] = $match;
                }
            }
        }
        $retval->symbol = $symbol;

        $allowed_externals = array(
            'puts', 'printf', 'putchar', 'sscanf', 'getchar', 'gets',
            '__stack_chk_guard', '__stack_chk_fail'
        );

        $minimum_externals = array(
            'puts', 'printf', 'putchar'
        );

        $externals = array();
        foreach ( $lines as $line) {
            if ( strlen($line) < 1                 // blank lines
                || (! preg_match('/^\s/', $line))  // _main:
                || preg_match('/^\s+\./', $line)   //     .cfi_startproc
                || preg_match('/^\s.#/', $line)    // comment
            ) {
                $new[] = $line;
                continue;
            }

            $matches = array();
            if ( preg_match('/([a-zA-Z0-9_]+)@PLT/', $line, $matches) ) {
                if ( count($matches) > 1 ) {
                    $external = $matches[1];
                    if ( strpos($external,'_') === 0 && strlen($external) > 1 ) $external = substr($external, 1);
                    $externals[] = $external;
                }
            }

            $matches = array();
            if ( preg_match('/([a-zA-Z0-9_]+)@GOTPCREL/', $line, $matches) ) {
                if ( count($matches) > 1 ) {
                    $external = $matches[1];
                    if ( strpos($external,'_') === 0 && strlen($external) > 1 ) $external = substr($external, 1);
                    $externals[] = $external;
                }
            }

            $pieces = explode("\t", $line);
            // var_dump($pieces);

            // Mac internal and external
            //  callq    _printf
            if ( count($pieces) > 2 ) {
                if ( $pieces[1] == 'callq' ) {
                    $external = $pieces[2];
                    if ( strpos($external,'_') === 0 && strlen($external) > 1 ) {
                        $external = substr($external, 1);
                        if ( ! in_array($external,$externals) ) $externals[] = $external;
                    }
                }
            }
        }
        $retval->externals = $externals;

        // Run the check
        $minimum = false;
        $allowed = true;
        foreach($externals as $external) {
            if ( in_array($external, $minimum_externals) ) $minimum = true;
            if ( in_array($external, $retval->symbol) ) continue;
            if ( ! in_array($external, $allowed_externals) ) $allowed = false;
        }
        $retval->minimum = $minimum;
        $retval->allowed = $allowed;
    }

    $eof = 'EOF' . md5(uniqid());
    if ( $allowed && $minimum ) {
        $script = "cd /tmp;\n";
        $script .= "cat > student.c << $eof\n";
        $script .= $code;
        $script .= "\n$eof\n";
        $script .= "/usr/bin/gcc -ansi -Wno-return-type -fno-asm student.c\n";
        if ( is_string($input) && strlen($input) > 0 ) {
            $script .= "[ -f a.out ] && cpulimit --limit=25 --include-children ./a.out << $eof\n";
            $script .= $input;
            $script .= "\n$eof\n";
        } else {
            $script .= "[ -f a.out ] && cpulimit --limit=25 --include-children ./a.out\n";
        }

        // echo("-----\n");echo($script);echo("-----\n");
        $retval->docker = cc4e_pipe($docker_command, $script, $folder, $env, 2.0);
    }

    $cleanup = false;
    $minimum = $retval->minimum ?? null;
    $allowed = $retval->allowed ?? null;
    if ( $minimum === false || $allowed === false ) {
        $json = json_encode($retval, JSON_PRETTY_PRINT);
        file_put_contents($folder . '/result.json', $json);
    } else if ( $cleanup ) {
        system("rm -rf $folder");
    }

    return $retval;
}

