<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprasicaremp extends baseClases
{

    function sql($emp1, $emp2, $nom, $fec1, $fec2)
    {
        $sql = "select a.codemp, a.codcar, a.codnom, a.codcat, to_char(b.fecing,'dd/mm/yyyy') as fecasi, a.nomemp, a.nomcar, a.nomnom, a.nomcat, a.unieje,
					a.sueldo,b.codniv,c.desniv,
					(CASE WHEN a.status='v' THEN 'VIGENTE' ELSE 'NO VIGENTE' END)
					from npasicaremp a, nphojint b LEFT OUTER JOIN npestorg c ON (b.codniv=c.codniv)
					where
					a.codemp=b.codemp and b.codniv=c.codniv and
					a.codemp >= '$emp1' and a.codemp <= '$emp2' and
					a.codnom='$nom' and b.staemp='A' and a.fecasi>=to_date('$fec1','dd/mm/yyyy') and a.fecasi<=to_date('$fec2','dd/mm/yyyy')
					 and a.status='V' order by b.codniv,a.codcar,a.codemp";
        return $this->select($sql);
    }

    function sql2($codemp)
    {
        $sql = "select codpai as pais,codest as estado,codciu as ciudad
						from nphojint
						where codemp='$codemp'";
        return $this->select($sql);
    }

    function sql3($pais,$ciudad,$estado)
    {
        $sql = "select nomciu as ubicacion
					     from npciudad where codpai='$pais' and
     				     codciu=$ciudad and
     				     codedo=$estado";
        return $this->select($sql);
    }
	
    function sqlt($emp1,$emp2,$nom,$fec1,$fec2)
    {
        $sql = "select count (a.codcar) as cant,sum (a.sueldo) as sueldo
					from npasicaremp a, nphojint b LEFT OUTER JOIN npestorg c ON (b.codniv=c.codniv)
					where
					a.codemp=b.codemp and b.codniv=c.codniv and  a.status='V' and
					a.codemp >= '$emp1' and a.codemp <= '$emp2' and
					a.codnom='$nom' and b.staemp='A' and a.fecasi>=to_date('$fec1','dd/mm/yyyy') and a.fecasi<=to_date('$fec2','dd/mm/yyyy')";
        return $this->select($sql);
    }
}

?>
