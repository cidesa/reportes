<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprnomdefcatgas extends baseClases
{
    function sql($especial, $tipnom, $codempdes, $codemphas, $codcardes, $codcarhas, $tipnomesp, $codcondes, $codconhas)
    {
        if ($especial == 'S')
        {
            $sql = "SELECT
							distinct C.CODEMP as codemp,a.codtipgas,a.destipgas,f.nomnom,
							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
							C.NOMEMP as nomemp,
							to_char(C.FECING,'dd/mm/yyyy') as fecing,
							C.NUMCUE as CUENTA_BANCO,
							B.CODCAT as CODCAT,
							D.nomcat as nomcat,
							C.CEDEMP as cedemp,
							B.CODCAR as CODCAR,
							B.NOMCAR as nomcar,
							(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
							G.CODCAR as codcargo,
							G.CODCON as codcon,
							G.NOMCON AS NOMCON,
							(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
							(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC,
							(CASE WHEN G.ASIDED='P' THEN coalesce(G.SALDO,0) ELSE 0 END) as APORTE
						FROM
							NPHOJINT C,
							NPASICAREMP B,
							NPCATPRE D,
							NPESTORG E,
							NPNOMCAL G,
							NPDEFCPT H,
							NPTIPGAS A,
							npnomina F
						WHERE
							B.CODNOM = '$tipnom' AND
							C.CODEMP >= '$codempdes' AND
							C.CODEMP <= '$codemphas' AND
							B.CODCAR >= '$codcardes' AND
							B.CODCAR <= '$codcarhas' AND
							G.CODNOMESP='$tipnomesp' AND
							B.STATUS='V' AND
							G.CODCON>='$codcondes' AND
							G.CODCON<='$codconhas' AND
g.especial='$especial' AND

							C.CODEMP=B.CODEMP AND
							B.CODEMP=G.CODEMP AND
							B.CODCAR=G.CODCAR AND
							B.CODNOM=G.CODNOM AND
							B.CODCAT=D.CODCAT AND
							B.CODTIPGAS=A.CODTIPGAS AND
							B.CODNOM=F.CODNOM AND
							C.CODNIV=E.CODNIV AND
							G.CODCON=H.CODCON and h.impcpt='S'
						ORDER BY
							a.codtipgas,b.codcat,C.CODEMP";
        }
        else
        {
            $sql = "SELECT
							distinct C.CODEMP as codemp,a.codtipgas,a.destipgas,f.nomnom,
							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
							C.NOMEMP as nomemp,
							to_char(C.FECING,'dd/mm/yyyy') as fecing,
							C.NUMCUE as CUENTA_BANCO,
							B.CODCAT as CODCAT,
							D.nomcat as nomcat,
							C.CEDEMP as cedemp,
							B.CODCAR as CODCAR,
							B.NOMCAR as nomcar,
							(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
							G.CODCAR as codcargo,
							G.CODCON as codcon,
							G.NOMCON AS NOMCON,
							(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
							(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC,
							(CASE WHEN G.ASIDED='P' THEN coalesce(G.SALDO,0) ELSE 0 END) as APORTE
						FROM
							NPHOJINT C,
							NPASICAREMP B,
							NPCATPRE D,
							NPESTORG E,
							NPNOMCAL G,
							NPDEFCPT H,
							NPTIPGAS A,
							npnomina F
						WHERE
							B.CODNOM = '$tipnom' AND
							C.CODEMP >= '$codempdes' AND
							C.CODEMP <= '$codemphas' AND
							B.CODCAR >= '$codcardes' AND
							B.CODCAR <= '$codcarhas' AND
							B.STATUS='V' AND
							G.CODCON>='$codcondes' AND
							G.CODCON<='$codconhas' AND
g.especial='$especial' AND

							C.CODEMP=B.CODEMP AND
							B.CODEMP=G.CODEMP AND
							B.CODCAR=G.CODCAR AND
							B.CODNOM=G.CODNOM AND
							B.CODCAT=D.CODCAT AND
							B.CODTIPGAS=A.CODTIPGAS AND
							B.CODNOM=F.CODNOM AND
							C.CODNIV=E.CODNIV AND
							G.CODCON=H.CODCON and h.impcpt='S'
						ORDER BY
							a.codtipgas,b.codcat,C.CODEMP";
        }

        return $this->select($sql);
    }
    function sql2($tipnom)
    {
    	$sql="SELECT frecal, numsem, to_char(ULTFEC,'dd/mm/yyyy') as FECHA,to_char(PROFEC,'dd/mm/yyyy') as FECHA2 FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
    }
}
?>
