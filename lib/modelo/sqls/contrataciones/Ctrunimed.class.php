<?php

require_once("../../lib/modelo/baseClases.class.php");

class Ctrunimed extends baseClases {

  function sqlp($codunides, $codunihas) {


    $sql = "select distinct(coduni) as codigo, desuni as descripcion
     from ocunidad where
         coduni>= '" . $codunides . "' AND
         coduni<= '" . $codunihas . "'
      order BY  coduni";
//H::PrintR($sql);exit;
    return $this->select($sql);
  }

}

?>