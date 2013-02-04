<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Npvac_relacionsalidas extends baseClases
{

    function sql($tipnomdes,$codempdes,$codemphas,$fecsaldes,$fecsalhas)
    {
        $sql = "select
						c.codemp,
						c.nomemp,
						to_char(c.fecing,'dd/mm/yyyy') as fecing,
						c.fecret,
						c.cedemp,
						a.codcar,
						b.nomcar,
						b.codcat,
						e.nomcat,
						to_char(fechasalida,'dd/mm/yyyy') as fechasalida,
						to_char(fechaentrada,'dd/mm/yyyy') as fechaentrada,
						diadis,
						perini,
						perfin,
						diasbono
						from  npcatpre e,npvacregsal a,nphojint c, npasicaremp b
						where
						b.codnom= '$tipnomdes' and
						b.codnom=a.codnom and
						b.codcat=e.codcat and
						b.codcar=a.codcar and
						b.codemp=c.codemp and
						b.codemp=a.codemp and
						b.codemp >= '$codempdes'  and
						b.codemp <= '$codemphas' and
						a.fechasalida >= to_date('$fecsaldes','dd/mm/yyyy') and
						a.fechasalida <= to_date('$fecsalhas','dd/mm/yyyy') and
						b.status='V' and
						a.stavac='N'
						order by
						c.codemp,
						perini";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
