<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        #drop-zone{
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

<h1>Drag and Drop File Upload</h1>
    <div id="drop-zone">

        <input type="file" id="file-input" name="fileToUpload" />
    </div>

    <ul id="file-list"></ul>

    <img  id="show_image" width="1000" height="1000"/>

    <script src="./jquery-3.7.1.min.js" ></script>
    <script src="./Global_Javascript_Extensions/Jquery/Extensions.js"></script>
    <script>
        $(document).ready(function(e){
            function ajax_(url, type, data, action, successCallback, errorCallback, processData = true, contentType = null) {
                $.ajax({
        url: url,
        type: type,
        data: data,
        processData: processData,
        contentType: contentType,
        success: function (response) {
            alert("aaaaa"+response);
            if (successCallback) {
                successCallback(response);
            }
        },
        error: function (xhr, status, error) {
            alert(statust);
            if (errorCallback) {
                errorCallback(error);
            }
        }
    });
}

    function uploadFiles(files ,type, imagePreview_id) {
        // ตรวจสอบว่ามีไฟล์หรือไม่
        if (files.length > 0) {
          var file = files[0]; // เลือกไฟล์แรกเท่านั้น
          // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่ (อื่นๆ สามารถตรวจสอบได้ด้วย)
        if (file.type.indexOf('image') === 0) {
            var reader = new FileReader();
            reader.onload = function(e) {
            let imagePreview = imagePreview_id;
            var imageUrl = e.target.result;
              // ทำสิ่งที่คุณต้องการกับ URL ของรูปภาพ, เช่นแสดงรูปภาพในหน้าเว็บ
            $(imagePreview).attr('src', imageUrl);
            };

            reader.readAsDataURL(file); // อ่านไฟล์เป็น Data URL
            let formdata = new FormData();
            formdata.append("files_fileToUpload_name" ,'fileToUpload');
            formdata.append("size",10);
            formdata.append("fileToUpload",file)
            console.log(files)

            ajax_('Exten.php', 'POST', formdata
                , 'upload', function(response) {
                // สิ่งที่คุณต้องการทำเมื่อส่งข้อมูลสำเร็จ
            }, function(error) {

                // สิ่งที่คุณต้องการทำเมื่อเกิดข้อผิดพลาด
            },false,false);

        } else {
            alert('แจ้งเตือน');
        }
    }
    }
    $("#drop-zone").on('drop', function(e) {
   
            e.preventDefault();
            $(this).removeClass('dragover');
            var files = e.originalEvent.dataTransfer.files; // รับรายการไฟล์ที่ลากมา
          // เรียกใช้ฟังก์ชันที่จะอัปโหลดไฟล์
            uploadFiles(files ,'image', 'show_image');
        });
    $("#drop-zone").on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });
    $("#drop-zone").on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });
        
        })
    </script>
</body>
</html>