<?php
class ChartsController extends Controller {
	function __construct() {
		parent::__construct ();

	}

	function index() {

		$data = array(array('', 10), array('', 1));
		$plot = new PHPlot();
		$plot->SetDataValues($data);
		$plot->SetTitle('First Test Plot');

		$pdf = new FPDF();
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Write(4, 'Olá Mundo!!');
		$pdf->Image($plot->DrawGraph(),4,5,150,70,jpg);
		$arquivo = "app/public/pdf/Teste.pdf";

		//if (!file_exists($arquivo)) {
		$pdf->Output($arquivo, "F");
		//}


		
	}

}