<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrlislic extends baseClases
{
	function sqlp($licdes,$lichas,$tipdes,$tiphas,$fechadesde,$fechahasta)
	{

	$sql="SELECT A.NUMLIC,A.RIFCON,A.NOMNEG,A.CODTIPLIC,TO_CHAR(A.FECLIC,'DD/MM/YYYY') AS FECLIC,
						C.DESTIPLIC
						FROM
    					FCSOLLIC A,FCTIPLIC C
						WHERE
						A.NUMLIC IS NOT NULL AND
						A.NUMLIC>=('".$licdes."') AND
						A.NUMLIC<=('".$lichas."') AND
						A.CODTIPLIC>=('".$tipdes."') AND
						A.CODTIPLIC<=('".$tiphas."') AND
						A.FECLIC>=TO_DATE('".$fechadesde."','DD/MM/YYYY') AND
						A.FECLIC<=TO_DATE('".$fechahasta."','DD/MM/YYYY') AND
						A.STALIC<>'C' and
     					A.STALIC<>'N' and
     					A.STALIC<>'S' and
     					A.CODTIPLIC=C.CODTIPLIC
						ORDER BY
      					A.NUMLIC";

	 //H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
