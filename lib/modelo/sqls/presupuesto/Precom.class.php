<?php
require_once("../../lib/modelo/baseClases.class.php");

class Precom extends baseClases{
 function sqlp($fecprc1,$fecprc2,$tipprc1,$tipprc2,$pre1,$pre2,$codpre1,$codpre2,$comodin,$estatus)
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
               Mon_Aju, monto
               FROM (SELECT
                A.refcom as referencia,
                RTRIM(A.descom) as descripcion,
                A.tipcom as tipo,
                to_char(A.feccom,'DD/MM/YYYY') as fecha,
                A.CEDRIF as cedrif,
                a.stacom as estat,
                RTRIM(B.CodPre) as codigo,
                B.monimp as imputado,
                B.monimp as comprometido,
(SELECT SUM(S.MONIMP) FROM CPCAUSAD R,CPIMPCAU S WHERE S.REFERE=B.REFCOM AND S.CODPRE=B.CODPRE AND S.REFCAU=R.REFCAU AND  R.FECCAU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND R.FECCAU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (R.STACAU='A' OR (R.STACAU='N' AND R.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as causado,
(SELECT SUM(S.MONIMP) FROM CPpagos R,CPimppag S WHERE S.REFcom=B.REFCOM AND S.CODPRE=B.CODPRE AND S.REFpag=R.REFpag AND  R.FECpag>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND R.FECpag<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (R.STApag='A' OR (R.STApag='N' AND R.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as pagado,				
(SELECT SUM(Y.MONAJU) FROM CPAJUSTE X,CPMOVAJU Y,CPDOCAJU Z WHERE X.REFERE=B.REFCOM AND Y.CODPRE=B.CODPRE AND X.REFAJU=Y.REFAJU AND  X.TIPAJU=Z.TIPAJU AND Z.REFIER='C' AND X.FECAJU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND X.FECAJU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (X.STAAJU='A' OR (X.STAAJU='N' AND X.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as Ajuste,

                (B.monimp-B.monaju)as Mon_Aju, c.nomben,         a.moncom as monto
                FROM
                CPCOMPRO as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
                CPIMPCOM as B,
                CPDOCCOM as D
                WHERE
                A.TIPCOM=D.TIPCOM AND RTRIM(D.AFECOM)='S'
                AND A.REFCOM = B.REFCOM
                AND (RTRIM(A.TIPCOM) >= RTRIM('".$tipprc1."') AND RTRIM(A.TIPCOM) <= RTRIM('".$tipprc2."'))
                AND (A.REFCOM)>=RTRIM('".$pre1."')  AND (A.REFCOM) <=RTRIM('".$pre2."')
                AND (B.CODPRE >=RTRIM('".$codpre1."') AND B.CODPRE<=RTRIM('".$codpre2."'))
                ".$stacom." $filtro

                UNION
                SELECT
                A.refcau as referencia,
                RTRIM(A.descau)as descripcion,
                A.tipcau as tipo,
                to_char(A.feccau,'dd/mm/yyyy') as fecha,
                A.CEDRIF as cedrif,
                a.stacau as estat,
                RTRIM(B.CodPre ) as codigo,
                B.monimp as imputado,
                B.monimp as comprometido,
                B.monIMP as causado,
(SELECT SUM(S.MONIMP) FROM CPpagos R,CPimppag S WHERE S.REFere=B.REFCau AND S.CODPRE=B.CODPRE AND S.REFpag=R.REFpag AND  R.FECpag>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND R.FECpag<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (R.STApag='A' OR (R.STApag='N' AND R.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as pagado,				
(SELECT SUM(Y.MONAJU) FROM CPAJUSTE X,CPMOVAJU Y,CPDOCAJU Z WHERE X.REFERE=B.REFCAU AND Y.CODPRE=B.CODPRE AND X.REFAJU=Y.REFAJU AND  X.TIPAJU=Z.TIPAJU AND Z.REFIER='A' AND X.FECAJU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND X.FECAJU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (X.STAAJU='A' OR (X.STAAJU='N' AND X.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as Ajuste,

                (B.monimp-B.monaju) as Mon_Aju, c.nomben, a.moncau as monto
                FROM
                CPCAUSAD as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
                CPIMPCAU as B,
                CPDOCCAU as D
                WHERE
                A.TIPCAU=D.TIPCAU AND RTRIM(D.AFECOM)='S'
                AND A.REFCAU = B.REFCAU
                AND (RTRIM(A.TIPCAU) >=  RTRIM('".$tipprc1."') AND RTRIM(A.TIPCAU) <=  RTRIM('".$tipprc2."'))
                AND (A.REFCAU)>=RTRIM('".$pre1."') AND (A.REFCAU) <=RTRIM('".$pre2."')
                AND (B.CODPRE >=RTRIM('".$codpre1."') AND B.CODPRE<=RTRIM('".$codpre2."'))
                ".$stacau." $filtro

                UNION
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
(SELECT SUM(Y.MONAJU) FROM CPAJUSTE X,CPMOVAJU Y,CPDOCAJU Z WHERE X.REFERE=B.REFPAG AND Y.CODPRE=B.CODPRE AND X.REFAJU=Y.REFAJU AND  X.TIPAJU=Z.TIPAJU AND Z.REFIER='G' AND X.FECAJU>=TO_DATE('".$fecprc1."','DD/MM/YYYY') AND X.FECAJU<=TO_DATE('".$fecprc2."','DD/MM/YYYY') and (X.STAAJU='A' OR (X.STAAJU='N' AND X.FECANU>=TO_DATE('".$fecprc2."','DD/MM/YYYY')))) as Ajuste,

                (B.monimp-B.monaju) as Mon_Aju, c.nomben, a.monpag as monto
                FROM
                CPPAGOS as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
                CPIMPPAG as B,
                CPDOCPAG as D
                WHERE
                A.TIPPAG=D.TIPPAG
                AND RTRIM(D.AFECOM)='S'
                AND A.REFPAG = B.REFPAG
                 AND (A.TIPPAG >=  RTRIM('".$tipprc1."') AND RTRIM(A.TIPPAG) <=  RTRIM('".$tipprc2."'))
                AND (A.REFPAG)>=RTRIM('".$pre1."') AND (A.REFPAG) <=RTRIM('".$pre2."')
                AND (B.CODPRE >=RTRIM('".$codpre1."') AND B.CODPRE<=RTRIM('".$codpre2."'))
                 ".$stapag."  $filtro ORDER BY fecha,referencia asc,codigo,estat
                ) as J left outer join CPDEFTIT P on (RTRIM(J.CODIGO)=RTRIM(P.CODPRE))";
               //H::printR($sql); exit;
 return $this->select($sql);
    }
}
?>