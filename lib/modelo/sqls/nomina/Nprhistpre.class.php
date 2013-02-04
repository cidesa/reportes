<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistpre extends baseClases
{
    function sqlp($empdes,$emphas,$condes,$conhas,$tipnomdes,$fecnomdes,$fecnomhas,$especial)
    {
        $sql = "select (a.codcat||'-'||c.codpar) as codpre,
				sum((CASE WHEN c.opecon='A' THEN a.monto ELSE 0 END)) as asigna,
				sum((CASE WHEN c.opecon='D' THEN a.monto ELSE 0 END)) as deduci,
				sum((CASE WHEN c.opecon='P' THEN a.monto ELSE 0 END)) as aporte
				from nphiscon a,npdefcpt c
				where
				a.codcon=c.codcon and
				a.codemp >= '$empdes' and a.codemp <= '$emphas' and
				a.codcon >= '$condes' and a.codcon <= '$conhas' and
				a.codnom = '$tipnomdes' and a.monto>0
				and fecnom>=to_date('$fecnomdes','dd/mm/yyyy') and fecnom<=to_date('$fecnomhas','dd/mm/yyyy')
				and a.codcon not in(select codcon from npconceptoscategoria)
				group by (a.codcat||'-'||c.codpar)
				union
				select (a.codcat||'-'||c.codpar) as codpre,
				sum((CASE WHEN c.opecon='A' THEN a.monto ELSE 0 END)) as asigna2,
				sum((CASE WHEN c.opecon='D' THEN a.monto ELSE 0 END)) as deduci2,
				sum((CASE WHEN c.opecon='P' THEN a.monto ELSE 0 END)) as aporte2
				from nphiscon a,npdefcpt c,npconceptoscategoria d
				where
				a.codcon=c.codcon and c.codcon=d.codcon and a.codcon=d.codcon and
                a.especial='$especial' AND
				a.codemp >= '$empdes' and a.codemp <= '$emphas' and
				a.codcon >= '$condes' and a.codcon <= '$conhas' and
				a.codnom = '$tipnomdes' and a.monto>0
				and fecnom>=to_date('$fecnomdes','dd/mm/yyyy') and fecnom<=to_date('$fecnomhas','dd/mm/yyyy')
				group by (a.codcat||'-'||c.codpar)
				order by codpre";
       // print("<pre>".'$sql'.$sql);exit;
        return $this->select($sql);
    }
	
    function sqlx($tipnomdes)
    {
        $sql = "select codnom, nomnom, ultfec, profec from npnomina where codnom='$tipnomdes'";
        //print("<pre>".'$sql'.$sql);exit;
        return $this->select($sql);
    }
	
    function sql2($codpre)
    {
        $sql = "select nompre as nombre	from cpdeftit where codpre='$codpre'";
        //print("<pre>".'$sql'.$sql);exit;
        return $this->select($sql);
    }
}

?>
