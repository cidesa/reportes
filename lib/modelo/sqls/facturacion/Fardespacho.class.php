<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardespacho extends baseClases
{
	function sqlp($despdes,$desphas,$clides,$clihas,$fecdes,$fechas,$estatus,$caso)
	{

       if ($caso == 1)
		     {
		        $sql = "select
				distinct (a.dphart) as dphart,
				to_char(a.fecdph,'dd/mm/yyyy') as fecdph,
				a.desdph as desdph,
				a.codcli as codcli,
				(case when a.stadph = 'A' then 'Activa' when a.stadph = 'N' then 'Anulada' end) as stadph,
				a.codalm as codalm,
				a.mondph as mondph,
				a.obsdph as obsdph,
				a.fordesp as fordesp,
				--b.codart as codart,
				--b.cantot as cantot,
				--b.candph precio as precio,
				--b.montot as montot,
				--b.numlot as numlot,
				--c.desart as desart,
				--c.cospro as cospro,
				d.nompro as nompro,
				d.rifpro as rifpro,
				d.dirpro as dirpro,
				d.telpro as telpro,
				e.nomdes as nomdes
				--f.deslot as deslot,
				--f.fecven as fecven
				from cadphart a,
				--caartdph b,
				--caregart c,
				facliente d,
				fafordes e,
				fadeflot f
				where --b.dphart=a.dphart and
				a.codcli=d.codpro and
				--b.codart=c.codart and
			--	a.fordesp=e.id and
				--b.codart=f.codart and
				a.codalm = f.codalm and
				rtrim(a.dphart) >= '".$despdes."' and
				rtrim(a.dphart) <= '".$desphas."' and
				a.codcli >= '".$clides."' and
				a.codcli <= '".$clihas."' and
				a.fecdph >= '".$fecdes."' and
				a.fecdph <= '".$fechas."' --and
				--(a.stadph   = :sta1 or
				--a.stadph  = :sta2 )
				order by a.dphart				";
		     }
		else
             {
		        $sql = "select
				distinct (a.dphart) as dphart,
				to_char(a.fecdph,'dd/mm/yyyy') as fecdph,
				a.desdph as desdph,
				a.codcli as codcli,
				(case when a.stadph = 'A' then 'Activa' when a.stadph = 'N' then 'Anulada' end) as stadph,
				a.codalm as codalm,
				a.mondph as mondph,
				a.obsdph as obsdph,
				a.fordesp as fordesp,
				--b.codart as codart,
				--b.cantot as cantot,
				--b.candph precio as precio,
				--b.montot as montot,
				--b.numlot as numlot,
				--c.desart as desart,
				--c.cospro as cospro,
				d.nompro as nompro,
				d.rifpro as rifpro,
				d.dirpro as dirpro,
				d.telpro as telpro,
				e.nomdes as nomdes
				--f.deslot as deslot,
				--f.fecven as fecven
				from cadphart a,
				--caartdph b,
				--caregart c,
				facliente d,
				fafordes e,
				cadefalm  f
				where --b.dphart=a.dphart and
				a.codcli=d.codpro and
				--b.codart=c.codart and
				--a.fordesp=e.id and
				--b.codart=f.codart and
			--	a.codalm = f.codalm and
				rtrim(a.dphart) >= '".$despdes."' and
				rtrim(a.dphart) <= '".$desphas."' and
				a.codcli >= '".$clides."' and
				a.codcli <= '".$clihas."' and
				a.fecdph >= '".$fecdes."' and
				a.fecdph <= '".$fechas."' and
				(a.stadph = '".$estatus."')
				order by a.dphart				";
		     }


		       //		H::PrintR($sql);exit;
		return $this->select($sql);
	}
//'".$codart."'"
    function sqldetalle ($codigo){

    	$sql="SELECT
				b.codart as codart,
				b.cantot as cantot,
				b.candph as precio,
     			b.montot as montot,
				b.numlot as numlot,
				c.desart as desart,
				c.cospro as cospro,
				f.deslot as deslot,
				to_char(f.fecven,'dd/mm/yyyy') as fecven

				from
				caartdph b,
				caregart c, fadeflot f
				where
                b.dphart='".$codigo."' and b.codart=c.codart and b.codart=f.codart ";
    	//H::PrintR($sql);
        return $this->select($sql);

    }


}
?>
