<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="upload.php" method="POST" enctype="multipart/form-data">
        Select File to Upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
<?php
    // require './Exten.php';
    // use ViewModel;
    // use Exten;
    include("./Exten.php");
    include("./ViewModel.php");
    // echo"Hello world";

    // $arr = array("12","333","444444444444","4444");
    // $dataform_array_to_json = json_encode($arr);
    // // echo $dataform_array_to_json[0];
    // // foreach($arr as $item ){
    // //     echo "<div> arr : $item</div>";
    // // }
    // $newobject = new ViewModel();
    // $newobject->age = "age is 49";
    // ViewModel::$name = 'Static member';
    // $newobject->id = "id is 1";
    // $datahash = password_hash( $newobject->age , PASSWORD_DEFAULT );
    // // echo "Datahash :". $datahash;
    // $list = [];
    // $list[] = $newobject;
    // // foreach($list as $item){

    // //     echo $item->age;
    // //     echo $item->id;
    // //     echo ViewModel::$name;
    // // }

    $Extention = new Exten();
    $Extention->upload("submit","fileToUpload",10);
    // $data =  $Extention->SelectAll("PREGOV;CORRGOV;ORAIEC23");

    // $Extention->Log("This is test log");
    // $dataform_array_to_json = json_encode($arr);
    // $data_from_json = json_decode($dataform_array_to_json);

    // // $Extention->ExportPDF($data,$keys);
    // $Extention->ExportCSV("SELECT ANUMBER , LEAD_CALL_DATE FROM MAS_LEADS_TRANS WHERE ROWNUM <= 1000","PREGOV;CORRGOV;ORAIEC23");
    // function Test1(){
    //     global $arr , $dataform_array_to_json;
    //     $data_from_json = json_decode($dataform_array_to_json);
    //     foreach($data_from_json as $item){
    //         // echo "<div> data_from_json : $item </div>";
    //         file_put_contents("D://Test.txt",$item."\n" , FILE_APPEND);
    //     }
    // }
    ?>

</body>
</html>

