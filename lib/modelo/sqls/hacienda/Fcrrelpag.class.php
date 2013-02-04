<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrrelpag extends BaseClases
{
	function sqlp($fecdes,$fechas,$cajerodes,$cajerohas,$codempdes,$codemphas,$caj)
	{


       if($caj=='T'){
			$sql="SELECT
						A.NUMPAG,
						to_char(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
						B.NOMCON as NOMCON,A.EDOPAG,
						SUM(A.MONPAG) AS MONPAG
						FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON A.RIFCON=B.RIFCON
						WHERE
						A.FECPAG>=to_date('".$fecdes."','yyyy-mm-dd') AND
						A.FECPAG<=to_date('".$fechas."','yyyy-mm-dd') AND
						rtrim(a.funpag)>=rtrim('".$cajerodes."') AND
						rtrim(a.funpag)<=rtrim('".$cajerohas."') and
						A.RIFCON>=('".$codempdes."') AND
						A.RIFCON<=('".$codemphas."') AND
 						coalesce(A.EDOPAG,' ')<>'A'
						GROUP BY A.NUMPAG,A.FECPAG,B.NOMCON,A.EDOPAG
						ORDER BY A.FECPAG,A.NUMPAG";
						//print $this->sql;exit;
			}
			if($caj=='V'){
			$sql="SELECT
						A.NUMPAG,
						to_char(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
						B.NOMCON as NOMCON,A.EDOPAG,
						SUM(A.MONPAG) AS MONPAG
						FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON A.RIFCON=B.RIFCON
						WHERE
					    A.FECPAG>=to_date('".$fecdes."','yyyy-mm-dd') AND
						A.FECPAG<=to_date('".$fechas."','yyyy-mm-dd') AND
						rtrim(a.funpag)>=rtrim('".$cajerodes."') AND
						rtrim(a.funpag)<=rtrim('".$cajerohas."') and
						A.RIFCON>=('".$codempdes."') AND
						A.RIFCON<=('".$codemphas."') AND
 						coalesce(A.EDOPAG,' ')='V'
						GROUP BY A.NUMPAG,A.FECPAG,B.NOMCON,A.EDOPAG
						ORDER BY A.FECPAG,A.NUMPAG";
						//print $this->sql;exit;
			}
			if($caj=='NV'){
			$sql="SELECT
						A.NUMPAG,
						to_char(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
						B.NOMCON as NOMCON,A.EDOPAG,
						SUM(A.MONPAG) AS MONPAG
						FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON A.RIFCON=B.RIFCON
						WHERE
					    A.FECPAG>=to_date('".$fecdes."','yyyy-mm-dd') AND
						A.FECPAG<=to_date('".$fechas."','yyyy-mm-dd') AND
						rtrim(a.funpag)>=rtrim('".$cajerodes."') AND
						rtrim(a.funpag)<=rtrim('".$cajerohas."') and
						A.RIFCON>=('".$codempdes."') AND
						A.RIFCON<=('".$codemphas."') AND
 						A.EDOPAG IS NULL
						GROUP BY A.NUMPAG,A.FECPAG,B.NOMCON,A.EDOPAG
						ORDER BY A.FECPAG,A.NUMPAG";
			      }
			     // H::PrintR($sql);exit;
	return $this->select($sql);
	}
}
?>
