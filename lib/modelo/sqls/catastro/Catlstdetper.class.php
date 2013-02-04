<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catlisregper extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "select a.cedrif as codigo, a.relemp as relacion, a.prinom as nombre, a.priape as apellido, a.nomper as razon,
  	 	  case when a.tipper='N' then 'NATURAL' WHEN a.tipper='J' then 'JURIDICA' END as tipo,
		  (select b.desdivgeo from catdivgeo b where b.id=a.catdivgeo_id) as localidad,
		  a.telper as telf, a.faxper as fax,a.emaper as correo,a.dirper as direccion,
                  case when a.nacper='V' then 'VENEZOLANO' when a.nacper='E' then 'EXTRANJERO' END as nacionalidad,




			from catregper a where
    		  a.id >= $coddes and
      		  a.id <= $codhas order by a.id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
