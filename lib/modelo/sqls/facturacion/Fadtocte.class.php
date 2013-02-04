<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fadtocte extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "select distinct a.codtipcte,b.nomtipcte
				from fadtocte a,fatipcte b where b.codtipcli=a.codtipcte
				and codtipcte>='".$coddes."' and codtipcte<='".$codhas."'
				";

		//H::PrintR($sql);exit;
		return $this->select($sql);
	}


	function sqldet($coddesc)
	{

		$sql= "select a.coddto,b.desdesc,b.mondesc,(case when b.tipdesc='P' then 'Porcentual'
				when b.tipdesc='M' then 'Puntual' end) as tipdesc
			from fadtocte a,fadescto b,fatipcte c where a.coddto=b.coddesc
			and c.codtipcli=a.codtipcte and a.codtipcte='".$coddesc."'";

		//H::PrintR($sql);
		return $this->select($sql);
	}

}
?>