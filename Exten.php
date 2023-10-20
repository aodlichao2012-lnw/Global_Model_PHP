<?php
require './tecnickcom/tcpdf/tcpdf.php';
 class Exten{
    public function Log($message){
        $date = date('dd-MM-yyyy HH:mm:ss');
        $path = getcwd() ."\\Log\\" .date("yyyyMMdd") . ".txt";
        $message = $date ." : ".$message;
        file_put_contents($path,$message,FILE_APPEND);
    }
    public function ExportPDF($values){
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
        // Add content to the PDF   
        foreach($values as $item){
            echo"<div>item 1 send to pdf : $item</div>";
            $pdf->Cell(0, 10,$item , 0, 1, 'L');
        }
        // $path = "". getcwd() ."\\Log\\" .date("yyyyMMdd")."";
        // Output the PDF to the browser
        ob_end_clean();
        $pdf->Output('my_pdf.pdf', 'I');
    }

}


?>