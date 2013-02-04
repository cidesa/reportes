<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oce0409 extends baseClases
{
	function sqlp($coddes,$codhas,$periodo)
	{

$sql= "select tipo, cuenta,buscardescripcion(tipo,cuenta) as desccta, saldocta(tipo,cuenta,'00') as monanoact
                     from forcfgrepins where cuenta>='".$coddes."' and cuenta<='".$codhas."' and nrofor='0409' order by cuenta";
//H::PrintR($sql);exit;
	return $this->select($sql);
	}
}
?>
