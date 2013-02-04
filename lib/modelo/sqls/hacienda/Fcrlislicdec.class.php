<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrlislicdec extends baseClases
{
	function sqlp($cod1,$cod2,$caj1,$caj2,$estatus,$anio)
	{

if ($estatus=='E')
			{
				$sql="SELECT A.NUMREF,E.RIFCON,E.NOMNEG,SUM(A.MONDEC) as suma,
						    SUM(CASE WHEN B.MONPAG IS NULL THEN A.AUTLIQ ELSE COALESCE(B.MONPAG,0) END) as pago
						    FROM FCDECLAR A LEFT OUTER JOIN FCDECPAG B ON A.NUMDEC=B.NUMDEC AND
						    A.NUMREF=B.NUMREF AND A.FECVEN=B.FECVEN AND A.NUMERO=B.NUMERO AND
						    A.MONDEC=B.MONDEC LEFT OUTER JOIN FCPAGOS C ON B.NUMPAG=C.NUMPAG,
						    FCDEFINS D,FCSOLLIC E
						    WHERE
						    A.modo='E' and
							A.NUMREF>=('".$cod1."') AND
							A.NUMREF<=('".$cod2."') AND
							E.CODTIPLIC>=('".$caj1."') AND
							E.CODTIPLIC<=('".$caj2."') AND
							A.ANODEC = ('".$anio."') AND
						    (RTRIM(A.FUEING)=RTRIM(D.CODPIC)
							OR RTRIM(A.FUEING)=RTRIM(D.CODAJUPIC)) AND
							A.NUMREF=E.NUMLIC AND
							COALESCE(C.EDOPAG,' ')<>'A' AND
							E.STALIC<>'C' and
     						E.STALIC<>'N' and
     						E.STALIC<>'S'
							group by a.numref,e.rifcon,e.nomneg
							order by e.nomneg,a.numref";
			}
			if ($estatus=='D'){
				$sql="SELECT A.NUMREF,E.RIFCON,E.NOMNEG,SUM(A.MONDEC) as suma,
						    SUM(CASE WHEN B.MONPAG IS NULL THEN A.AUTLIQ ELSE COALESCE(B.MONPAG,0) END) as pago
						    FROM FCDECLAR A LEFT OUTER JOIN FCDECPAG B ON A.NUMDEC=B.NUMDEC AND
						    A.NUMREF=B.NUMREF AND A.FECVEN=B.FECVEN AND A.NUMERO=B.NUMERO AND
						    A.MONDEC=B.MONDEC LEFT OUTER JOIN FCPAGOS C ON B.NUMPAG=C.NUMPAG,
						    FCDEFINS D,FCSOLLIC E
						    WHERE
						    A.modo='D' and
							A.NUMREF>=('".$cod1."') AND
							A.NUMREF<=('".$cod2."') AND
							E.CODTIPLIC>=('".$caj1."') AND
							E.CODTIPLIC<=('".$caj2."') AND
							A.ANODEC = ('".$anio."') AND
						    (RTRIM(A.FUEING)=RTRIM(D.CODPIC)
							OR RTRIM(A.FUEING)=RTRIM(D.CODAJUPIC)) AND
							A.NUMREF=E.NUMLIC AND
							COALESCE(C.EDOPAG,' ')<>'A' and
							E.STALIC<>'C' and
     						E.STALIC<>'N' and
     						E.STALIC<>'S'
							group by a.numref,e.rifcon,e.nomneg
							order by e.nomneg,a.numref";
			                }
// H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
