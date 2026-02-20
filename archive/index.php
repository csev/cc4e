<?php
require_once "../top.php";
?>
<style>
#chuck:hover {opacity: 0.7; cursor: pointer;}
#archive-modal {
  display: none;
  position: fixed;
  z-index: 1050;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.9);
}
#archive-modal .modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}
#archive-modal #archive-caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}
#archive-modal .archive-close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  cursor: pointer;
  background: none;
  border: none;
  padding: 0;
}
#archive-modal .archive-close:hover,
#archive-modal .archive-close:focus {
  color: #bbb;
}
</style>
<?php
require_once "../nav.php";
?>
<div id="container">
<img id="chuck" alt="Picture of Dr. Chuck in the 1990's wearing a members only jacket - which was a thing back then"
   src="1990-Chuck-Members-Only-Jacket.png"
   style="padding: 5px; float:right; width:240px;"/>

<div id="archive-modal" role="dialog" aria-modal="true" aria-label="Enlarged image">
  <button type="button" class="archive-close" aria-label="Close modal">&times;</button>
  <img class="modal-content" id="img01" alt="">
  <div id="archive-caption"></div>
</div>

<h1>Archives of Courses Taught by Dr. Chuck</h1>
<p>These are related courses taught by Dr. Chuck in the past.</p>
<ul>
<li><p><a href="1991-lbs290">Lyman Briggs (LBS290) - C</a>
Taught Fall 1991 at Michigan State University.  This was taught with students
logging in to a 
<a href="https://en.wikipedia.org/wiki/3B_series_computers#3B2" target="_blank" rel="noopener noreferrer">AT&T 3B2</a>
mincomputer.
</p></li>
<li><p><a href="1992-lbs290f" target="_blank">Lyman Briggs (LBS290F) - FORTRAN</a><br/>
Taught Winter 1992 at Michigan State University.
</p></li>
<li><p>
<a href="2000-eecs280" target="_blank">EECS 280 - C++</a><br/>
Taught Winter 2000 at the University of Michigan.  This was the first
and only time that Dr. Chuck taught C++ and the very first course
Dr. Chuck taught at the University of Michigan.
</p>
</li>
</ul>
<br clear="all">
</div>

<script>
(function() {
  var modal = document.getElementById("archive-modal");
  var img = document.getElementById("chuck");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("archive-caption");
  var closeBtn = document.querySelector("#archive-modal .archive-close");

  if (img) img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
  };
  if (closeBtn) closeBtn.onclick = function() {
    modal.style.display = "none";
  };
  document.addEventListener("keydown", function(e) {
    if (e.key === "Escape" && modal.style.display === "block") {
      modal.style.display = "none";
    }
  });
})();
</script>
<?php
require_once "../footer.php";
?>
