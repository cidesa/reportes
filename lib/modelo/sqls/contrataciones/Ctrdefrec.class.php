<?php

require_once("../../lib/modelo/baseClases.class.php");

class Ctrdefrec extends baseClases {

  function sqlp($codrecdes, $codunihas) {


    $sql = "select codrec as codigo, desrec as descripcion
     from lirecaud where
         codrec>= '" . $codrecdes . "' AND
         codrec<= '" . $codunihas . "'
      order BY  codrec";
//H::PrintR($sql);exit;
    return $this->select($sql);
  }

}

?>