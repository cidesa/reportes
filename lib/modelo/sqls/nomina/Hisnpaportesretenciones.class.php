<?php
require_once("../../lib/modelo/baseClases.class.php");

class Hisnpaportesretenciones extends baseClases
{

    function sqlp($fecnomdes,$fecnomhas,$codtipapodes,$codtipapohas,$codempdes,$codemphas,$tipnomdes,$tipnomhas)//DATOS DEL EMPLEADO
	{
		$sql = "SELECT
						DISTINCT
						D.CODTIPAPO as codtipapo,D.DESTIPAPO as destipapo,D.PORAPO,D.PORRET,E.CODNOM as CODNOMAPO,
						A.CODEMP as codemp,
						B.CEDEMP as cedemp,
						A.CODNOM,
						A.CODCAR as codcar,
						to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
						B.NOMEMP as nomemp,
						B.NACEMP,
						to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
						B.SEXEMP as sexemp,
						B.CODNIV,F.CUENTA_BANCO as ctalph,b.numcuefid,
						substr(A.CODCAT,1,2) as codcat,
						(select coalesce(SUM(monto),0) as valor from nphiscon f, npconsalint g
							where
							f.codnom=a.codnom and
							f.codnom=g.codnom and
							f.codcon=g.codcon and
							f.codemp=a.codemp and
							f.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
							f.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy')) as monsueldo,
						(SELECT coalesce(SUM(monto),0) as ELMONTO FROM NPHISCON H, NPCONTIPAPORET I
							 WHERE
							 I.CODTIPAPO=D.CODTIPAPO AND
							 H.CODNOM=I.CODNOM AND
							 H.CODCON=I.CODCON AND
							 I.TIPO='R' AND
							 H.CODEMP=A.CODEMP AND H.CODNOM=A.CODNOM and
							 H.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
							 H.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy')) as monapoemp,
						(SELECT coalesce(SUM(MONTO),0) as ELMONTO FROM NPHISCON H, NPCONTIPAPORET I
							 WHERE
							 I.CODTIPAPO=D.CODTIPAPO AND
							 H.CODNOM=I.CODNOM AND
							 H.CODCON=I.CODCON AND
							 I.TIPO='A' AND
							 H.CODEMP=A.CODEMP AND H.CODNOM=A.CODNOM and
							 H.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
							 H.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy')) as monapopat
						FROM
						NPHISCON  A left outer join NPEMPLEADOS_BANCO F on A.CODEMP = F.CODEMP AND
						A.CODNOM = F.CODNOM, NPHOJINT B, NPTIPAPORTES D,NPCONTIPAPORET E
						WHERE
						A.CODEMP = B.CODEMP AND
						A.CODNOM = E.CODNOM AND
						A.CODCON = E.CODCON AND
						D.CODTIPAPO = E.CODTIPAPO AND
						D.CODTIPAPO>='$codtipapodes' AND
						D.CODTIPAPO<='$codtipapohas'
						AND  B.CODEMP >='$codempdes'
						AND  B.CODEMP <='$codemphas'
						AND  A.CODNOM >= '$tipnomdes'
						AND  A.CODNOM <= '$tipnomhas'
						AND A.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy')
						AND A.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy')
						GROUP BY D.CODTIPAPO,D.DESTIPAPO,D.PORAPO,D.PORRET,E.CODNOM,b.numcuefid,
						A.CODEMP,B.CEDEMP,A.CODNOM,A.CODCAR,B.NOMEMP,B.NACEMP,B.CODNIV,substr(A.CODCAT,1,2),
						B.FECNAC,F.CUENTA_BANCO,B.SEXEMP,coalesce(FECREI,FECING)
						ORDER BY D.CODTIPAPO,A.CODNOM,substr(A.CODCAT,1,2),B.CEDEMP";
							
					
		
		return $this->select($sql);
	}
	
	function sqlp2($fecnomdes,$fecnomhas,$tipnomdes,$tipnomhas,$codempdes,$codemphas)
	{
		$sql="SELECT distinct
						count(distinct a.codemp) as canemp,
						sum((SELECT coalesce(SUM(MONTO),0) as ELMONTO FROM NPHISCON H, NPCONTIPAPORET I
							 WHERE
							 I.CODTIPAPO=D.CODTIPAPO AND
							 H.CODNOM=I.CODNOM AND
							 H.CODCON=I.CODCON AND
							 I.TIPO='A' AND
							 H.CODEMP=A.CODEMP AND H.CODNOM=A.CODNOM and
							 H.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy') and
							 H.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy'))) as totope
						FROM
						NPHISCON  A left outer join NPEMPLEADOS_BANCO F on A.CODEMP = F.CODEMP AND
						A.CODNOM = F.CODNOM, NPHOJINT B, NPTIPAPORTES D,NPCONTIPAPORET E
						WHERE
						A.CODEMP = B.CODEMP AND
						A.CODNOM = E.CODNOM AND
						A.CODCON = E.CODCON AND
						D.CODTIPAPO = E.CODTIPAPO 
						AND  A.CODNOM >= '$tipnomdes'
						AND  A.CODNOM <= '$tipnomhas'
						AND  B.CODEMP >= '$codempdes'
						AND  B.CODEMP <= '$codemphas'
						AND A.FECNOM >= to_date('$fecnomdes','dd/mm/yyyy')
						AND A.FECNOM <= to_date('$fecnomhas','dd/mm/yyyy')";
						
				
		return $this->select($sql);
	}
	
	
	function CFnomnom($tipnom)
	{
			$sql="SELECT DISTINCT(NOMNOM) as nombre
									FROM NPNOMINA WHERE CODNOM = '$tipnom'";
			return $this->select($sql);
	}
	
	function CFfecha($tipnom,$num)
	{
		if ($num==1)
		{
		$sql="SELECT to_char(ULTFEC,'dd/mm/yyyy') as VALOR FROM NPNOMINA WHERE CODNOM='$tipnom'";
		return $this->select($sql);
		}
		else{
		$sql="SELECT to_char(profec,'dd/mm/yyyy') as VALOR FROM NPNOMINA WHERE CODNOM='$tipnom'";
		return $this->select($sql);
		}
	}
}