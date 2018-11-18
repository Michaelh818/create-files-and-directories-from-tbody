<?php
// Create a File
$name = "tests/" . $_POST['name'];
$handle = fopen($name, 'w') or die('Cannot open file:  '.$name); //implicitly creates file
