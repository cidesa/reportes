<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardescto extends baseClases
{
	function sqlp($CODDES,$CODHAS,$TIPDESC)
	{
$condicion='';
if ($TIPDESC =='P' OR $TIPDESC =='M')
{
	$condicion=  "AND TIPDESC ='".$TIPDESC."' ";

}

$sql= "select CODDESC, DESDESC,CODCTA,mondesc, CASE WHEN tipdesc='P' THEN 'Porcentual' WHEN
        tipdesc='M' THEN 'Puntual' ELSE 'Ambos' END as tipodescuento FROM FADESCTO
	  WHERE
		CODDESC >= '".$CODDES."' AND
		CODDESC <= '".$CODHAS."'
		" .$condicion."
		ORDER BY CODDESC";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
?>
