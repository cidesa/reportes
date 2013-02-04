<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlistiptra extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select codtiptra, destiptra from viadeftiptra where codtiptra>='$coddes' and codtiptra<='$codhas'";

        return $this->select($sql);
    }

}
?>
