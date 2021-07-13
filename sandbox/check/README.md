
C Code Protection
=================

This folder contains attack vectors for C-Code - it tests the `sandbox.php`
and docker setup.  To run:

	php test.php

It will take all the C code files and run them throught the sandboxed compiler.

The file names tell us what the expecte behavior of the sandbox will be:

* If 'allow' is the the name it should be rejected because of whilte list violation

* If 'minimum' is in the name it should be rejected because it apparently produces no output

* If neither are present it should pass the check, run and produce some output.

