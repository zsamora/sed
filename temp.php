


$dompdf = new Dompdf();
$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
//exit(0);
// Descomentar para PDF descargable
//$dompdf->stream("Informe - ".$nombre." ".$apellido.".pdf");
////////////////////////////////////

/*$dompdf->load_html_file("'informe.php?usuario_id=".$usuario_id."
&car_id=".$cargo_id."
&cic_id=".$ciclo_id."
&asi_id=".$asi_id."'")));
//$html = file_get_contents("welcome.php");
//$dompdf->loadHtml($tbl);
$dompdf->load_html($_SESSION['prints']['table']);
$dompdf->load_html_file(index.php);
//$dompdf->load_html(file_get_contents("index.php"));
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream("Informe.pdf")*/
?>
