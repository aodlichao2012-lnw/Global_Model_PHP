<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // require './Extension.php';
    require './ViewModel.php';
    require './Extension.php';




    echo"Hello world";

    $arr = array("12","333","444444444444","4444");
    $dataform_array_to_json = json_encode($arr);
    echo $dataform_array_to_json[0];
    foreach($arr as $item ){
        echo "<div> arr : $item</div>";
    }
    $newobject = new ViewModel();
    $newobject->age = "age is 49";
    ViewModel::$name = 'Static member';
    $newobject->id = "id is 1";

    $list = [];
    $list[] = $newobject;
    foreach($list as $item){

        echo $item->age;
        echo $item->id;
        echo ViewModel::$name;
    }

    $Extention = new Extension();
    $Extention->Log("This is test log");
    $dataform_array_to_json = json_encode($arr);
    $Extention->ExportPDF($dataform_array_to_json);
    function Test1(){
        global $arr , $dataform_array_to_json;
        $data_from_json = json_decode($dataform_array_to_json);
        foreach($data_from_json as $item){
            echo "<div> data_from_json : $item </div>";
            file_put_contents("D://Test.txt",$item."\n" , FILE_APPEND);
        }
    }
    ?>
    <div>   
        <? Test1() ?>
    </div>
</body>
</html>