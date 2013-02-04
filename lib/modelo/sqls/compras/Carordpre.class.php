<?php
require_once("../../lib/modelo/baseClases.class.php");

class Carordpre extends baseClases
{

    function sqlp($ordcomdes,$ordcomhas)
  {

			$sql="SELECT DISTINCT A.ORDCOM, B.CODCAT,
                            (SELECT DESUBI FROM BNUBICA y where y.codubi=A.coduni) as udministrativa,
                            (SELECT DESCEN FROM CADEFCEN x where x.codcen=A.codcen) as uejecutora,
			to_char(a.fecord,'DD/MM/YYYY') as fecord,
			A.CODPRO,
			E.NOMPRO,
			E.RIFPRO,
			E.NITPRO,
			E.DIRPRO,
			E.TELPRO,
			B.RGOART,
			A.DESORD as desord,
			(CASE WHEN A.CRECON='CT' THEN 'Contado' WHEN A.CRECON='CR' THEN 'Credito' ELSE 'Desconocido' END) AS CRECON,
			A.MONORD,
			(CASE WHEN A.STAORD='A' THEN 'Activo' WHEN A.STAORD='N' THEN 'Anulado' ELSE 'Desconocido' END) AS STAORD,
			A.AFEPRE,
			A.TIPORD,
			B.RGOART,
			B.CODART,
			B.UNIMED,
			B.CANORD AS CANTOT,
			B.PREART AS PREART,
			B.TOTART AS TOTART,
			B.CODPAR as CODPAR,
			C.CODPAR as CODPAR1,
			RTRIM(F.DESRES) AS DESRES--,
			--(G.monrgo/100) AS MONRGO
			FROM CAORDCOM A, CAARTORD B, CAREGART C,CAPROVEE E, CARESORDCOM F--,carecarg G
			WHERE
			A.ORDCOM>='".$ordcomdes."' AND
			A.ORDCOM<='".$ordcomhas."' AND
			A.ORDCOM = B.ORDCOM AND
			rtrim(B.CODART) = rtrim(F.CODART) and
			A.ORDCOM = F.ORDCOM AND
			A.CODPRO = E.CODPRO AND
			B.CODART  = C.CODART AND
                        B.CANORD=F.CANORD
			ORDER BY DESRES, A.ORDCOM,B.PREART,to_char(a.fecord,'DD/MM/YYYY')";
 echo '<pre>'; 			print_r($sql);
   return $this->select($sql);
  }



  function sqlp2($ordcomdes,$ordcomhas,$codprodes,$codprohas,$codartdes,$codarthas,$fecorddes,$fecordhas,$status,$despacho)
  {
        if ($status=="Activas")
	{
		$condicion=" a.staord='A' AND ";
	}
	elseif ($status=="Ambos")
	{
		$condicion=" (a.staord='A' or a.staord='N') AND ";
	}
	else
	{
		$condicion=" a.staord='N' AND ";
	}

	if (trim($despacho)=="Todos" or trim($despacho)=="")
	{
		$condicionD=" ";
	}
	else
	{
		$condicionD=" a.lugent ='".$despacho."' AND";
	}


	$sql="SELECT DISTINCT A.ORDCOM, B.CODCAT,
                       (SELECT DESUBI FROM BNUBICA y where y.codubi=A.coduni) as udministrativa,
                       (SELECT DESCEN FROM CADEFCEN x where x.codcen=A.codcen) as uejecutora,
			to_char(a.fecord,'DD/MM/YYYY') as fecord,
			A.CODPRO,
			E.NOMPRO,
			E.RIFPRO,
			E.NITPRO,
			E.DIRPRO,
			E.TELPRO,
			B.RGOART,
			A.DESORD as desord,
			(CASE WHEN A.CRECON='CT' THEN 'Contado' WHEN A.CRECON='CR' THEN 'Credito' ELSE 'Desconocido' END) AS CRECON,
			A.MONORD,
			(CASE WHEN A.STAORD='A' THEN 'Activo' WHEN A.STAORD='N' THEN 'Anulado' ELSE 'Desconocido' END) AS STAORD,
			A.TIPORD,
			B.RGOART,
			B.CODART,
			B.UNIMED,
			B.CANORD AS CANTOT,
			B.PREART AS PREART,
			B.TOTART AS TOTART,
			B.CODPAR as CODPAR,
			C.CODPAR as CODPAR1,
			RTRIM(F.DESRES) AS DESRES--,
			--(G.monrgo/100) AS MONRGO
			FROM CAORDCOM A, CAARTORD B, CAREGART C,CAPROVEE E, CARESORDCOM F--,carecarg G
			WHERE
			--B.codrgo=G.codrgo AND
			A.ORDCOM>='".$ordcomdes."' AND
			A.ORDCOM<='".$ordcomhas."' AND
			E.CODPRO >='".$codprodes."' AND
			E.CODPRO <='".$codprohas."' AND
			".$condicionD."
			A.FECORD >=TO_DATE('".$fecorddes."','DD/MM/YYYY') AND
			A.FECORD <=TO_DATE('".$fecordhas."','DD/MM/YYYY') AND
			--".$condicion."
			C.CODART >='".$codartdes."' AND
			C.CODART <='".$codarthas."' AND
			A.ORDCOM = B.ORDCOM AND
			rtrim(B.CODART) = rtrim(F.CODART) and
			A.ORDCOM = F.ORDCOM AND
			A.CODPRO = E.CODPRO AND
			B.CODART  = C.CODART
			ORDER BY DESRES, to_char(a.fecord,'DD/MM/YYYY')";

//, A.ORDCOM,B.PREART,to_char(a.fecord,'DD/MM/YYYY')";

//echo '<pre>'; 			print_r($sql);exit;
   return $this->select($sql);
  }

