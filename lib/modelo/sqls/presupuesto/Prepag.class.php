<?php
require_once("../../lib/modelo/baseClases.class.php");

class Prepag extends baseClases{
 function sqlp($fecprc1,$fecprc2,$tipprc1,$tipprc2,$pre1,$pre2,$codpre1,$codpre2,$comodin,$estatus)
  {

        if($estatus=="T"){

            $stapag=" AND A.FECPAG>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECPAG <=to_date('".$fecprc2."','dd/mm/yyyy')";
        }
        else if ($estatus=="A"){
            $stapag=" AND A.FECPAG>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECPAG <=to_date('".$fecprc2."','dd/mm/yyyy') AND (A.STAPAG='A' OR (A.STAPAG='N' AND A.FECANU>=to_date('".$fecprc2."','dd/mm/yyyy')))";
        }
        else if($estatus=="N"){

            $stapag=" AND A.STAPAG='N' AND A.FECANU>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECANU <=to_date('".$fecprc2."','dd/mm/yyyy')";
        }

        if ($comodin=="")
        {
            $filtro = "";
        }
        else
        {
            $filtro = "and B.CODPRE like '%$comodin%'";
        }

  	   $sql= " SELECT
               P.nompre,
               referencia,
               descripcion,
               tipo,
               fecha,
               cedrif,nomben,
               estat,
			   codigo,
			   imputado,
			   comprometido,
			   causado,
			   pagado,
			   Ajuste,
			   Mon_Aju, status, monto
               FROM (
				SELECT
				A.refpag as referencia,
				RTRIM(A.despag)as descripcion,
				A.tippag as tipo,
				to_char(A.fecpag,'dd/mm/yyyy') as fecha,
				A.CEDRIF as cedrif,
				a.stapag as estat,
				RTRIM(B.CodPre ) as codigo,
				B.monimp as imputado,
				B.monimp as comprometido,
				B.monIMP as causado,
				B.monIMP as pagado,
				(SELECT SUM(y.MONAJU) 
				   FROM CPAJUSTE X, CPMOVAJU Y, CPDOCAJU Z
			      WHERE X.REFERE=B.REFPAG AND 
				  Y.CODPRE=B.CODPRE AND 
				  x.refaju=y.refaju AND
				  X.TIPAJU=Z.TIPAJU AND 
				  Z.REFIER='G' AND 
				  X.FECAJU>=to_date('".$fecprc1."','dd/mm/yyyy') and X.FECAJU<=to_date('".$fecprc2."','dd/mm/yyyy') 
				  and (X.STAAJU='A' OR (X.STAAJU='N' AND X.FECANU >to_date('".$fecprc2."','dd/mm/yyyy'))) ) as Ajuste,
				(B.monimp-B.monaju) as Mon_Aju, B.staimp AS status, c.nomben,   	  a.monpag as monto
				FROM
				CPPAGOS as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
				CPIMPPAG as B,
				CPDOCPAG as D
				WHERE
				A.TIPPAG=D.TIPPAG
				AND RTRIM(D.AFEPAG)='S'
                AND A.REFPAG = B.REFPAG
                 AND (A.TIPPAG >=  RTRIM('".$tipprc1."') AND RTRIM(A.TIPPAG) <=  RTRIM('".$tipprc2."'))
                AND (A.REFPAG)>=RTRIM('".$pre1."') AND (A.REFPAG) <=RTRIM('".$pre2."')
                AND (B.CODPRE >=RTRIM('".$codpre1."') AND B.CODPRE<=RTRIM('".$codpre2."'))
                 ".$stapag."  $filtro ORDER BY fecha,referencia asc,codigo,estat
                ) as J left outer join CPDEFTIT P on (RTRIM(J.CODIGO)=RTRIM(P.CODPRE))";
        //      H::printR($sql); exit;
 return $this->select($sql);
	}
}
?>