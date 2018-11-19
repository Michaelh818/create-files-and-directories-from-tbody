<?php
// mkdir("/path/to/my/dir", 0700);
$directory = "tests/" . $_POST['dir'] . "/" . $_POST['name'];
if ( !file_exists($directory) )
{
    mkdir($directory, 0700);
}