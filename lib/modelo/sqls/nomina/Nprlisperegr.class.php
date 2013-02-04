<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprlisperegr extends baseClases {

	function sql($codempdes,$codemphas,$fecretdes,$fecrethas,$tipnom) {
		$sql = "select distinct cast(REPLACE(a.cedemp,'.', '') as int )
	            as cedemp,a.nomemp,to_char(fecing,'dd/mm/yyyy') as fecing,to_char(fecret,'dd/mm/yyyy') as fecret,
				b.nomcar,c.desniv,e.nomnom as nomina
				from nphojint a, npcargos b, npestorg c, npasicaremp d,npnomina e
				where
				a.codemp>='$codempdes' and
				a.codemp<='$codemphas' and
				a.fecret>=to_date('$fecretdes','dd/mm/yyyy') and
				a.fecret<=to_date('$fecrethas','dd/mm/yyyy') and
				d.codnom='" . $tipnom . "' and
				a.codemp=d.codemp and
				d.codcar=b.codcar and d.codnom=e.codnom and
				a.codniv=c.codniv and d.status='V'
				order by cast(REPLACE(a.cedemp,'.', '') as int )";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>