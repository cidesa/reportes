<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Oce704 extends baseClases{

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

		$sql = "
				select codcta,descta,preapr,premod,prgtri,comtri,cautri,pagtri,prgaltri,comaltri,caualtri,pagaltri,mondis, r.descripcion as descripcion,cuenta,tipo
        from (
		select ('I')::VARCHAR(1) as tip,a.codpar as codcta,a.nompre as descta,
		sum(preapr) as preapr,
		sum(premod) as premod,
		sum(prgtri) as prgtri,
		sum(comtri) as comtri,
		sum(cautri) as cautri,
		sum(pagtri) as pagtri,
		sum(prgaltri) as prgaltri,
		sum(comaltri) as comaltri,
		sum(caualtri) as caualtri,
		sum(pagaltri) as pagaltri,
		sum(mondis) as mondis
		from
                (
                  select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)) as codpar,b.nompre,
	          sum(monasi) as preapr,
	          sum((montra-montrn)+(monadi-mondim)) as premod,
	          0 as prgtri,
	          0 as comtri,
	          0 as cautri,
	          0 as pagtri,
	          0 as prgaltri,
	          0 as comaltri,
	          0 as caualtri,
	          0 as pagaltri,
	          0 as mondis
	          from ciasiini a, cideftit b
	          where perpre='00' and
	          a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)||'%'
	          group by b.codpre,b.nompre

              union all
              select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)),b.nompre,
              0,
              0,
              sum(monasi),
              sum(moncom),
              sum(moncau),
              sum(monpag),
              0,
              0,
              0,
              0,
              0
	          from ciasiini a, cideftit b
	          where
			  a.perpre>='$des' and a.perpre<='$has'  and
			  a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)||'%'
			  group by b.codpre,b.nompre

              union all
              select trim(substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)),b.nompre,
              0,
              0,
              0,
              0,
              0,
              0,
              sum(monasi),
              sum(moncom),
              sum(moncau),
              sum(monpag),
              0
	          from ciasiini a, cideftit b
	          where
			  a.perpre>='01' and a.perpre<='$has'  and
			  a.codpre like '%'||substr(b.codpre,(select sum(lonniv+1) as loncat from ciniveles where catpar='C')::integer+1)||'%'
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