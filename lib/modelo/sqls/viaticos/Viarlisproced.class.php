<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisproced extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select codproced, desproced, case when aprobacion='S' then 'SI' else 'NO' end as aprobacion from viadefproced where codproced>='$coddes' and codproced<='$codhas'";

        return $this->select($sql);
    }

}
?>
