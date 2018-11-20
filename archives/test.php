<?php
// Create a File
$name = "tests/api/test.txt";
$handle = fopen($name, 'w') or die('Cannot open file:  '.$name); //implicitly creates file
