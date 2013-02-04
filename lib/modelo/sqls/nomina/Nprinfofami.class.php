<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprinfofami extends baseClases{
	function sql($nom,$codesde,$codhasta){
		$sql="select DISTINCT b.codemp,a.cedfam,a.nomfam,
			B.CEDEMP as cedemp,
			B.NOMEMP as nomemp,to_char(B.FECNAC,'dd/mm/yyyy') as fecnac1, Extract(year from age(now(),B.FECNAC)) AS  edademp,
			(CASE WHEN B.SEXEMP ='F' THEN 'F' ELSE 'M' END)  as sexemp,
			A.CEDFAM as cedfam,
			A.NOMFAM as nomfam,
			(CASE WHEN A.SEXFAM ='F' THEN 'Femenino' WHEN A.SEXFAM ='M' then 'Masculino' END) as sexfam,
			to_char(A.FECNAC,'dd/mm/yyyy') as fecnac,
			Extract(year from age(now(),A.FECNAC)) AS  edafam,
			A.PARFAM as parfam,
			(CASE WHEN A.SEGHCM ='S' THEN 'SI' WHEN A.SEGHCM ='N' THEN 'NO' END) as seghcm,
			(select C.DESPAR from NPTIPPAR C where A.PARFAM = C.TIPPAR) as despar

			from NPASICAREMP C, nphojint b left outer join npinffam a on (a.codemp=b.codemp)
						WHERE C.CODEMP=B.CODEMP AND C.CODNOM='$nom'  AND
								B.CODEMP >= '$codesde' AND
							B.CODEMP <= '$codhasta' and b.staemp='A'
						ORDER BY B.CODEMP";
		return $this->select($sql);
	}
}
?>
