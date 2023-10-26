<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        #drop-zone {
            width: 300px;
            height: 200px;
            border: 2px dashed #ccc;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            margin: 0 auto;
        }
    </style>
<body>
<form action="upload.php" method="POST" enctype="multipart/form-data">

<h1>Drag and Drop File Upload</h1>
    <div id="drop-zone">

        <input type="file" id="file-input" multiple>
    </div>

    <ul id="file-list"></ul>


    </form>
    <script src="./jquery-3.7.1.min.js" ></script>
    <script src="./Global_Javascript_Extensions/Jquery/Extensions.js"></script>
    <script>
        dropAnddrag("#drop-zone","#file-input")
        ajax_('upload.php','POST', $("#file-input"), )
    </script>
</body>
</html>

