<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce1940 extends baseClases {

	function SQLp($catdes,$cathas)
	{
		$sql="select distinct substr(a.codcat,1,2) as codcat,(select nompre from cpdeftit where codpre=substr(a.codcat,1,2)) as nomcat from npcatpre a where substr(a.codcat,1,2)>='$catdes' and substr(a.codcat,1,2)<='$cathas'";

		return $this->select($sql);
	}

	function SQLp2($forma)
	{
		$sql="select nrofor,tipo,cuenta,orden,descripcion  from forcfgrepins where nrofor='$forma' order by orden";

		return $this->select($sql);
	}

    function SQLcargos($codpre,$tipo,$esq,$tri='N',$proacc) {

	if($tri=='N')
	{
			$sql="select * from empresa where 1=0";
			if((!empty($esq)) && $tipo=='P')
			{
				$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, formatonum(sum(monasi)) as monasi from cpasiini where codpre like '$proacc%$codpre%'
					";	
			}
	}else
	{
		
			$sql="select * from empresa where 1=0";
			if((!empty($esq)) && $tipo=='P')
			{
				$sql="set search_path to \"$esq\";
				select codpre ,formatonum(sum(monasi01)) as monasi01,formatonum(sum(monasi02)) as monasi02,formatonum(sum(monasi03)) as monasi03,formatonum(sum(monasi04)) as monasi04 from (
			      select '$codpre' as codpre, (sum(monasi)) as monasi01,0 as monasi02,0 as monasi03,0 as monasi04 from cpasiini where codpre like '$proacc%$codpre%' and perpre>='01' and perpre<='03' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,(sum(monasi)) as monasi02,0 as monasi03,0 as monasi04 from cpasiini where codpre like '$proacc%$codpre%' and perpre>='04' and perpre<='06' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,(sum(monasi)) as monasi03,0 as monasi04 from cpasiini where codpre like '$proacc%$codpre%' and perpre>='07' and perpre<='09' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,0 as monasi03,(sum(monasi)) as monasi04 from cpasiini where codpre like '$proacc%$codpre%' and perpre>='10' and perpre<='12' 
				  )a
				  group by codpre
					";	
			}		
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
	function sqlnomcue($cuenta,$tipo)
	{		
		$sql="select codpre,nompre from cpdeftit where codpre like '%$cuenta%' order by codpre limit 1";
		$rs = $this->select($sql);
		return $rs[0]['nompre'];	
		
	}
}
?>