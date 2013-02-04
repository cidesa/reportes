<?php

require_once("../../lib/modelo/baseClases.class.php");

class Nprvacdisf extends baseClases
{

 function sqlp($codempdes,$codemphas,$per1,$per2)
  {
  	 $sql="select
				b.cedemp,
				b.nomemp,
				a.perini as ini,
				a.perfin as fin,
				a.diasdisfutar as disf,
				a.diasdisfrutados as adisf,
				(a.diasdisfutar-a.diasdisfrutados) as pend
				from
				npvacdisfrute a, NPHOJINT b
				whERE a.codemp=b.codemp and RTRIM(a.codemp) >= RTRIM('".trim($codempdes)."')AND
				RTRIM(a.codemp) <= RTRIM('".trim($codemphas)."') and
 				rtrim(a.perini)>= RTRIM('".trim($per1)."') and
 				rtrim(a.perfin)<= RTRIM('".trim($per2)."')
 				ORDER BY  a.codemp
						";
    // print '<pre>'; print $sql; exit;

   return $this->select($sql);
  }
}
?>