<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>



<?php // include_once "api-v2.html" 
// https://github.com/woocommerce/woocommerce/tree/master/tests/unit-tests

?>


<!-- our target for example:

-->

<script> 
$.get('api-v2.html', function(data, status){

    // data='<td class="content"> <span class="css-truncate css-truncate-target"> <a class="js-navigation-open" title="coupons.php" id="f3dbdcb4766894375ce49bab38675eaf-3953aef70442d47b0be295b27da62bdfc4bc5434" href="/woocommerce/woocommerce/blob/master/tests/unit-tests/api/coupons.php">coupons.php</a></span></td><td class="content"> <span class="css-truncate css-truncate-target"> <a class="js-navigation-open" title="coupons.php" id="f3dbdcb4766894375ce49bab38675eaf-3953aef70442d47b0be295b27da62bdfc4bc5434" href="/woocommerce/woocommerce/blob/master/tests/unit-tests/api/not-coupons-baby.php">coupons.php</a></span></td>'
    var $items = $(data).find('.js-navigation-open');
    
    $items.each(function(){
        var str = this.href;
        var res = str.split("http://localhost:8081/")[1];
        // var url = "https://github.com/"+res;
        var sub_url = res.split("/blob");

        var url = "https://raw.githubusercontent.com/"+sub_url[0]+sub_url[1];
        // console.log(url);
        $.get(url, function(source_code, status) {
            // console.log(source_code);
            isPHPFile(name) ? writeFile(name, source_code) : createDirectory(name);
            
            function isPHPFile(str) {
                return str.includes('.php');
            }

            

            function createFile(name) {
                $.post("create_file.php",
                {
                    name: name,
                },
                function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                });
            }
            

            // writeFile(name, "https://raw.githubusercontent.com/woocommerce/woocommerce/master/tests/unit-tests/api/");

            function writeFile(name, data) {
                $.post("write_file.php",
                {
                    name: name,
                    data: data,
                },
                function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                });
            }

            function createDirectory(name) {
                $.post("create_directory.php",
                {
                    name: name,
                },
                function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                });
            }
        });
    });
});

</script>

</body>