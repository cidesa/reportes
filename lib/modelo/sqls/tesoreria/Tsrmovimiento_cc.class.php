<?php
require_once("../../lib/modelo/baseClases.class.php");
require_once("../../lib/general/funciones.php");

class Tsrmovimiento_cc extends baseClases
{

 function sqlp($numchedes,$numchehas,$bendes,$benhas,$fechades,$fechahas,$numcuedes,$numcuehas)
  {
	$sql2="select
				a.reflib, a.feclib as feclib,a.tipmov,
				b.numche,b.cedrif,c.nomben, d.codtip,
				d.debcre, e.codpre as codpre, e.monimp,substr(e.codpre,10,12) as partida,substr(e.codpre,7,3) as act,
				(CASE WHEN d.debcre='C' THEN a.monmov ELSE 0 END) as haber,
				(CASE WHEN d.debcre='D' THEN a.monmov ELSE 0 END) as deber, ((CASE WHEN d.debcre='D' THEN a.monmov ELSE 0 END)-(CASE WHEN d.debcre='C' THEN a.monmov ELSE 0 END)) as saldo,
				b.numcue, f.nomcue, (select monasi
						       from cpasiini where
						       CODPRE= e.codpre AND PERPRE='00') as monasi
				from
				tsmovlib a, tscheemi b left outer join tsdefban f on f.numcue=b.numcue , opbenefi c, tstipmov d, cpimppag e
				where
				trim(b.numche)>= trim('".$numchedes."') and
				trim(b.numche) <= trim('".$numchehas."') and
				trim(b.numcue)>= trim('".$numcuedes."') and
				trim(b.numcue) <= trim('".$numcuehas."') and
				trim(c.cedrif) >= trim('".$bendes."') and
				trim(c.cedrif) <= trim('".$benhas."') and
				fecemi >= to_date('".$fechades."','dd/mm/yyyy') and
				fecemi <= to_date('".$fechahas."','dd/mm/yyyy') and
				a.reflib=b.numche and
				b.cedrif=c.cedrif and
				a.tipmov=d.codtip and
				trim(a.refpag)=e.refpag
		        order by b.numcue,b.numche,a.feclib,a.reflib";

		      	$sql="select
				b.numche,a.feclib as feclib,c.nomben,sum(e.monimp) as monimp,substr(e.codpre,10,16) as partida,
				b.numcue, f.nomcue
				from
				tsmovlib a, tscheemi b left outer join tsdefban f on f.numcue=b.numcue , opbenefi c, tstipmov d, cpimppag e
				where
				trim(b.numche)>= trim('".$numchedes."') and
				trim(b.numche) <= trim('".$numchehas."') and
				trim(b.numcue)>= trim('".$numcuedes."') and
				trim(b.numcue) <= trim('".$numcuehas."') and
				trim(c.cedrif) >= trim('".$bendes."') and
				trim(c.cedrif) <= trim('".$benhas."') and
				fecemi >= to_date('".$fechades."','dd/mm/yyyy') and
				fecemi <= to_date('".$fechahas."','dd/mm/yyyy') and
				a.reflib=b.numche and
				b.cedrif=c.cedrif and
				a.tipmov=d.codtip and
				trim(a.refpag)=e.refpag
				group by b.numche,
				substr(e.codpre,10,16) , a.feclib ,c.nomben, b.numcue, f.nomcue
				order by b.numcue,b.numche";

//echo '<pre>';print_r($sql);exit;

   	return $this->select($sql);
  }

 function sqlcodpre($reflib)
  {
	$sql="select e.codpre , e.monimp from tsmovlib a , cpimppag e where a.reflib='".$reflib."' and a.refpag=e.refpag group by substr(e.codpre,10,16),e.codpre, e.monimp";

//echo '<pre>';print_r($sql);exit;

   	return $this->select($sql);
  }
//select e.codpre from tsmovlib a , cpimppag e where a.reflib='00672863' and a.refpag=e.refpag
 function sqlasi($codpre)
  {
	$sql="select  (monasi) as asig  from cpasiini where  codpre='".$codpre."' AND PERPRE='00'";

//echo '<pre>';print_r($sql);exit;

   	return $this->select($sql);
  }
}
?>
