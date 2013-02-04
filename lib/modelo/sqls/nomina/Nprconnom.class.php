<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprconnom extends baseClases
{

    function sqlp($nom, $cod1, $cod2, $tip)
    {
        $sql = "select distinct(b.codcon),b.frecon,a.nomcon, 
			        (CASE WHEN c.codpre is null THEN a.codpar ELSE c.codpre END) as codpar1,
					 a.opecon as opecon, a.acuhis as acuhis,
					a.inimon as inimon, a.conact as conact, a.impcpt as impcpt, a.ordpag as ordpag,d.codnom,d.nomnom 
					from npdefcpt a, 
					npasiconnom b LEFT OUTER JOIN npasicodpre c ON b.codnom=c.codnom and b.codcon=c.codcon
					left outer join Npnomina d on b.codnom=d.codnom
					where 
					a.codcon=b.codcon and
					b.codnom = '$nom' and
					a.codcon >= '$cod1' and a.codcon <= '$cod2' and
					a.opecon = '$tip'
					order by b.codcon";
	
		//print('dadiashd');exit;
        return $this->select($sql);

    }

    function sql($nom, $cod1, $cod2)
    {
        $sql = "select distinct(b.codcon),b.frecon,a.nomcon, 
					(CASE WHEN c.codpre is null THEN a.codpar ELSE c.codpre END) as codpar1,
					a.opecon as opecon, a.acuhis as acuhis,
					a.inimon as inimon, a.conact as conact, a.impcpt as impcpt, a.ordpag as ordpag,d.codnom,d.nomnom
					from npdefcpt a, 
					npasiconnom b LEFT OUTER JOIN npasicodpre c ON (b.codnom=c.codnom) and (b.codcon=c.codcon)
					left outer join Npnomina d on (b.codnom=d.codnom)
					where 
					a.codcon=b.codcon and
					b.codnom = '$nom' and
					a.codcon >= '$cod1' and a.codcon <= '$cod2'
					order by b.codcon";
		//print("<pre>".'$sql='.$sql);exit;
        return $this->select($sql);
    }


}

?>
