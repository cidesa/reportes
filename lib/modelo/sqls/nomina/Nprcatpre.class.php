<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprcatpre extends baseClases
{

    function sqlp($cod1,$cod2)
    {
        $sql = "select a.codcat, a.nomcat as nomcat
			from npcatpre a
			where a.codcat >= '$cod1' and a.codcat <= '$cod2' 
			order by a.codcat";
			
        return $this->select($sql);
    }

}

?>
