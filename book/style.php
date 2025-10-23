<?php
use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap');

body {
  font-family: "Roboto", "Arial", sans-serif;
  font-optical-sizing: auto;
  font-size: 1.2rem;
  
  background-color: #f5f5f0;
  color: black;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  line-height: 1.5;
}

.dark-mode {
  background-color: #1a1a1a;
  color: #f3f3f3;
}

p {
  text-align: justify;
  line-height: 1.6;
  margin-bottom: 1em;
}

code, pre {
    font-family: "Source Code Pro", monospace;
    font-size: 1.1rem;
    background-color: #d0e0e0;
}

pre {
  padding: 10px 16px;
  border-radius: 5px;
  overflow-x: auto;
}

p > code {
  padding: 2px 6px;
  border-radius: 3px;
}

.dark-mode code, .dark-mode pre {
    background-color: #2d3748;
    color: #c0c5cc;
}

.note {
    border: 2px solid green;
    border-radius: 3px;
    padding-left: 1em;
    padding-right: 1em;
}

.code {
    border: 1px solid gray;
    padding-left: 1em;
    clear: both;
}

@media print {
    #chapters {
        display: none;
    }
}

table {
  border: 2px solid #90a1b0;
  border-collapse: collapse;
  
  width: 100%;
  margin: 1.5em 0;
  font-size: 1rem;
  
  overflow: hidden;
}

.dark-mode table {
  border: 2px solid #90a1b0;
}

th {
  border: 1px solid transparent;
  border-right: 2px solid #90a1b0;
  
  padding: 12px 15px;
  background-color: #d0e0e0;
  font-weight: 600;
  color: #333;
  text-transform: uppercase;
  font-size: 1rem;
  letter-spacing: 0.5px;
}

th:last-child {
  border-right: 1px solid transparent;
}

.dark-mode th {
  border: 1px solid transparent;
  border-right: 2px solid #90a1b0;
  
  background-color: #2d3748;
  color: #f3f3f3;
    
  padding: 12px 18px;
}

td {
  border: 1px solid transparent;
  border-right: 2px solid #90a1b0;
  padding: 10px 16px;
}

td:last-child {
  border-right: 1px solid transparent; 
}

tr:nth-child(even) {
    background-color: #d0e0e088;
}

.dark-mode td {
  border: 1px solid transparent;
  border-right: 2px solid #90a1b0;
  padding: 10px 16px;
}

.dark-mode td:last-child {
  border-right: 1px solid transparent; 
}

.dark-mode tr:nth-child(even) {
  background-color: #2d374888;
}

.dark-mode a {
    color: white;
}

.dark-mode a:visited {
    color: white;
}

a.xyzzy, a.xyzzy:hover, a.xyzzy:focus, a.xyzzy:active {
      text-decoration: none;
      color: inherit;
}
</style>

<script src="https://static.tsugi.org/js/jquery-1.11.3.js"></script>

