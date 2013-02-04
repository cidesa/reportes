<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farnotentpre extends baseClases
{
	function sqlp($notdes,$nothas,$clides,$clihas,$fecdes,$fechas,$status,$ref,$i)
	{

	  switch ($i) {

		case 1:
		$sql= "SELECT A.NRONOT as nronot,
				to_char(A.FECNOT,'dd/mm/yyyy') as fecnot,
				A.CODCLI as codcli,
				A.TIPREF as tipref,
				A.CODREF as codref,
				A.AUTPOR as autpor,
				A.OBSNOT as obsnot,
				A.STATUS as status,
				--B.CODART as codart,
				--B.NUMLOT as numlot,
				--B.CANTOT as cantot,
				--C.DESART as desart,
				--C.UNIMED as unimed,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.DIRPRO as dircli,
				--E.DESLOT as deslot,
				--E.FECVEN as fecven,
				A.CODALM as codalm,
				F.NOMALM as nomalm,
				(CASE WHEN A.TIPREF = 'P' THEN A.CODREF END) as referencia
				FROM FANOTENT A,
				--FAARTNOT B,
				--CAREGART C,
				FACLIENTE D,
				--FADEFLOT E,
				CADEFALM F
				WHERE --B.NRONOT=A.NRONOT AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				--B.CODART=E.CODART AND
				--A.CODALM=E.CODALM AND
				--B.NUMLOT=E.NUMLOT AND
				A.CODALM=F.CODALM AND
				--E.CODALM=F.CODALM AND
				A.NRONOT >= '".$notdes."' AND
				A.NRONOT <= '".$nothas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."' AND
				A.FECNOT >= '".$fecdes."' AND
				A.FECNOT <= '".$fechas."'
				ORDER BY A.NRONOT";
				break;

		case 2:
        $sql= "SELECT A.NRONOT as nronot,
				to_char(A.FECNOT,'dd/mm/yyyy') as fecnot,
				A.CODCLI as codcli,
				A.TIPREF as tipref,
				A.CODREF as codref,
				A.AUTPOR as autpor,
				A.OBSNOT as obsnot,
				A.STATUS as status,
				--B.CODART as codart,
				--B.NUMLOT as numlot,
				--B.CANTOT as cantot,
				--C.DESART as desart,
				--C.UNIMED as unimed,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.DIRPRO as dircli,
				--E.DESLOT as deslot,
				--E.FECVEN as fecven,
				A.CODALM as codalm,
				F.NOMALM as nomalm,
				(CASE WHEN A.TIPREF = 'P' THEN A.CODREF END) as referencia
				FROM FANOTENT A,
				--FAARTNOT B,
				--CAREGART C,
				FACLIENTE D,
				--FADEFLOT E,
				CADEFALM F
				WHERE --B.NRONOT=A.NRONOT AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				--B.CODART=E.CODART AND
				--A.CODALM=E.CODALM AND
				--B.NUMLOT=E.NUMLOT AND
				A.CODALM=F.CODALM AND
				--E.CODALM=F.CODALM AND
				A.NRONOT >= '".$notdes."' AND
				A.NRONOT <= '".$nothas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."' AND
				A.FECNOT >= '".$fecdes."' AND
				A.FECNOT <= '".$fechas."' AND
				A.TIPREF = '".$ref."'
				ORDER BY A.NRONOT";
				break;
        case 3:
        $sql= "SELECT A.NRONOT as nronot,
				to_char(A.FECNOT,'dd/mm/yyyy') as fecnot,
				A.CODCLI as codcli,
				A.TIPREF as tipref,
				A.CODREF as codref,
				A.AUTPOR as autpor,
				A.OBSNOT as obsnot,
				A.STATUS as status,
				--B.CODART as codart,
				--B.NUMLOT as numlot,
				--B.CANTOT as cantot,
				--C.DESART as desart,
				--C.UNIMED as unimed,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.DIRPRO as dircli,
				--E.DESLOT as deslot,
				--E.FECVEN as fecven,
				A.CODALM as codalm,
				F.NOMALM as nomalm,
				(CASE WHEN A.TIPREF = 'P' THEN A.CODREF END) as referencia
				FROM FANOTENT A,
				--FAARTNOT B,
				--CAREGART C,
				FACLIENTE D,
				--FADEFLOT E,
				CADEFALM F
				WHERE --B.NRONOT=A.NRONOT AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				--B.CODART=E.CODART AND
				--A.CODALM=E.CODALM AND
				--B.NUMLOT=E.NUMLOT AND
				A.CODALM=F.CODALM AND
				--E.CODALM=F.CODALM AND
				A.NRONOT >= '".$notdes."' AND
				A.NRONOT <= '".$nothas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."' AND
				A.FECNOT >= '".$fecdes."' AND
				A.FECNOT <= '".$fechas."' AND
				A.STATUS = '".$status."'
				ORDER BY A.NRONOT";
				break;
        case 4:
        $sql= "SELECT A.NRONOT as nronot,
				to_char(A.FECNOT,'dd/mm/yyyy') as fecnot,
				A.CODCLI as codcli,
				A.TIPREF as tipref,
				A.CODREF as codref,
				A.AUTPOR as autpor,
				A.OBSNOT as obsnot,
				A.STATUS as status,
				--B.CODART as codart,
				--B.NUMLOT as numlot,
				--B.CANTOT as cantot,
				--C.DESART as desart,
				--C.UNIMED as unimed,
				D.RIFPRO as rifcli,
				D.NOMPRO as nomcli,
				D.DIRPRO as dircli,
				--E.DESLOT as deslot,
				--E.FECVEN as fecven,
				A.CODALM as codalm,
				F.NOMALM as nomalm,
				(CASE WHEN A.TIPREF = 'P' THEN A.CODREF END) as referencia
				FROM FANOTENT A,
				--FAARTNOT B,
				--CAREGART C,
				FACLIENTE D,
				--FADEFLOT E,
				CADEFALM F
				WHERE --B.NRONOT=A.NRONOT AND
				A.CODCLI=D.CODPRO AND
				--B.CODART=C.CODART AND
				--B.CODART=E.CODART AND
				--A.CODALM=E.CODALM AND
				--B.NUMLOT=E.NUMLOT AND
				A.CODALM=F.CODALM AND
				--E.CODALM=F.CODALM AND
				A.NRONOT >= '".$notdes."' AND
				A.NRONOT <= '".$nothas."' AND
				A.CODCLI >= '".$clides."' AND
				A.CODCLI <= '".$clihas."' AND
				A.FECNOT >= '".$fecdes."' AND
				A.FECNOT <= '".$fechas."' AND
				A.STATUS = '".$status."'  AND
				A.TIPREF = '".$ref."'
				ORDER BY A.NRONOT";
				break;

		}

		//H::PrintR($sql);exit;
		return $this->select($sql);
	}
//'".$codart."'"
    function sqldetalle ($nronot,$codalm){

    	$sql ="select a.codart as codart, a.numlot as numlot, a.cantot as cantot,
    			b.unimed as unimed,b.desart as desart, c.deslot as deslot, to_char(c.fecven,'dd/mm/yyyy') as fecven
    			from faartnot a, caregart b, fadeflot c
    			where c.codalm = '".$codalm."' and a.nronot = '".$nronot."' and a.numlot = c.numlot
    			 and a.codart = b.codart and a.codart = c.codart";
        //H::PrintR($sql);exit;
        return $this->select($sql);


    }
}
?>