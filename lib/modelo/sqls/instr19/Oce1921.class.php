<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce1921 extends baseClases {

	function SQLp($prodes,$prohas) {
		$sql="select a.proacc,b.nompre from (
		select distinct substr(a.codpre,1,2) as proacc from cpdeftit a
				where substr(codpre,1,2)>='$prodes' and substr(codpre,1,2)<='$prohas' 
		)a inner join cpdeftit b on (trim(a.proacc)=trim(b.codpre))";
		$rs = $this->select($sql);
		
		$sql1="select a.proacc,b.nompre from (
		select distinct substr(a.codpre,1,2) as proacc from cpdeftit a
				where substr(codpre,1,2)>='$prodes' and substr(codpre,1,2)<='$prohas' 
		)a inner join cpdeftit b on (trim(a.proacc)=trim(b.codpre))";
		$rs1 = $this->select($sql1);
		return array('0' => $rs, '1' => $rs1);
    }
	function sqlcargos($codpre,$esq)
	{
		$sql="select * from empresa where 1=0";
		if(!empty($esq))
		{			
			$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, formatonum(sum(monasi)) as monasi from cpasiini where substr(codpre,1,2)='$codpre'
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