<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../../lib/modelo/baseClases.class.php");

class contrataciones extends baseClases {

    public static function catalogo_salida($objhtml) {
        $sql = "select distinct(coduni) as codigo, desuni as descripcion from ocunidad where ( coduni like '%V_0%' AND desuni like '%V_1%' ) order by coduni";
        $catalogo = array(
            $sql,
            array('Código de Unidad de Medida', 'Descripción'),
            array($objhtml),
            array('codigo'),
            100
        );
    }

    public static function catalogo_codclacomp($objhtml) {
        $sql = "SELECT codclacomp as codigo, desclacomp as descripcion FROM occlacomp where ( codclacomp like '%V_0%' and desclacomp like '%V_1%') order by codclacomp";


        $catalogo = array(
            $sql,
            array('Código', 'Descripcion'),
            array($objhtml),
            array('codigo'),
            100
        );

        return $catalogo;
    }

    public static function catalogo_recaudos($objhtml) {
        $sql = "Select codrec as codigo, desrec from lirecaud where ( codrec like '%V_0%' AND desrec like '%V_1%' ) order by codrec";
        $catalogo = array(
            $sql,
            array('Tipo de Recaudo', 'Descripción'),
            array($objhtml),
            array('codigo'),
            100
        );

        return $catalogo;
    }

}

?>
