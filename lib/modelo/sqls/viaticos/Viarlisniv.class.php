<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisniv extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select codniv, desniv from viadefniv where codniv>='$coddes' and codniv<='$codhas'";

        return $this->select($sql);
    }

}
?>
