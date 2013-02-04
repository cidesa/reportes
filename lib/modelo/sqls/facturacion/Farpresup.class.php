<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farpresup extends baseClases
{
	function sqlp($predes,$prehas,$clides,$clihas,$fecdes,$fechas)
	{
         $sql = "SELECT
				A.REFPRE as refpre,
				to_char(A.FECPRE,'dd/mm/yyyy') as fecpre,
				A.CODCLI as codcli,
				A.MONPRE as monpre,
				A.MONDESC as mondesc,
				A.AUTPOR as autpor,
				RTRIM(A.OBSERV) as OBSERV,
				--RTRIM(C.DESART) as DESART,
				D.CODPRO as codpro,
				D.NOMPRO as nompro,
				D.TELPRO as telpro,
				D.DIRPRO as dirpro,
				D.RIFPRO as rifpro,
				D.FAXPRO as faxpro,
				D.EMAIL as email,
				E.DESCONPAG as desconpag
				FROM
				FAPRESUP A,
				FACLIENTE D,
				CACONPAG E
				WHERE
				A.CODCLI=D.CODPRO AND
				A.faconpag_id= replace(E.CODCONPAG, '', '')::int AND
				A.REFPRE >= '".$predes."' AND
				A.REFPRE <= '".$prehas."' AND
				D.CODPRO >= '".$clides."' AND
				D.CODPRO <= '".$clihas."' AND
				A.FECPRE >= '".$fecdes."' AND
				A.FECPRE <= '".$fechas."'
				ORDER BY A.REFPRE
				";
       		//H::PrintR($sql);exit;
		return $this->select($sql);
	}
//'".$codart."'"
    function sqldetalle ($codigo){

    	$sql="SELECT
				A.CODART as codart,
				A.CANSOL as cansol,
				A.PRECIO as precio,
				A.MONRGO as monrgo,
				A.TOTART as totart,
				B.UNIMED as unimed,
                RTRIM(B.DESART) as DESART
				FROM
				FADETPRE A,
				CAREGART B
				WHERE
				A.REFPRE='".$codigo."' AND
				A.CODART = B.CODART";
    	//H::PrintR($sql);exit;
        return $this->select($sql);

    }

    function telcontacto ($codigo){

    	$sql = "SELECT MAX(NOMCONT) as CONTACTO
			  FROM FACONTCTE
			  WHERE CODCLI= '".$codigo."";
    }

}
?>