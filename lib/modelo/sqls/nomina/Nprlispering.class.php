<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprlispering extends baseClases {

	function sql($estatus,$codempdes,$codemphas,$fecingdes,$fecinghas,$tipnom) {

		if ($estatus == 'T') {
			$estatus = "    ";
		} else
			$estatus = " a.staemp = 'A' AND     ";
		$sql = "select a.cedemp,a.nomemp,to_char(fecing,'dd/mm/yyyy') as fecing,
				b.nomcar,c.desniv,e.nomnom as nomina
				from nphojint a, npcargos b, npestorg c, npasicaremp d,npnomina e
				where
				a.codemp>='$codempdes' and
				a.codemp<='$codemphas' and
				a.fecing>=to_date('$fecingdes','dd/mm/yyyy') and
				a.fecing<=to_date('$fecinghas','dd/mm/yyyy') and
				d.codnom='" . $tipnom . "' and $estatus
				a.codemp=d.codemp and
				d.status='V' and
				d.codcar=b.codcar and
				(a.codniv)=(c.codniv) and d.codnom=e.codnom
				order by c.codniv";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>