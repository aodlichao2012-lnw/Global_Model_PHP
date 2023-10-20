<?
require_once './vendor/autoload.php';
 class Extension{
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
            $pdf->Cell(0, 10, $item, 0, 1, 'C');
        }
        $path = getcwd() ."\\Log\\" .date("yyyyMMdd");
        // Output the PDF to the browser
        $pdf->Output($path.'/my_pdf.pdf', 'I');
    }

}


?>