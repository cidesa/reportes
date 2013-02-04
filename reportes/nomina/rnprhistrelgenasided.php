<?

	require_once("pdfnprhistrelgenasided.php");

	$obj= new pdfreporte();


	$obj->AliasNbPages();
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
?>