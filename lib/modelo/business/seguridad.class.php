<?php

require_once("../../lib/modelo/baseClases.class.php");

class seguridad extends baseClases {

    public static function catalogo_usuariospermisos($objhtml) {
        $sql = "select distinct a.loguse as cod,b.nomuse as des from \"SIMA_USER\".apli_user a,\"SIMA_USER\".usuarios b where a.loguse=b.loguse and ( a.loguse like '%V_0%' AND b.nomuse like '%V_1%' ) ORDER BY a.loguse";

        $catalogo = array(
            $sql,
            array('Login del Usuario', 'Nombre del Usuario'),
            array($objhtml),
            array('cod'),
            100
        );

        return $catalogo;
    }

}

?>
