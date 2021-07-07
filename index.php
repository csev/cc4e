<?php
if ( isset($_POST['secret']) && $_POST['secret'] == '42' ) {
    setCookie('secret', '42', time() + 15 * 3600 * 24);
    header("Location: index.php");
} else if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
?>
<body style="font-family: Courier,monospace; width: 80%; max-width:500px;margin-left: auto; margin-right: auto;">
<center>
<h1>CC4E - C Programming<br/> for Everybody</h1>
<form method="post">
<input type="text" name="secret">
<input type="submit" value="Unlock">
<p>
The unlock code is a number.  
It is not very big. 
It is a very significant number with that
makes an appearance throughout Dr. Chuck's other online courses 
(<a href="https://www.py4e.com" target="_blank">Python</a>, 
<a href="https://www.py4e.com" target="_blank">Django</a>, 
<a href="https://www.py4e.com" target="_blank">PHP</a>, and 
<a href="https://www.py4e.com" target="_blank">PostgreSQL</a>).
</p>
<p>
If you are having trouble guessing the number, you can take
a fun break and look at some cool pictures of
<a href="https://www.sakaiger.com/sakaicar/" target="_blank">Dr. Chuck's Race Car</a>.
</p>
</form>
</center>
<?php
    return;
}

use \Tsugi\Core\LTIX;
use \Tsugi\UI\Output;

require_once "top.php";
require_once "nav.php";
?>
<div id="container">
<div style="margin-left: 10px; float:right">
<iframe width="400" height="225" src="https://www.youtube.com/embed/sQwkC5PBTfk?rel=0" frameborder="0" allowfullscreen></iframe>
</div>
<h1>C Programming for Everybody</h1>
<p>
This web site is dedicated to understanding computer architecture and low-level programming 
by studying the "classic" version of
the C Programming language from the 1978 book written by Brian Kernighan and Dennis Ritchie.
</p>
<p>
The K&amp;R book places the reader in the middle of the 1970's transition from
a hardware-centered computer science to a focus on writing portable and efficient
software.  C was used to develop operating systems like Unix, Minix, and Linux and 
progamming languages like Java, JavaScript, and Python.
</p>
<p>
This site uses <a href="http://www.tsugi.org" target="_blank">Tsugi</a>
framework to embed a learning management system into this site and
provide the autograders.
If you are interested in collaborating
to build these kinds of sites for yourself, please see the
<a href="http://www.tsugi.org" target="_blank">tsugi.org</a> website and/or
contact me.
</p>
<p>
And yes, Dr. Chuck actually has a race car - it is called the
<a href="https://www.sakaiger.com/sakaicar/" target=_blank">SakaiCar</a>.
He races in a series called
<a href="https://www.24hoursoflemons.com" target="_blank">24 Hours of Lemons</a>.
</p>
<!--
<?php
echo(Output::safe_var_dump($_SESSION));
var_dump($USER);
?>
-->
</div>
<?php $OUTPUT->footer();
