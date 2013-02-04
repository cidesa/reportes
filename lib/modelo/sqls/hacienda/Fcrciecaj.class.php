<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrciecaj extends baseClases
{
	function sqlp($cajdes,$cajhas,$fecpagdes,$fecpaghas)
	{

	  $this->sql= "SELECT A.TIPPAG, C.DESPAG, SUM(A.MONPAG) as MONPAG
	    FROM FCDETPAG A left outer join FCPAGOS B on (A.NUMPAG=B.NUMPAG),FCTIPPAG C
	   	WHERE
		trim(A.TIPPAG)=trim(C.TIPPAG) and
		TRIM(B.FUNPAG)>=TRIM('".$cajdes."') AND
		TRIM(B.FUNPAG)<=TRIM('".$cajhas."') AND
		B.FECPAG>=to_date('".$fecpagdes."','dd/mm/yyyy') AND
		B.FECPAG<=to_date('".$fecpaghas."','dd/mm/yyyy') and
		coalesce(B.EDOPAG,' ')<>'A' AND
		coalesce(B.EDOPAG,' ')='V'
		GROUP BY A.TIPPAG,C.DESPAG";

		//H::PrintR($this->sql);exit;
		return $this->select($this->sql);

		}

}
?>