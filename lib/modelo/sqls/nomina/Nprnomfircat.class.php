<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprnomfircat extends baseClases
{

    function sql($tipnom,$codempdes,$codemphas,$codcardes,$codcarhas,$codcatdes,$codcathas,$codcondes,$codconhas)
    {
        $sql = "SELECT DISTINCT
							C.CODEMP as codemp,
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
							G.CODCON>='$codcondes' AND
							G.CODCON<='$codconhas' AND
							B.STATUS='V' AND
							B.CODEMP=C.CODEMP AND
							B.CODCAT=D.CODCAT AND
							E.CODNIV=C.CODNIV AND
							B.CODEMP=G.CODEMP AND
							B.CODCAR=G.CODCAR AND
							B.CODNOM=G.CODNOM AND
							G.CODCON=H.CODCON AND
							H.IMPCPT='S'
						ORDER BY
							b.codcat,C.CODEMP";
        //print"<pre> $sql=".$sql;
        return $this->select($sql);
    }
	
	function rs($tipnom)
    {
    	$sql="select upper(nomnom) as nombre from NPNOMINA where codnom='$tipnom'";
		return $this->select($sql);
    }
	
	function sr($tipnom)
    {
    	$sql="SELECT frecal, numsem, to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
    }
	
	function ss($tipnom)
    {
    	$sql="SELECT to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
    }
}
?>
