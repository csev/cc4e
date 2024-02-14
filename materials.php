<?php include("top.php");?>
<?php include("nav.php");?>
<div id="iframe-dialog" title="Read Only Dialog" style="display: none;">
   <iframe name="iframe-frame" style="height:600px" id="iframe-frame"
    src="<?= $OUTPUT->getSpinnerUrl() ?>"></iframe>
</div>
<h1>Using this Course in Your Local LMS</h1>
<p>
You are welcome to use/reuse/remix/retain the materials from this site in your own courses.
Nearly all the material in this web site is Copyright Creative Commons Attribution.  These are
links to downloadable content as well as links to other sources of this course material.</p>
<ul>
<li>
<p>
Download course material as an
<a href="https://www.imsglobal.org/cc/index.html" target="_blank">
IMS Common Cartridge®</a>, to import into an LMS like Sakai, Moodle, Canvas,
Desire2Learn, Blackboard, or similar.
After loading the Cartridge, you will need an LTI key and secret to provision the
LTI-based tools provided in that cartridge.
<a href="#" class="btn btn-info" role="button" title="Download course material"
  onclick="showModalIframeUrl(this.title, 'iframe-dialog', 'iframe-frame', 'tsugi/cc/select', _TSUGI.spinnerUrl, true); return false;" >
  Download 
  </a>
</p>
</li>
<?php if ( $CFG->providekeys ) { ?>
<li>
<p>
If your LMS supports
<a href="https://www.imsglobal.org/activity/learning-tools-interoperability" target="_blank">
IMS Learning Tools Interoperabilty®</a> version 1.x, you can login, and request access
to the tools on this site.  Make sure you indicate whether you need an LTI 1.x
key.   You will be given instructions on how to use
your credentials once you get your key.
</p>
</li>
<li>
<p>
If your LMS supports
<a href="https://www.imsglobal.org/specs/lticiv1p0" target="_blank">
Learning Tools Interoperability® Content-Item Message</a> you can
login and apply for an LTI 1.x key and secret and install this web site
into your LMS as an App Store / Learning Object Repository that allows
you to author you class in your LMS while selecting tools and content
from this site one item at a time.  You will be given instructions
on how to set up the "app store" in your LMS when you receive
your key and secret.
</p>
</li>
<?php } ?>
</ul>
<h1>Links to course materials</h1>
<ul>
    <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj5NbaFb1b2n8lib01uNPWLa" target="_blank">YouTube Playlist</a></li>
    <li><a href="https://audio.cc4e.com" target="_blank">Podcast</a></li>
    <li><a href="lectures/" target="_blank">Lecture Slides and Handouts</a></li>
    <li><a href="code/" target="_blank">Sample Code</a></li>
    <li><a href="book/">Textbook</a></li>
</ul>

<p>This web site uses the <a href="http://www.tsugi.org/" target="_blank">Tsugi</a> software
to both host the software-based autograders and provide this material so it can easily be
integrated into a Learning Management System like
<a href="http://www.sakaiproject.org/" target="_blank">Sakai</a>, Moodle, Canvas, Desire2Learn, Blackboard
or similar.
</p>

    <p>
        All the course content and autograder software is available on
        <a href="https://github.com/csev/py4e" target="_blank">
        Github</a> under a Creative Commons or Apache 2.0 license.
    </p>

<?php include("footer.php"); ?>

