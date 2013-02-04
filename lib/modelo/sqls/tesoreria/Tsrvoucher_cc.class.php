<?php

require_once("../../lib/modelo/baseClases.class.php");
require_once("../../lib/general/funciones.php");

class Tsrvoucher_cc extends baseClases
{

 function sqlp($numchedes,$numcue)
  {
	$sql="select distinct (a.numche) as numche,a.fecemi,
CASE WHEN  A.NOMBENSUS='' THEN rtrim(c.nomben) ELSE rtrim(A.nombensus) end AS nomben,

a.numcue,a.monche,
		to_char(a.fecemi,'dd') as dia,
		to_char(a.fecemi,'mm') as mes,
		to_char(a.fecemi,'yyyy') as ano,
		ltrim(rtrim(to_char(a.monche,'999,999,999,999.99'))) as monchestr,
                A.CODMON,
                Z.NOMMON,
		c.cedrif,b.nomcue,d.deslib as descon,d.numcom, b.desenl
		--,e.numord,e.desord
		from tsdefban b, opbenefi c, tsmovlib d,tscheemi a LEFT OUTER JOIN TSDESMON Z ON A.CODMON=Z.CODMON
		--left join opordpag e on rtrim(a.numche)=rtrim(e.numche)
		where
		rtrim(a.numche)=rtrim('".$numchedes."') and
		rtrim(b.numcue)=rtrim('".$numcue."') and
		(a.numcue)=(b.numcue) and
		(a.numche)=(d.reflib) and
		(a.numcue)=(d.numcue) and
		(a.cedrif)=(c.cedrif)
		order by a.numche";
    //H::Printr($sql);exit;


   	return $this->select($sql);
  }




function sqlpx($numchedes,$numcue)
  {
	$sql="select a.numord,c.deslib, b.numche
		from opordche a, tscheemi b, tsmovlib c
		where
		rtrim(a.numche)=('".$numchedes."') and
	    rtrim(b.numcue)=rtrim('".$numcue."') and
		rtrim(a.numche)=rtrim(b.numche) and rtrim(b.numcue)=rtrim(c.numcue) and
		(b.numche)=(c.reflib)
		order by a.numord";
//H::Printr($sql);exit;
   	return $this->select($sql);
  }




function sqlp2($numchedes,$numcue)
  {
	$sql="select a.numche as numche,d.numcom,
		f.desasi,f.monasi,f.debcre, f.codcta
		from contabc1 f, tsmovlib d, tscheemi a
		where
		rtrim(a.numche)=('".$numchedes."') and
	    rtrim(a.numcue)=rtrim('".$numcue."') and
		rtrim(a.numche)=rtrim(f.refasi) and
		rtrim(a.numche)=rtrim(d.reflib) and
             rtrim(f.numcom)=rtrim(d.numcom)and
		(a.numcue)=(d.numcue)";
//H::Printr($sql);exit;
//print $sql;exit; order by f.debcre, f.codcta
   	return $this->select($sql);
  }

  function sqlpz($numchedes,$numcue)
  {
	//$sql="select a.numche, b.refpag, b.codpre, b.monimp, b.refere, substr(b.codpre,10,3) as par,
	//	substr	(b.codpre,14,2) as gen, substr(b.codpre,17,2) as es, substr(b.codpre,20,2) as subes,
	//	substr(b.codpre,23,2) as cre, c.refpag
	//		from tscheemi a, cpimppag b, tsmovlib c
	//		where
	//			rtrim(a.numche)=('".$numchedes."') and
	//		    rtrim(a.numcue)=rtrim('".$numcue."') and
	//		    rtrim(a.numcue)=rtrim(c.numcue) and
	//			trim(a.numche)=c.reflib and
	//			b.refpag=c.refpag
	//	 order by a.numche, b.refere";
//H::Printr($sql);exit;

 $sql="select  a.numche, b.numord, b.monord, b.monret, b.monord - b.monret as mon, b.numche,
        b.ctaban, b.monpag, c.numcue, c.reflib
			from tscheemi a, opordpag b, tsmovlib c
			where
				rtrim(a.numche)=('".$numchedes."') and
			    rtrim(a.numcue)=rtrim('".$numcue."') and
			    rtrim(a.numcue)=rtrim(c.numcue) and
				trim(a.numche)=c.reflib and
				a.numche=b.numche and
                a.numcue=b.ctaban
		 order by b.numord";



   	return $this->select($sql);
  }




}
?>
