<?

	require_once("pdfconbalgenfis.php");

	$obj= new pdfreporte();


	$obj->AliasNbPages();
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
?>