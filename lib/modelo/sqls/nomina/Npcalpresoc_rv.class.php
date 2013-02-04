<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Npcalpresoc_rv extends baseClases
{

    function sql($codempdes,$codemphas)
    {
        $sql = "select a.*,to_char(a.feccor,'dd/mm/yyyy') as feccor,c.nomemp,to_char(b.feccal,'dd/mm/yyyy') as fecing 
					from NPPRESOCANT a, NPasiempcont b ,NPHOJINT c
					where 
					a.codemp=c.codemp and
					a.codemp >= '$codempdes' and  
					a.codemp <= '$codemphas' and 
					a.codemp=b.codemp";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sql2($tbcodemp)
    {
        $sql = "select codemp,to_char(min(fecini),'dd/mm/yyyy') as f1,to_char(min(fecfin),'dd/mm/yyyy') as f2,
							anoser,salemp,antacum
							from npimppresocant
							where codemp='$tbcodemp'
							group by codemp,anoser,salemp,antacum
							order by min(fecini)";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
