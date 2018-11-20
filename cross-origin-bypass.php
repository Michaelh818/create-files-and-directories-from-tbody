<?php 

$url = $_POST['url'];
// $url = "https://github.com/woocommerce/woocommerce/tree/master/tests/unit-tests/api/v2";
echo file_get_contents($url);