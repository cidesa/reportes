<?
	
	require_once("pdfNPRPAISES.php");
	require_once("anchoNPRPAISES.php");
	
	$objrep=new mysreportes();
	
	$obj= new pdfreporte();
	
	for($i=0;$i<count($obj->titulos);$i++)
	{
		$obj->anchos[$i]=$objrep->getAncho($i);
	}
	
	for($i=0;$i<count($obj->titulos2);$i++)
	{
		$obj->anchos2[$i]=$objrep->getAncho2($i);
	}
	
	for($i=0;$i<count($obj->titulos3);$i++)
	{
		$obj->anchos3[$i]=$objrep->getAncho3($i);
	}

	$obj->AliasNbPages(); 
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
?>