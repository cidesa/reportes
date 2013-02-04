<?

	require_once("pdfhistnpprestacionesdiasadd.php");
	$obj= new pdfreporte();
	$obj->AliasNbPages();
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
?>