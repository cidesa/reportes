<?php
	require_once("../../lib/modelo/baseClases.class.php");
	
class Nomina_presupuesto extends baseClases{
	
	function sqlp($nom,$car1,$car2,$emp1,$emp2,$con1,$con2){
		
		$sql="select substr(b.codcat||'-'||c.codpar,1,50) as codpre,
						sum(CASE WHEN a.asided='A' THEN a.saldo ELSE 0 END) as asigna,
						sum(CASE WHEN a.asided='D' THEN a.saldo ELSE 0 END) as deduci,
						sum(CASE WHEN a.asided='P' THEN a.saldo ELSE 0 END) as aporte
						from npnomcal a,npasicaremp b,npdefcpt c
						where
						a.codnom ='$nom' and
						b.codemp=a.codemp and
						b.codcar=a.codcar and
						b.codnom=a.codnom and
						c.codcon=a.codcon and
						b.status='V' and
						a.codcar >= '$car1' and a.codcar <= '$car2' and
						a.codemp >= '$emp1' and a.codemp <= '$emp2' and
						a.codcon >= '$con1' and a.codcon <= '$con2' and
						impcpt = 'S' and opecon <> 'P' and a.saldo>0 and a.codcon<>'XXX'
						and a.codcon not in (select codcon from npconceptoscategoria)
						group by substr(b.codcat||'-'||c.codpar,1,50),a.codnom
						order by substr(b.codcat||'-'||c.codpar,1,50)";
		return $this->select($sql);
	}
	
	function sqlx($nom){
		$sql="select codnom, nomnom, to_char(ultfec,'dd/mm/yyyy') as ultfec, to_char(profec,'dd/mm/yyyy') as profec
						from npnomina where codnom='$nom'";
				 
		return $this->select($sql);
		
	}
	
	
	
	function sqla($codpre){
		$sql="select nompre as nombre
						from cpdeftit
						where codpre='$codpre'";
		
		return $this->select($sql);
	}
	
}
?>