  function sql_nompre($codpar)
  {
   $sql="select a.nompre as nombre
	from cpdeftit a
	where rtrim(a.codpre)=rtrim('".$codpar."')";
//	echo '<pre>'; 	print_r($sql);exit;
   return $this->select($sql);

  }
    function sql_nompre2($codpre)
  {
   $sql="select a.nompre as nombre
	from cpdeftit a
	where rtrim(a.codpre)=rtrim('".$codpre."')";
	//echo '<pre>'; 	print_r($sql);exit;
   return $this->select($sql);

  }

  function sql_req($ordcom)
  {
   $sql="SELECT to_char(B.fecreq,'dd/mm/yyyy') as fecha, A.refsol as req
	 FROM CAORDCOM A, CASOLART B
         WHERE A.ORDCOM='".$ordcom."' AND B.reqart=A.REFSOL;";
		/*echo '<pre>';
		print_r($sql);exit;*/
   return $this->select($sql);
  }

  function sql_ent($ordcom)
  {
   $sql="SELECT A.DESFORENT
	 FROM CAFORENT A, CAORDFORENT B
         WHERE B.ORDCOM='".$ordcom."' AND B.CODFORENT=A.CODFORENT;";
	 /* echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  function sql_conpag($ordcom)
  {
   $sql="SELECT A.DESCONPAG
	 FROM CACONPAG A, CAORDCONPAG B
         WHERE B.ORDCOM='".$ordcom."' AND B.CODCONPAG=A.CODCONPAG;";
		/*echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  function sql_fuefin($ordcom)
  {
   $sql="SELECT A.NomExt as nomfuefin
	 FROM FORTIPFIN A, CAORDCOM B
         WHERE B.ORDCOM='".$ordcom."' AND B.TIPFIN=A.CODFIN;";
		/*echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  #UNIDAD ADMINISTRATIVA
  function sql_responsable($ordcom)
  {
   $sql="SELECT A.NomEmp,A.NomCar,A.NomJef
	 FROM BNUBICA A, CAORDCOM B
         WHERE B.ORDCOM='".$ordcom."' AND B.coduni=A.codubi;";
		/*echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  #UNIDAD EJECUTORA
  function sql_gergen($ordcom)
  {
   $sql="SELECT A.NomEmp,A.NomCar
	 FROM CADEFCEN A, CAORDCOM B
         WHERE B.ORDCOM='".$ordcom."' AND B.codcen=A.codcen;";
	/*	echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  function sql_elapor($ordcom,$esq)
  {
   $sql="select upper(c.nomuse) as nomuse from \"SIMA_USER\".segbitaco a,\"$esq\".caordcom b, \"SIMA_USER\".usuarios c
            where
            upper(a.valcla)='CAORDCOM' and a.codmod='almordcom'  and
            a.codapl='com' and tipope='G' and ordcom='$ordcom' and
            a.refmov::integer=b.id and
            a.codintusu::integer=c.id
            ";
	/*	echo '<pre>';
		print_r($sql);exit;*/

   return $this->select($sql);
  }

