<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrrelpagrub extends BaseClases
{
	function sqlp($fecdes,$fechas,$cajerodes,$cajerohas,$codempdes,$codemphas,$fuendes,$fuenhas,$direccion,$tipdoc)
	{

     if($tipdoc=='I'){

				$sql="SELECT
						A.NUMPAG,A.DESPAG,d.numref,
						to_char(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
						B.NOMCON as NOMCON,C.CODFUE,C.NOMFUE,D.FUEING,
						SUM(D.MONPAG) AS MONPAG,A.DIRCON
						FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON A.RIFCON=B.RIFCON,
						FCFUEPRE C,FCDECPAG D
						WHERE
						rtrim(a.funpag)>=rtrim('".$cajerodes."') AND
						rtrim(a.funpag)<=rtrim('".$cajerohas."') and
						A.RIFCON>=('".$codempdes."') AND
						A.RIFCON<=('".$codemphas."') AND
 						coalesce(A.EDOPAG,' ')<>'A' AND
						A.FECPAG>=to_date('".$fecdes."','yyyy-mm-dd') AND
						A.FECPAG<=to_date('".$fechas."','yyyy-mm-dd') AND
						D.FUEING>=RTRIM('".$fuendes."') AND
						D.FUEING<=RTRIM('".$fuenhas."') AND
						A.NUMPAG=D.NUMPAG AND
						D.FUEING = C.CODFUE AND
						upper(coalesce(A.DIRCON,' ')) like '%".trim(strtoupper($direccion))."%'
						GROUP BY A.NUMPAG,A.DESPAG,A.FECPAG,d.numref,B.NOMCON,C.CODFUE,C.NOMFUE,D.FUEING,A.DIRCON
						ORDER BY D.FUEING,A.FECPAG,A.NUMPAG";
			}
			if($tipdoc=='E'){
					$sql="SELECT B.RIFCON,A.NUMPAG,A.DESPAG,d.numref,
							   to_char(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
      						   B.NOMCON as NOMCON,C.CODFUE,C.NOMFUE,
                               D.FUEING, SUM(D.MONPAG) AS MONPAG,A.DIRCON
                               FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON
                               A.RIFCON=B.RIFCON,FCFUEPRE C,FCDECPAG D
							   WHERE
     						   A.RIFCON=('".$codempdes."') AND
							   A.FECPAG>=to_date('".$fecdes."','yyyy-mm-dd') AND
						       A.FECPAG<=to_date('".$fechas."','yyyy-mm-dd') AND
							   D.FUEING>=RTRIM('".$fuendes."') AND
						       D.FUEING<=RTRIM('".$fuenhas."') AND
                               coalesce(A.EDOPAG,' ')<>'A' AND
                               A.NUMPAG=D.NUMPAG AND
                               D.FUEING = C.CODFUE AND
     						   upper(coalesce(A.DIRCON,' ')) like '%".trim(strtoupper($direccion))."%'
                               GROUP BY
                               B.RIFCON,A.NUMPAG,A.DESPAG,
							   A.FECPAG,B.NOMCON,C.CODFUE,d.numref,C.NOMFUE,
                               D.FUEING,D.MONPAG,A.DIRCON
                               ORDER BY
                               D.FUEING,A.FECPAG,A.NUMPAG";
			}
			     // H::PrintR($sql);exit;
	return $this->select($sql);
	}
}
?>
