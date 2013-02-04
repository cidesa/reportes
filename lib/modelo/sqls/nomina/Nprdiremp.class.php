<?php 
require_once("../../lib/modelo/baseClases.class.php");

class Nprdiremp extends baseClases{
	
	function sqlp($nom,$emp1,$emp2,$car1,$car2){
		$sql="select a.codemp, a.nomemp,a.codnom,a.nomnom,b.cedemp,coalesce(b.dirhab,' ') as dirhab,
						coalesce(b.dirotr,' ') as dirotr, coalesce(b.telhab,' ') as telhab, coalesce(b.telotr,' ') as telotr,
						coalesce(b.emaemp,' ') as emaemp
					from npasicaremp a,  nphojint b 
					where
					a.codnom = '$nom' and a.codemp   = b.codemp and
					a.codemp >='$emp1' and a.codemp <= '$emp2' and
					a.codcar >='$car1' and a.codcar <= '$car2' and
					b.staemp =  'A'
					order by b.nomemp";
		//print("<pre>".'$sql= '.$sql);exit;					
		return $this->select($sql);
	
	}
}

?>