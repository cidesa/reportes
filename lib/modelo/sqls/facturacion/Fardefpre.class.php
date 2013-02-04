<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardefpre extends baseClases
{
	function sqlp($CODDES,$CODHAS,$CODPDES,$CODPHAS,$FECHAMIN,$FECHAMAX)
	{
		$sql="
			select 
			A.CODART,
			B.CODBAR, 
			B.DESART,
			A.DESPVP,
			A.PVPART, 
			COALESCE(D.MONRGO,0) AS POR_IVA,
			ROUND((A.PVPART * COALESCE(D.MONRGO,0) /100),2) AS MONTO_IVA,
			ROUND(A.PVPART + (A.PVPART * COALESCE(D.MONRGO,0) /100),2) AS PVP_MAS_IVA,
			to_char(A.FECDES,'DD/MM/YYYY') as fecdes,
			to_char(A.FECHAS,'DD/MM/YYYY') as fechas
			from faartpvp A left outer join 
			(select codart, monrgo, ra.codrgo from farecart ra,farecarg re where ra.codrgo =  re.codrgo) D on (A.codart = D.codart),
			caregart B
			where	
				A.CODART = B.CODART and
				A.CODART >= '".$CODDES."' AND
				A.CODART <= '".$CODHAS."' AND
				A.ID >= '".$CODPDES."' AND
				A.ID <= '".$CODPHAS."' AND
				A.FECDES >= '".$FECHAMIN."' AND
				A.FECHAS <= '".$FECHAMAX."'
			ORDER BY A.CODART, A.PVPART, A.DESPVP";

		//H::PrintR($sql);
		return $this->select($sql);
	}
}
?>
