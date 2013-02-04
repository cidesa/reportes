<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprimppresocant extends baseClases
{
	function sqlp($codemp,$fecing)
	{
		$dias=30;

		$sql="select to_char(a.fecfin,'dd/mm/yyyy'),
			case when (to_char(a.fecfin,'mm')='10' or a.fecfin='1991-04-30' or a.fecfin='1997-06-18') then formatonum((a.salemp/$dias)) else null end  as saldia,
			case when (to_char(a.fecfin,'mm')='10' or a.fecfin='1991-04-30' or a.fecfin='1997-06-18') then a.anoser else null end  as anoser,
			case when (to_char(a.fecfin,'mm')='10' or a.fecfin='1991-04-30' or a.fecfin='1997-06-18') then formatonum((a.salemp*a.anoser)) else null end as antper,
			case when formatonum(a.adeant)=',00' then null else  formatonum(a.adeant) end as adeant,
			case when formatonum(acum_npimppresocant(a.codemp,fecfin))=',00' then null else formatonum(acum_npimppresocant(a.codemp,fecfin)) end as antacu,
			formatonum(a.antacum),a.tasint,a.diadif,formatonum(a.intdev),formatonum(a.intacum) as intacum,formatonum(a.capemp),'V' as tip
			from npimppresocant a
			where trim(a.codemp)=trim('$codemp') and a.fecini>=to_date('".$fecing."','dd/mm/YYYY')
			union all
			select to_char(a.fecfin,'dd/mm/yyyy'),
			formatonum((a.salemp/$dias))  as saldia,
			a.diaart108,
			formatonum(((a.salemp/$dias)*a.diaart108)) as antper,
			case when formatonum(a.adeant)=',00' then null else  formatonum(a.adeant) end ,
			case when formatonum(acum_npimppresoc(a.codemp,fecfin))=',00' then null else formatonum(acum_npimppresocant(a.codemp,fecfin)) end as antacu,
			formatonum(a.antacum),a.tasint,a.diadif,formatonum(a.intdev),formatonum(a.intacum),formatonum(a.capemp),'N' as tip
			from npimppresoc a
			where trim(a.codemp)=trim('$codemp')
			and a.tipo is null";

					/* print '<pre>';
						print_r($sql);
						 print '</pre>';
						exit;*/

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
			rpad(a.codemp,16,' ')=rpad('09332041',16, ' ') and
			a.codemp=b.codemp and
			a.codemp=c.codemp and
			b.codemp=c.codemp and
			a.codcat=d.codcat and
			a.codcar=e.codcar
			group by d.nomcat,e.nomcar, b.cedemp, b.nomemp, to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy'),to_char(c.feccor,'dd/mm/yyyy'), c.anotra,c.mestra,c.diatra";

			 		/*	print '<pre>';
						print_r($sql);
						 print '</pre>';
						exit;*/

		return $this->select($sql);
	}


}