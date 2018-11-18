$(document).ready(function(){
    const content_items = document.querySelectorAll(".js-navigation-open");

    content_items.forEach(
    function(content_item) {
        let name = content_item.innerHTML;
        isPHPFile(name) ? createFile(name) : createDirectory(name);
        
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
