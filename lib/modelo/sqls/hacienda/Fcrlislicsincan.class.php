<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrlislicsincan extends BaseClases
{

	function sqlp($CODDES,$CODHAS,$rifdesde,$rifhasta,$fechadesde,$fechahasta,$codactdes,$codacthas)
  {
  	  $sql="select distinct a.numlic,b.rifcon,a.rifcon,a.nomcon,a.nomneg,a.dirpri,c.codact
						from fcsollic a left outer join fcpagos b on (a.rifcon=b.rifcon),
						fcactpic c
						where
						rtrim(a.numlic)>=rtrim('".$CODDES."')    and
						rtrim(a.numlic)<=rtrim('".$CODHAS."')    and
						rtrim(a.rifcon)>=rtrim('".$rifdesde."')  and
						rtrim(a.rifcon)<=rtrim('".$rifhasta."')  and
						rtrim(c.codact)>=rtrim('".$codactdes."') and
						rtrim(c.codact)<=rtrim('".$codacthas."') and
     					a.numlic is not null AND
     					a.codtiplic <>'000004' and
     					a.numlic=c.numdoc and
     					--upper(a.dirpri) like '%".trim(strtoupper($this->direccion))."%' and
     					--b.rifcon is null and
     					a.STALIC<>'C' and
     					a.STALIC<>'N' and
     					a.STALIC<>'S'
     					order by a.numlic";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

 	function sqlp1($CODIGO)
  {
  	  $sql="select distinct desact from fcactcom where rtrim(codact) =rtrim('".$CODIGO."')";
  	  //H::PrintR($sql);exit;

	return $this->select($sql);
  }
}