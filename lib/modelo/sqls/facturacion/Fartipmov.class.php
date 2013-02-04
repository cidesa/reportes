<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fartipmov extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT DESMOV as desmov, NOMABR as nomabr, (CASE WHEN DEBCRE = 'D' THEN 'DEBITO' WHEN DEBCRE = 'C' THEN 'CREDITO' END) as debcre, CODCTA as codcta, ID as id FROM fatipmov WHERE id >='".$coddes."' and id <= '".$codhas."'";
		return $this->select($sql);
	}

/*unction sqlalt($codart)
	{

		$sql= "SELECT
		DESART as desart
		FROM CAREGART A
		WHERE
		A.CODART= '".$codart."'";

		//H::PrintR($sql);
		return $this->select($sql);
	}*/


}
?>