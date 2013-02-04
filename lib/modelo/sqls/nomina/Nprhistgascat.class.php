<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprhistgascat extends baseClases
{
    function sql($tipnom,$codcondes,$codconhas,$codnivdes,$codnivhas,$codgasdes,$codgashas,$fecnomdes,$fecnomhas)
    {
    	$sql="SELECT
						A.CODTIPGAS,
						E.DESTIPGAS,
						A.CODCAT as codcat,
						RTRIM(B.NOMCAT) as NOMCAT,
						A.CODCON as codcon,
						D.NOMCON as nomcon,
						SUM((CASE WHEN D.OPECON='D' THEN A.MONTO ELSE 0 END)) as DEDUC ,
						SUM((CASE WHEN D.OPECON='A' THEN A.MONTO ELSE 0 END)) as ASIGNA,
 						SUM((CASE WHEN D.OPECON='P' THEN A.MONTO ELSE 0 END)) as PATRON
						FROM
						NPHISCON A,
						NPCATPRE B,
						NPDEFCPT D,
						NPTIPGAS E
						WHERE
						A.CODNOM = '$tipnom' AND
						A.CODCON >= '$codcondes' AND
						A.CODCON <= '$codconhas' AND
						A.CODCAT >= '$codnivdes' AND
						A.CODCAT <= '$codnivhas' AND
						A.CODTIPGAS >= '$codgasdes' AND
						A.CODTIPGAS <= '$codgashas' AND
						A.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
						A.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy') and
						A.CODCAT=B.CODCAT AND
						A.CODCON=D.CODCON AND
						E.CODTIPGAS=A.CODTIPGAS
						GROUP BY
						A.CODTIPGAS,
						E.DESTIPGAS,
						A.CODCAT,
						B.NOMCAT,
						A.CODCON,
						D.NOMCON
						HAVING
						(SUM((CASE WHEN D.OPECON='D' THEN A.MONTO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN D.OPECON='A' THEN A.MONTO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN D.OPECON='P' THEN A.MONTO ELSE 0 END))<>0)
						ORDER BY
						A.CODTIPGAS,
						A.CODCAT,A.codcon";

		return $this->select($sql);
    }
}
?>
