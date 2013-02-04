<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardefpre extends baseClases
{
	function sqlp($CODDES,$CODHAS,$CODPDES,$CODPHAS)
	{


$sql= "SELECT
A.CODART,
A.codpvp as id,
A.PVPART,
A.DESPVP,
B.DESART
FROM FAARTPVP A,CAREGART B
WHERE
rtrim(A.CODART)=rtrim(B.CODART) and
A.CODART >= '".$CODDES."' AND
A.CODART <= '".$CODHAS."' AND
A.codpvp >= '".$CODPDES."' AND
A.codpvp <= '".$CODPHAS."'
ORDER BY A.CODART, A.codpvp";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
