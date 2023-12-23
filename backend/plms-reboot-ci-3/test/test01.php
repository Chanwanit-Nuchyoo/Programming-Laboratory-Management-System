<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PLMS test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://161.246.127.189/20s2ds/assets/bootstrap-3.3.7/css/bootstrap.min.css">
    <link href="http://161.246.127.189/20s2ds/assets/summernote/summernote.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="http://161.246.127.189/20s2ds/assets/codemirror-5.22.0/lib/codemirror.css">
    <link rel="stylesheet" type="text/css"
        href="http://161.246.127.189/20s2ds/assets/codemirror-5.22.0/theme/monokai.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
    <script src="http://161.246.127.189/20s2ds/assets/jquery/jquery-3.1.1.min.js"></script>
    <!-- <script src="http://161.246.4.240/19s1ds/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script> -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://161.246.127.189/20s2ds/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

    <script defer type="text/javascript" src="http://161.246.127.189/20s2ds/assets/jquery/jquery.tablesorter.min.js"></script>
    


</head>

<body>
    <input type="file" name="submitted_file" value="" id="userfile" accept=".py" onchange="checkSourceCode();">



    <script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
    var postForm = function() {
        var content = $('textarea[name="lab_content"]').html($('#summernote').code());
    }
    </script>

    <script type="text/javascript">
        
    </script>
    <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
        lineNumbers: true,
        matchBrackets: true,
        indentUnit: 4,
        readonly: true,
        mode: "text/x-csrc"
    });
    </script>






    <script type="text/javascript"src="http://161.246.127.189/20s2ds/assets/js/plms_python.js"></script>
    <script>
        
        function checkSourceCode() {
            let userfile = document.getElementById("userfile").value;
            console.log(`userfile=> ${userfile}`);
            let file = /([^\\]+)$/.exec(userfile)[1];   // userfile.replace(/^.*(\\|\/|\:)/, '');
            console.log(`file=> ${file}`);
            let fileName = (file.split('.')).at(0);
            console.log(`fileName=> ${fileName}`);
            let fileExtension = (file.split('.')).at(-1);
            console.log(`fileExtension=> ${fileExtension}`);
            if (fileExtension != 'py') {
                console.log("อนุญาตให้ส่งไฟล์สกุล .py เท่านั้น");
                alert("อนุญาตให้ส่งไฟล์สกุล .py เท่านั้น");
                return false;
            }
            const input = document.querySelector('input[type="file"]')
            console.log(input.files)
            const reader = new FileReader()
            reader.onload = function() {
                console.log(reader)
                console.log(reader.result)
            }
            
            
            
            
        }
        document.getElementById("userfile").onchange = checkSourceCode;
    </script>
</body>

</html>