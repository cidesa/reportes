<?php
require_once("../../lib/modelo/baseClases.class.php");
class Cprcompromisoext extends baseClases {

//   function Cprcompromiso() {
//    }

    public function sqlp($comprodes,$comprohas,$codmondes,$codmonhas){
    	$sql="SELECT A.REFCOMEXT,A.REFCOM,
              A.TIPCOM,
              TO_CHAR(A.FECCOM,'dd/mm/yyyy') AS FECCOM,
              A.MONCOM,
              --A.SALAJU,
              A.DESCOM,
              B.CODPRE,
              C.NOMPRE,
              B.MONIMP,
              D.CEDRIF,
              D.NOMBEN,
              B.MONAJU,e.nommon as nommon,a.valmon as valmon,
			  TO_CHAR(A.FECCOM,'yyyy') AS ANOPRE,
			  C.CODCTA
			  FROM CPCOMEXT A,CPIMPCOMEXT B, CPDEFTIT C, OPBENEFI D,TSDEFMON E
                WHERE
                A.CODMON=E.CODMON AND
              RTRIM(A.REFCOMEXT)>=RTRIM('".$comprodes."') AND
              RTRIM(A.REFCOMEXT)<=RTRIM('".$comprohas."') AND
              RTRIM(A.CODMON)>=RTRIM('".$codmondes."') AND
              RTRIM(A.CODMON)<=RTRIM('".$codmonhas."') AND                  

			  A.REFCOMEXT = B.REFCOMEXT AND
              B.CODPRE = C.CODPRE  AND
              A.CEDRIF=D.CEDRIF
			  ORDER BY A.REFCOMEXT,B.CODPRE,A.FECCOM,A.TIPCOM";
			 //print '<pre>'; print $sql;
		return $this->select($sql);
    }

    public function sql_contabb($compromiso){
		$sql="SELECT 
			  A.CODCTA,
			  SUM(B.MONIMP) AS TOTCTA,
			  C.DESCTA
			  FROM CPIMPCOMext B, CPDEFTIT A, CONTABB C
			  WHERE
			  TRIM(B.REFCOMext)=TRIM('".$compromiso."') AND
			  TRIM(A.CODCTA)=TRIM(C.CODCTA) AND
			  A.CODPRE=B.CODPRE
			  GROUP BY A.CODCTA, C.DESCTA";
			//  print '<pre>'; print $sql;
		return $this->select($sql);
    }

    function sql_cpniveles(){
    	$sql="SELECT
    		  CATPAR,
    		  CONSEC,
    		  NOMABR,
    		  NOMEXT,
    		  LONNIV,
    		  STANIV
    		  FROM CPNIVELES ORDER BY CONSEC";
		return $this->select($sql);
    }
}
?>