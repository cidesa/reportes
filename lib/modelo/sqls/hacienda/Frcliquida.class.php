<?php
require_once("../../lib/modelo/baseClases.class.php");

class Frcliquida extends baseClases
{
	function sqlp($CODDES,$CODHAS)
	{

$sql= " select   		a.numpag,
						to_char(a.fecpag,'dd/mm/yyyy') as fecpag,
						a.rifcon,
						a.monpag,
						a.despag,
						b.nomcon,
						b.dircon,
						c.mondec,
						to_char(c.fecven,'dd/mm/yyyy') as fecven,
						d.nombre,
						d.mondec as monrec,
						d.mora,
						e.fueing,
						e.nomfue,
						e.codfue,
						f.marveh,
						f.modveh,
						f.plaveh,
						f.colveh
						from fcpagos a, fcconrep b,fcdecpag c,fcdeclar d, fcfuepre e, fcregveh f
						where trim(a.numpag)=trim(c.numpag)
							and trim(c.numdec)=trim(d.numdec)
							and trim(c.numref)=trim(d.numref)
							and trim(c.fecven)=trim(d.fecven)
							and trim(d.fueing)=trim(e.codfue)
							and trim(a.rifcon)=trim(b.rifcon) and
						    rtrim(a.rifcon)>=rtrim('".$CODDES."') and
							trim(f.rifcon)=trim(a.rifcon) and
						    rtrim(a.rifcon)<=rtrim('".$CODHAS."')
						order by a.numpag,c.fecven limit 10" ;//H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
