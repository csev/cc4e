
C Programming for Everybody (CC4E)
===========================

Course materials for www.cc4e.com

See the file [`book/README.md`](book/README.md) for book-related details.

Setup On Localhost
------------------

Here are the steps to set this up on localhost on a Macintosh using MAMP.

Install MAMP (or similar) using https://www.wa4e.com/install

Check out this repo into a top level folder in htdocs

    cd /Applications/MAMP/htdocs
    git clone https://github.com/csev/cc4e.git

Go into the newly checked out folder and get a copy of Tsugi:

    cd cc4e
    git clone https://github.com/csev/tsugi.git

Create a database in your SQL server:

    CREATE DATABASE tsugi DEFAULT CHARACTER SET utf8;
    CREATE USER 'ltiuser'@'localhost' IDENTIFIED BY 'ltipassword';
    GRANT ALL ON tsugi.* TO 'ltiuser'@'localhost';
    CREATE USER 'ltiuser'@'127.0.0.1' IDENTIFIED BY 'ltipassword';
    GRANT ALL ON tsugi.* TO 'ltiuser'@'127.0.0.1';

Still in the `tsugi` folder set up config.php:

    cp config-dist.php config.php

Edit the config.php file, scroll through and set up all the variables.  As you scroll through the file
some of the following values are the values I use on my MAMP:

    $wwwroot = 'http://localhost:8888/cc4e/tsugi';   // Embedded Tsugi localhost
    
    ...
    
    $CFG->pdo = 'mysql:host=127.0.0.1;port=8889;dbname=tsugi'; // MAMP
    $CFG->dbuser    = 'ltiuser';
    $CFG->dbpass    = 'ltipassword';
    
    ...
    
    $CFG->adminpw = 'short';
    
    ...
    
    $CFG->apphome = 'http://localhost:8888/cc4e';
    $CFG->context_title = "C Programming for Everybody";
    $CFG->lessons = $CFG->dirroot.'/../lessons.json';
    
    ... 
    
    $CFG->tool_folders = array("admin", "../tools", "../mod");
    $CFG->install_folder = $CFG->dirroot.'./../mod'; // Tsugi as a store
    
    ...
    
    $CFG->servicename = 'CC4E';

(Optional) If you want to use Google Login,
go to https://console.developers.google.com/apis/credentials and
create an "OAuth Client ID".  Make it a "Web Application", give it a name,
put the following into "Authorized JavaScript Origins":

        http://localhost

And these into Authorized redirect URIs:

    http://localhost/cc4e/tsugi/login.php
    http://localhost/cc4e/tsugi/login

Note: You do not need port numbers for either of these values in your Google
configuration.

Google will give you a 'client ID' and 'client secret', add them to `config.php`
as follows:

    $CFG->google_client_id = '96..snip..oogleusercontent.com';
    $CFG->google_client_secret = 'R6..snip..29a';

While you are there, you could "Create credentials", select "API
key", and name the key "My Google MAP API Key" and put the API
key into `config.php` like the following:

    $CFG->google_map_api_key = 'AIza..snip..9e8';

Starting the Application
------------------------

After the above configuration is done, navigate to your application:

    http://localhost:8888/cc4e/tsugi/

It should complain that you have not created tables and suggest you 
use the Admin console to do that:

    http://localhost:8888/cc4e/tsugi/admin

It will demand the `$CFG->adminpw` from `config.php` (above) before 
unlocking the admin console.  Run the "Upgrade Database" option and
it should create lots of tables in the database and the red warning
message about bad database, should go away.

Alternately, you can create all the databases on the command line using:

    cd cc4e/tsugi/admin
    php upgrade.php

Keep refreshing the `/cc4e/tsugi` page until all the error messages go away.
Once the error messages are gone, the main page should also have no errors.

    http://localhost:8888/cc4e/

Go into the database and the `lti_key` table, find the row with the `key_key`
of google.com and put a value in the `secret` column - anything will do - 
just don't leave it empty or the internal LTI tools will not launch.

You can always test the tools using the "App Store" at:

    http://localhost:8888/cc4e/tools/

This allows you to do test launches as the instructor and student in a test environment using the
key '12345'.

Setting up Emscripten
---------------------

To compile, run, and autograde code, this site uses Emscripten which compiles C to Web Assembly:

https://emscripten.org/

Using this means that we can run student in their browser rather than on the server.  This
saves a bunch of compute resources, reliability issues, and security vulnerabilities when
running student code on the server.  The code is compiled to WASM and JS using `emcc`
and then the code is sent to the browser for execution and the ouytput is thenn returned
from the browser.

You need to install the Emscripten compiler.  On Ubuntu:

     apt install emscripten  

On Macintosh:

    brew install emscripten

You also need to make a folder `/var/www/compile` where the student code will be stored
and compiled and chown it to www-root:

    mkdir /var/www/compile
    chown -R www-data.www-data /var/www/compile

This folder will accumulate student programs and results.  You probably want to make a 
`cron` job to clear out this folder for data more than a week old so it does not grow.

Here are the configuration options to setup the compiler for Ubuntu:

    $CFG->setExtension('emcc_path', '/var/www/emsdk/upstream/emscripten/emcc');
    $CFG->setExtension('emcc_folder', '/var/www/compile');
    $CFG->setExtension('emcc_secret', 'changeme');

On Macintosh: 

    $CFG->setExtension('emcc_path', '/opt/homebrew/bin/emcc');
    $CFG->setExtension('emcc_folder', '/tmp/zap');
    $CFG->setExtension('emcc_secret', 'zap');

If you want to debug the Emscripten process, you can add this configuration option:

    $CFG->setExtension('emcc_pause', 'true');

Instead of the spinner and flash, the process wqill pause sou you can look at
the in-browser code to load and run the WASM and then send the output back to
be graded or shown.

Using the Application
---------------------

Navigate to:

    http://localhost:8888/cc4e/

You should click around without logging in and see if things work.

Then log in with your Google account and the UI should change.  In particular you should
see 'Assignments' and in Lessons you should start seeing LTI autograders.

