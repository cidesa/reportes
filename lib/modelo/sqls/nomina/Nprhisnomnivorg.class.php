<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhisnomnivorg extends baseClases
{

    function sql($tipnomdes,$empdes,$emphas,$fecdes,$fechas,$condes,$conhas,$cardes,$carhas,$nivdes,$nivhas)
    {
        $sql = "SELECT DISTINCT(B.CODEMP) as codemp,
to_char(C.FECRET,'dd/mm/yyyy') as fecret,
to_char(C.FECING,'dd/mm/yyyy') as fecing,
C.NOMEMP,
B.codcat,
d.nomcat,
C.NUMCUE AS CUENTA_BANCO,
B.CODNIV,
C.CEDEMP,
f.nomban,
A.NOMCAR,
E.DESNIV,
B.CODEMP,
B.CODCON,
G.OPECON,
LTRIM(RTRIM(G.NOMCON)) AS NOMCON,
LTRIM(RTRIM(B.CODCAR)) AS CODCAR,
(CASE WHEN G.OPECON='A' THEN coalesce(B.MONTO,0) ELSE 0 END) as ASIGNA,
(CASE WHEN G.OPECON='D' THEN coalesce(B.MONTO,0) ELSE 0 END) as DEDUC
FROM
NPHISCON B LEFT OUTER JOIN NPCATPRE D ON (B.CODCAT=D.CODCAT),
NPHOJINT C LEFT OUTER JOIN npbancos f ON (C.CODBAN=f.codban),
 NPCARGOS A,NPDEFCPT G, NPESTORG E
 WHERE
B.CODNOM= '$tipnomdes'
 AND B.CODEMP>= '$empdes'
 AND B.CODEMP <= '$emphas'
 AND B.FECNOM>=to_date('$fecdes','dd/mm/yyyy')
 AND B.FECNOM<=to_date('$fechas','dd/mm/yyyy')
 and B.CODCON>='$condes'
 AND B.CODCON<='$conhas'
 AND B.CODCAR>= '$cardes'
 AND B.CODCAR <='$carhas'
 AND B.CODNIV >= '$nivdes'
 AND B.CODNIV <= '$nivhas'
AND G.IMPCPT='S'
 AND E.CODNIV=C.CODNIV
 AND B.CODEMP=C.CODEMP
 and B.CODCON=G.CODCON
 AND A.CODCAR=B.CODCAR
 ORDER BY B.CODNIV,B.CODEMP";
	//print '<pre>'.$sql;exit;
        return $this->select($sql);
    }
	
	function rs($tipnom){
		$sql="select upper(nomnom) as nombre from NPASICAREMP where codnom='$tipnom'";
		return $this->select($sql);
	}
	
	function sr($tipnom){
		$sql="SELECT to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
	}
	
	function ss($tipnom){
		$sql="SELECT to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
		return $this->select($sql);
	}
	
	function sql2($tb2codemp,$tb2codcar){
		$sql="SELECT coalesce(SUM(MONTO),0) as VALOR FROM NPASICONEMP A,NPCONSUELDO B WHERE CODEMP ='$tb2codemp' AND CODCAR ='$tb2codcar' AND A.CODCON=B.CODCON";
		return $this->select($sql);
	}
	
	function sql3($tbcodemp,$tbcodcar){
		$sql="SELECT coalesce(SUM(MONTO),0) as VALOR FROM NPASICONEMP A,NPCONSUELDO B WHERE CODEMP ='$tbcodemp' AND CODCAR ='$tbcodcar' AND A.CODCON=B.CODCON";
		return $this->select($sql);
	}
	
	function sql4($tbcodcar,$tbcodemp){
		$sql="SELECT coalesce(ACUMULADO,0) as SALDO FROM NPASICONEMP WHERE CODCAR = '$tbcodcar' AND CODEMP='$tbcodemp' AND CODCON='$tbcodcon'";
		return $this->select($sql);
	}
	function sql5($tbcodcon){
		$sql=" SELECT CODTIPPRE as VALOR FROM NPTIPPRE WHERE CODCON='$tbcodcon'";
		return $this->select($sql);
	}
}

?>