  function sql_imp($ordcom,$codref='')
  {
   $sql="SELECT distinct '1' as ord,(codcat||'-'||codpar) as codigo,
   split_part(B.codpar, '-', 1) as se,
	 split_part(B.codpar, '-', 2) as pg,
	 split_part(B.codpar, '-', 3) as sp,
	 split_part(B.codpar, '-', 4) as ac,
	 split_part(B.codpar, '-', 5) as part,
	 split_part(B.codpar, '-', 6) as ge,
	 split_part(B.codpar, '-', 7) as es,
	 split_part(B.codpar, '-', 8) as Subespe,
	 split_part(B.codpar, '-', 9) as aux,
	 sum((preart*canord)) as monto,
	 c.nompre
	 FROM CAORDCOM A, CAARTORD B left outer join cpdeftit C on trim((codcat||'-'||codpar))=trim(c.codpre)
         WHERE A.ORDCOM = '".$ordcom."' AND B.ORDCOM=A.ORDCOM
         and case when '$codref'<>''  then codcat||'-'||codpar else '' end>='$codref'
         GROUP BY codcat,codpar,nompre
         UNION ALL
         SELECT distinct '2' as ord,b.codpre as codigo,
   split_part(B.codpre, '-', 1) as se,
	 split_part(B.codpre, '-', 2) as pg,
	 split_part(B.codpre, '-', 3) as sp,
	 split_part(B.codpre, '-', 4) as ac,
	 split_part(B.codpre, '-', 5) as part,
	 split_part(B.codpre, '-', 6) as ge,
	 split_part(B.codpre, '-', 7) as es,
	 split_part(B.codpre, '-', 8) as Subespe,
	 split_part(B.codpre, '-', 9) as aux,
	 sum(monrgo) as monto,
         c.nompre
	 FROM  CADISRGO B , CAORDCOM A, CPDEFTIT C
         WHERE A.ORDCOM = '".$ordcom."' AND B.REQART=A.ORDCOM
         and b.codpre=c.codpre
         and case when '$codref'='Z'  then '' else '$codref' end='$codref'
	 GROUP BY b.codpre,c.nompre
         order by ord,codigo
 ";
 //echo '<pre>';		print_r($sql);exit;

   return $this->select($sql);
  }

   function sql_rgo($ordcom)
  {
   $sql="SELECT distinct codpre as codigo,substr(B.codpre,1,2) as se,
	 substr(B.codpre,4,2) as pg,
	 substr(B.codpre,7,2) as sp,
	 substr(B.codpre,10,6) as ac,
	 substr(B.codpre,17,3) as part,
	 substr(B.codpre,21,2) as ge,
	 substr(B.codpre,24,2) as es,
	 substr(B.codpre,27,2) as Subespe,
	 substr(B.codpre,30,2) as aux,
	 sum(monrgo) as monto
	 FROM  CADISRGO B , CAORDCOM A
         WHERE A.ORDCOM = '".$ordcom."' AND B.REQART=A.ORDCOM
	 GROUP BY codpre";
	//echo '<pre>'; 		print_r($sql);
   return $this->select($sql);
  }


  function sql_cpniveles($tip='C')
  {
   $sql="select nomabr, nomext from cpniveles where catpar='".$tip."' and staniv='A' order by consec";
   //echo '<pre>'; 		print_r($sql);
   return $this->select($sql);
  }
//$this->sql= "select a.monrgo,b.monrgo as suma from carecarg a,cargosol b where b.reqart='".$this->arrp[$this->i-1]["ordcom"]."' and a.codrgo=b.codrgo";
  function sql_ivas($ordcom)
  {
//   $sql="select a.monrgo,b.monrgo as suma from carecarg a,cargosol b where b.reqart='".$ordcom."' and a.codrgo=b.codrgo";
//  $sql="select a.monrgo as porcen,a.monrgo,b.monrgo as suma from carecarg a,cadisrgo b where b.reqart='".$ordcom."' and a.codrgo=b.codrgo";

$sql="select a.monrgo as porcen, sum(b.monrgo) as suma from carecarg a, cadisrgo b where b.reqart='".$ordcom."' and a.codrgo=b.codrgo group by porcen";
echo '<pre>';		print_r($sql);exit;
   return $this->select($sql);
  }
}
?>
