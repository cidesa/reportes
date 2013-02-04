<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcreccarg extends baseClases
{
	function sqlp($coddes,$codhas,$tipo)
	{

		if ($tipo == 'A')// ambos
		{
			$sql= "SELECT A.codrec as codrgo,A.nomrec as nombre,
				(CASE WHEN A.tipo = 'R' THEN 'Recargo' WHEN A.tipo = 'I' THEN 'Interes Moratorio' END) as tipo,
				(CASE WHEN A.periodo = 'A' THEN 'Actual' WHEN A.periodo = 'T' THEN 'Pasado' END) as periodo,
                (select b.monrgo from carecarg b where RTRIM(a.codrec)=RTRIM(b.codrgo)) as monto

				FROM fcdefrecint a

				WHERE RTRIM(a.codrec) >= RTRIM(('".$coddes."')) AND
				RTRIM(a.codrec) <= RTRIM(('".$codhas."'))
				ORDER BY a.codrec ";


		}
		else
		{
		  $sql= "SELECT A.codrec as codrgo,A.nomrec as nombre,
				(CASE WHEN A.tipo = 'R' THEN 'Recargo' WHEN A.tipo = 'I' THEN 'Interes Moratorio' END) as tipo,
				(CASE WHEN A.periodo = 'A' THEN 'Actual' WHEN A.periodo = 'T' THEN 'Pasado' END) as periodo,
                (select b.monrgo from carecarg b where RTRIM(a.codrec)=RTRIM(b.codrgo)) as monto

				FROM fcdefrecint a

				WHERE RTRIM(a.codrec) >= RTRIM(('".$coddes."')) AND
				RTRIM(a.codrec) <= RTRIM(('".$codhas."'))AND
			    RTRIM(a.TIPO) = RTRIM('".$tipo."')
			    ORDER BY a.codrec	";// H::PrintR($sql);exit;


		}

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