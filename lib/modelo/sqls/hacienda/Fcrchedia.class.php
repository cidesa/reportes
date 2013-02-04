<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrchedia extends baseClases
{
	function sqlp($fecdes,$fechas)
	{
		$this->sql= "SELECT A.NUMPAG,A.NRODET,SUM(A.MONPAG) AS MONPAG,A.TIPPAG FROM FCDETPAG A, FCPAGOS B
							WHERE A.NUMPAG=B.NUMPAG AND
							B.FECPAG>=to_date('".$fecdes."','dd/mm/yyyy') AND
							B.FECPAG<=to_date('".$fechas."','dd/mm/yyyy') AND
							RTRIM(A.TIPPAG)='002' and
							coalesce(B.EDOPAG,' ')<>'A'
							group by A.NUMPAG,A.NRODET,A.TIPPAG
							order by a.numpag,a.nrodet";
			//H::PrintR($this->sql);exit;
      return $this->select($this->sql);
	}

}
?>