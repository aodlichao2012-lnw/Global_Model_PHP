<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require './Library/tecnickcom/tcpdf/tcpdf.php';
require './Interface.php';
require './Library/spreadsheet-reader-master/spreadsheet-reader-master/php-excel-reader/excel_reader2.php';

 class Exten implements IAction{

    public function Log($message){
        $date = date('dd-MM-yyyy HH:mm:ss');
        $path = getcwd() ."\\Log\\" .date("yyyyMMdd") . ".txt";
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
 
    // public static function ConnectDb($type , $connectionstring , $Strdb){
    //     global $con;
    //     $username = explode(';',$connectionstring)[0];
    //     $password = explode(';',$connectionstring)[1];
    //     $tns = explode(';',$connectionstring)[2];
    //     $con = oci_connect($username,$password,$tns);
    //     if(! $con){

    //         $e = oci_error();
    //         echo"การเชื่อมต่อล้มเหลว: " . $e['message'];
    //         die("การเชื่อมต่อล้มเหลว: " . $e['message']);
    //     }else{
    //         echo"เชื่อมต่อสำเร็จ";
    //     }

    // }
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
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Country Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Country Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Capital');
        
        $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
        
        $rowCount   =   2;
        $values_export = [];
        if(oci_execute($result) ){
            while($row  =   oci_fetch_row($result)){
                $values_export[] = $row;
            }
        }
        oci_free_statement($result);
        oci_close($conn1);
        foreach($values_export as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[1]);
            $rowCount++;
        }
        
        $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $filename = 'your_exported_data.xlsx';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
        $objWriter->save('php://output');
        readfile($filename);
    }
}
?>