<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarliscalrub extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select a.codrub, b.desrub, canunitri,valunitri,monto from viacalrub a, viadefrub  b
              where a.codrub=b.codrub and a.codrub>='$coddes' and a.codrub<='$codhas'";

        return $this->select($sql);
    }

}
?>
