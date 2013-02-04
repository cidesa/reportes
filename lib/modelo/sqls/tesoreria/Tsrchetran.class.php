<?php
require_once("../../lib/modelo/baseClases.class.php");

class Tsrchetran extends baseClases {

  function sqlp($numchedes,$numchehas,$numcuedes,$numcuehas,$bendes,$benhas,$fecdes,$fechas)
  {
		$sql="select a.reflib as anumche, a.numcue as anumcue, b.nomcue as anomcue, c.nomben as anomben, a.feclib as afecemi, a.monmov as amonche
				from tsmovlib a, tsdefban b, opbenefi c, tscheemi d
				where
					trim(a.reflib) >= trim('".$numchedes."') AND
					trim(a.reflib) <= trim('".$numchehas."') AND
					c.cedrif >= '".$bendes."' AND
					c.cedrif <= '".$benhas."' AND
					a.feclib >= to_date('".$fecdes."','dd/mm/yyyy') AND
					a.feclib <= to_date('".$fechas."','dd/mm/yyyy') AND
					trim(a.numcue) >= trim('".$numcuedes."') AND
					trim(a.numcue) <= trim('".$numcuehas."') AND
					(d.cedrif = c.cedrif) and
					a.reflib=d.numche and
					a.numcue=d.numcue and
					b.numcue=d.numcue and
					a.stacon='N'  and
					a.numcue = b.numcue
				order by a.numcue, a.feclib, a.reflib	";

//H::PrintR($sql);exit;and
					//(a.reflib not in (select reflibpad from tsmovlib where reflib like 'A%' and reflib='A'||substr(a.reflib,2,8) ) and
					//((a.tipmov='CH' or a.tipmov='CHQD' or a.tipmov='CHQF'  ) or
					//(select feclib from tsmovlib where reflib like 'A%' and reflib='A'||substr(a.reflib,2,8) ) >to_date('".$fechas."','dd/mm/yyyy'))) and
					//(a.tipmov='CH' or a.tipmov='CHQD' or a.tipmov='CHQF' )

   return $this->select($sql);
  }


  function sqlpx($numchedes,$numchehas)
  {
	$sql="select a.numord, b.numche
		from opordche a, tscheemi b
		where
		rtrim(a.numche)>=('".$numchedes."') and
		rtrim(a.numche)<=('".$numchehas."') and
		rtrim(a.numche)=rtrim(b.numche)
		order by a.numord";
     //print $sql;

   	return $this->select($sql);
  }



}
?>
