<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">   
<title>CC4E Archive</title>
</head>
<style>
#chuck:hover {opacity: 0.7; cursor: pointer;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>   
<body>
<img id="chuck" alt="Picture of Dr. Chuck in the 1990's wearing a members only jacket - which was a thing back then"
   src="1990-Chuck-Members-Only-Jacket.png"
    style="padding: 5px; float:right; width:240px;"/>

<div id="cModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById("cModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("chuck");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script> 
<?php
require_once "../top.php";
require_once "../nav.php";
?>  
<h1>Archives of Courses Taught by Dr. Chuck</h1>
<p>These are related courses taught by Dr. Chuck in the past.</p>
<ul>
<li><p><a href="1991-lbs290">Lyman Briggs (LBS290) - C</a>
Taught Fall 1991 at Michigan State University.  This was taught with students
logging in to a 
<a href="https://en.wikipedia.org/wiki/3B_series_computers#3B2" target="_blank">AT&T 3B2</a>
mincomputer.
</p></li>
<li><p><a href="1992-lbs290f" target="_blank">Lyman Briggs (LBS290F) - FORTRAN</a><br/>
Taught Winter 1992 at Michgan State University.
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
<p>
This is a picture of Dr. Chuck's undergraduate project for the year-long compiler
course in 1980.  He was the first and last student at the Michigan State University 
Computer Science Deptartment to do the compiler project
in Pascal.  He was also one of the few students that took two years to do a one year project
and insisted he do the project by himself :)
<center>
<img style="padding: 10px;" src="1980-06-03-pascal-compiler.jpg">
</center>
</p>
