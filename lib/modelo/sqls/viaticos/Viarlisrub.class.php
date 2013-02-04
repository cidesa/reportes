<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisrub extends baseClases {

    function SQLp($coddes,$codhas) {

        $sql="select codrub, desrub, case when tipo='C' then 'CALCULABLE POR TABLA' else 'MONTO MANUAL' end as tipo, codpar from viadefrub where codrub>='$coddes' and codrub<='$codhas'";

        return $this->select($sql);
    }

}
?>
