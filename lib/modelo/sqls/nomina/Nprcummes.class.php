<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprcummes extends baseClases
{
    function sqlp($emp1,$emp2,$nom)
    {
        $sql = "select a.codniv,d.desniv,a.codemp, a.nomemp, a.cedemp, to_char(a.fecnac,'dd/mm') as fecnac,         
						a.edaemp, b.codcat,  b.nomcat
						from nphojint a,npasicaremp b,npcatpre c,npestorg d
						where
						b.status='V' and a.codniv=d.codniv and b.codcat=c.codcat and a.codemp=b.codemp and
						a.codemp >= '$emp1' and a.codemp <= '$emp2'  and
						to_char(fecnac,'mm')='$nom' 
						order by a.codniv,fecnac,a.nomemp";
						
        return $this->select($sql);
    }

}


?>
