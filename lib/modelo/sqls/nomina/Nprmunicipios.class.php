<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprmunicipios extends baseClases
{

    function sql($codmundes,$codmunhas,$codpaides,$codpaihas)
    {
        $sql = "select a.codpai, rtrim(a.nompai) as nompai, b.codedo, b.nomedo, c.codciu, c.nomciu
			from nppais a, npestado b, npciudad c
			where
			B.codedo >= '$codmundes' and B.codedo <= '$codmunhas' and
			B.codpai >= '$codpaides' and B.codpai <= '$codpaihas' and
			a.codpai = b.codpai and
			a.codpai = c.codpai and
			b.codedo = c.codedo
			order by a.codpai,b.codedo,c.codciu";

        return $this->select($sql);
    }

}

?>
