<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrdeumorinm extends BaseClases
{
	function sqlp($fecdes,$fechas,$fuendes,$fuenhas,$direc)
	{

			$sql="SELECT
						C.RIFCON as rifcon,
						D.NOMCON as nomcon,
						D.NROINM as nroinm,
						C.NOMBRE as nombre,
						C.MONDEC as mondeu,
						C.FECDEC,
						C.FECVEN,
						D.DIRINM as dirinm,
						E.NOMFUE as nomfue
						FROM FCDECLAR C, FCREGINM D,FCFUEPRE E
						WHERE
						               C.FECVEN>=TO_DATE('".$fecdes."','DD/MM/YYYY') AND
									   C.FECVEN<=TO_DATE('".$fechas."','DD/MM/YYYY') AND
									   C.FUEING>='".$fuendes."' AND
									   C.FUEING<='".$fuenhas."' AND
									   C.EDODEC <>'P' AND
									   C.EDODEC <>'X' AND
									   C.NUMREF=D.NROINM AND
									  UPPER(D.DIRINM) LIKE UPPER('".$direc."') AND
									   C.FUEING=E.CODFUE
						ORDER BY D.NROINM,C.FECVEN,D.NOMCON";

			      //H::PrintR($sql);exit;
	return $this->select($sql);
	}
}
?>
