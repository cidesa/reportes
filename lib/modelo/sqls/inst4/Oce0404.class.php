<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce0404 extends baseClases {

	function SQLp($prodes,$prohas,$inifin) {

		$sql="select distinct substr(codpre,".$inifin[0][0].",".($inifin[0][1]-$inifin[0][0]).") as codpar
				from cpdeftit a
				where trim(substr(codpre,".$inifin[0][0].",".($inifin[0][1]-$inifin[0][0])."))<>'' ";

		//H::PrintR($sql);exit;
		return $this->select($sql);

    }
	function sqlcargos($codpre,$esq,$inifin)
	{
		$sql="select * from empresa where 1=0";
		if(!empty($esq))
		{
			$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, formatonum(sum(monasi)) as monasi from cpasiini where codpre like '%$codpre%'
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
	function sqlnompre($codpar)
	{
		$sql="select codpre,nompre from cpdeftit where codpre like '%$codpar%' order by codpre limit 1";
		$rs = $this->select($sql);;
		return $rs[0]['nompre'];
	}
}
?>