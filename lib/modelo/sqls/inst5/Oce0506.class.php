<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oce0506 extends baseClases

 {
	function sqlp($coddes,$codhas)
	{

   $sql= "select tipo, cuenta,desccta, saldocta(tipo,cuenta,'00') as monanoact
                     from forcfgrepins where  cuenta>='".$coddes."' and cuenta<='".$codhas."' and  nrofor='1226' order by orden";

	return $this->select($sql);
	}

	function sqlp1($I,$cuenta)
	{

$sql= "select saldocta(tipo,cuenta,'$I') as monanoact
                     from forcfgrepins where nrofor='1226' and cuenta='".$cuenta."'  ";

	return $this->select($sql);
	}

 function sqlue($cuenta)
	{

      $ano_ue=(date("Y")-1);
      $ano=sprintf($ano_ue);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldocta(tipo,cuenta,'00') as monulest
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='1226' order by orden";
   // H::PrintR($sql);print $esquema;//exit;
      return $this->select($sql,$esquema);
	}

    function sqlar($cuenta)
	{

      $ano_ar=(date("Y")-2);
      $ano=sprintf($ano_ar);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldoctareal(tipo,cuenta,'00') as monreal
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='1226' order by orden";

	  return $this->select($sql,$esquema);
	}


}
?>
