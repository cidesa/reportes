<?php
require_once("../../lib/modelo/baseClases.class.php");

class Facciecaj extends baseClases
{
	function sqlp($FECDES,$FECHAS,$DETALLES)
	{

$sql= "SELECT A.REFFAC ,
A.FECFAC,
A.DESFAC,
--Nvl(B.TIPPAG,DECODE(C.TIPCONPAG,'R','V/C','S/T')) TIPPAG, -- Dudas
B.NROPAG,
B.NOMBAN,
B.MONPAG+A.vuelto MONPAG,
--A.MONFAC MONPAG,
B.NUMERO FROM FAFACTUR A, FAFORPAG B,CACONPAG C
WHERE
A.CONPAG=C.CODCONPAG AND
--A.REFFAC=B.REFFAC(+) AND-- Dudas
A.FECFAC>=to_date('".$FECDES."','yyyy/mm/dd') AND
A.FECFAC<=to_date('".$FECHAS."','yyyy/mm/dd') AND
(A.STATUS='A' OR (A.STATUS='N' AND FECANU>to_date('".$FECHAS."','yyyy/mm/dd'))

UNION

SELECT A.REFFAC ,
A.FECFAC,
A.DESFAC,
'RET' TIPPAG,
' ' NROPAG,
' ' NOMBAN,
B.MONDESC,
A.REFFAC NUMERO FROM FAFACTUR A, FADESCART B,CADESCTO C
WHERE A.REFFAC=B.REFDOC AND
B.CODDESC=C.CODDESC AND
C.TIPRET='S' AND
A.FECFAC>=to_date('".$FECDES."','yyyy/mm/dd') AND
A.FECFAC<=to_date('".$FECHAS."','yyyy/mm/dd') AND
(A.STATUS='A' OR (A.STATUS='N' AND FECANU>to_date('".$FECHAS."','yyyy/mm/dd')))

UNION

SELECT A.REFFAC ,
A.FECFAC,
A.DESFAC,
'ANU' TIPPAG,
' ' NROPAG,
' ' NOMBAN,
A.MONFAC,
A.MOTANU NUMERO
FROM FAFACTUR A
WHERE
A.FECFAC>=to_date('".$FECDES."','yyyy/mm/dd') AND
A.FECFAC<=to_date('".$FECHAS."','yyyy/mm/dd') AND
A.STATUS='N' AND
A.FECANU=A.FECFAC AND
A.FECANU>=to_date('".$FECDES."','yyyy/mm/dd') AND
A.FECANU<=to_date('".$FECHAS."','yyyy/mm/dd') AND

UNION

SELECT
--'NC/'||B.CORREL REFFAC,
A.FECFAC,
A.DESFAC,
'NDC' TIPPAG,
' ' NROPAG,
' ' NOMBAN,
A.MONFAC,
A.REFFAC NUMERO
FROM FAFACTUR A,FaNotCre B
WHERE
A.REFFAC=B.REFFAC AND
A.STATUS='N' AND
A.FECANU<>A.FECFAC AND
A.FECANU>=to_date('".$FECDES."','yyyy/mm/dd') AND
A.FECANU<=to_date('".$FECHAS."','yyyy/mm/dd') AND
ORDER BY 2,1,4";
H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp1($codpro)
	{

	$sql=" SELECT A.REFFAC ,
A.FECFAC,
A.DESFAC,
'ANU' TIPPAG,
' ' NROPAG,
' ' NOMBAN,
A.MONFAC,
A.MOTANU NUMERO
FROM FAFACTUR A
WHERE
A.FECFAC>=:FECHADES AND
A.FECFAC<=:FECHAHAS AND
A.STATUS='N' AND
A.FECANU=A.FECFAC AND
A.FECANU>=:FECHADES AND
A.FECANU<=:FECHAHAS order by a.reffac";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}




}
?>