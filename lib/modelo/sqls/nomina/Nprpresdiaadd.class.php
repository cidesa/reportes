<?php 
require_once("../../lib/modelo/baseClases.class.php");

class Nprpresdiaadd extends baseClases{
	
	function sql($tipnom,$tipnom2){
		$sql=" SELECT DISTINCT A.CODTIPAPO as codtipapo,A.DESTIPAPO as destipapo,(A.PORAPO) as porapo,(A.PORRET) as porret,B.CODNOM as CODNOMAPO, d.nomnom
								FROM NPTIPAPORTES A,NPCONTIPAPORET B, npdiaadicnom c , npnomina d WHERE
								A.CODTIPAPO=B.CODTIPAPO AND
								b.codnom=c.codnom AND b.codcon=c.codcon and
								B.CODNOM>='$tipnom' and B.CODNOM<='$tipnom2' and B.CODNOM=D.CODNOM";
		return $this->select($sql);
	}
	function sql2($especial,$tipnomesp,$tbcodnomapo,$codempdes,$codemphas,$catdes,$cathas,$fecreg1,$fecreg2){
		if ($especial == 'S') {
			$especial = " a.especial = 'S' AND
					A.CODNOMESP = '$tipnomesp' AND
			 ";
			$especial2 = " a.especial = 'S' AND
					A.CODNOMESP = '$tipnomesp' AND
			 ";
		} else {
			if ($especial == 'N')
				$especial = " a.especial = 'N' AND --A.CODCON<>'A03' AND";
			else
				if ($especial == 'T')
					$especial = "A.CODCON<>'A03' AND";
		}
		$sql="select codemp as codemp,cedemp,CODNOM,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,sum(monto) as monto  ,cast(REPLACE(cedemp,'.', '') as int ) from (select distinct codemp as codemp,cedemp,CODNOM,codcar,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,monto,cast(REPLACE(cedemp,'.', '') as int ) from ((SELECT
									DISTINCT
									A.CODEMP as codemp,
									B.CEDEMP as cedemp,
									A.CODNOM,
									A.CODCAR as codcar,
									SUM(A.monto) as MONTO,
									to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
									B.NOMEMP as nomemp,
									B.NACEMP,
									to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
									B.SEXEMP as sexemp,
									B.CODNIV, cast(REPLACE(b.cedemp,'.', '') as int ), '0014' as codtipapor
									 FROM
									   nphiscon  A,NPHOJINT B, npdefcpt e, npconsalint d
									 WHERE
									 " . $especial . "
									B.CODEMP = A.CODEMP and A.codcon = d.codcon and A.codnom = d.codnom
									--AND e.opecon='A'
									AND  A.CODNOM = '$tbcodnomapo'
									AND  B.CODEMP >=  '$codempdes'
									AND  B.CODEMP <= '$codemphas'
									and a.codcat >= '$catdes'
									and a.codcat <= '$cathas' AND
									A.fecnom >= to_date('$fecreg1','dd/mm/yyyy') AND A.fecnom <= to_date('$fecreg2','dd/mm/yyyy') and
			                        a.codcon=e.codcon   and ( montorethist('0014','A',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') +  montorethist('0014','R',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') )> 0
									GROUP BY A.CODEMP, B.CEDEMP, A.CODNOM, A.CODCAR, to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') ,
				                    B.NOMEMP , B.NACEMP, to_char(B.FECNAC,'dd/mm/yyyy') , B.SEXEMP ,B.CODNIV, a.codcat order by cast(REPLACE(b.cedemp,'.', '') as int ) )
			union all
					             (    SELECT
									DISTINCT
									A.CODEMP as codemp,
									B.CEDEMP as cedemp,
									A.CODNOM,
									A.CODCAR as codcar,
									SUM(A.monto) as MONTO,
									to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
									B.NOMEMP as nomemp,
									B.NACEMP,
									to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
									B.SEXEMP as sexemp,
									B.CODNIV, cast(REPLACE(b.cedemp,'.', '') as int ), '0013' as codtipapor
									 FROM
									   nphiscon  A,NPHOJINT B, npdefcpt e, npconsalint d
									 WHERE
									  " . $especial . "
									B.CODEMP = A.CODEMP and A.codcon = d.codcon and A.codnom = d.codnom
									--AND e.opecon='A'
									AND  A.CODNOM = '$tbcodnomapo'
									AND  B.CODEMP >=  '$codempdes'
									AND  B.CODEMP <= '$codemphas'
									and a.codcat >= '$catdes'
									and a.codcat <= '$cathas' AND
									A.fecnom >= to_date('$fecreg1','dd/mm/yyyy') AND A.fecnom <= to_date('$fecreg2','dd/mm/yyyy') and
			                        a.codcon=e.codcon   and ( montorethist('0013','A',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') +  montorethist('0013','R',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') )> 0
									GROUP BY A.CODEMP, B.CEDEMP, A.CODNOM, A.CODCAR, to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') ,
				                    B.NOMEMP , B.NACEMP, to_char(B.FECNAC,'dd/mm/yyyy') , B.SEXEMP ,B.CODNIV, a.codcat order by cast(REPLACE(b.cedemp,'.', '') as int  )
									) )a group by
									codemp,cedemp,CODNOM,codcar,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,monto
			                      )a group by
			codemp,cedemp,CODNOM,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV  order by cast(REPLACE(cedemp,'.', '') as int )";
		
		return $this->select($sql);
	}
	
	function sql4($especial,$tipnomesp,$tb2codtipapor,$tb2codemp,$fecreg1,$fecreg2){
		
		if ($especial == 'S'){
			$especial2 = " a.especial = 'S' AND
					A.CODNOMESP = '$tipnomesp' AND
			 ";
		}
		$sql="SELECT SUM(monto) as ELMONTO FROM nphiscon A, NPHOJINT B, NPCONTIPAPORET C
															 WHERE
															 C.CODTIPAPO='$tb2codtipapor' AND
															 A.CODNOM=C.CODNOM AND
															 A.CODCON=C.CODCON AND
															 C.TIPO='R' AND
															 B.CODEMP=A.CODEMP and ".$especial2 . "
															 B.CODEMP='$tb2codemp' and
													         a.FECNOM>=to_date('$fecreg1','dd/mm/yyyy') AND
													         a.FECNOM<=to_date('$fecreg2','dd/mm/yyyy')";
		return $this->select($sql);
	}
	
	function sql5_(){
		$sql="SELECT SUM(monto) as ELMONTO FROM nphiscon A, NPHOJINT B, NPCONTIPAPORET C
																 WHERE
																 C.CODTIPAPO='0014'  AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP and  " . $especial2 . "
																 B.CODEMP='$tb2codemp'";
		
		return $this->select($sql);
	}
	function sql5($tb2codemp,$fecreg1,$fecreg2,$tbcodcar){
		$sql="select sum (ELMONTO) as ELMONTO from (SELECT SUM(MONTO) as  ELMONTO
																 FROM NPCONTIPAPORET C, NPHOJINT B, NPHISCON A
																 WHERE
																 C.CODTIPAPO='0014' AND
																 B.CODEMP='$tb2codemp' AND
																 FECNOM>=to_date('$fecreg1','dd/mm/yyyy') AND
														  		 FECNOM<=to_date('$fecreg2','dd/mm/yyyy') AND
																 A.CODCAR='$tbcodcar' AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP
																 union
																 SELECT SUM(MONTO) as  ELMONTO
																 FROM NPCONTIPAPORET C, NPHOJINT B, NPHISCON A
																 WHERE
																 (C.CODTIPAPO='0013' or C.CODTIPAPO='0014')  and
																 B.CODEMP='$tb2codemp' AND
																 FECNOM>=to_date('$fecreg1','dd/mm/yyyy') AND
														  		 FECNOM<=to_date('$fecreg2','dd/mm/yyyy') AND
															--	 A.CODCAR='$tb2codcar' AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP)a";
		
		return $this->select($sql);
	}
}

?>