<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprbancos extends baseClases
{
    function sqlp($cod1,$cod2)
    {
        $sql = "select codban, rtrim(nomban) as nomban
					from npbancos
					where codban >= '$cod1' and codban <= '$cod2'
					order by codban";
        return $this->select($sql);
    }
	
	function sql($codban)
    {
        $sql = "select count(distinct(codemp)) as canemp from nphojint where codban='$codban' and staemp='A'";
        return $this->select($sql);
    }
}
?>
