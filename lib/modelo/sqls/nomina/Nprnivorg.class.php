<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprnivorg extends baseClases
{
    function sqlp($cod1,$cod2)
    {
        $sql = "select * from npestorg
					where codniv >= '$cod1' and codniv <= '$cod2'
					order by codniv";
        return $this->select($sql);
    }
}

?>
