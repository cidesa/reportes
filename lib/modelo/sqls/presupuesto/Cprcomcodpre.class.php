<?php

require_once("../../lib/modelo/baseClases.class.php");

/**
 * Description of Cprcomcodpre
 * listado de Compromisos
 * @author ogutierrez
 */
class Cprcomcodpre {

    function sqlp($codpredes, $codprehas) {
        $sql = "select a.*,b.descom,b.tipcom,b.feccom FROM cpimpcom a, cpcompro b
                where a.refcom=b.refcom 
                and codpre>='".$codpredes."'
                and codpre<='".$codprehas."'
                order by codpre,feccom,refcom";
//print $sql; exit;
        return $this->select($sql);
    }

}

?>
