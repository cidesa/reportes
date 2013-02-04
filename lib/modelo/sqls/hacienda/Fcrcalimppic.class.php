<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrcalimppic extends BaseClases
{

	function sqlp($LICDES,$LICHAS,$FECDES,$FECHAS)
  {
  	  $sql="SELECT DISTINCT A.CODACT,B.DESACT,B.AFOACT,A.MONACT,A.NUMDOC,
                        A.ANODEC as fec,D.RIFCON,D.NOMCON,SUBSTR(D.NUMLIC,4,3) as RUTA,
                        SUBSTR(D.NUMLIC,8,4) as UBICA,A.MODO,
                        (CASE WHEN A.MONACT*B.AFOACT/100 < B.MINTRI*C.VALUNITRI THEN
                        B.MINTRI*C.VALUNITRI ELSE A.MONACT*B.AFOACT/100  END) AS DEUDA
                        FROM FCACTPIC A,FCACTCOM B, FCDEFINS C,FCSOLLIC D
                        WHERE
						A.NUMDOC>=('".$LICDES."') AND
						A.NUMDOC <=('".$LICHAS."') AND
                        A.ANODEC>=('".$FECDES."') AND
                        A.ANODEC<=('".$FECHAS."') AND
                        A.CODACT=B.CODACT AND
                        A.ANODEC=B.ANOACT AND
                        A.NUMDOC=D.NUMLIC AND
                        D.STALIC<>'C' and
     					D.STALIC<>'N' and
     					D.STALIC<>'S'
                        ORDER BY A.NUMDOC,D.RIFCON,A.MODO";//H::PrintR($sql);exit;

	return $this->select($sql);
  }
}