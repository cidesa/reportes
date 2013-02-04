<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisfortra extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select distinct(codfortra) as codfortra, desfortra from viadeffortra where codfortra>='$coddes' and codfortra<='$codhas'";

        return $this->select($sql);
    }

}
?>
