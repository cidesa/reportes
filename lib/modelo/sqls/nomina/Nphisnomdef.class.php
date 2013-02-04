<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nphisnomdef extends baseClases
{

    function sqla($nom, $niv1, $niv2)
    {
        $sql = "select distinct(c.codniv) from  nphojint c,nphiscon b where
					b.codemp=c.codemp and
					b.codnom = '$nom' and
					c.codniv>= '$niv1' and c.codniv <= '$niv2'  
					order by c.codniv";
       //print "<pre>".$sql; exit ;

        return $this->select($sql);
    }

    function sqlx($nom)
    {
        $sql = "select codnom, nomnom, ultfec, profec from npnomina where codnom='$nom'";
        //print "<pre>".$sql; exit ;

        return $this->select($sql);
    }

    function sqlax($codniv)
    {
        $sql = "select desniv as cadena from npestorg where codniv='$codniv'";
        //print "<pre>".$sql; exit ;

        return $this->select($sql);
    }

    function sql($emp1, $emp2, $car1, $car2, $niv1, $niv2, $fecha1, $fecha2, $codniv, $nom)
    {
        $sql = "select distinct(c.codemp),c.nomemp,c.numcue,to_char(c.fecing,'dd/mm/yyyy') as fecing,c.fecret,c.cedemp,b.codcar,
						c.codniv as codcat,
						(CASE WHEN c.staemp='A' THEN 'Activo'
							  WHEN c.staemp='S' THEN 'Suspendido'
							  WHEN c.staemp='V' THEN 'Vacaciones' END) as estatus
						from  nphojint c, nphiscon b, npdefcpt e           
						where
						b.codemp=c.codemp and	
						c.codemp>= '$emp1' and c.codemp <= '$emp2' and
						b.codcar>= '$car1' and b.codcar <= '$car2' and
						b.codcon=e.codcon and
						c.codniv>= '$niv1' and c.codniv <= '$niv2' and
						b.fecnom>=to_date('$fecha1','dd/mm/yyyy') and b.fecnom<=to_date('$fecha2','dd/mm/yyyy') and
						c.codniv='$codniv' and
						b.codnom = '$nom'						
						order by c.nomemp,c.codemp";
        //print "<pre>".$sql; exit ;
        return $this->select($sql);
    }

    function sqlt($codcar)
    {
        $sql = "select nomcar as cadena from npcargos where codcar='$codcar'";
        //print "<pre>".$sql; exit ;

        return $this->select($sql);
    }
    function sqlb($nom,$car1,$car2,$fecha1,$fecha2,$codniv,$codemp)
    {
        $sql = "select c.codemp, c.nomemp,c.numcue,c.fecing,c.fecret,c.cedemp,b.codcar,
						c.codniv as codcat,
						(CASE WHEN c.staemp='A' THEN 'Activo'
							  WHEN c.staemp='S' THEN 'Suspendido'
							  WHEN c.staemp='V' THEN 'Vacaciones' END) as estatus,
						b.codcon,rtrim(e.nomcon) as nomcon,
						(CASE WHEN e.opecon='A' THEN coalesce(sum(b.monto),0) ELSE 0 END) as asigna,
						(CASE WHEN e.opecon='D' THEN coalesce(sum(b.monto),0) ELSE 0 END) as deduc,
						(CASE WHEN e.opecon='P' THEN coalesce(sum(b.monto),0) ELSE 0 END) as aporte
						from  npdefcpt e,nphojint c, nphiscon b              

						where
						b.codnom = '$nom' and
						b.codemp=c.codemp and
						b.codcar>= '$car1' and b.codcar <= '$car2' and
						b.fecnom>=to_date('$fecha1','dd/mm/yyyy') and b.fecnom<=to_date('$fecha2','dd/mm/yyyy') and
						b.codcon=e.codcon and
						c.codniv='$codniv' and
						c.codemp= '$codemp' 
						
						group by
						c.codemp, c.nomemp,c.numcue,c.fecing,c.fecret,c.cedemp,b.codcar,         
						--d.nomcar,
						c.codniv,
						--f.desniv,
						c.staemp,b.codcon,e.nomcon,e.opecon
						order by c.nomemp,c.codemp,e.opecon,b.codcon";
        //print "<pre>".$sql; exit ;

        return $this->select($sql);
    }
}
?>
