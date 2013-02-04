<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Relnomban extends baseClases
{

    function sql($especial,$tipnomesp1,$tipnomdes)
    {
        if ($especial == 'S')
        { //print'si';
            $especial = " g.especial = 'S' AND
                              g.CODNOMESP = '$tipnomesp1' AND";
        }
        else
        {
            if ($especial == 'N')
			//print'No';
                $especial = " g.especial = 'N' AND";
        }
        $sql = "SELECT
							distinct C.CODEMP as codemp,
							B.CODNOM,
							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
							C.NOMEMP as nomemp,
							to_char(C.FECING,'dd/mm/yyyy') as fecing,
							C.NUMCUE as CUENTA_BANCO,
							B.CODCAT as CODCAT,
							D.nomcat as nomcat,
							C.CEDEMP as cedemp,
							LTRIM(RTRIM(B.CODCAR)) as CODCAR,
							B.NOMCAR as nomcar,
							(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
							G.CODCAR as codcargo,
							G.CODCON as codcon,
							LTRIM(RTRIM(G.NOMCON)) AS NOMCON,
							(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
							(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC,
							(CASE WHEN G.ASIDED='P' THEN coalesce(G.SALDO,0) ELSE 0 END) as APORTE
						FROM
							NPHOJINT C,
							NPASICAREMP B,
							NPCATPRE D,
							NPNOMCAL G,
							NPDEFCPT H
						WHERE
							B.CODNOM = '$tipnomdes' AND".$especial."
							D.CODCAT=B.CODCAT AND
							B.CODEMP=C.CODEMP AND
							B.STATUS='V' AND
							G.CODCON=H.CODCON AND H.IMPCPT='S' AND
							G.CODNOM = '$tipnomdes' AND
							G.CODCAR=B.CODCAR AND
							G.CODEMP=C.CODEMP
						ORDER BY
							B.CODNOM";
    //print"<pre> sql=".$sql;exit;
    return $this->select($sql);
	}
    function per($tipnomdes)
    {
        $sql = "select to_char(ultfec,'dd/mm/yyyy') as ultfec, to_char(profec,'dd/mm/yyyy') as profec from npnomina where CODNOM = '$tipnomdes'";
        //print"<pre> $sql=".$sql;
        return $this->select($sql);
    }
}
?>
