<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oce0406 extends baseClases

 {
	function sqlp($coddes,$codhas)
	{

   $sql= "select tipo, cuenta,buscardescripcion(tipo,cuenta) as desccta, saldocta(tipo,cuenta,'00') as monanoact
                     from forcfgrepins where  cuenta>='".$coddes."' and cuenta<='".$codhas."' and  nrofor='0406' order by orden";
//H::PrintR($sql);exit;
	return $this->select($sql);
	}

	function sqlp1($I,$cuenta)
	{

$sql= "select saldocta(tipo,cuenta,'$I') as monanoact
                     from forcfgrepins where nrofor='0406' and cuenta='".$cuenta."'  ";
//H::PrintR($sql);exit;
	return $this->select($sql);
	}

 function sqlue($cuenta)
	{

      $ano_ue=(date("Y")-1);
      $ano=sprintf($ano_ue);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldocta(tipo,cuenta,'00') as monulest
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='0406' order by orden";
   // H::PrintR($sql);print $esquema;//exit;
      return $this->select($sql,$esquema);
	}

    function sqlar($cuenta)
	{

      $ano_ar=(date("Y")-2);
      $ano=sprintf($ano_ar);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldoctareal(tipo,cuenta,'00') as monreal
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='0406' order by orden";

	  return $this->select($sql,$esquema);
	}


}
?>
