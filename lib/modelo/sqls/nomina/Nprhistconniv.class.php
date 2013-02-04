<?php

require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistconniv extends baseClases
{
    function sql($especial, $tipnomesp, $tipnom, $codcondes, $codconhas, $codnivdes, $codnivhas, $fechades, $fechahas)
    {
        if ($especial == 'S')
        {
            $especial = "  c.especial = 'S' and
        		C.CODNOMESP = '$tipnomesp' AND	";
        }
        else
        {
            $especial = " c.especial = 'N' and ";
        }
        $sql = "SELECT c.CODCAT as codcat,
						RTRIM(B.NOMCAT) as NOMCAT,
						C.CODCON as codcon,
						D.NOMCON as nomcon,D.codpar as codpar,
						SUM((CASE WHEN D.OPECON='D' THEN C.MONTO ELSE 0 END)) as DEDUC ,
						SUM((CASE WHEN D.OPECON='A' THEN C.MONTO ELSE 0 END)) as ASIGNA,
 						SUM((CASE WHEN D.OPECON='P' THEN C.MONTO ELSE 0 END)) as PATRON, to_Char(E.ultfec,'dd/mm/yyyy') as ultfec, to_char(E.profec,'dd/mm/yyyy') as profec
						FROM

						NPCATPRE B,
						NPHISCON C,
						NPDEFCPT D , NPNOMINA E
						WHERE
						C.CODNOM = '$tipnom' AND c.codnom=E.codnom and
						C.CODCON >= '$codcondes' AND
						C.CODCON <= '$codconhas' AND".$especial."
						c.CODCAT >= '$codnivdes' AND
						c.CODCAT <= '$codnivhas' AND   c.fecnom>=to_date('$fechades','dd/mm/yyyy') and
							 c.fecnom<=to_date('$fechahas','dd/mm/yyyy') and
						c.CODCAT=B.CODCAT AND
					--	A.CODEMP=C.CODEMP AND a.status='V' and
					--	A.CODCAR=C.CODCAR AND
						C.CODCON=D.CODCON
						GROUP BY
						c.CODCAT,
						B.NOMCAT,
						C.CODCON,
						D.NOMCON,D.CODPAR, E.ultfec, E.profec
						HAVING
						(SUM((CASE WHEN D.OPECON='D' THEN C.MONTO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN D.OPECON='A' THEN C.MONTO ELSE 0 END))<>0) OR
						(SUM((CASE WHEN D.OPECON='P' THEN C.MONTO ELSE 0 END))<>0)
						ORDER BY
						c.CODCAT";
        return $this->select($sql);

    }

    function usql($tipnom)
    {
    	$sql="SELECT DISTINCT B.NOMNOM as nomnom
								FROM NPNOMCAL A,NPNOMINA B
								WHERE A.CODNOM=B.CODNOM
								AND B.CODNOM = '$tipnom'";
		return $this->select($sql);
    }
}

?>
