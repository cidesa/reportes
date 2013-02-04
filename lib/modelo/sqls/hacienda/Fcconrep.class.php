<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcconrep extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select a.cedcon as cedula,a.rifcon as codemp, a.nomcon as nombre, a.naccon as nacionalidad,a.tipcon as tipo,
       a.dircon as direccion,a.ciucon as rif2,
       (select b.nommun from fcmunici b where a.codmun= b.codmun and a.codedo = b.codedo and a.codpai= b.codpai) as parroquia,
       a.cpocon as codpostal, a.apocon as codparpostal, a.telcon as telefono, a.urlcon as url

       from fcconrep a

       where
      trim(a.rifcon) >=trim('".$CODDES."') and
       trim(a.rifcon) <=trim('".$CODHAS."') order by a.rifcon limit 500";//H::PrintR($sql);exit;

	return $this->select($sql);
  }
  function sqlp1($rifcon)
  {
   	  $sql=  "select a.codrec as codrec, b.desrec as desrecaudo
       from fcreccon a, carecaud b

       where
       a.codrec=b.codrec and
       trim(a.rifcon)=trim('".$rifcon."') order by a.codrec";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

}