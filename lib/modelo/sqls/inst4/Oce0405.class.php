<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce0405 extends baseClases {

	function SQLp($forma)
	{
		$sql="select nrofor,tipo,cuenta,orden,descripcion  from forcfgrepins where nrofor='$forma' order by orden";

		return $this->select($sql);
	}

    function SQLcargos($codpre,$tipo,$esq) {

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
			      select '$codpre' as codpre,sum( salact)  as monasi from contabb1 where codcta='$codpre'
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