<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">   
<title>LBS 290 - C Programming</title>
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
<?php
require_once "../../top.php";
require_once "../../nav.php";
?>
<img id="chuck" alt="Picture of Dr. Chuck in the 1990's wearing a members only jacket - which was a thing back then"
   src="../1990-Chuck-Members-Only-Jacket.png"
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
<h1>LBS 290 - C Programming</h1>
<p>
This course was taught Fall 1991 in the
<a href="https://lbc.msu.edu/" target="_blank">Lyman Briggs School</a>
at
<a href="https://www.msu.edu/" target="_blank">Michigan State University</a>.
It featured writing three programs per week.  It met three times per week and
after each lecture a new assignment was handed out.
The course was taught on UNIX running on an
<a href="https://en.wikipedia.org/wiki/3B_series_computers" target="_blank">
AT&T 3B2 Microcomputer
</a> which was physically present in the lab with student terminals.
Dr Chuck was also the system administrator of the UNIX system.
We did not use the Kernighan and Ritchie book.
</p>
<ul>
<li><a href="syllabus.txt" target="_blank">Course Syllabus</a></li>
<li><a href="assn03.txt" target="_blank">ASSIGNMENT 3 - THE FIRST C PROGRAM - Due 10/7/91</a></li>
<li><a href="assn06.txt" target="_blank">ASSIGNMENT 6 - Mathematics - Due 10/14/91</a></li>
<li><a href="assn07.txt" target="_blank">ASSIGNMENT 7 - INPUT AND OUTPUT - Due 10/16/91</a></li>
<li><a href="assn08.txt" target="_blank">ASSIGNMENT 8 - CALCULATING AN AVERAGE - Due 10/18/91</a></li>
<li><a href="assn09.txt" target="_blank">ASSIGNMENT 9 - IF STATEMENTS - Due 10/23/91</a></li>
<li><a href="assn10.txt" target="_blank">ASSIGNMENT 10 - LOOPING - Due 10/25/91</a></li>
<li><a href="assn11.txt" target="_blank">ASSIGNMENT 11 - FUNCTIONS - Due 10/28/91</a></li>
<li><a href="assn12.txt" target="_blank">ASSIGNMENT 12 - SCOPING RULES - Due 10/30/91</a></li>
<li><a href="assn13.txt" target="_blank">ASSIGNMENT 13 - CALL BY VALUE SUBROUTINE - Due 11/04/91</a></li>
<li><a href="assn14.txt" target="_blank">ASSIGNMENT 14 - ARRAYS - Due 11/06/91</a></li>
<li><a href="assn15.txt" target="_blank">ASSIGNMENT 15 - Strings - Due 11/06/91</a></li>
<li><a href="assn16.txt" target="_blank">ASSIGNMENT 16 - A CALCULATOR - Due 11/15/91</a></li>
<li><a href="assn17.txt" target="_blank">ASSIGNMENT 17 - AN INVENTORY PROGRAM - Due 11/18/91</a></li>
<li><a href="assn18.txt" target="_blank">ASSIGNMENT 18 - MACHINE LANGUAGE - I - Due 11/20/91</a></li>
<li><a href="assn19.txt" target="_blank">ASSIGNMENT 19 - MACHINE LANGUAGE - II - Due Before the final</a></li>
<li><a href="assn20.txt" target="_blank">ASSIGNMENT 20 - ALGEBRA - Due 11/25/91</a></li>
<li><a href="assn21.txt" target="_blank">ASSIGNMENT 21 - ALGEBRA - Due 11/25/91</a></li>
<li><a href="assn22.txt" target="_blank">ASSIGNMENT 22 - PHYSICS/HEAT FLOW - Due 12/3/91</a></li>
<li><a href="assn23.txt" target="_blank">ASSIGNMENT 23 - SORTING - Due 12/4/91</a></li>
<li><a href="assn24.txt" target="_blank">ASSIGNMENT 24 - PUTTING IT ALL TOGETHER - Due 12/12/91</a></li>
</ul>
<br clear="all">

<center>
<a href="https://en.wikipedia.org/wiki/3B_series_computers" target="_blank">
<img alt="Picture of AT&T 3B2 Minicomputer" src="1076px-3B2_model_400_sitting_on_grass.jpg" style="padding: 5px; width:80%;"/>
</a>
</center>
</html>
