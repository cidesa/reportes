<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farestado extends baseClases
{
	function sqlp($coddes,$codhas,$codpaides,$codpaihas)
	{

$sql= "SELECT
a.id,b.nompai, b.id as codpais
FROM FAESTADO A,FAPAIS B
WHERE
a.fapais_id=b.id AND
a.fapais_id>='".$codpaides."' and
a.fapais_id<='".$codpaihas."' and
a.id >= '".$coddes."' AND
a.id <= '".$codhas."'
ORDER BY b.id";
//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp1($codpais)
	{

$sql= "SELECT
a.id,
a.nomedo
FROM FAESTADO A,FAPAIS B
WHERE
a.fapais_id='".$codpais."' and
a.fapais_id=b.id
ORDER BY a.nomedo";
return $this->select($sql);
	}

}
?>
