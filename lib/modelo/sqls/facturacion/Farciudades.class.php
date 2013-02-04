<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farciudades extends baseClases
{
	function sqlp($codpaides,$codpaihas,$coddes,$codhas,$codciudes,$codciuhas)
	{

$sql= "select a.id as codpais, a.nompai as nompai, b.id as codedo, b.nomedo, c.id as codciudad, c.nomciu
			from fapais a, faestado b, faciudad c
			where
			 a.id  = b.fapais_id    and
			 b.id  = c.faestado_id  and
			(a.id) >= '".$codpaides."' and
			(a.id) <= '".$codpaihas."' and
			(b.id) >= '".$coddes."' and
			(b.id) <= '".$codhas."' and
			(c.id) >= '".$codciudes."'and
			(c.id) <='".$codciuhas."'
			 order by c.id";
//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp1($codpais)
	{
$sql= "select a.id as codpais, a.nompai as nompai, b.id as codedo, b.nomedo, c.id as codciudad, c.nomciu
			from fapais a, faestado b, faciudad c
			where
			 (a.id) = '".$codpais."' and
			 a.id  = b.fapais_id    and
			 b.id  = c.faestado_id
			 order by c.id";

			//H::PrintR($sql);
return $this->select($sql);
	}


	function sqlp2($codedo)
	{
$sql= "select a.id as codpais, a.nompai as nompai, b.id as codedo, b.nomedo, c.id as codciudad, c.nomciu
			from fapais a, faestado b, faciudad c
			where
			(b.id) = '".$codedo."' and
			 a.id  = b.fapais_id    and
			 b.id  = c.faestado_id
			 order by c.id";
return $this->select($sql);
	}

}
?>
