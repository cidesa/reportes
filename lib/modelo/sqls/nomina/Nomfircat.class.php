<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nomfircat extends baseClases
{

    function sql($especial,$tipnom,$codempdes,$codemphas,$codcardes,$codcarhas,$codcatdes,$codcathas,$codcondes,$codconhas)
    {
        if ($especial == 'S')
        {
            $especial = "  g.especial = 'S' and ";
        }
        else
        {
            $especial = "  g.especial = 'N' and ";
        }
        
        $sql = "SELECT DISTINCT
        							C.CODEMP as codemp,
        							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
        							C.NOMEMP as nomemp,
        							to_char(C.FECING,'dd/mm/yyyy') as fecing,
        							C.NUMCUE as CUENTA_BANCO,
        							B.CODCAT as CODCAT,
        							D.nomcat as nomcat,
        							C.CEDEMP as cedemp,CAST(C.CODEMP AS INT) AS CODEMPORD,
        							B.CODCAR as CODCAR, CAST(B.CODCAR AS INT) AS CODCARORD,
        							B.NOMCAR as nomcar,
        							(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
        							G.CODCAR as codcargo,
        							G.CODCON as codcon,
        							LTRIM(RTRIM(G.NOMCON)) AS NOMCON,
        							(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
        							(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC
        						FROM
        							NPHOJINT C,
        							NPASICAREMP B,
        							NPCATPRE D,
        							NPESTORG E,
        							NPNOMCAL G,
        							NPDEFCPT H
        						WHERE
        							B.CODNOM = '$tipnom' AND
        							D.CODCAT=B.CODCAT AND
        							B.CODEMP=C.CODEMP AND
        							C.CODEMP>= '$codempdes' AND
        							C.CODEMP <= '$codemphas' AND
        							B.CODCAR>= '$codcardes' AND
        							B.CODCAR <= '$codcarhas' AND
        							B.CODcat >= '$codcatdes' AND
        							B.CODcat <= '$codcathas' AND
        							B.STATUS='V' AND
        							G.CODCON=H.CODCON AND
        							G.CODCON>='$codcondes' AND
        							G.CODCON<='$codconhas' AND
        							G.CODNOM = '$tipnom' AND
        							G.CODCAR=B.CODCAR AND
        							G.CODEMP=C.CODEMP AND".$especial."
        							H.IMPCPT='S'
        						ORDER BY
        							CODCARORD,CODEMPORD";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }

    function sqls($var,$tipnom)
	{
        if ($var == 1)
        {
            $sql = "select upper(nomnom) as nombre from NPASICAREMP where codnom='$tipnom'";
        } else if ($var == 2)
        {
            $sql = "SELECT to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
        } else
            $sql = "SELECT to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		//print"<pre> $sql=".$sql;	
        return $this->select($sql);
	}
	
}
?>
