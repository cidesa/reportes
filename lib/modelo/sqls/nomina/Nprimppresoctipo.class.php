<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprimppresoctipo extends baseClases
{
	function sqlp($codemp,$tipo,$fecing)
	{
		if($tipo=='0')
			$campo="formatonum(capvie) as capvie,";
		elseif($tipo=='1')
			$campo="case when formatonum(adepre*0)=',00' then null else formatonum(adepre*0) end  as comtra,
					case when formatonum(adepre)=',00' then null else  formatonum(adepre) end as adepre,
					formatonum(capvie) as capvie,";
		else
			$campo="formatonum(capvie) as capvie,";

		$sql="select to_char(a.fecfin,'dd/mm/yyyy') as fecfin,".$campo."tasint,diadif,
			formatonum(intdev) as intdev, formatonum(intacum) as intacum,formatonum(capcap) as capcap
			from npimppresoc1 a
			where
			trim(a.codemp)=trim('$codemp') and
			a.fecini>=to_date('".$fecing."','dd/mm/YYYY') and
			a.tipo='$tipo'
			order by a.fecfin";

		return $this->select($sql);
	}


	function sqldatos($codemp)
	{
		$sql="select
			d.nomcat as categoria, e.nomcar as cargo,
			b.cedemp,
			b.nomemp,
			to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy') as fecing,
			to_char(c.feccor,'dd/mm/yyyy') as fecret,
			c.anotra,
			c.mestra,
			c.diatra
			from
			nphiscon a,
			nppresoc c,
			nphojint b, npcatpre d, npcargos e
			where
			rpad(a.codemp,16,' ')=rpad('$codemp',16, ' ') and
			a.codemp=b.codemp and
			a.codemp=c.codemp and
			b.codemp=c.codemp and
			a.codcat=d.codcat and
			a.codcar=e.codcar
			group by d.nomcat,e.nomcar, b.cedemp, b.nomemp, to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy'),to_char(c.feccor,'dd/mm/yyyy'), c.anotra,c.mestra,c.diatra";


//		$sql="select a.nomcat,a.cedemp,a.nomemp,to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy') as fecing,to_char(c.feccor,'dd/mm/yyyy') as fecret,c.anotra,c.mestra,c.diatra
//			from nphiscon a, nppresoc c, nphojint b
//			where
//			a.codemp=c.codemp and
//			a.codemp=b.codemp and
//			trim(a.codemp)=trim('$codemp')
//			group by a.nomcat,a.cedemp,a.nomemp,to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy'),to_char(c.feccor,'dd/mm/yyyy'),c.anotra,c.mestra,c.diatra";

		return $this->select($sql);
	}

	function sqlfirst($codemp,$tipo,$fecing)
	{
		if($tipo=='0')
			$campo="'' as tasint,'' as diadif,'' as intdev,'' as intacum,";
		elseif($tipo=='1')
			$campo="'' as comtra,'' as comrec,'' as tasint,'' as diadif,'' as intdev,'' as intacum,";
		else
			$campo="'' as tasint,'' as diadif,'' as intdev,'' as intacum,";

		$sql="select to_char(fecini,'dd/mm/yyyy'),formatonum(capvie),".$campo." formatonum(capvie)
				from npimppresoc1
				where
				trim(codemp)=trim('$codemp') and fecini>=to_date('".$fecing."','dd/mm/YYYY') and
				tipo='$tipo'
				order by fecini";
		return $this->select($sql);
	}


}