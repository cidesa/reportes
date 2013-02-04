<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistrecibopag extends baseClases{
	
    function sql($tipnom, $codempdes, $codemphas, $codcardes, $codcarhas, $especial, $codcondes, $codconhas, $fechades, $fechahas)
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
    							G.CODCON as codcon, e.DESNIV as desniv,
    							G.NOMCON AS NOMCON,-- G.MONTO as ASIGNA
    							(CASE WHEN H.OPECON='A' THEN coalesce(G.MONTO,0) ELSE 0 END) as ASIGNA,
    							(CASE WHEN H.OPECON='D' THEN coalesce(G.MONTO,0) ELSE 0 END) as DEDUC,
    							(CASE WHEN H.OPECON='P' THEN coalesce(G.MONTO,0) ELSE 0 END) as APORTE
    						FROM
    							NPHOJINT C,
    							NPASICAREMP B,
    							NPCATPRE D,
    							NPESTORG E,
    							NPHISCON G,
    							NPDEFCPT H,
    							NPTIPGAS A,
    							npnomina F
    						WHERE
    							B.CODNOM = '$tipnom' AND
    							C.CODEMP >= '$codempdes' AND
    							C.CODEMP <= '$codemphas' AND
    							B.CODCAR >= '$codcardes' AND
    							B.CODCAR <= '$codcarhas' AND
                                 G.especial='$especial' AND
    							B.STATUS='V' AND
    							G.CODCON>='$codcondes' AND
    							G.CODCON<='$codconhas' AND
    							C.CODEMP=B.CODEMP AND
    							B.CODEMP=G.CODEMP AND
    							B.CODCAR=G.CODCAR AND
    							B.CODNOM=G.CODNOM AND
    							B.CODCAT=D.CODCAT AND
    							B.CODTIPGAS=A.CODTIPGAS AND
    							B.CODNOM=F.CODNOM AND
    							C.CODNIV=E.CODNIV AND
    							G.CODCON=H.CODCON and G.CODCON<>'006' and
    		      g.fecnomdes>=to_date('$fechades','dd/mm/yyyy') and
    			  g.fecnom<=to_date('$fechahas','dd/mm/yyyy')
    						ORDER BY
    							a.codtipgas,b.codcat,C.CODEMP";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>