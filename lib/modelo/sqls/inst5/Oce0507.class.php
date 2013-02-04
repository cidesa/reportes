<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce0507 extends baseClases {

	function SQLp($cardes,$carhas) {
		$sql="select a.codtipcar as codcar from nptipcar a where trim(a.codtipcar)>='$cardes' and trim(a.codtipcar)<='$carhas' order by a.codtipcar";
      //  H::PrintR($sql);exit;
		return $this->select($sql);
    }
	function sqlcargos($codcar,$esq)
	{
		$sql="select * from empresa where 1=0";
		if(!empty($esq))
		{
			$sql="set search_path to \"$esq\";
			      select a.codtip as codcar,c.destip as nomcar,sum(coalesce(b.canmuj,0)) as canmuj,sum(coalesce(b.canhom,0)) as canhom,
					sum(coalesce(b.canpre-b.canasi,0)) as canvac,sum(coalesce(b.canpre,0)) as canpre,
					formatonum(sum(coalesce(a.suecar,0))) as suecar,
					formatonum(sum(coalesce(a.comcar,0))) as comcar,
					formatonum(sum(coalesce(a.pricar,0))) as pricar,
					formatonum(sum((coalesce(b.canpre,0))*((coalesce(a.suecar,0))+(coalesce(a.comcar,0))+(coalesce(a.pricar,0))))) as total
					from forcargos a, npcarpre b, nptipcar c
					where
					a.codtip='$codcar' and
					a.codtip=c.codtip and
					a.codcar=b.codcarrac
					group by a.codtip,c.destip
					order by a.codtip";

		}

		return $this->select($sql);
	}
	function sqlanos()
	{
		$sql="select to_char(fecini,'yyyy') as perfis from contaba";
		return $this->select($sql);
	}
	function sqlesquema($ano)
	{
		$sql="select * from fordefesq where ano='$ano'";

		return $this->select($sql);
	}
}
?>