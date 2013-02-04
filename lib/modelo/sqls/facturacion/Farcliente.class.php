<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farcliente extends baseClases
{
  function sqlp($coddes,$codhas,$rifdes,$rifhas,$estades,$estahas)
  {

$sql= "SELECT A.CODPRO, A.NOMPRO,
    CASE WHEN A.TIPPER='N' THEN 'Natural' ELSE 'Juridica' END,
    A.RIFPRO,
    A.DIRPRO,
    A.CODCTA,
    A.TELPRO,
    A.FATIPCTE_ID,
    B.NOMTIPCTE as tippro,
    EDO.NOMEDO
    FROM FACLIENTE A,FATIPCTE B, OCESTADO EDO
  WHERE
    A.FATIPCTE_ID=B.id AND    ---La Tabla FATIPCTE no contiene el campo CODTIPCLI
    A.CODPRO >= '".$coddes."' AND
    A.CODPRO <= '".$codhas."' AND
    A.RIFPRO >= '".$rifdes."' AND
    A.RIFPRO <= '".$rifhas."' AND
    A.CODEDO >= '".$estades."' AND
    A.CODEDO <= '".$estahas."' AND
    A.CODEDO = EDO.CODEDO";
//H::PrintR($sql);exit;
return $this->select($sql);
  }

}
?>
