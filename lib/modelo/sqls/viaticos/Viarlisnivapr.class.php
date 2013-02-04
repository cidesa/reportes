<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisnivapr extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select codnivapr, desnivapr from viadefnivapr where codnivapr>='$coddes' and codnivapr<='$codhas'";

        return $this->select($sql);
    }

}
?>
