<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>


<script> 
var visited = []; // urls visited 
var url = "https://github.com/woocommerce/woocommerce/tree/master/tests/unit-tests/";
go(url);


function createDirName(arr)
{
    var n = arr.length - 1;
    var dir = arr[n];
    return dir;
}

function go(url) {
    var urlArr = url.split('/');
    var dir = url === "https://github.com/woocommerce/woocommerce/tree/master/tests/unit-tests/" ? "tests" : createDirName(url.split("tests/unit-tests/"));
    visited[url] = true;

    $.post("cross-origin-bypass.php",
    {
        url: url,
    },
    function(data, status){
        $files = $(data).find("table.files");
        $items = $($files[0].innerHTML).find('a.js-navigation-open');
        console.log($items.length);

        $items.each(function(){

            if (this.innerHTML == '..' || this.innerHTML == '.')
            {
                console.log("Not processing dot folder:" + this.innerHTML);
                // will use this to back track and traverse... 
            }
            else
            {
                // console.log(this.innerHTML);
                var name = this.innerHTML;
                var rawURL = getURL(this);

                if (rawURL) {
                    console.log(rawURL);
                    if ( rawURL.indexOf('https://raw.githubusercontent.com/') > -1 ) {
                        $.get(rawURL, function(source_code, status){
                            writeFile(name, source_code);
                        });
                    } else if ( rawURL.indexOf('https://github.com/') > -1 ) {
                        $.post("cross-origin-bypass.php",
                        {
                            url: rawURL,
                        },
                        function(data, status){
                            createDirectory(name, rawURL)
                        });
                    }
                } else {
                    console.log("Raw Url Invalid: " + rawURL);
                }
                
            }
        });

        function getURL(anchor_element) {
            
            var url = anchor_element.href;
            //console.log(url);
            var res = url.split("http://localhost:8081/")[1];

            // not all of them have blob
            var sub_url = res.split("/blob");

            if (sub_url.length > 1) {
                return "https://raw.githubusercontent.com/"+sub_url[0]+sub_url[1];
            } else {
                var sub_url = res.split("/tree")
                if (sub_url.length > 1) {
                    return "https://github.com/"+res;
                }
                return false;
            }
        }

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
                name: dir,
            },
            function(data, status){
                console.log("Create Directory: " + data + "\nStatus: " + status);
                if (typeof(visited[url]) == "undefined") 
                { 
                    go(url);
                } else { alert("Finished Scraping!"); }
            });
        }
    });
}
</script>

</body>