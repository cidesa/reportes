<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprelcondet extends baseClases
{

    function sql($codempdes, $codemphas, $codcardes, $codcarhas, $codcondes, $codconhas, $tipnom)
    {
        $sql = "SELECT
							A.CODEMP,         
							E.CODCAT,
							substr(C.NOMEMP,1,25) as nomemp,
							C.CEDEMP,
							D.CODCON,
							D.CODPAR,
							A.CODCAR,         
							substr(B.NOMCAR,1,30) as nomcar,
							A.NOMCON, 
							A.SALDO,
							C.CODEMPANT,
							D.OPECON,
							D.IMPCPT,
							D.CONACT      
						FROM 
							NPNOMCAL A, NPCARGOS B, NPHOJINT C,
							NPDEFCPT D,NPASICAREMP E
						WHERE
							D.CODCON=A.CODCON AND
							C.CODEMP=A.CODEMP AND
							E.CODEMP=A.CODEMP AND
							E.CODCAR=A.CODCAR AND
							B.CODCAR=A.CODCAR AND
							D.IMPCPT='S' AND
							(D.OPECON='A' OR D.OPECON='D')  AND
							A.SALDO<>0.00 AND
							D.CONACT='S' AND
							A.CODEMP >= '$codempdes' AND
							A.CODEMP <= '$codemphas' AND
							A.CODCAR >= '$codcardes' AND
							A.CODCAR <= '$codcarhas' AND
							A.CODCON >= '$codcondes' AND
							A.CODCON <= '$codconhas' AND
							A.CODNOM='$tipnom'
						ORDER BY A.CODCON,C.CODEMP";
		//print "<pre>".$sql;exit;
        return $this->select($sql);
    }
	
	function rs($tipnom){
		$sql="select upper(nomnom) as nombre from NPASICAREMP where codnom='$tipnom'";
		return $this->select($sql);
	}
	
	function sr($tipnom){
		$sql="SELECT to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
	}
	
	function ss($tipnom){
		$sql="SELECT to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
	}
	
	function cate($tbcodcon){
		$sql="SELECT coalesce(CODCAT,'0') as categoria FROM npconceptoscategoria WHERE CODCON = '$tbcodcon'";
		return $this->select($sql);
	}
}
?>
