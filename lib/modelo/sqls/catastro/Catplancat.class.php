<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catplancat extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "select a.nroinc as numero, (a.coddivgeo||a.nrocas) as codcatastral, a.codcatant as codanterior,
       a.catbarurb_id as codurba,a.cattramofro_id as tramofro, a.cattramolat_id as codlat1,a.id as id,
       a.cattramolat2_id as codlat2,a.edicas as edicas, folio as folio, to_char(a.fecreg,'dd/mm/yyyy') as fecreg,
       a.linnor,a.linsur,a.lineste,a.linoes from CATREGINM a
       where
     TRIM(a.coddivgeo||a.nrocas) >= TRIM('".$coddes."') and
    TRIM(a.coddivgeo||a.nrocas) <= TRIM('".$codhas."') order by a.coddivgeo||a.nrocas ";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
  function sqlp1($codigo)
  {
  	 $sql= "select a.cedrif as cedula,a.prinom as prinombre,a.segnom as segnombre,a.priape as priapellido,a.segape as segapellido,
       a.tipper as tipo, a.telper as telefono
 from catregper a, catperinm b
  where

	b.catreginm_id= $codigo and
	a.id=b.catregper_id and
	b.conocu='P'";//H::PrintR($sql); exit;

   return $this->select($sql);
  }

    function sqlp2($codigo)
  {
  	 $sql= "select nombarurb as urbani
       from catbarurb
       where
        id= $codigo  ";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
   function sqlp3($codigo)
  {
  	 $sql= "select nomtramo as tramo
         from cattramo
          where
           id=  $codigo  ";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
  function sqlp4($codigo)
  {
  	 $sql= "select a.cedrif as cedula,a.prinom as prinombre,a.segnom as segnombre,a.priape as priapellido,a.segape as segapellido,
       a.tiper as tipo, a.telper as telefono,
 from catregper a, catperinm b
  where

	b.catreginm_id= $codigo and
	a.id=b.catregper_id and
	b.conocu='A'";//H::PrintR($sql); exit;

   return $this->select($sql);
  }

}
?>
