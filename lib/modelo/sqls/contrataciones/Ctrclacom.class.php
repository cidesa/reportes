<?php

require_once("../../lib/modelo/baseClases.class.php");

class Ctrclacom extends baseClases {

  function sqlp($codclacompdes, $codclacomphas) {


    $sql = "select codclacomp, desclacomp from occlacomp
      where
         codclacomp >= '$codclacompdes' and
         codclacomp <= '$codclacomphas'
      order BY  codclacomp";
//H::PrintR($sql);exit;
    return $this->select($sql);
  }

}

?>
