<?php 
require_once("../../lib/modelo/baseClases.class.php");
class Disasidedhist extends baseClases{
	
	function sql_mae($nom1,$nom2,$fecnomdes,$fecnomhas){
		$sql="SELECT DISTINCT(a.CODNOM) AS codnom,b.nomnom
								FROM
								nphiscon a,npnomina b
								WHERE
								a.CODNOM >= '$nom1' AND
								a.CODNOM <= '$nom2' and
								A.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
								A.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy') and
								a.codnom=b.codnom";
		return $this->select($sql);
	}
	
	function sql($codnom,$fecnomdes,$fecnomhas){
		$sql="SELECT distinct
							B.CODNOM,
							A.NOMNOM,
							B.CODCON,
							B.NOMCON,
							H.OPECON as asided,
							(CASE WHEN H.OPECON='A' THEN sum(coalesce(B.MONTO,0)) ELSE 0 END) as ASIGNA,
							(CASE WHEN H.OPECON='D' THEN sum(coalesce(B.MONTO,0)) ELSE 0 END) as DEDUC,
							(CASE WHEN H.OPECON='P' THEN sum(coalesce(B.MONTO,0)) ELSE 0 END) as APORTE
						FROM
							NPHOJINT C,
							NPHISCON B,
							NPCATPRE D,
							NPDEFCPT H,
							npnomina A
						WHERE
							B.CODNOM = '$codnom' AND numcue<>'' and
							B.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
							B.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy') and
							B.CODEMP=C.CODEMP AND
							B.CODCAT=D.CODCAT AND
							B.CODCON=H.CODCON and
							b.codnom=a.codnom
						GROUP BY
							B.CODNOM,A.NOMNOM,H.OPECON,B.CODCON,B.NOMCON
						ORDER BY
							B.CODNOM,A.NOMNOM,H.OPECON,B.CODCON,B.NOMCON";
		return $this->select($sql);
	}
}
?>