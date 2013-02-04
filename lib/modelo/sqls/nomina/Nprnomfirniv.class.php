<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprnomfirniv extends baseClases{
	
	function sql($tipnom,$codempdes,$codemphas,$codcardes,$codcarhas,$codnivdes,$codnivhas,$codcondes,$codconhas){
		$sql="SELECT DISTINCT
							C.CODEMP as codemp,
							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
							C.NOMEMP as nomemp,
							to_char(C.FECING,'dd/mm/yyyy') as fecing,
							C.NUMCUE as CUENTA_BANCO,
							C.CODNIV as codniv,
							C.CEDEMP as cedemp,
							LTRIM(RTRIM(B.CODCAR)) as CODCAR,
							B.NOMCAR as nomcar,
							E.DESNIV as desniv,
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
							C.CODEMP>= '$codempdes' AND
							C.CODEMP <= '$codemphas'AND
							B.CODCAR>= '$codcardes' AND
							B.CODCAR <= '$codcarhas' AND
							C.CODNIV >= '$codnivdes' AND
							C.CODNIV <= '$codnivhas' AND
							G.CODCON>='$codcondes' AND
							G.CODCON<='$codconhas' AND
							B.STATUS='V' AND
							B.CODEMP=C.CODEMP AND
							B.CODCAT=D.CODCAT AND
							E.CODNIV=C.CODNIV AND
							G.CODCAR=B.CODCAR AND
							G.CODEMP=B.CODEMP AND
							G.CODNOM=B.CODNOM AND
							G.CODCON=H.CODCON AND
							H.IMPCPT='S'
						ORDER BY
							C.CODNIV,C.CODEMP";
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