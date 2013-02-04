<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrconvpag extends baseClases
{
	function sqlp($RIFDES)
	{

$sql= "select b.refcon,a.rifcon,a.nomcon,a.dircon,a.cedcon,a.telcon,
      				a.repcon, b.moncon,c.numdec,c.fueing,e.nomfue,d.nombre,
      				d.mondec,b.monini,b.monfin,b.totcuo
					from
    				fcconrep a,fcconpag b,fcdeucon c,fcdeclar d,fcfuepre e
					where
     				rtrim(a.rifcon)=rtrim('".$RIFDES."') and
     				a.rifcon=b.rifcon and
     				b.refcon=c.refcon and
     				c.numdec=d.numdec and
     				c.fecven = d.fecven and
     				d.fueing=e.codfue
					order by
     			    a.rifcon"  ; //H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
