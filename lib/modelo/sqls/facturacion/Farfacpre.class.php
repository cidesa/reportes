<?php

require_once("../../lib/modelo/baseClases.class.php");

class Farfacpre extends baseClases
{

  function sqlp($coddes,$codhas,$codfacdes,$codfachas,$codartdes,$codarthas,$fecdes,$fechas)
  {
       $sql="SELECT
		A.REFFAC,
		A.FecAnu,
		to_char(A.FECFAC,'dd/mm/yyyy') as fecfac,
		A.CODCLI,
		D.DIRPRO AS DIRCLI,
		D.TELPRO AS TELCLI,
		A.MONFAC,
		A.MONDESC,
		--B.CODART,
		B.CANTOT,
		B.PRECIO,
		B.MONRGO,
		B.TOTART,
		B.DESART,
		D.NOMPRO AS NOMCLI,
		CASE WHEN A.STATUS='A' THEN 'Activo' WHEN
		A.STATUS='N' THEN 'Anulado' END as estatus,
		F.DESCONPAG,B.NRONOT,
        case when (select codart from farecart where codart=B.CODART)<>'' then B.TOTART else 0 end as monext
		FROM
		FAFACTUR A,
		FAARTFAC B,
		CAREGART C,
		FACLIENTE D,
		FACONPAG F
		WHERE
		A.CODCLI=D.CODPRO AND
		B.REFFAC=A.REFFAC AND
		B.CODART=C.CODART AND
		A.CODCONPAG=F.ID AND
		A.REFFAC >= '".$coddes."'  AND
		A.REFFAC <= '".$codhas."' AND
		A.CODCLI >= '".$codfacdes."' AND
		A.CODCLI <= '".$codfachas."' AND
		B.CODART >= '".$codartdes."' AND
		B.CODART <= '".$codarthas."' AND
		A.FECFAC >= to_date('".$fecdes."','yyyy/mm/dd') AND
		A.FECFAC <= to_date('".$fechas."','yyyy/mm/dd')
		ORDER BY  A.REFFAC ";

//print '<pre>';print $sql;exit;
   return $this->select($sql);
  }
}
?>
