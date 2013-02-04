<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprcalantpresoc extends baseClases{
	
    function tsql($codempdes,$codemphas)
    {
        $sql = "SELECT DISTINCT(a.codemp)  as codemp,
						C.NOMEMP,
						to_char(D.feccor,'dd/mm/yyyy') as feccor,
						D.ANOSER,
						D.MESSER,
						D.DIASER,
						to_char(D.feccal,'dd/mm/yyyy') as feccal,
						to_char(B.feccal,'dd/mm/yyyy') as fecing
						from NPANTPRE A,NPHOJINT C, NPPRESOC D,NPASIEMPCONT B
						where
						a.codemp=c.codemp and
						A.CODEMP=D.CODEMP AND
						A.CODEMP=B.CODEMP AND
						a.codemp>= '$codempdes' AND
						a.codemp <= '$codemphas'
						order by a.codemp";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sql($codempdes,$codemphas)
    {
        $sql = "SELECT A.*,
						to_char(A.fecant,'dd/mm/yyyy') as fecantemp,
						C.NOMEMP,
						to_char(D.feccor,'dd/mm/yyyy') as feccor,
						D.ANOSER,
						D.MESSER,
						D.DIASER,
						to_char(D.feccal,'dd/mm/yyyy') as feccal,
						to_char(B.feccal,'dd/mm/yyyy') as fecing
						from NPANTPRE A,NPHOJINT C, NPPRESOC D,NPASIEMPCONT B
						where
						a.codemp=c.codemp and
						A.CODEMP=D.CODEMP AND
						A.CODEMP=B.CODEMP AND
						a.codemp>= '$codempdes' AND
						a.codemp <= '$codemphas'
						order by a.codemp,A.fecant";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>