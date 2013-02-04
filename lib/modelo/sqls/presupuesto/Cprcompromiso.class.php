<?php
require_once("../../lib/modelo/baseClases.class.php");
class Cprcompromiso extends baseClases {

//   function Cprcompromiso() {
//    }

    public function sqlp($comprodes,$comprohas){
    	$sql="SELECT A.REFCOM,
              A.TIPCOM,
              TO_CHAR(A.FECCOM,'dd/mm/yyyy') AS FECCOM,
              A.MONCOM,
              A.SALAJU,
              A.DESCOM,
              B.CODPRE,
              C.NOMPRE,
              B.MONIMP,
              D.CEDRIF as CEDRIF,
              D.nomBEN as NOMBEN,
              B.MONAJU,
			  TO_CHAR(A.FECCOM,'yyyy') AS ANOPRE,
			  C.CODCTA
			  FROM CPCOMPRO A,CPIMPCOM B, CPDEFTIT C, OPBENEFI D
			  WHERE
              (A.REFCOM)>=('".$comprodes."') AND
              (A.REFCOM)<=('".$comprohas."') AND
			  A.REFCOM = B.REFCOM AND
              B.CODPRE = C.CODPRE  AND
              A.CEDRIF=D.CEDRIF
			  ORDER BY A.REFCOM,B.CODPRE,A.FECCOM,A.TIPCOM";
			 // print '<pre>'; print $sql;exit;
		return $this->select($sql);
    }

    public function sql_contabb($compromiso){
		$sql="SELECT 
			  A.CODCTA,
			  SUM(B.MONIMP) AS TOTCTA,
			  C.DESCTA
			  FROM CPIMPCOM B, CPDEFTIT A, CONTABB C
			  WHERE
			  TRIM(B.REFCOM)=TRIM('".$compromiso."') AND
			  TRIM(A.CODCTA)=TRIM(C.CODCTA) AND
			  A.CODPRE=B.CODPRE
			  GROUP BY A.CODCTA, C.DESCTA";
			//  print '<pre>'; print $sql;
		return $this->selectrecordset($sql);
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