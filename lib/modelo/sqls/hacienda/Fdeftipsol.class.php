<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fdeftipsol extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql="select distinct(a.codtip) as codigo, a.destip, a.monsol,
       case when b.propie='I' then 'INMUEBLE' WHEN b.propie='L' then 'LICENCIA'
       WHEN b.propie='C' then 'CONTRIBUYENTE' END AS PROPIE,
       (select c.nomfue from fcfuepre c where c.tipfue=b.tipo) as fuente

       from FCTIPSOL a, fcdefdetsol b

       where
       a.codtip=b.codsol AND
       A.CODTIP >= '".$CODDES."'AND
       A.CODTIP <= '".$CODHAS."'
       order by a.codtip ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}
