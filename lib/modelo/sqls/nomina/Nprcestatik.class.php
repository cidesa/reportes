<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprcestatik extends baseClases {

    function SQLp($especial,$codnomdes,$codnomhas,$codcondes,$tipnomesp) {

    	 if ($especial == 'S')
            {
            	$especial = " a.especial = 'S' AND 		(a.codnomesp) = TRIM('".$tipnomesp."') AND  ";
            }
            else
            {
            	if ($especial == 'N')       	$especial = " a.especial = 'N' AND"; else
            	if ($especial == 'T')         $especial = "";
            }


	    	$sql="select b.cedemp, b.nomemp ,a.saldo as saldo
						from
						npnomcal a, NPHOJINT B, npcestatickets c
						where
						B.CODEMP = A.CODEMP and $especial
						A.CODNOM >= '".$codnomdes."'  and  A.CODNOM <= '".$codnomhas."'
                        and a.codnom=c.codnom and a.codcon=c.codcon
						order by cast(REPLACE(b.cedemp,'.', '') as int ) ";

 
 	//   H::PrintR($sql);exit;

        return $this->select($sql);
    }
}
?>