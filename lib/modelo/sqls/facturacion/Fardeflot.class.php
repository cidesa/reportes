<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardeflot extends baseClases
{
	function sqlp($CODDES,$CODHAS,$FECDES,$FECHAS,$NUMMIN,$NUNMAX)
	{


$sql= "SELECT
		A.CODART,
		C.DESART,
		A.NUMLOT,
		A.DESLOT,
		B.NOMALM,
		A.CANLOT,
		A.FECVEN,
		A.COSLOT
		FROM FADEFLOT A,
		CADEFALM B,
		CAREGART C
	WHERE
		A.CODALM=B.CODALM AND
		A.CODART=C.CODART AND
		A.CODART>= '".$CODDES."' AND
		A.CODART<= '".$CODHAS."' AND
		A.NUMLOT>= '".$NUMMIN."' AND
		A.NUMLOT<= '".$NUNMAX."' AND
		A.FECVEN>= to_date('".$FECDES."','yyyy/mm/dd') AND
		A.FECVEN<= to_date('".$FECHAS."','yyyy/mm/dd')
		ORDER BY A.CODART, A.NUMLOT";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
