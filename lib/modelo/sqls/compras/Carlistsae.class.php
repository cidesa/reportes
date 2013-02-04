<?php
require_once("../../lib/modelo/baseClases.class.php");

class Carlistsae extends baseClases
{
	function sqlp($coddes,$codhas,$fechades,$fechahas,$estatus)
	{
$status='';
if ($estatus =='A' OR $estatus =='N')
          {
	$status=  "AND a.stareq ='".$estatus."' ";
          }

$sql= "select a.reqart as codigo, a.desreq as descripcion, to_char(a.fecreq,'dd/mm/yyyy') as fecha, a.stareq as estatus
        from CASOLART a, caartsol b
        where
        a.reqart=b.reqart and
         a.reqart >= '".$coddes."' AND
         a.reqart <= '".$codhas."' and
         a.fecreq  >= to_date('".$fechades."','yyyy/mm/dd') AND
         a.fecreq  <= to_date('".$fechahas."','yyyy/mm/dd') ".$status."
         order BY  a.reqart";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

		function sqlp1($codigo)
	{


$sql= "select codart as codigo, desart as descripcion,montot as monto,
       mondes as descuento,monrgo as recargo
        from caartsol
        where
         reqart = '".$codigo."'

         order BY  codart";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
?>