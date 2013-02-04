<?php
	require_once("../../lib/modelo/baseClases.class.php");
	
class Nomina_definicion_conceptos extends baseClases{
	
	
	function sqlp($nom1,$nom2,$cod1,$cod2){
		
		$sql="select b.codnom, b.nomnom, a.codcon,  a.nomcon, d.codpre as codpar, a.opecon as opecon, a.acuhis as acuhis,
				a.inimon as inimon,	a.conact as conact, a.impcpt as impcpt, a.ordpag as ordpag, a.afepre as afepre
				from npdefcpt a,npnomina b,
				npasiconnom c LEFT OUTER JOIN npasicodpre d ON (c.codcon=d.codcon) and (c.codnom=d.codnom)
				where
				--(c.codcon=d.codcon) and (c.codnom=d.codnom) and
				a.codcon=c.codcon and b.codnom=c.codnom and
				b.codnom>='$nom1' and b.codnom<='$nom2' and
				a.codcon >= '$cod1' and a.codcon <= '$cod2'
				order by b.codnom,a.codcon";
		return $this->select($sql);
	}
	
	
}

?>