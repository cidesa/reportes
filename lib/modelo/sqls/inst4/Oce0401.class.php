<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce0401 extends baseClases {

	function SQLp($codescdes,$codeschas) {
		$sql="select codesc,valini,valfin from npescsue where trim(codesc)>='$codescdes' and trim(codesc)<='$codeschas' order by codesc";

		return $this->select($sql);
    }
	function sqlescala($codesc,$valini,$valfin,$esq,$tipdes)
	{
		$sql="select * from empresa";
		if(!empty($esq))
		{
			$sql="set search_path to \"$esq\";
			      select '$codesc' as codesc,'$valini   -   $valfin' as escala,
				    sum(coalesce(b.canpre,0)) as canpre,
					formatonum(sum(coalesce(a.suecar,0))) as suecar,
					formatonum(sum(coalesce(a.comcar,0))) as comcar,
					formatonum(sum(coalesce(a.pricar,0))) as pricar,
					formatonum(sum((coalesce(b.canpre,0))*((coalesce(a.suecar,0))+(coalesce(a.comcar,0))+(coalesce(a.pricar,0))))) as total
					from forcargos a, npcarpre b
					where
					a.suecar>='$valini' and a.suecar<='$valfin' and
					a.codtip='$tipdes' and
					a.stacar='E' and
					a.codcar=b.codcarrac
					group by a.codcar,a.nomcar
					order by a.codcar
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