<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprgastcat extends baseClases
{
    function sql($tipnom,$codcondes,$codconhas,$codnivdes,$codnivhas,$codgasdes,$codgashas)
    {
    	$sql="SELECT
						A.CODTIPGAS,
						E.DESTIPGAS,
						A.CODCAT as codcat,
						RTRIM(B.NOMCAT) as NOMCAT,
						C.CODCON as codcon,
						D.NOMCON as nomcon,
						SUM((CASE WHEN C.ASIDED='D' THEN C.SALDO ELSE 0 END)) as DEDUC ,
						SUM((CASE WHEN C.ASIDED='A' THEN C.SALDO ELSE 0 END)) as ASIGNA,
 						SUM((CASE WHEN C.ASIDED='P' THEN C.SALDO ELSE 0 END)) as PATRON
						FROM
						NPASICAREMP A,
						NPCATPRE B,
						NPNOMCAL C,
						NPDEFCPT D,
						NPTIPGAS E
						WHERE
						C.CODNOM = '$tipnom' AND
						C.CODCON >= '$codcondes' AND
						C.CODCON <= '$codconhas' AND
						A.CODCAT >= '$codnivdes' AND
						A.CODCAT <= '$codnivhas' AND
						A.CODTIPGAS >= '$codgasdes' AND
						A.CODTIPGAS <= '$codgashas' AND
						A.CODCAT=B.CODCAT AND
						A.CODEMP=C.CODEMP AND
						A.CODCAR=C.CODCAR AND
						A.CODNOM=C.CODNOM AND
						C.CODCON=D.CODCON AND
						E.CODTIPGAS=A.CODTIPGAS
						GROUP BY
						A.CODTIPGAS,
						E.DESTIPGAS,
						A.CODCAT,
						B.NOMCAT,
						C.CODCON,
						D.NOMCON
						HAVING
						(SUM((CASE WHEN C.ASIDED='D' THEN C.SALDO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN C.ASIDED='A' THEN C.SALDO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN C.ASIDED='P' THEN C.SALDO ELSE 0 END))<>0)
						ORDER BY
						A.CODTIPGAS,
						A.CODCAT,c.codcon";
						
		return $this->select($sql);
    }
}
?>
