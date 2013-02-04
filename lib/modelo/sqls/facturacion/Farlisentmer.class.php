<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farlisentmer extends baseClases
{
	function sqlp($CODDES,$CODHAS,$CODPDES,$CODPHAS)
	{
$sql= "SELECT A.CODART,
A.CODPRO,
--DECODE(A.TIPPER,'P','Proveedor','C','Cliente') TIPPER,
C.NOMALM,
D.DESART,
A.COMISI
FROM FAARTPRO A,CADEFALM C,CAREGART D
WHERE
C.CODALM=A.CODALM AND
D.CODART=A.CODART AND
A.CODART>= '".$CODDES."' AND
A.CODART<= '".$CODHAS."' AND
A.CODPRO>='".$CODPDES."' AND  --Consultar en que tabla es que busca
A.CODPRO <='".$CODPHAS."'     --Consultar en que tabla es que busca
ORDER BY A.CODART";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
