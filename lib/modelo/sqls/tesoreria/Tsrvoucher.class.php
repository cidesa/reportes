<?php

require_once("../../lib/modelo/baseClases.class.php");

class Tsrvoucher extends baseClases
{

 function sqlp($numchedes,$numchehas)
  {
	$sql="select a.numche as numche,a.fecemi,rtrim(c.nomben) as nomben,a.numcue,a.monche,
		to_char(a.fecemi,'dd') as dia,
		to_char(a.fecemi,'mm') as mes,
		to_char(a.fecemi,'yyyy') as ano,
		ltrim(rtrim(to_char(a.monche,'999,999,999,999.99'))) as monchestr,
		c.cedrif,b.nomcue,d.deslib as descon,d.numcom,e.numord,e.desord
		from tsdefban b, opbenefi c, tsmovlib d, tscheemi a
		left join opordpag e on rtrim(a.numche)=rtrim(e.numche)
		where
		rtrim(a.numcue)=rtrim(b.numcue) and rtrim(a.numche)=rtrim(d.reflib) and
		rtrim(a.numcue)=rtrim(d.numcue) and rtrim(a.cedrif)=rtrim(c.cedrif) and
		rtrim(a.numche)>=rtrim('".$numchedes."') and rtrim(a.numche)<=rtrim('".$numchehas."')
		order by rtrim(a.numche)";

   	return $this->select($sql);
  }

}
?>