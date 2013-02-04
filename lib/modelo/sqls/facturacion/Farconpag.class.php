<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farconpag extends baseClases
{
	function sqlp($CODDES,$CODHAS,$CONDI)
	{
$condicion='';
if ($CONDI =='C' OR $CONDI =='R')
{
	$condicion=  "AND TIPCONPAG ='".$CONDI."' ";

}

$sql= "select id as codconpag, desconpag, CASE WHEN tipconpag='C' THEN 'Contado' WHEN
        tipconpag='R' THEN 'Credito' END FROM FACONPAG
	  WHERE
		id >= '".$CODDES."' AND
		id <= '".$CODHAS."'
		" .$condicion."
		ORDER BY id";
		//H::PrintR($sql);
return $this->select($sql);
	}
}
?>
