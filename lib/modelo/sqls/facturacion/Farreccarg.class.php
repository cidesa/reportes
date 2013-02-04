<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fareccarg extends baseClases
{
	function sqlp($coddes,$codhas,$tipo)
	{

		if ($tipo == 'A')
		{
			$sql= "SELECT CODRGO as codrgo,
			NOMRGO as nomrgo,
			CODPRE as codpre,
			(CASE WHEN TIPRGO = 'P' THEN 'Porcentual' WHEN TIPRGO = 'M' THEN 'Puntual' END) as tiprgo,
			MONRGO as monto
			FROM CARECARG
			WHERE RTRIM(CODRGO) >= RTRIM('".$coddes."') AND
			RTRIM(CODRGO) <= RTRIM('".$codhas."')
			ORDER BY CODRGO	";

		}
		else
		{
		  $sql= "SELECT CODRGO as codrgo,
			NOMRGO as nomrgo,
			CODPRE as codpre,
			(CASE WHEN TIPRGO = 'P' THEN 'Porcentual' WHEN TIPRGO = 'M' THEN 'Puntual' END) as tiprgo,
			MONRGO as monto
			FROM CARECARG
			WHERE RTRIM(CODRGO) >= RTRIM('".$coddes."') AND
			RTRIM(CODRGO) <= RTRIM('".$codhas."') AND
			 RTRIM(TIPRGO) = RTRIM('".$tipo."')
			ORDER BY CODRGO	";

		}
		//H::PrintR($sql);
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