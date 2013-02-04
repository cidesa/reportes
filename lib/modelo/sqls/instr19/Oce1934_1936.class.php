<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce1934_1936 extends baseClases {

	function SQLp($forma)
	{
		$sql="select nrofor,tipo,cuenta,orden,descripcion  from forcfgrepins where nrofor='$forma' order by orden";

		return $this->select($sql);
	}

    function SQLcargos($codpre,$tipo,$esq,$tri='N') {

	if($tri=='N')
	{
		if(strtoupper($tipo)=="P")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, formatonum(sum(monasi)) as monasi from cpasiini where codpre like '%$codpre%'
					";	
			}

		}elseif(strtoupper($tipo)=="C")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, (sum(b.salant)+(sum(a.totdeb)-sum(a.totcre))) as monasi from contabb1 a, contabb b where a.codcta='$codpre' and a.codcta=b.codcta
					";	
			}

		}elseif(strtoupper($tipo)=="I")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
			      select '$codpre' as codpre, formatonum(sum(monasi)) as monasi from ciasiini where codpre like '%$codpre%'
					";	
			}
		}

	}else
	{
		if(strtoupper($tipo)=="P")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
				select codpre ,formatonum(sum(monasi01)) as monasi01,formatonum(sum(monasi02)) as monasi02,formatonum(sum(monasi03)) as monasi03,formatonum(sum(monasi04)) as monasi04 from (
			      select '$codpre' as codpre, (sum(monasi)) as monasi01,0 as monasi02,0 as monasi03,0 as monasi04 from cpasiini where codpre like '%$codpre%' and perpre>='01' and perpre<='03' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,(sum(monasi)) as monasi02,0 as monasi03,0 as monasi04 from cpasiini where codpre like '%$codpre%' and perpre>='04' and perpre<='06' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,(sum(monasi)) as monasi03,0 as monasi04 from cpasiini where codpre like '%$codpre%' and perpre>='07' and perpre<='09' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,0 as monasi03,(sum(monasi)) as monasi04 from cpasiini where codpre like '%$codpre%' and perpre>='10' and perpre<='12' 
				  )a
				  group by codpre
					";	

			}

		}elseif(strtoupper($tipo)=="C")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
				  select codpre ,formatonum(sum(monasi01)) as monasi01,formatonum(sum(monasi02)) as monasi02,formatonum(sum(monasi03)) as monasi03,formatonum(sum(monasi04)) as monasi04 from (
			      select '$codpre' as codpre, (sum(b.salant)+(sum(a.totdeb)-sum(a.totcre))) as monasi01, 0 as monasi02, 0 as monasi03, 0 as monasi04  from contabb1 a, contabb b where a.codcta='$codpre' and a.codcta=b.codcta and a.pereje>='01' and a.pereje<='03' 
				  union all
  			      select '$codpre' as codpre, 0 as monasi01, (sum(b.salant)+(sum(a.totdeb)-sum(a.totcre))) as monasi02, 0 as monasi03, 0 as monasi04  from contabb1 a, contabb b where a.codcta='$codpre' and a.codcta=b.codcta and a.pereje>='04' and a.pereje<='06' 
				  union all
  			      select '$codpre' as codpre, 0 as monasi01, 0 as monasi02, (sum(b.salant)+(sum(a.totdeb)-sum(a.totcre))) as monasi03, 0 as monasi04  from contabb1 a, contabb b where a.codcta='$codpre' and a.codcta=b.codcta and a.pereje>='07' and a.pereje<='09' 
				  union all
  			      select '$codpre' as codpre, 0 as monasi01, 0 as monasi02, 0 as monasi03, (sum(b.salant)+(sum(a.totdeb)-sum(a.totcre))) as monasi04  from contabb1 a, contabb b where a.codcta='$codpre' and a.codcta=b.codcta and a.pereje>='10' and a.pereje<='12' 
				  )a
				  group by codpre								  
					";	
			}

		}elseif(strtoupper($tipo)=="I")
		{
			$sql="select * from empresa where 1=0";
			if(!empty($esq))
			{
				$sql="set search_path to \"$esq\";
				select codpre ,formatonum(sum(monasi01)) as monasi01,formatonum(sum(monasi02)) as monasi02,formatonum(sum(monasi03)) as monasi03,formatonum(sum(monasi04)) as monasi04 from (
			      select '$codpre' as codpre, (sum(monasi)) as monasi01,0 as monasi02,0 as monasi03,0 as monasi04 from ciasiini where codpre like '%$codpre%' and perpre>='01' and perpre<='03' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,(sum(monasi)) as monasi02,0 as monasi03,0 as monasi04 from ciasiini where codpre like '%$codpre%' and perpre>='04' and perpre<='06' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,(sum(monasi)) as monasi03,0 as monasi04 from ciasiini where codpre like '%$codpre%' and perpre>='07' and perpre<='09' 
				  UNION ALL
				  select '$codpre' as codpre, 0 as monasi01,0 as monasi02,0 as monasi03,(sum(monasi)) as monasi04 from ciasiini where codpre like '%$codpre%' and perpre>='10' and perpre<='12' 
				  )a
				  group by codpre
					";	
			}
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
	function sqlnomcue($cuenta,$tip)
	{
		if($tip=='P')
		{
			$sql="select codpre,nompre from cpdeftit where codpre like '%$cuenta%' order by codpre limit 1";
			$rs = $this->select($sql);
			return $rs[0]['nompre'];	
		}elseif($tip=='C')
		{
			$sql="select descta from contabb where codcta='$cuenta'";
			$rs = $this->select($sql);
			return $rs[0]['descta'];	
		}else
		{
			$sql="select codpre,nompre from cideftit where codpre like '%$cuenta%' order by codpre limit 1";
			$rs = $this->select($sql);
			return $rs[0]['nompre'];	
		}
		
	}
}
?>