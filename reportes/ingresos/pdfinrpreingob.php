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
							ALTER TABLE ciasiiniacu OWNER TO postgres");//

	 $rstempasig=$this->bd->select("select asignacion_codpre('01','12','$this->codpredes','$this->codprehas','$this->comodin') as res2 from empresa ");

	 //
	 if ($this->nivel=="")
	     $this->nivel=0;
	     //print $this->nivel;exit;
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


	 $this->sql="select a.codpre,b.nompre, sum(a.monasi) as monasi,sum(a.modificacion) as modificado from
	 			 (
	 			 select a.codpre,
	 			 sum(a.monasi) as monasi,(adicdism('$this->perdesde','$this->perhasta',a.codpre,'A')-adicdism('$this->perdesde','$this->perhasta',a.codpre,'D')) as modificacion from $tabla a
	 			 $sqlper
	 			 group by a.codpre

	 			 ) A, cideftit b where  length(rtrim(a.codpre))<=$caract and trim(a.codpre)=trim(b.codpre)
	 			 group by a.codpre,b.nompre
	 			 order by a.codpre
	 			  ";


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
	 $this->setY(22);$this->cell(180,5,$_POST["titulo"],0,0,'C');
	 $this->setY(26);$this->cell(180,5,"EJERCICIO FISCAL $this->anofis",0,0,'C');
	 $this->setY(30);$this->cell(180,5,$this->fecdes."  al  ".$this->fechas,0,0,'C');
	 $this->ln(6);
	 $this->setFont("Arial","B",9);
	 $this->cell(270,5,'Codigo Presupuestario Desde '.$this->codpredes.' Hasta '.$this->codprehas);
	 $this->ln(5);
	 $this->cell(270,5,'Periodo Del '.$this->perdesde.' Al '.$this->perhasta);
	 $this->ln(5);
	 $this->Line(10,$this->getY(),200,$this->getY());
	 $this->ln(5);
	 $this->SetWidths(array(25,75,25,25,25,15));
	 $this->SetBorder(true);
	 $this->Setaligns(array('C','C','C','C','C','C'));
	 $this->Row(array('Codigo','Nombre Presupuestario','Previsto','Modificaciones','Previsto Actualizado','%'));
	 $this->Setaligns(array('L','L','R','R','R','C'));
	}

	function Cuerpo()
	{
		while(!$this->tb->EOF)
		{
			$this->RowM(array(trim($this->tb->fields["codpre"]),trim($this->tb->fields["nompre"]),
			H::FormatoMonto($this->tb->fields["monasi"]),H::FormatoMonto($this->tb->fields["modificado"]),
			H::FormatoMonto($this->tb->fields["monasi"]-$this->tb->fields["modificado"]),
			H::FormatoMonto(($this->tb->fields["monasi"]*100) / ($this->tb->fields["monasi"]-$this->tb->fields["modificado"]))));

			if(strlen(trim($this->tb->fields["codpre"]))>=($this->caract-1))
			{
				$tot_pre+=$this->tb->fields["monasi"];
				$tot_mod+=$this->tb->fields["modificado"];
			}

			$this->tb->MoveNext();
		}
		//TOTALES
		$this->setAutoPageBreak(false);
		$this->ln(4);
		$this->RowM(array("","TOTAL Asignacion",
			H::FormatoMonto($tot_pre),H::FormatoMonto($tot_mod),
			H::FormatoMonto($tot_pre-$tot_mod),""));
    }
}
?>