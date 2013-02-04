<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprintpresoc_rn extends baseClases{
	
    function sql($codempdes,$codemphas)
    {
        $sql = "select a.*,to_char(a.feccor,'dd/mm/yyyy') as feccor,c.nomemp,to_char(b.feccal,'dd/mm/yyyy') as fecing 
					from NPPRESOC a, NPasiempcont b ,NPHOJINT c
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
        $sql = "Select *,to_char(fecfin,'dd/mm/yyyy') as fecfin,to_char(fecini,'dd/mm/yyyy') as fecini, fecfin as fec2 
							from npimppresoc  
							where codemp='$tbcodemp' and diadif>0 order by fec2";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>