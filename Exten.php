<?php
require './Library/tecnickcom/tcpdf/tcpdf.php';
require './Interface.php';
require './Library/spreadsheet-reader-master/spreadsheet-reader-master/php-excel-reader/excel_reader2.php';

class Exten implements IAction{
    public function Log($message){
        $date = date('dd-MM-yyyy HH:mm:ss');
        $path = getcwd() ."\\Log\\" .date("yyyyMMdd") . ".txt";
        if(!is_dir( getcwd() ."\\Log\\" )){
            mkdir( getcwd() ."\\Log\\" ,true);
        }
        $message = $date ." : ".$message;
        file_put_contents($path,$message,FILE_APPEND);
    }
    public function ExportPDF($values , $column){
        $pdf =  new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Set document information
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('My PDF Document');
        $pdf->SetSubject('PDF Export');
        $pdf->SetKeywords('PDF, Export, PHP');
        // Add a page
        $pdf->AddPage();
        // Set font
        $pdf->SetFont('helvetica', '', 12);
        $w = 10;
        // foreach($values as $column) {
        //     $pdf->Cell($w, 6, $column);
        //     $w += 100;
        // }
    
        // Add content to the PDF   
        foreach($values as $row) {
            $pdf->Cell(10 , 6, $row[0]);
            $pdf->Cell( 100 , 6, $row[1], '', 0, 'C');
            $pdf->Ln();
        }

        // $path = "". getcwd() ."\\Log\\" .date("yyyyMMdd")."";
        // Output the PDF to the browser
        ob_end_clean();
        $pdf->Output('my_pdf.pdf', 'I');
    }
    public function execute($sqls ,  $connectionstring){
        $conn = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);

        if (!$conn) {
            die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
        }
    
        $sql = $sqls;
        $stmt = oci_parse($conn, $sql);
    
        if (oci_execute($stmt)) {
            // ดำเนินการดึงข้อมูลหรือประมวลผลผลลัพธ์ที่นี่
        } else {
            die("ไม่สามารถ execute คำสั่ง SQL");
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
    }
    public function remove($sqls ,  $connectionstring){
        $conn = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);

        if (!$conn) {
            die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
        }
    
        $sql = $sqls;
        $stmt = oci_parse($conn, $sql);
    
        if (oci_execute($stmt)) {
            // ดำเนินการดึงข้อมูลหรือประมวลผลผลลัพธ์ที่นี่
        } else {
            die("ไม่สามารถ execute คำสั่ง SQL");
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        
    }
    public function Select($sqle ,  $connectionstring){
        $conn = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);

        if (!$conn) {
            die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
        }
    
        $sql = $sqle;
        $stmt = oci_parse($conn, $sql);
    
        if (oci_execute($stmt)) {
            // ดำเนินการดึงข้อมูลหรือประมวลผลผลลัพธ์ที่นี่
        } else {
            die("ไม่สามารถ execute คำสั่ง SQL");
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
    }

