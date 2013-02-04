<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrcontribuyente extends baseClases
{
	function sqlp($CODDES,$CODHAS)
	{

$sql=    "select	    distinct(a.rifcon),
						a.cedcon,
						a.nomcon,
						a.dircon,
						a.telcon,
						a.emacon,
						a.codsec,
						a.codpar
						from fcconrep a
						where  rtrim(a.rifcon)>=rtrim('".$CODDES."') and
							   rtrim(a.rifcon)<=rtrim('".$CODHAS."')
						order by a.rifcon limit 100";// H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
