<?php
$realpath = 'adminConfig/init.php';
include($realpath);
//include('config/init.php');
require_once(realpath( dirname( __FILE__ ) ).'/fpdf181/fpdf.php');
$array = explode('/',$_SERVER['DOCUMENT_ROOT']);
array_pop($array);
$path = implode('/',$array);
@extract($_POST);

if($_GET['action'] == 'addnew'){
	$dsk_detail = $objAdmin->add_new_dsk_event_detail($_POST);
	if($dsk_detail != '')
	{
		class PDF extends FPDF
		{
			// Better table
			function ImprovedTable($header,$data)
			{
			    // Column widths
			    //$w = array(80, 50, 50);
			    // Header
			 //   for($i=0;$i<count($header);$i++)
			 //       $this->Cell($w[$i],7,$header[$i],1,0,'C');
			 //   $this->Ln();
			 //   $this->Cell(10);
			 //   for ($i=0; $i <count($data) ; $i++) {
			 //   		$this->Cell($w[$i],14,$data[$i],1,0,'C');
			 //   }
			 //   $this->Ln();
			}
		}

		$doc = new DOMDocument();

		//load HTML in PHP DOM
		@$doc->loadHTML($content);

		//extract the text of a DIV element for PDF
		$text_for_pdf = $doc->getElementById('page_content')->nodeValue;

		//use FPDF
		$pdf = new PDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(150);
		$pdf->Cell(0,10,"Receipt No.- 00".$dsk_detail);
		$pdf->Image('https://www.mrscapital.in/images/logo.png',20,20,40);

		//specify width and height of the cell Multicell(width, height, string)
		//load extracted text into FPDF
		
		$pdf->Ln();
        $pdf->Cell(110);
        $pdf->Cell(0,5,"Lights In Dark Travel & Events PVT LTD.");
        $pdf->Ln();
        $pdf->Cell(105);
        $pdf->Cell(0,5,"Building No-6 2nd Floor, Jwalaheri Market");
        $pdf->Ln();
        $pdf->Cell(110);
        $pdf->Cell(0,5,"Paschim Vihar, New Delhi-110063, India.");
        $pdf->Ln();
        $pdf->Cell(135);
        $pdf->Cell(0,5,"GSTIN-07AACCL4198F1ZE");
        $pdf->Line(20, 40, 220-20, 40);
		$pdf->Ln();
		$pdf->Cell(50);
		$pdf->SetFont('times','B',14);
		$pdf->Cell(0,30,"Thank you for registering at Mrs Capital.");
		$pdf->Ln();
		$pdf->SetFont('times','I',14);
		$pdf->Cell(10);
		$pdf->Cell(0,0,$_POST['firstname']." ". $_POST['lastname']);
		$pdf->Ln();
		$pdf->Cell(10);
		$pdf->cell(0,12,"Age: ".$_POST['age']."Year");
		$pdf->Ln();
		$pdf->Cell(10);
		$pdf->Cell(0,0,"Email: ".$_POST['email']);
		$pdf->Ln();
		$pdf->Cell(10);
		$pdf->Cell(0,12,"Address: ".$_POST['address'].", ".$_POST['address1'].",".$_POST['city'].",".$_POST['state'].",".$_POST['pincode']);
		$pdf->Ln();
		$pdf->Cell(60);
		$pdf->SetFont('times','B',18);
		$pdf->Cell(0,20,"PAYMENT RECIEPT");

		$pdf->Ln();
		$pdf->Cell(15);
		$pdf->SetFont('times','I',14);
// 		$header = array("Particulars","Amount","Transaction id");
// 		$data = array("Registration Fee For participation ","Rs. 1770 /-",'Cash');
// 		$pdf->ImprovedTable($header,$data);
        $width_cell=array(60, 50, 50);
        $pdf->SetFillColor(193,229,252); // Background color of header 
        // Header starts // 
        $pdf->Cell($width_cell[0],10,'Particulars',1,0,'C',true); // First header column 
        $pdf->Cell($width_cell[1],10,'Amount',1,0,'C',true); // Second header column
        $pdf->Cell($width_cell[2],10,'Transaction id',1,0,'C',true); // Third header column 
        //// header is over ///////
        $pdf->Ln();
        $pdf->Cell(15);
        $pdf->SetFont('Arial','',10);
        // First row of data 
        $pdf->Cell($width_cell[0],14,'Registration Fee For participation',1,0,'C',false); // First column of row 1 
        $pdf->Cell($width_cell[1],14,'Rs. 1500 /-',1,0,'C',false); // Second column of row 1 
        $pdf->Cell($width_cell[2],14,'Cash',1,0,'C',false); // Third column of row 1 
        $pdf->Ln(); 
        $pdf->Cell(15);
        //  First row of data is over 
        //  Second row of data 
        $pdf->Cell($width_cell[0],14,'GST On Registration Fee 18%',1,0,'C',false); // First column of row 2 
        $pdf->Cell($width_cell[1],14,'Rs. 270 /-',1,0,'C',false); // Second column of row 2
        $pdf->Cell($width_cell[2],14,'',1,0,'C',false); // Third column of row 2
        $pdf->Ln();
        $pdf->Cell(15);
        //   Sedond row is over 
        //  Third row of data
        $pdf->Cell($width_cell[0],14,'Total',1,0,'C',false); // First column of row 3
        $pdf->Cell($width_cell[1],14,'Rs. 1770 /-',1,0,'C',false); // Second column of row 3
        $pdf->Cell($width_cell[2],14,'',1,0,'C',false); // Third column of row 3
        $pdf->Ln();

		$pdf->Cell(50);
		$pdf->SetFont('times','I',12);
		$pdf->SetTextColor(255,0,0);
		$pdf->Cell(0,5,"*this fee is non-refundable and non-amendable.");
		$pdf->Ln();
		$pdf->Cell(10);
		$pdf->SetFont('times','B',16);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(0,20,"Note:");
		$pdf->Ln();
// 		$pdf->Cell(25);
// 		$pdf->SetFont('times','B',14);
// 		$pdf->Cell(0,8,"Registration Amount is Rs.1500/- and GST(18%) Amount is Rs.270/-.");
// 		$pdf->Ln();
		$pdf->Cell(25);
		$pdf->SetFont('times','',14);
		$pdf->Cell(0,5,"1. Please bring this receipt with you at the time of auditions.");
		$pdf->Ln();
		$pdf->Cell(25);
		$pdf->SetFont('times','',14);
		$pdf->Cell(0,5,"2. Hard Copy is not required.");
		$pdf->Ln();
		$pdf->Cell(25);
		$pdf->SetFont('times','B',14);
		$pdf->Cell(0,5,"3. You will be govern about the audition date & timings through whatsapp or call.");
		$fileName = 'receipt'.$dsk_detail.'.pdf';
		$content = $pdf->Output($fileName,'F');
		file_put_contents($content);
		$realpath =  $path.'/mrscapital.in/invoice/'.$fileName;
		copy($fileName,$realpath);
		unlink($fileName);
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>