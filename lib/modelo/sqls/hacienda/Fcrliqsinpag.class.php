<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrliqsinpag extends BaseClases
{
	function sqlp($fecdes,$fechas,$cajerodes,$cajerohas,$codempdes,$codemphas,$fuendes,$fuenhas)
	{


            $sql= "Select
						a.nrocon,
						to_char(a.fecreg,'dd/mm/yyyy') as fecreg,
						substr(d.nomfue,1,30) as nomfue,
						a.rifcon,
						substr(a.nomcon,1,30) as nomcon,
						a.monimp,b.monpag,b.numpag,
						a.funrec
						from fcotring a left outer join fcdecpag b
						on rtrim(a.nrocon)=rtrim(substr(b.numdec,3))
						left outer join fcpagos c on b.numpag=c.numpag,
						fcfuepre d
						where (b.numdec is null or c.edopag='A')
						and  a.FECREG>=to_date('".$fecdes."','yyyy-mm-dd')
						AND	a.FECREG<=to_date('".$fechas."','yyyy-mm-dd')
						AND	a.RIFCON>=('".$codempdes."')
						AND	a.RIFCON<=('".$codemphas."')
						AND rtrim(a.funrec)>=rtrim('".$cajerodes."')
						and rtrim(a.funrec)<=rtrim('".$cajerohas."')
						and	d.codfue>=('".$fuendes."')
						and	d.codfue<=('".$fuenhas."')
						and a.codfue=d.codfue
						group by a.nrocon,a.fecreg,d.nomfue,a.rifcon,a.nomcon,a.monimp,b.monpag,
      					b.numpag,a.funrec
						order by a.fecreg,a.nrocon";

			     // H::PrintR($sql);exit;
	return $this->select($sql);
	}
}
?>
