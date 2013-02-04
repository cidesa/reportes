<?php
require_once("../../lib/modelo/baseClases.class.php");

class Precomext extends baseClases{
 function sqlp($fecprc1,$fecprc2,$tipprc1,$tipprc2,$pre1,$pre2,$codpre1,$codpre2,$codmon1,$codmon2,$comodin,$estatus)
  {
        if($estatus=="T"){

             $stacom=" AND A.FECCOM>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECCOM <=to_date('".$fecprc2."','dd/mm/yyyy')";
            $stacau=" AND A.FECCAU>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECCAU <=to_date('".$fecprc2."','dd/mm/yyyy')";
            $stapag=" AND A.FECPAG>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECPAG <=to_date('".$fecprc2."','dd/mm/yyyy')";
        }
        else if ($estatus=="A"){

             $stacom=" AND A.FECCOM>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECCOM <=to_date('".$fecprc2."','dd/mm/yyyy') AND (A.STACOM='A' OR (A.STACOM='N' AND A.FECANU>=to_date('".$fecprc2."','dd/mm/yyyy')))";
            $stacau=" AND A.FECCAU>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECCAU <=to_date('".$fecprc2."','dd/mm/yyyy') AND (A.STACAU='A' OR (A.STACAU='N' AND A.FECANU>=to_date('".$fecprc2."','dd/mm/yyyy')))";
            $stapag=" AND A.FECPAG>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECPAG <=to_date('".$fecprc2."','dd/mm/yyyy') AND (A.STAPAG='A' OR (A.STAPAG='N' AND A.FECANU>=to_date('".$fecprc2."','dd/mm/yyyy')))";
        }
        else if($estatus=="N"){
             $stacom=" AND A.STACOM='N' AND A.FECANU>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECANU <=to_date('".$fecprc2."','dd/mm/yyyy')";
            $stacau=" AND A.STACAU='N' AND A.FECANU>=to_date('".$fecprc1."','dd/mm/yyyy') AND A.FECANU <=to_date('".$fecprc2."','dd/mm/yyyy')";
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
               Mon_Aju, monto,nommon,valmon
               FROM (SELECT
                A.refcomext as referencia,
                RTRIM(A.descom) as descripcion,
                A.tipcom as tipo,
                to_char(A.feccom,'DD/MM/YYYY') as fecha,
                A.CEDRIF as cedrif,
                a.stacom as estat,
                RTRIM(B.CodPre) as codigo,
                B.monimp as imputado,
                B.monimp as comprometido,
(SELECT SUM(S.MONIMP)/COALESCE(VALMON,1) FROM CPCAUSAD R,
CPIMPCAU S WHERE 

 S.CODPRE=B.CODPRE AND 
S.REFCAU=R.REFCAU AND 
 R.FECCAU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND 
R.FECCAU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (R.STACAU='A' OR (R.STACAU='N' AND
 R.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY'))) AND S.REFERE=A.REFCOM) as causado,
(SELECT SUM(S.MONIMP) /COALESCE(VALMON,1)
FROM CPpagos R,CPimppag S WHERE

 S.CODPRE=B.CODPRE AND
 S.REFpag=R.REFpag AND 
 R.FECpag>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND 
R.FECpag<=TO_DATE('".$fecprc2."','DD/MM/YYYY') 
and (R.STApag='A' OR (R.STApag='N' 
AND R.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY'))) AND S.REFCOM=A.REFCOM) as pagado,				
(SELECT SUM(Y.MONAJU) 
FROM CPAJUSTE X,CPMOVAJU Y,CPDOCAJU Z WHERE 

Y.CODPRE=B.CODPRE AND 
X.REFAJU=Y.REFAJU AND 
X.TIPAJU=Z.TIPAJU AND 
Z.REFIER='C' AND X.FECAJU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') 
AND X.FECAJU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and 
(X.STAAJU='A' OR (X.STAAJU='N' AND X.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as Ajuste,

                (B.monimp-B.monaju)as Mon_Aju, c.nomben,         a.moncom as monto,e.nommon as nommon,a.valmon as valmon
                FROM
                CPCOMEXT as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
                CPIMPCOMEXT as B,
                CPDOCCOM as D,TSDEFMON AS E
                WHERE
                A.CODMON=E.CODMON AND
                A.TIPCOM=D.TIPCOM AND RTRIM(D.AFECOM)='S'
                AND A.REFCOMEXT = B.REFCOMEXT
                AND (A.TIPCOM >= ('".$tipprc1."') AND A.TIPCOM <= ('".$tipprc2."'))
                AND (A.REFCOMEXT)>=RTRIM('".$pre1."')  AND (A.REFCOMEXT) <=RTRIM('".$pre2."')
                AND (A.CODMON)>=RTRIM('".$codmon1."')  AND (A.CODMON) <=RTRIM('".$codmon2."')
                AND (B.CODPRE >=RTRIM('".$codpre1."') AND B.CODPRE<=RTRIM('".$codpre2."'))
                ".$stacom." $filtro
                  ORDER BY fecha,referencia asc,codigo,estat
                ) as J left outer join CPDEFTIT P on (RTRIM(J.CODIGO)=RTRIM(P.CODPRE))";
             // H::printR($sql); exit;
 return $this->select($sql);
    }
}
?>