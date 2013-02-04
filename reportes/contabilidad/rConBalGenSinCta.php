<?
	
	require_once("pdfConBalGenSinCta.php");
	
	$obj= new pdfreporte();
	
	
	$obj->AliasNbPages(); 
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
?>