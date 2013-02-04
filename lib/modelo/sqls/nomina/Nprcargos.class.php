<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprcargos extends baseClases
{

    function sqlp($cod1, $cod2, $codn1, $codn2)
    {
        $sql = "select b.codcar, count (a.codemp) as canemp, c.nomcar, c.suecar, d.nomnom, b.codnom, c.carvan
						from npasicaremp a, npasicarnom b  , npcargos c, npnomina d, NPHOJINT e
						where (a.codcar = b.codcar and a.codnom = b.codnom) and
						b.codcar = c.codcar and b.codnom = d.codnom and
						b.codcar >='$cod1' and b.codcar <= '$cod2'
						and b.codnom >= '$codn1' and b.codnom <= '$codn2'  and a.codemp=e.codemp and
	                    e.staemp='A' and a.status='V'
						group by b.codcar, c.nomcar, c.suecar, d.nomnom, b.codnom, c.carvan order by b.codnom";
		
        return $this->select($sql);
    }

    function sql($cod1, $cod2, $codn1, $codn2)
    {
        $sql = "select count (x.canemp) as canemp,  x.codcar, x.nomcar, x.suecar, x.nomnom, x.codnom, x.carvan from
						(select  distinct (a.codemp) as canemp, b.codcar, c.nomcar, c.suecar, d.nomnom, b.codnom, c.carvan
						from npasicaremp a, npasicarnom b  , npcargos c, npnomina d, NPHOJINT e
						where (a.codcar = b.codcar and a.codnom = b.codnom) and
						b.codcar = c.codcar and b.codnom = d.codnom and
						b.codcar >='$cod1'  and b.codcar <= '$cod2'
						and b.codnom >= '$codn1' and b.codnom <= '$codn2'  and a.codemp=e.codemp and
						e.staemp='A' and a.status='V'
						group by a.codemp,b.codcar, c.nomcar, c.suecar, d.nomnom, b.codnom, c.carvan) x
					        group by x.codcar, x.nomcar, x.suecar, x.nomnom, x.codnom, x.carvan order by x.codnom";
		//print('tariom'.$sql);exit;
        return $this->select($sql);
    }

}

?>
