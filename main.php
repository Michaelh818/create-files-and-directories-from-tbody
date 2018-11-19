<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>


<script> 
var url = "https://github.com/woocommerce/woocommerce/tree/master/tests/unit-tests/api";  //"fuck-cross-origin.php";
go(url);


function go(url) {
    var urlArr = url.split('/');
    var dir = urlArr[urlArr.length - 1].includes('.') ? urlArr[urlArr.length - 1] : "api";
    $.post("fuck-cross-origin.php",
    {
        url: url,
    },
    function(data, status){
        $items = $(data).find(".js-navigation-open")

        $items.each(function(){
            var name = this.innerHTML;
            var str = this.href;
            var res = str.split("http://localhost:8080/")[1];
            // var url = "https://github.com/"+res;
            var sub_url = res.split("/blob");

            if (sub_url.length > 1) {
                var url = "https://raw.githubusercontent.com/"+sub_url[0]+sub_url[1];
                // console.log(url);
                $.get(url, function(source_code, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    isFile(name) ? writeFile(name, source_code) : createDirectory(name, url);
                });
                
                
            }
        });

        function isPHPFile(str) {
            return str.includes('.php');
        }

        function isFile(str) {
            return str.includes('.');
        }

        function writeFile(name, data) {
            $.post("write_file.php",
            {
                name: name,
                data: data,
                dir: dir,
            },
            function(data, status){
                console.log("Data: " + data + "\nStatus: " + status);
            });
        }

        function createDirectory(name, url) {
            $.post("create_directory.php",
            {
                name: name,
            },
            function(data, status){
                console.log("Create Directory: " + data + "\nStatus: " + status);
                // go(url);
            });
        }
    });
}
</script>

</body>