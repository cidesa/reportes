<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Oce717 extends baseClases{

	function sqlp($tri,$form){
		if($tri=='I')
		{
			$des='01';
			$has='03';
		}elseif($tri=='II'){
			$des='04';
			$has='06';
		}elseif($tri=='III')
		{
			$des='07';
			$has='09';
		}else
		{
			$des='10';
			$has='12';
		}

		$sql="select codcta,descta,preapr,premod,prgtri,ejetri,prgaltri,ejealtri, r.descripcion as descripcion,cuenta,tipo
        from (
		select
		('C' )::VARCHAR(1) as tip,a.codcta,a.descta,
		sum(preapr) as preapr,sum(premod) as premod,sum(prgtri) as prgtri,sum(ejetri) as ejetri,sum(prgaltri) as prgaltri,sum(ejealtri) as ejealtri
		from (
		select
		codcta,
		sum(monasi) as preapr,
		sum((montra-montrn)+(monadi-mondim)) as premod,0 as prgtri,0 as ejetri,0 as prgaltri,0 as ejealtri
		from cpasiini z, cpdeftit x where perpre='00' and z.codpre=x.codpre GROUP BY CODCTA
		union all
		select
		codcta,
		0 as preapr,
		0 as premod,
		sum(monasi) as prgtri,
		sum(moncom) as ejetri,
		0 as prgaltri,
		0 as ejealtri
		from cpasiini z, cpdeftit x where perpre>='$des' and perpre<='$has' and z.codpre=x.codpre GROUP BY CODCTA
		union all
		select
		codcta,
		0 as preapr,
		0 as premod,
		0 as prgtri,
		0 as ejetri,
		sum(monasi) as prgaltri,
		sum(moncom) as ejealtri
		from cpasiini z, cpdeftit x where perpre>='01' and perpre<='$has' and z.codpre=x.codpre GROUP BY CODCTA
	             ) as B,CONTABB A
		WHERE
		B.codcta like a.codcta||'%'
		GROUP BY a.codcta,a.descta
		UNION ALL
		 --mejorar este segundo subquery
		select 'P' as tip,a.codpar,a.nompre,
		sum(preapr) as preapr,
		sum(premod) as premod,
		sum(prgtri) as prgtri,
		sum(ejetri) as ejetri,
		sum(prgaltri) as prgaltri,
		sum(ejealtri) as ejealtri
		from
                (
                  select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)) as codpar,b.nompre,
	          sum(monasi) as preapr,
	          sum((montra-montrn)+(monadi-mondim)) as premod,
	          0 as prgtri,
	          0 as ejetri,
	          0 as prgaltri,
	          0 as ejealtri
	          from cpasiini a, cpdeftit b
	          where perpre='00' and
	          a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)||'%'
	          group by b.codpre,b.nompre

              union all
              select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)),b.nompre,
              0,0,sum(monasi),sum(moncom),0,0
	          from cpasiini a, cpdeftit b
	          where
			  a.perpre>='$des' and a.perpre<='$has'  and
			  a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)||'%'
			  group by b.codpre,b.nompre

              union all
              select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)),b.nompre,
              0,0,0,0,sum(monasi),sum(moncom)
	          from cpasiini a, cpdeftit b
	          where
			  a.perpre>='01' and a.perpre<='$has'  and
			  a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from cpniveles where catpar='C')::integer+1)||'%'
			  group by b.codpre,b.nompre
		) a
		where codpar is not null  and codpar<>''
		group by a.codpar,a.nompre
           ) as i right outer join  forcfgrepins r on (i.codcta=r.cuenta and i.tip=r.tipo)
	   where
	   r.nrofor='$form' 
	   order by r.orden";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>