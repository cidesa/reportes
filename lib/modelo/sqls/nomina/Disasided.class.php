<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Disasided extends baseClases{
	
	function sql_mae($nom1,$nom2){
		$sql="SELECT
								DISTINCT(a.CODNOM) AS codnom,b.nomnom
								FROM
								NPNOMCAL a,npnomina b
								WHERE
								a.CODNOM >= '$nom1' AND
								a.CODNOM <= '$nom2' and
								a.codnom=b.codnom";
		return $this->select($sql);
	}
	
	function sql($codnom){
		$sql="SELECT
							G.CODNOM,
							G.NOMNOM,
							G.CODCON,
							G.NOMCON,
							G.ASIDED,
							(CASE WHEN G.ASIDED='A' THEN sum(coalesce(G.SALDO,0)) ELSE 0 END) as ASIGNA,
							(CASE WHEN G.ASIDED='D' THEN sum(coalesce(G.SALDO,0)) ELSE 0 END) as DEDUC,
							(CASE WHEN G.ASIDED='P' THEN sum(coalesce(G.SALDO,0)) ELSE 0 END) as APORTE
						FROM
							NPHOJINT C,
							NPASICAREMP B,
							NPCATPRE D,
							NPNOMCAL G,
							NPDEFCPT H
						WHERE
							B.CODNOM = '$codnom' and numcue <>'' and
							B.CODEMP=C.CODEMP AND
							B.CODCAT=D.CODCAT AND
							G.CODCAR=B.CODCAR AND
							G.CODEMP=B.CODEMP AND
							G.CODNOM=B.CODNOM AND
							G.CODCON=H.CODCON AND
							B.STATUS='V'
						GROUP BY
							G.CODNOM,G.NOMNOM,G.ASIDED,G.CODCON,G.NOMCON
						ORDER BY
							G.CODNOM,G.NOMNOM,G.ASIDED,G.CODCON,G.NOMCON";
		return $this->select($sql);
	}
}


?>
