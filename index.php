<?php
if ( isset($_POST['secret']) && ($_POST['secret'] == '42' || $_POST['secret'] == ':wq') ) {
    setCookie('secret', '42', time() + 15 * 3600 * 24);
    header("Location: index.php");
    return;
} else if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
?>
<body style="font-family: Courier,monospace; width: 80%; max-width:500px;margin-left: auto; margin-right: auto;">
<center>
<h1>CC4E - C Programming<br/> for Everybody</h1>
<form method="post">
<input type="text" name="secret">
<input type="submit" value="Unlock">
<p>
The unlock code is a number.  You won't be given the number.  It is a puzzle
where you prove that you have the pre-requisite skills for this course.
You need to figure the number out yourself.  There are clues in this page
and the links from this page.
</p>
<p>
It is not too long and has none of those funny hex (abcde) characters.
It is a very significant number with that
makes a regular appearance throughout Dr. Chuck's other online courses
(<a href="https://www.py4e.com" target="_blank">Python</a>,
<a href="https://www.dj4e.com" target="_blank">Django</a>,
<a href="https://www.wa4e.com" target="_blank">PHP</a>, and
<a href="https://www.pg4e.com" target="_blank">PostgreSQL</a>).
</p>
<p>
If you get tired of trying to guess the number, you can take
a fun break and look at some cool pictures of
<a href="https://www.sakaiger.com/sakaicar/" target="_blank">Dr. Chuck's Race Car</a>.
It is pretty awesome and he races in a series called
<a href="https://www.24hoursoflemons.com" target="_blank">24 Hours of Lemons</a>.
</p>
<p>
You can view the
<a href="privacy" target="_new">Privacy policies</a> for this web site before you enter.
We take your privacy seriously.
</p>
</form>
    <script language="javascript">
    console.log('The code is a number that is central to the book "Hitchhiker\'s Guide to the Galaxy');
    console.log('It is also the number of Dr. Chuck\'s race car');
    </script>
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
<!--
<blockquote>
<p><b>Update:</b> I am planning on having this site ready to "Beta Teach" September 2021.
To participate in that couse when it is ready, simply log in and you will be notified when
I start teaching this material.
I used this book to teach "LBS290 - Programming for Scientists" in September 1991 - almost
30 years ago and if all goes well we will re-trace the syllabus of that course.
</p>
</blockquote>
-->
<p>
This web site is dedicated to understanding computer architecture and low-level programming
by studying the "classic" version of
the C Programming language from the 1978 book written by Brian Kernighan and Dennis Ritchie.
</p>
<p>
The K&amp;R book places the reader in the middle of the 1970's transition from
a hardware-centered computer science to a focus on writing portable and efficient
software.  C was used to develop operating systems like Unix, Minix, and Linux and
progamming languages like C++, Java, JavaScript, and Python.
</p>
<p>
In this course we will be reflecting on how C provided an important foundation for the creation of
modern programming languages.  This is not a good place to start if you do not
already have some programming experience.  Some suggested pre-requisites include:
<ul>
<li><a href="https://www.py4e.com" target="_blank">Python for Everybody</a></li>
<li><a href="https://www.dj4e.com" target="_blank">Django for Everybody</a></li>
<li><a href="https://www.pg4e.com" target="_blank">PostgreSQL for Everybody</a></li>
<li><a href="https://www.wa4e.com" target="_blank">Web Applications for Everybody</a></li>
</ul>
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
<p>
If you would like to help th develop the content of this site, please join us at
<a href="https://github.com/csev/cc4e" target="_blank">https://github.com/csev/cc4e</a>.
Thanks in advance.
</p>
<!--
<?php
echo(Output::safe_var_dump($_SESSION));
var_dump($USER);
?>
-->
</div>
<?php 
require_once "footer.php";
