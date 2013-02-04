<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrlisdoc extends baseClases
{
	function sqlp($coddes,$codhas,$codctedes,$codctehas,$fechades,$fechahas,$tipmovdes,$tipmovhas)
	{

$sql= " SELECT A.REFDOC, to_char(A.FECEMI,'dd/mm/yyyy') as FECEMI, A.FATIPMOV_ID AS CODMOV, A.CODCLI as CODPRO, B.NOMPRO as NOMPRO,
A.DESDOC, A.MONDOC, A.RECDOC, A.DSCDOC, A.SALDOC
FROM COBDOCUME A,
FACLIENTE B
WHERE A.CODCLI >= '".$codctedes."' AND
A.CODCLI <= '".$codctehas."' AND
A.REFDOC >= '".$coddes."' AND
A.REFDOC <= '".$codhas."' AND
A.FATIPMOV_ID >= '".$tipmovdes."' AND
A.FATIPMOV_ID <= '".$tipmovhas."' AND
A.FECEMI >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECEMI <= to_date('".$fechahas."','yyyy/mm/dd') AND
A.STADOC='A' AND
A.CODCLI=B.CODPRO
GROUP BY
A.REFDOC, A.FECEMI, A.FATIPMOV_ID, A.CODCLI, B.NOMPRO,
A.DESDOC, A.MONDOC, A.RECDOC, A.DSCDOC, A.SALDOC
ORDER BY A.REFDOC,A.FECEMI";
//print '<pre>';H::PrintR($sql);
return $this->select($sql);
	}

}