    public function SelectAll( $connectionstring){
        $result = [];
        $conn = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);
    if (!$conn) {
        die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
    }
    $sql = "SELECT ANUMBER , LEAD_CALL_DATE FROM MAS_LEADS_TRANS WHERE ROWNUM <= 1000";
    $stmt = oci_parse($conn, $sql);
    if (oci_execute($stmt)) {
        while( $row = oci_fetch_row($stmt)){
            $result[] = $row;
        }
        oci_free_statement($stmt);
        oci_close($conn);
        return  $result;
        }
    }   
    public static function ConnectDb($type , $connectionstring , $Strdb){
        global $con;
        $username = explode(';',$connectionstring)[0];
        $password = explode(';',$connectionstring)[1];
        $tns = explode(';',$connectionstring)[2];
        $con = oci_connect($username,$password,$tns);
        if(! $con){

            $e = oci_error();
            echo"การเชื่อมต่อล้มเหลว: " . $e['message'];
            die("การเชื่อมต่อล้มเหลว: " . $e['message']);
        }else{
            echo"เชื่อมต่อสำเร็จ";
        }

    }
    public function ImportExcel(){

        require('library/php-excel-reader/excel_reader2.php');
        require('library/SpreadsheetReader.php');

        if(isset($_POST['Submit'])){


        $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
        if(in_array($_FILES["file"]["type"],$mimes)){


            $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);


            $Reader = new SpreadsheetReader($uploadFilePath);


            $totalSheet = count($Reader->sheets());


            echo "You have total ".$totalSheet." sheets".


            $html="<table border='1'>";
            $html.="<tr><th>Title</th><th>Description</th></tr>";


            /* For Loop for all sheets */
            for($i=0;$i<$totalSheet;$i++){


            $Reader->ChangeSheet($i);


            foreach ($Reader as $Row)
            {
                $html.="<tr>";
                $title = isset($Row[0]) ? $Row[0] : '';
                $description = isset($Row[1]) ? $Row[1] : '';
                $html.="<td>".$title."</td>";
                $html.="<td>".$description."</td>";
                $html.="</tr>";


                $query = "insert into items(title,description) values('".$title."','".$description."')";


                    $mysqli->query($query);
                }


            }


            $html.="</table>";
            echo $html;
            echo "<br />Data Inserted in dababase";


        }else { 
            die("<br/>Sorry, File type is not allowed. Only Excel file."); 
        }


        }
    }
    public function ExportExcel($query , $connectionstring){
        include('./Library/PHPExcel-1.8/Classes/PHPExcel.php');
        $conn1 = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);
        if (!$conn1) {
            die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
        }
        $objPHPExcel    =   new PHPExcel();
        $result         =  oci_parse($conn1, $query);
        
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
        
        $rowCount   =   1;
        $values_export = [];
        if(oci_execute($result) ){
            while($row  =   oci_fetch_row($result)){
                $values_export[] = $row;
            }
        }
        foreach($values_export as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[0] ,true );
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[1] , true );
            $rowCount++;
        }
        
        $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $filename = 'your_exported_data.xlsx';
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
        $objWriter->save('php://output');
        oci_free_statement($result);
        oci_close($conn1);
    }
    public function ExportCSV($query , $connectionstring){
        $conn1 = oci_connect( explode(';',$connectionstring)[0],  explode(';',$connectionstring)[1], explode(';',$connectionstring)[2]);
        if (!$conn1) {
            die("ไม่สามารถเชื่อมต่อกับ Oracle Database");
        }
        $result         =  oci_parse($conn1, $query);
    
        $csvFileName = 'example.csv';
        $csvFile = fopen($csvFileName, 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$csvFileName.'"');
        $values_export_header = [ 'ANUMBER' ,'DATE'];
        fputcsv( $csvFile, $values_export_header );
        if(oci_execute($result) ){
            while($row  =   oci_fetch_row($result)){
                $values_export =   [$row[0] , $row[1]];
                fputcsv( $csvFile, $values_export );
            }
        }
        fclose($csvFile);
            $filename = getcwd().'\\CSV\\';
        if(!is_dir($filename)){

            mkdir($filename,0, true);
        }else{

        }
        $destinationPath = $filename . $csvFileName;
        copy($csvFileName, $destinationPath);
        echo $destinationPath;  
    }
    public function RamdomNumber($start , $end){
        $randomnumber = rand($start,$end);
        return $randomnumber;
    }
    public function upload( $files_fileToUpload_name  , $size) {
        $responseMessage = "";
        echo($files_fileToUpload_name);
        if($_FILES[$files_fileToUpload_name]["name"] != "" || $_FILES[$files_fileToUpload_name]["name"]  == null){
            $responseMessage = "ไม่มีรูปภาพ";
        }
            $targetDirectory = getcwd().'\\FILE\\'; // ระบุโฟลเดอร์ที่คุณต้องการให้ไฟล์ถูกบันทึก
            if(!is_dir($targetDirectory)){

                mkdir($targetDirectory,0, true);
            }else{
    
            }
            $targetFile = $targetDirectory . basename($_FILES[$files_fileToUpload_name]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            // ตรวจสอบว่าไฟล์เป็นไฟล์รูปภาพหรือไม่ (คุณสามารถปรับปรุงเพิ่มเติมเพื่อรองรับประเภทไฟล์อื่น ๆ)
            if ($_FILES[$files_fileToUpload_name]["type"] != "image/jpeg" && $_FILES[$files_fileToUpload_name]["type"] != "image/png" && $_FILES[$files_fileToUpload_name]["type"] != "image/gif") {
                $uploadOk = 0;
                $responseMessage =  "<div>Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</div>";
            }
        
            // ตรวจสอบว่าไฟล์มีอยู่แล้วหรือไม่
            if (file_exists($targetFile)) {
                $uploadOk = 0;
                $responseMessage = "<div>Sorry, file already exists.</div>";
            }
        
            // ตรวจสอบขนาดไฟล์
            if ($_FILES[$files_fileToUpload_name]["size"] > 500000) {  // ปรับขนาดไฟล์ตามที่คุณต้องการ
                $uploadOk = 0;
                $responseMessage =  "<div>Sorry, your file is too large.</div>";

            }
        
            if (pathinfo($targetFile, PATHINFO_EXTENSION) != "jpg" && pathinfo($targetFile, PATHINFO_EXTENSION) != "jpeg" && pathinfo($targetFile, PATHINFO_EXTENSION) != "png" && pathinfo($targetFile, PATHINFO_EXTENSION) != "gif") {
                $uploadOk = 0;
                $responseMessage = "<div>Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</div>";
            }
            // ตรวจสอบว่า $uploadOk ยังคงเป็น 1 หรือไม่
            if ($uploadOk == 0) {
                $responseMessage = "<div>Sorry, your file was not uploaded.</div>";
            } else {
                // ถ้าทุกอย่างถูกต้อง, ก็อัปโหลดไฟล์
                if (move_uploaded_file($_FILES[$files_fileToUpload_name ]["tmp_name"], $targetFile)) {
                    $responseMessage =  "<div>The file " . basename($_FILES[$files_fileToUpload_name ]["name"]) . " has been uploaded.</div>";
                } else {
                    $responseMessage = "<div>Sorry, there was an error uploading your file.</div>";
                }
            }
            echo($_FILES[$files_fileToUpload_name]["name"] );
        }
        }
        $Extention = new Exten();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
            // if (isset($_POST["upload"])) {
                // เรียกฟังก์ชันที่ถูกระบุ
                    $param1 = $_POST["files_fileToUpload_name"];
                    $param2 = $_POST["size"];
                    echo$param1."".$param2."";
                    $Extention->upload( $param1,$param2); // เรียกฟังก์ชัน myFunction
                }
?>