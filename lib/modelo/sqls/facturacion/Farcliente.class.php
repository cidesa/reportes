<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farcliente extends baseClases
{
  function sqlp($coddes,$codhas,$rifdes,$rifhas)
  {

$sql= "SELECT A.CODPRO, A.NOMPRO,
    CASE WHEN A.TIPPER='N' THEN 'Natural' ELSE 'Juridica' END,
    A.RIFPRO,
    A.DIRPRO,
    A.CODCTA,
    A.TELPRO,
    A.FATIPCTE_ID,
    B.NOMTIPCTE as tippro
    FROM FACLIENTE A,FATIPCTE B
  WHERE
    A.FATIPCTE_ID=B.id AND    ---La Tabla FATIPCTE no contiene el campo CODTIPCLI
    A.CODPRO >= '".$coddes."' AND
    A.CODPRO <= '".$codhas."' AND
    A.RIFPRO >= '".$rifdes."' AND
    A.RIFPRO <= '".$rifhas."' ";
//H::PrintR($sql);exit;
return $this->select($sql);
  }

}
?>
