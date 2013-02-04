<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprnomdefcat extends baseClases
{
    function sql($especial, $tipnom, $codempdes, $codemphas, $codcatdes, $codcathas, $codcardes, $codcarhas, $codcondes, $codconhas, $tipnomesp)
    {
        if ($especial == 'S')
        {
            $sql = "SELECT
              distinct C.CODEMP as codemp,
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
              NPNOMCAL G,
              NPDEFCPT H
            WHERE
              (B.CODNOM) = '$tipnom' AND
              C.CODEMP>= '$codempdes' AND
              C.CODEMP <= '$codemphas' AND
              B.CODCAT>= '$codcatdes' AND
              B.CODCAT <= '$codcathas' AND
              B.CODCAR>= '$codcardes' AND
              B.CODCAR <= '$codcarhas' AND
              G.CODCON>='$codcondes' AND
              G.CODCON<='$codconhas' AND
		G.especial='$especial' AND
		G.CODNOMESP='$tipnomesp' AND
              B.STATUS='V' AND
              H.IMPCPT='S' AND
              B.CODEMP=C.CODEMP AND
              B.CODCAT=D.CODCAT AND
              B.CODEMP=G.CODEMP AND
              B.CODCAR=G.CODCAR AND
              B.CODNOM=G.CODNOM AND
              G.CODCON=H.CODCON
            ORDER BY
              b.codcat, G.CODCAR,C.CODEMP";
        }
        else
        {

            $sql = "SELECT
              distinct C.CODEMP as codemp,
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
              NPNOMCAL G,
              NPDEFCPT H
            WHERE
              (B.CODNOM) = '$tipnom' AND
              C.CODEMP>= '$codempdes' AND
              C.CODEMP <= '$codemphas' AND
              B.CODCAT>= '$codcatdes' AND
              B.CODCAT <= '$codcathas' AND
              B.CODCAR>= '$codcardes' AND
              B.CODCAR <= '$codcarhas' AND
              G.CODCON>='$codcondes' AND
              G.CODCON<='$codconhas' AND
		G.especial='$especial' AND
              B.STATUS='V' AND
              H.IMPCPT='S' AND
              B.CODEMP=C.CODEMP AND
              B.CODCAT=D.CODCAT AND
              B.CODEMP=G.CODEMP AND
              B.CODCAR=G.CODCAR AND
              B.CODNOM=G.CODNOM AND
              G.CODCON=H.CODCON
            ORDER BY
              b.codcat, G.CODCAR,C.CODEMP";
        }
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
    	$sql="SELECT frecal, numsem, to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
    }
}
?>
