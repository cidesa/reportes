<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catinfdet extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT A.CODCATANT AS NUMERO,TO_CHAR(A.FECREG,'dd/mm/yyyy') AS FECHA,A.FOLIO AS FOLIO,
  	(a.coddivgeo||a.nrocas) as codcatastral, a.codcatant as codanterior,
	A.LINNOR AS LINORTE,A.LINSUR AS LINSUR,A.LINESTE AS LINESTE,A.LINOES AS LINOESTE,
	B.VALOR AS VALOR,B.DIMENSIONES AS DIMENSIONES,C.COSTO AS COSTO,D.METARE AS METARE,
	E.VALOR AS VALOR2,E.CATUSOESP_ID AS CATUSO,a.id as id,
	a.catbarurb_id as codurba,a.cattramofro_id as tramofro, a.cattramolat_id as codlat1,
        a.cattramolat2_id as codlat2,a.edicas as edicas

	FROM
	CATREGINM A
	    LEFT OUTER JOIN CATCOSAVAL   C ON (A.CATUSOESP_ID=C.CATUSOESP_ID AND A.CODDIVGEO=C.CODDIVGEO)
	    LEFT OUTER JOIN CATUSOESPINM E ON (A.CATUSOESP_ID=E.CATUSOESP_ID)
	    LEFT OUTER JOIN CATCARCONINM D ON (D.CATREGINM_ID=E.CATREGINM_ID)
	    LEFT OUTER JOIN CATCARTERINM B ON (B.CATREGINM_ID=D.CATREGINM_ID and B.CATREGINM_ID=E.CATREGINM_ID)
				WHERE
    		    TRIM(a.coddivgeo||a.nrocas) >= TRIM('".$coddes."') and
                TRIM(a.coddivgeo||a.nrocas) <= TRIM('".$codhas."') order by a.coddivgeo||a.nrocas";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
    function sqlp1($codigo)
  {
  	 $sql= "select a.cedrif as cedula,a.prinom as prinombre,a.segnom as segnombre,a.priape as priapellido,a.segape as segapellido,
       a.tipper as tipo, a.telper as telefono
 from catregper a, catperinm b
  where

	b.catreginm_id= $codigo and
	a.id=b.catregper_id and
	b.conocu='P'"; //H::PrintR($sql); exit;

   return $this->select($sql);
  }
      function sqlp2($codigo)
  {
  	 $sql= "select nombarurb as urbani
       from catbarurb
       where
        id=$codigo"; //H::PrintR($sql); exit;

   return $this->select($sql);
  }
   function sqlp3($codigo)
  {
  	 $sql= "select nomtramo as tramo
         from cattramo
          where
           id= $codigo  ";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
  function sqlp4($codigo)
  {
  	 $sql= "select a.cedrif as cedula,a.prinom as prinombre,a.segnom as segnombre,a.priape as priapellido,a.segape as segapellido,
       a.tipper as tipo, a.telper as telefono
 from catregper a, catperinm b
  where

	b.catreginm_id= $codigo  and
	a.id=b.catregper_id and
	b.conocu='A'"; //H::PrintR($sql); exit;

   return $this->select($sql);
  }


}
?>
