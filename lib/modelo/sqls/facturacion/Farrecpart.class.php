<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farrecpart extends baseClases
{
   function sqlp($CODDES,$CODHAS)
    {

$sql= "select b.codrgo as
codrecargo, b.nomrgo as recargo
from caregart a, carecarg b, farecart c
where
a.codart=c.codart and
b.codrgo=c.codrgo and
b.codrgo >='".$CODDES."' and
b.codrgo <='".$CODHAS."'
order by b.codrgo";
//H::PrintR($sql);
return $this->select($sql);
    }

   function sqlp1($codrecargo)
    {
    $sql="select a.codart as codigo, a.desart as nombre
     from
        caregart a, carecarg b, farecart c
     where
        a.codart=c.codart and
        b.codrgo=c.codrgo and
        b.codrgo='".$codrecargo."'
    ORDER BY a.codart";
       // H::PrintR($sql);
return $this->select($sql);
  }
}
?>
