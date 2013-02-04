<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprbonotransf extends baseClases
{

    function sql($codempdes, $codemphas)
    {
        $sql = "SELECT a.*,to_char(B.feccal,'dd/mm/yyyy') as fecing,to_char(a.feccal,'dd/mm/yyyy') as feccal1,to_char(a.feccal-1,'dd/mm/yyyy') as feccal, c.nomemp 
						from NPPRESOCAnt a, NPasiempcont b  ,NPHOJINT c
						where 
						a.codemp=c.codemp and
						a.codemp>= '$codempdes' AND
						a.codemp <= '$codemphas' AND
						a.codemp=b.codemp";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sqlmon($tbcodemp)
    {
        $sql = "SELECT coalesce(sum(monasi),0) as valor FROM NPSALINT WHERE FECFINCON=to_date('31/12/1996','dd/mm/yyyy') AND  CODEMP='$tbcodemp'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
