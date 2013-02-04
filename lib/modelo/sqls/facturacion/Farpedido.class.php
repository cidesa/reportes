<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farpedido extends baseClases
{
	function sqlp($peddes,$pedhas,$clides,$clihas,$fecdes,$fechas,$status,$i)
	{
       if ($i == 1)
       {
         $sql = "SELECT
				A.NROPED as nroped,
				to_char(A.FECPED,'dd/mm/yyyy') as fecped,
				A.DESPED as desped,
				A.MONPED as monped,
				A.CODCLI as codcli,
				A.OBSPED as obsped,
				A.REAPOR as reapor,
				(case when A.STATUS = 'A' then 'Activa' when A.STATUS = 'N' then 'Anulada' END) as STATUS,
				--B.CODART,
				--B.CANTOT,
				--B.PREART,
				--B.TOTART,
				--C.DESART,
				--C.UNIMED,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.TELPRO as telcli,
				D.DIRPRO as dircli
				FROM FAPEDIDO A,
				--FAARTPED B,
				--CAREGART C,
				FACLIENTE D
				WHERE --B.NROPED=A.NROPED AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				A.NROPED >= '".$peddes."' AND
				A.NROPED <= '".$pedhas."' AND
				A.FECPED >= '".$fecdes."' AND
				A.FECPED <= '".$fechas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."'

				ORDER BY A.NROPED";
       }

       else
        {
        	 $sql = "SELECT
				A.NROPED as nroped,
				to_char(A.FECPED,'dd/mm/yyyy') as fecped,
				A.DESPED as desped,
				A.MONPED as monped,
				A.CODCLI as codcli,
				A.OBSPED as obsped,
				A.REAPOR as reapor,
				(case when A.STATUS = 'A' then 'Activa' when A.STATUS = 'N' then 'Anulada' END) as STATUS,
				--B.CODART,
				--B.CANTOT,
				--B.PREART,
				--B.TOTART,
				--C.DESART,
				--C.UNIMED,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.TELPRO as telcli,
				D.DIRPRO as dircli
				FROM FAPEDIDO A,
				--FAARTPED B,
				--CAREGART C,
				FACLIENTE D
				WHERE --B.NROPED=A.NROPED AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				A.NROPED >= '".$peddes."' AND
				A.NROPED <= '".$pedhas."' AND
				A.FECPED >= '".$fecdes."' AND
				A.FECPED <= '".$fechas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."' AND
				A.STATUS = '".$status."'
				ORDER BY A.NROPED";

        }
		//H::PrintR($sql);exit;
		return $this->select($sql);
	}
//'".$codart."'"
    function sqldetalle ($nroped){

    	$sql="select a.codart as codart, a.cantot as cantot, a.preart as preart,
    			a.totart as totart, b.unimed as unimed,b.desart as desart
    			from faartped a, caregart b
    			 where a.nroped = '".$nroped."'
    			 and a.codart = b.codart";
    	//H::PrintR($sql);exit;
        return $this->select($sql);


    }

    function datos(){
    	$sql = "select nomemp as nombre, diremp as direccion, tlfemp as telf FROM empresa where codemp = '001'";
    	//H::PrintR($sql);exit;
    	return $this->select ($sql);
    	}



}
?>