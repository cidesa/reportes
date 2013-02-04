<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrinmuebles extends baseClases
{
	function sqlp($CODDES,$CODHAS)
	{
     $sql= "SELECT 	a.codcatinm,a.nroinm,a.dirinm,a.rifcon,a.nomcon,b.codzon,
								b.codtip,
								b.coduso,
								deszon,
								b.destip,
								b.usoinm,
								b.anual
						FROM FCREGINM a, fcinmcam B
						WHERE
						a.nroinm=b.nroinm and
						RTRIM(a.codcatinm)>=RTRIM('".$CODDES."') AND
					    RTRIM(a.codcatinm)<=RTRIM('".$CODHAS."')
						ORDER BY a.codcatinm,a.nroinm limit 100"; //H::PrintR($sql); exit;
		return $this->select($sql);
	}

}
?>
