<?php
require_once("../../lib/modelo/baseClases.class.php");

class Carliscot extends baseClases
{
	function sqlp($coddes,$codhas,$fechades,$fechahas)
	{

$sql= "select a.refcot as codigo, a.descot as decripcion, a.feccot as fecha, a.porant as anticipo

   from CACOTIZA a,
        CADETCOT b

        where
         a.refcot=b.refcot and
         a.refcot >= '".$coddes."' AND
         a.refcot <= '".$codhas."' and
         a.feccot  >= to_date('".$fechades."','yyyy/mm/dd') AND
         a.feccot  <= to_date('".$fechahas."','yyyy/mm/dd')
         order BY  a.refcot";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

		function sqlp1($codigo)
	{


$sql= "select a.codart as codigo,b.desart as descripcion, a.costo as costounitario,
       a.canord as ordenada, a.mondes as descuento,a.totdet as monto
       from   CADETCOT a, caregart b
       where  a.codart=b.codart and
              a.refcot = '".$codigo."'


         order BY  a.codart";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
?>