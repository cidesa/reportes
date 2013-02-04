<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrliqemi extends baseClases
{
	function sqlp($fecpagdes,$fecpaghas,$cajdesde,$cajhasta,$codempdes,$codemphas)
	{

	      $sql= "SELECT distinct(A.NUMPAG), A.MONPAG, to_char(A.FECPAG,'dd/mm/yyyy') as fecpag, B.NOMCON
							 FROM FCPAGOS A LEFT OUTER JOIN FCCONREP B ON A.RIFCON=B.RIFCON
							 WHERE
							 A.FECPAG>=to_date('".$fecpagdes."','dd/mm/yyyy') AND
							 A.FECPAG<=to_date('".$fecpaghas."','dd/mm/yyyy')and A.RIFCON>=('".$codempdes."') AND
						     A.RIFCON<=('".$codemphas."') and
						     coalesce(A.EDOPAG,' ')<>'A'  AND rtrim(a.funpag)>=rtrim('".$cajdesde."')
						     and rtrim(a.funpag)<=rtrim('".$fecpaghas."')
						     ORDER BY A.NUMPAG ";

	//H::PrintR($sql);exit;
		return $this->select($sql);

		}
	function sqlp1($codigo)
	{

	  $sql="";

		//H::PrintR($this->sql);exit;
		return $this->select($sql);

		}

}
?>