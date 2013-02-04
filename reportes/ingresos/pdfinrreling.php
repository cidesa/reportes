<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/cabecera.php");

class pdfreporte extends fpdf
{

	var $bd;
	var $titulos;
	var $titulos2;
	var $anchos;
	var $anchos2;
	var $campos;
	var $sql;
	var $rep;
	var $numero;
	var $cab;
	var $numing1;
	var $numing2;
	var $rifcon1;
	var $rifcon2;
	var $fecing1;
	var $fecing2;
	var $tiping1;
	var $tiping2;
	var $codpre1;
	var $codpre2;
	var $comodin;

	function pdfreporte()
	{
	 $this->fpdf("p","mm","Letter");
	 $this->bd=new basedatosAdo();
	 $this->titulos=array();
	 $this->titulos2=array();
	 $this->campos=array();
	 $this->anchos=array();
	 $this->anchos2=array();
	 $this->perdesde=H::GetPost("perdesde");
	 $this->perhasta=H::GetPost("perhasta");
	 $this->codpredes=H::GetPost("codpredes");
	 $this->codprehas=H::GetPost("codprehas");
	 $this->comodin=H::GetPost("comodin");
	 $this->nivel=H::GetPost("nivel");
	 $this->asignacion=H::GetPost("asignacion");
     	 if ($this->nivel=="")
	     $this->nivel=0;
	 //CREA EL TEMPORAL CIDISNIV
	 $rstemp=$this->bd->select("select temporaling('$this->perdesde','$this->perhasta','$this->codpredes','$this->codprehas','$this->comodin') as res from empresa ");
	 //CREA EL TEMPORAL CIASIINIACU
	 $rsasig=$this->bd->select("CREATE  TEMPORARY TABLE ciasiiniacu
							(
							  codpre character varying(34),
							  perpre character varying(2),
							  monasi numeric(14,2)
							)
							WITHOUT OIDS;
							ALTER TABLE ciasiiniacu OWNER TO postgres");

	 $rstempasig=$this->bd->select("select asignacion_codpre('01','12','$this->codpredes','$this->codprehas','$this->comodin') as res2 from empresa ");

	 $niveles=$this->bd->select("select * from ciniveles where consec<='".$this->nivel."' order by consec");
	 $caract=0;
	 while(!$niveles->EOF)
	 {
	 	$caract+=$niveles->fields["lonniv"];
	 	$niveles->MoveNext();
	 	//if(!$niveles->EOF)
	 	$caract++;
	 }

	 if($this->asignacion=='A')
	 {
	 	$tabla="cidisniv";
	 	$sqlper="";
	 }
	 else
	 {
	 	$tabla="ciasiiniacu";
	 	$sqlper="where a.perpre>='01' and ";
	 	$sqlper.="a.perpre<='12' ";
	 }


	 $this->sql="select substr(a.codpre,1,3) as coding,a.codpre,b.nompre, sum(a.monasi) as monasi,sum(a.modificacion) as modificado, sum(recibido) as recibido,sum(recibidotot) as recibidotot from
	 			 (
	 			 select rpad(a.codpre,32,' ') as codpre,sum(a.monasi) as monasi,
				 (adicdism('$this->perdesde','$this->perhasta',a.codpre,'A')-adicdism('$this->perdesde','$this->perhasta',a.codpre,'D')) as modificacion,
				 0 as recibido,0 as recibidotot from $tabla a
	 			 $sqlper
	 			 group by a.codpre

	 			 --RECIBIDO
	 			 union all
	 			 select a.codpre,0 as monasi, 0 as modificacion, sum(monto) as recibido,0 as recibidotot from (

					select rpad(substr(a.codpre,1,3),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,3) union all

					select rpad(substr(a.codpre,1,6),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,6) union all

					select rpad(substr(a.codpre,1,9),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,9) union all

	 			 	select a.codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
	 			 	where a.refing=b.refing and
	 			 	a.fecing=b.fecing
	 			 	group by a.codpre
	 			 ) A group by a.codpre

	 			 --RECIBIDO TOTAL
	 			 union all
	 			 select a.codpre,0 as monasi, 0 as modificacion,0 as recibido, sum(monto) as recibidotot from (

	 			 	select rpad(substr(a.codpre,1,2),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,2) union all

					select rpad(substr(a.codpre,1,5),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,5) union all

					select rpad(substr(a.codpre,1,8),32,' ') as codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
					where a.refing=b.refing and a.fecing=b.fecing and
					(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
					group by substr(a.codpre,1,8) union all

					select a.codpre,coalesce(sum(a.moning)) as monto from ciimping a, cireging b
	 			 	where a.refing=b.refing and
	 			 	a.fecing=b.fecing and
	 			 	(b.staing='A' or (
	 			 	b.staing='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
	 			 	group by a.codpre


	 			 	union all
	 			 	select rpad(substr(a.codpre,1,3),32,' '),(coalesce(sum(a.monaju),0)*(-1)) as monto from cimovaju a, ciajuste b
	 			 	where a.refaju=b.refaju and
	 			 	(b.staaju='A' or (
	 			 	b.staaju='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
	 			 	group by rpad(substr(a.codpre,1,3),32,' ')

	 			 	union all
	 			 	select rpad(substr(a.codpre,1,6),32,' '),(coalesce(sum(a.monaju),0)*(-1)) as monto from cimovaju a, ciajuste b
	 			 	where a.refaju=b.refaju and
	 			 	(b.staaju='A' or (
	 			 	b.staaju='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
	 			 	group by rpad(substr(a.codpre,1,6),32,' ')

	 			 	union all
	 			 	select rpad(substr(a.codpre,1,9),32,' '),(coalesce(sum(a.monaju),0)*(-1)) as monto from cimovaju a, ciajuste b
	 			 	where a.refaju=b.refaju and
	 			 	(b.staaju='A' or (
	 			 	b.staaju='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
	 			 	group by rpad(substr(a.codpre,1,9),32,' ')

	 			 	union all
	 			 	select a.codpre,(coalesce(sum(a.monaju),0)*(-1)) as monto from cimovaju a, ciajuste b
	 			 	where a.refaju=b.refaju and
	 			 	(b.staaju='A' or (
	 			 	b.staaju='N' and to_char(b.fecanu,'mm')>'$this->perhasta')  	)
	 			 	group by a.codpre
	 			 ) A group by a.codpre

	 			 ) A, cideftit b where  length(rtrim(a.codpre))<$caract and trim(a.codpre)=trim(b.codpre)
	 			 group by substr(a.codpre,1,3),a.codpre,b.nompre
	 			 order by substr(a.codpre,1,3),a.codpre
	 			  ";
	 			 // H::PrintR($this->sql);exit;

	 $this->caract=$caract;
	 $this->tb=$this->bd->select($this->sql);
	 if(!$this->tb->EOF)
	 $this->arrp=array("no vacio");
	 $this->cab=new cabecera();
	 $rs=$this->bd->select("select to_char(feccie,'yyyy') as anofis,to_char(fecdes,'dd/mm/yyyy') as fecha from contaba1 where to_char(fecdes,'mm')='$this->perdesde'");
	 $this->fecdes=$rs->fields["fecha"];
	 $this->anofis=$rs->fields["anofis"];
	 $rs=$this->bd->select("select to_char(fechas,'dd/mm/yyyy') as fecha from contaba1 where to_char(fechas,'mm')='$this->perhasta'");
	 $this->fechas=$rs->fields["fecha"];
	}

	function Header()
	{
	 $this->ln();
	 $this->cab->poner_cabecera($this,"","p","s","n");
	 $this->setFont("Arial","B",10);
	 $this->setY(30);$this->cell(180,5,$_POST["titulo"],0,0,'C');
	 $this->ln(6);
	 $this->setFont("Arial","B",9);
	 $this->cell(270,5,'Codigo Presupuestario Desde '.$this->codpredes.' Hasta '.$this->codprehas);
	 $this->ln(5);
	 $this->cell(270,5,'Periodo Del '.$this->perdesde.' Al '.$this->perhasta);
	 $this->ln(5);
	 $this->Line(10,$this->getY(),200,$this->getY());
	 $this->ln(5);
	 $this->SetWidths(array(25,55,25,25,25,25));
	 $this->SetBorder(true);
	 $this->Setaligns(array('C','C','C','C','C','C'));
	 $this->Row(array("Ingresos","Denominación","Ingresos \nEstimados","Ingresos \nRecaudados","Ingresos \npor Recaudar","Variaciones \n+ ó -"));
	 $this->Setaligns(array('L','L','R','R','R','R'));
	}

	function Cuerpo()
	{
		$refing=$this->tb->fields["coding"];
		$ting_asi=0;
		$ting_mod=0;
		$ting_rec=0;
		$ting_prec=0;
		$ting_nopre=0;
		$noming=$this->tb->fields["nompre"];
		while(!$this->tb->EOF)
		{
			$asigactual=($this->tb->fields["monasi"]-$this->tb->fields["modificado"]);
			$noprevisto=0;
			if($this->tb->fields["recibido"]>$asigactual)
				$noprevisto=abs($asigactual-$this->tb->fields["recibido"]);

			if($this->asignacion=='A')
			{
				if($noprevisto> 0)
				{
					$porrecib=0;
				}else
				{
					$porrecib=$asigactual-$this->tb->fields["recibido"];
				}
			}else
			{
				if($noprevisto> 0)
				{
					$porrecib=0;
				}else
				{
					$porrecib=$asigactual-$this->tb->fields["recibidotot"];
				}
			}
			//TOTALES POR INGRESO
			if($refing!=$this->tb->fields["coding"])
			{
				$this->RowM(array("","TOTAL $noming",
				H::FormatoMonto($ting_asi-$ting_mod),
				H::FormatoMonto($ting_rec),
				H::FormatoMonto($ting_prec),
				H::FormatoMonto($ting_nopre)));
				$ting_asi=0;
				$ting_mod=0;
				$ting_rec=0;
				$ting_prec=0;
				$ting_nopre=0;
				$noming=$this->tb->fields["nompre"];
			}

			$this->RowM(array(trim($this->tb->fields["codpre"]),trim($this->tb->fields["nompre"]),
			H::FormatoMonto($asigactual),
			H::FormatoMonto($this->tb->fields["recibido"]),
			H::FormatoMonto($porrecib),
			H::FormatoMonto($noprevisto)));
			if(strlen(trim($this->tb->fields["codpre"]))>=($this->caract-1))
			{
				$ting_asi+=$this->tb->fields["monasi"];
				$ting_mod+=$this->tb->fields["modificado"];
				$ting_rec+=$this->tb->fields["recibido"];
				$ting_prec+=$porrecib;
				$ting_nopre+=$noprevisto;
				//GENERAL
				$tot_asi+=$this->tb->fields["monasi"];
				$tot_mod+=$this->tb->fields["modificado"];
				$tot_rec+=$this->tb->fields["recibido"];
				$tot_prec+=$porrecib;
				$tot_nopre+=$noprevisto;
			}
			$refing=$this->tb->fields["coding"];
			$this->tb->MoveNext();
		}
		//TOTALES
		$this->setAutoPageBreak(false);
		$this->RowM(array("","TOTAL $noming",
				H::FormatoMonto($ting_asi-$ting_mod),
				H::FormatoMonto($ting_rec),
				H::FormatoMonto($ting_prec),
				H::FormatoMonto($ting_nopre)));
		$this->ln(4);
		$this->RowM(array("","TOTAL INGRESOS",
			H::FormatoMonto($tot_asi-$tot_mod),	H::FormatoMonto($tot_rec),
			H::FormatoMonto($tot_prec),H::FormatoMonto($tot_nopre)));
    }
}
?>