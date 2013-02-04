<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistpres extends baseClases
{
    function sql1()
    {
        $sql = "SELECT codtippre,destippre FROM NPTIPPRE";
        //print('$sql'.$sql);exit;
        return $this->select($sql);
    }

    function sqla($codempdes,$codemphas,$codtippre)
    {
        $sql = "SELECT distinct(A.CODEMP)
							FROM NPHISPRE A
							where 
							A.CODEMP >= '$codempdes' AND A.CODEMP <= '$codemphas'
							AND A.CODTIPPRE='$codtippre'
							order by a.codemp";
        //print('$sql'.$sql);exit;
        return $this->select($sql);
    }
	
	function sql2($codtippre,$codemp)
    {
        $sql = "SELECT A.CODEMP,A.CODTIPPRE as codtippredet,B.CEDEMP,B.NOMEMP,A.DESHISPRE,
				 to_char(A.FECHISPRE,'dd/mm/yyyy') as FECHISPRE,A.MONPRE, A.SALDO FROM NPHISPRE A,NPHOJINT B WHERE
				 A.CODTIPPRE='$codtippre' AND A.CODEMP='$codemp' and
				 A.CODEMP=B.CODEMP
				 ORDER BY A.FECHISPRE";
        //print('$sql'.$sql);exit;
        return $this->select($sql);
    }
}
?>
