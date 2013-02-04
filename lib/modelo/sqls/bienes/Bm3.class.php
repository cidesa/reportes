<?php
require_once("../../lib/modelo/baseClases.class.php");

class Bm3 extends baseClases
{
    function SQLp($ubiorides,$ubiorihas,$fecdes,$fechas)
    {
    	$sql="select
    		 a.codubiori,
    		 c.desubi as desubiori,
    		 trim(a.codact) as codact,
    		 e.desdis,
    		 trim(a.codmue) as codmue,
    		 trim((f.desmue)) as desmue,
    		 case when e.desinc='N' then formatonum(a.mondismue) else formatonum(0) end as incorp,
    		 case when e.desinc='S' then formatonum(a.mondismue) else formatonum(0) end as desinc
    		 from
    		 bndismue a left outer join bnregmue f on (a.codmue=f.codmue and a.codact=f.codact)
    		 left outer join bndefact b on(a.codact=b.codact)
    		 left outer join bnubibie c on(a.codubiori=c.codubi)
    		 left outer join bnubibie d on(a.codubides=d.codubi),
    		 bndisbie e
    		 where
    		 a.codubiori>='".$ubiorides."' and
    		 a.codubiori<='".$ubiorihas."' and
    		 a.fecdismue>=to_date('".$fecdes."','dd/mm/yyyy') and
    		 a.fecdismue<=to_date('".$fechas."','dd/mm/yyyy') and
    		 rtrim(substr(a.tipdismue,1,10)) = rtrim(e.coddis)
    		 order by a.codubiori, a.codubides, a.fecdismue, a.codact, a.codmue";

    	return $this->select($sql);
    }
    function SQLp_anterior($ubiorides,$ubiorihas,$fecdes)
    {
    	$sql="select  coalesce(sum(case when e.desinc='N' then coalesce(a.mondismue,0) else (-1*coalesce(a.mondismue,0)) end),0) as exiant
    		 from
    		 bndismue a left outer join bnregmue f on (a.codmue=f.codmue and a.codact=f.codact)
    		 left outer join bndefact b on(a.codact=b.codact)
    		 left outer join bnubibie c on(a.codubiori=c.codubi)
    		 left outer join bnubibie d on(a.codubides=d.codubi),
    		 bndisbie e
    		 where
    		 a.codubiori >= '".$ubiorides."' and
    		 a.codubiori <= '".$ubiorihas."' and
    		 a.fecdismue < to_date('".$fecdes."','dd/mm/yyyy') and
    		 rtrim(substr(a.tipdismue,1,10)) = rtrim(e.coddis)";

    	return $this->select($sql);
    }
    function SQLp_desinc60($ubiorides,$ubiorihas,$fecdes,$fechas)
    {
    	$sql="select  sum(case when e.desinc='S' then a.mondismue else 0 end) as desinc
    		 from
    		 bndismue a left outer join bnregmue f on (a.codmue=f.codmue and a.codact=f.codact)
    		 left outer join bndefact b on(a.codact=b.codact)
    		 left outer join bnubibie c on(a.codubiori=c.codubi)
    		 left outer join bnubibie d on(a.codubides=d.codubi),
    		 bndisbie e
    		 where
    		 a.codubiori>='".$ubiorides."' and
    		 a.codubiori<='".$ubiorihas."' and
    		 a.fecdismue>=to_date('".$fecdes."','dd/mm/yyyy') and
    		 a.fecdismue<=to_date('".$fechas."','dd/mm/yyyy') and
    		 rtrim(substr(a.tipdismue,1,10)) = '0000000060' ";


    	return $this->select($sql);
    }
	
	function sqlempresa()
	{
		$sql="select * from empresa";
		return $this->select($sql);
	}

 }
?>