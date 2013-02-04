<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce1915 extends baseClases {

	function SQLp($cardes,$carhas) {
		$sql="select distinct a.codtip as codcar,b.codnom,c.nomnom from forcargos a, npasicaremp b, npnomina c, npcarpre d
				where 
				a.codcar=b.codcar and
				a.codcar=d.codcarrac and
				b.codnom=c.codnom and
				trim(a.codtip)>='$cardes' and trim(a.codtip)<='$carhas' order by a.codtip,b.codnom";

		return $this->select($sql);
    }
	function sqlcargos($codcar,$esq,$codnom,$nomnom)
	{
		$sql="select * from empresa where 1=0";
		if(!empty($esq))
		{			
			$sql="set search_path to \"$esq\";
			      select a.codtip,c.destip,'$codnom' as codcar,'$nomnom' as nomcar,sum(coalesce(b.canmuj,0)) as canmuj,sum(coalesce(b.canhom,0)) as canhom,
					sum(coalesce(b.canpre-b.canasi,0)) as canvac,sum(coalesce(b.canpre,0)) as canpre,
					formatonum(sum(coalesce(a.suecar,0))) as suecar,
					formatonum(sum(coalesce(a.comcar,0))) as comcar,
					formatonum(sum(coalesce(a.pricar,0))) as pricar,
					formatonum(sum((coalesce(b.canpre,0))*((coalesce(a.suecar,0))+(coalesce(a.comcar,0))+(coalesce(a.pricar,0))))) as total
					from forcargos a, npcarpre b, nptipcar c
					where					
					a.codtip='$codcar' and
					a.codcar in (select codcar from npasicaremp where codnom='$codnom') and
					a.codtip=c.codtip and
					a.codcar=b.codcarrac
					group by a.codtip,c.destip
					";	

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