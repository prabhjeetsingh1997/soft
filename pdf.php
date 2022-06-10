<?php
include('config/init.php');
require_once("dompdf/dompdf_config.inc.php");
//$url = APP_URL.'gen_pdf.php?'.$_SERVER['QUERY_STRING'];
//$url = 'http://localhost/travlecrm/admin/gen_pdf.php';

$html = file_get_contents($url);

$tname = 'invoice';
$pdfName = $tname.'.pdf';

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($pdfName);