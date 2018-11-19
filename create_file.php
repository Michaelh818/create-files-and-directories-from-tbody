<?php
$directory = "tests/" . $_POST['dir'];
if ( !file_exists($directory) )
{
    mkdir($directory, 0700);
}
// Create a File
$name = $directory. "/" . $_POST['name'];
$handle = fopen($name, 'w') or die('Cannot open file:  '.$name); //implicitly creates file
