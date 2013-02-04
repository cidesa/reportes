<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce0437 extends baseClases {

	function Sqlp($codescdes,$codeschas,$codnomdes)
	{
		$sql="select a.codesc,a.valini||'  -  '||a.valfin as gruesc,
				sum(c.canpre)  as cancar,formatonum(sum(b.suecar)*12) as suecar
				from
				npescsue a, forcargos b, npcarpre c
				where
				b.codcar in (select codcar from npasicaremp where codnom='$codnomdes') and
				a.codesc>='$codescdes' and
				a.codesc<='$codeschas' and
				b.codcar=c.codcarrac and
				b.suecar>=a.valini and
				b.suecar<=a.valfin
				group by
				a.codesc,a.valini||'  -  '||a.valfin
				order by codesc";

		return $this->select($sql);
	}
	function SQLnomina($nomina)
	{
		$sql="select nomnom from npnomina where codnom='$nomina'";
		$rs = $this->select($sql);
		return $rs[0]['nomnom'];
	}
}
?>