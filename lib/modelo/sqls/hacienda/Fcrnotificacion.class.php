<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrnotificacion extends BaseClases
{

	function sqlp($ANIO,$MES)
  {

  	  		$sql="SELECT A.RIFCON,C.NOMNEG,C.dirpri,
					    SUM(A.MONDEC) as mondec
					    FROM FCDECLAR A,FCDEFINS B,FCSOLLIC C
						WHERE
						to_number(to_char(a.fecven,'yyyy'),'9999')=to_number('".$ANIO."','9999') and
						to_number(to_char(a.fecven,'mm'),'99')=to_number('".$MES."','99') and
						c.STALIC<>'C' and
     					c.STALIC<>'N' and
     					c.STALIC<>'S'
						AND A.EDODEC<>'P'
						AND (A.FUEING=B.CODPIC
     					OR A.FUEING=B.CODAJUPIC)
						AND A.NUMREF=C.NUMLIC
						GROUP BY A.RIFCON,C.NOMNEG,c.dirpri";
      		//H::PrintR($sql);exit;

	return $this->select($sql);
  }
}