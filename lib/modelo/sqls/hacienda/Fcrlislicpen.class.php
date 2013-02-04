<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrlislicpen extends BaseClases
{

	function sqlp($licdes,$lichas)
  {
  	  $sql="SELECT
      					A.NUMLIC,A.NUMSOL,A.RIFCON,A.NOMNEG,A.CODTIPLIC,B.CODACT
						FROM
    					FCSOLLIC A,FCACTPIC B
						WHERE
     					A.NUMSOL>=('".$licdes."') AND
     					A.NUMSOL<=('".$lichas."') AND
     					A.NUMLIC IS NULL AND
     					A.STALIC<>'C' and
     					A.STALIC<>'N' and
     					A.STALIC<>'S' and
     					A.NUMSOL=B.NUMDOC
						GROUP BY
      					A.NUMLIC,A.NUMSOL,A.RIFCON,A.NOMNEG,A.CODTIPLIC,B.CODACT
						ORDER BY
      					A.NUMSOL";

	return $this->select($sql);
  }
  function sqlp1()
  {
   	  $sql= "select nomemp as nombrempresa from empresa where codemp='001'";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

}