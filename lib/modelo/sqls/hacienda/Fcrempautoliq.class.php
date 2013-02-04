<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrempautoliq extends baseClases
{
	function sqlp($rifcondes,$rifconhas,$ano,$status)
	{

		if ($status=='E')
			{
				$this->valor='ESTIMADA';
				$this->sqll="SELECT DISTINCT(A.NUMREF) as numlic,A.ANODEC,A.MODO,A.RIFCON,A.FUEING,C.DIRPRI,C.NOMNEG
                         FROM FCDECLAR A,FCDEFINS B,FCSOLLIC C
                         WHERE rtrim(A.NUMREF) >= rtrim('".$rifcondes."') and
                         rtrim(A.NUMREF) <= rtrim('".$rifconhas."') and
                         A.ANODEC =('".$ano."') AND
                         a.numref=c.numlic and
                         (A.FUEING =B.CODPIC OR A.FUEING=B.CODAJUPIC) and
                         A.MODO = 'E' AND
                         C.STALIC<>'C' and
     					 C.STALIC<>'N' and
     					 C.STALIC<>'S'
						 ORDER BY A.NUMREF";
				//print $this->sqll;exit;
			}
			/*if ($this->status=='ED'){
				$this->sqll="SELECT DISTINCT(a.NUMREF) as numlic,c.nomneg,a.RIFCON,c.dirpri
                         FROM FCDECLAR a,FCDEFINS b,FCSOLLIC c
                         WHERE rtrim(NUMREF) >= rtrim('".$this->rifcondes."') and
                         rtrim(a.NUMREF) <= rtrim('".$this->rifconhas."') and
                         a.ANODEC =('".$this->ano."') AND
                         (a.FUEING = b.codpic or  a.FUEING =b.codajupic) AND
                         a.MODO ='E' and
						 a.numref=c.numlic
						 INTERSECT ALL
						 SELECT DISTINCT(a.NUMREF) as numlic,c.nomneg,a.RIFCON,c.dirpri
                         FROM FCDECLAR a,FCDEFINS b,FCSOLLIC c
                         WHERE rtrim(NUMREF) >= rtrim('".$this->rifcondes."') and
                         rtrim(a.NUMREF) <= rtrim('".$this->rifconhas."') and
                         a.ANODEC =('".$this->ano."') AND
                         (a.FUEING = b.codpic or  a.FUEING =b.codajupic) AND
                         a.MODO ='D' and
						 a.numref=c.numlic";
                         //print $this->sqll; exit;
			}*/
			if ($status=='D')
			{
				$this->valor='DEFINITIVA';
				$this->sqll="SELECT DISTINCT(A.NUMREF) as numlic,A.ANODEC,A.MODO,A.RIFCON,A.FUEING,C.DIRPRI,C.NOMNEG
                         FROM FCDECLAR A,FCDEFINS B,FCSOLLIC C
                         WHERE rtrim(A.NUMREF) >= rtrim('".$rifcondes."') and
                         rtrim(A.NUMREF) <= rtrim('".$rifconhas."') and
                         A.ANODEC =('".$ano."') AND
                         A.NUMREF=C.NUMLIC AND
                         (A.FUEING =B.CODPIC OR A.FUEING=B.CODAJUPIC) and
                         A.MODO ='D'
						 ORDER BY A.NUMREF";
				//print $this->sqll;exit;
			}
			if ($status=='ND'){
				$this->valor='NO DECLARADA';
				$this->sqll="SELECT A.NUMLIC as numlic,A.NOMNEG,A.DIRPRI,a.rifcon
							FROM
    						FCSOLLIC A left outer join (select distinct(numref) as numref
    						from FCDECLAR where anodec=('".$ano."')) b on
     						a.numlic=b.numref
							where
     						coalesce(a.numlic,' ')<> ' ' and
     						to_number(to_char(a.feclic,'yyyy'),'9999')<=to_number('".$ano."','9999') and
     						A.STALIC<>'C' and
     						A.STALIC<>'N' and
     						A.STALIC<>'S' and
     						b.numref is null
							order by
      						a.numlic";
			                //print $this->sqll;exit;
			}

		//H::PrintR($this->sqll);exit;
		return $this->select($this->sqll);

		}

}
?>