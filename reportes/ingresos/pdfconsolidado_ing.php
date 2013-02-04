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

	function pre_ejecutar()
	{

		$sql="select DISTINCT A.Codpre as CODPRE,A.Nompre as NOMPRE
			  FROM CIASIINI A, CPDEFNIV B
			  WHERE RTRIM(A.CODPRE)>=RTRIM('$this->codpredes') and
			        RTRIM(A.CODPRE)<=RTRIM('$this->codprehas') and
			        A.PERPRE >= RTRIM('$this->perdes') AND
			        A.PERPRE <= RTRIM('$this->perhas') AND
			        (A.ANOPRE = TO_CHAR(B.FECINI,'YYYY') OR
			         A.ANOPRE = TO_CHAR(B.FECCIE,'YYYY'))AND
			        A.CODPRE LIKE RTRIM(('$this->comodin')) ";
                 
		$rs=$this->bd->select($sql);
		$ars=$rs->GetArray();

		$sql2="SELECT to_char(A.FECDES,'dd/mm/yyyy') as fecha
			       FROM CIPEREJE A,CIDEFNIV B
			       WHERE A.FECINI=B.FECINI AND
			            A.FECCIE=B.FECCIE AND
			            A.PEREJE='$this->perdes'
			       union all
			       SELECT to_char(A.FECHAS,'dd/mm/yyyy')
			       FROM CPPEREJE A,CPDEFNIV B
			       WHERE A.FECINI=B.FECINI AND
			            A.FECCIE=B.FECCIE AND
			            A.PEREJE='$this->perhas'";

		$rs2=$this->bd->select($sql2);
		$fecini=$rs2->fields["fecha"];
		$rs2->MoveNext();
		$feccie=$rs2->fields["fecha"];

		$this->bd->select(" DELETE CONSOLIDADO_INGRESO;
			  	  COMMIT;");
		foreach($ars as $dato)
		{
			$sqlp="select genera_consolidadoing('".$dato["codpre"]."','".$dato["nompre"]."','$fecini','$feccie') as resp from empresa ";
                        //H::PrintR($sqlp);exit;
			$this->bd->select($sqlp);
		}


	}

	function pdfreporte()
	{
	 $this->fpdf("p","mm","Letter");
	 $this->bd=new basedatosAdo();
	 $this->titulos=array();
	 $this->titulos2=array();
	 $this->campos=array();
	 $this->anchos=array();
	 $this->anchos2=array();
	 $this->codpredes=H::GetPost("codpredes");
	 $this->codprehas=H::GetPost("codprehas");
	 $this->perdes=H::GetPost("perdes");
	 $this->perhas=H::GetPost("perhas");
	 $this->comodin=H::GetPost("comodin");
	 $this->pre_ejecutar();

	 $this->sql="SELECT
				CODPRE,
				NOMPRE,
				TIPMOV,
				REFPRC,
				REFCOM,
				REFCAU,
				REFPAG,
				to_char(FECMOV,'dd/mm/yyyy') as FECMOV,
				CEDRIF,
				MONMOV,
				(select sum(monto) as porrecibir from (
					 SELECT MONASI as monto FROM CIASIINI WHERE CODPRE=(CONSOLIDADO_INGRESO.CODPRE) AND PERPRE='00'
					 union all
					  SELECT coalesce(SUM(A.MONMOV),0) as  monto  FROM CPMOVTRA A, CPTRASLA B
					  WHERE A.REFTRA=B.REFTRA AND
			     	  B.PERTRA>='01' AND
			          B.PERTRA<'$this->perhas' AND
			          A.CODDES=(CONSOLIDADO_INGRESO.CODPRE) AND
			          (B.STATRA='A' OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'mm')>'$this->perhas'))
					  union all
					  SELECT (coalesce(SUM(A.MONMOV),0)*(-1)) as  monto  FROM CPMOVTRA A, CPTRASLA B
					  WHERE A.REFTRA=B.REFTRA AND
			     	  B.PERTRA>='01' AND
			          B.PERTRA<'$this->perhas' AND
			          A.CODORI=(CONSOLIDADO_INGRESO.CODPRE) AND
			          (B.STATRA='A' OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'mm')>'$this->perhas'))
					  union all
					  SELECT (coalesce(SUM(A.MONING),0)*(-1)) as monto FROM CIIMPING A, CIREGING B
					   WHERE A.REFING=B.REFING AND
					   A.CODPRE=(CONSOLIDADO_INGRESO.CODPRE) AND
					   TO_CHAR(B.FECING,'mm')<'$this->perhas' AND
					   (A.STAIMP='A'OR
					   (A.STAIMP)='N' AND TO_CHAR(B.FECANU,'mm')>'$this->perdes' ) ) A) as porrecibir,
				DESMOV,
				AFEDIS
				from CONSOLIDADO_INGRESO
				ORDER BY CODPRE,NOMPRE,FECMOV,IDENTI";
				//H::printR($this->sql); exit;

	 $this->llenartitulosmaestro();
	 $this->cab=new cabecera();
	 $arrp=$this->bd->select($this->sql);
	 $this->arrp = $arrp->getArray();
	 $this->setAutoPageBreak(true,25);
	 $this->vr="M";
	}

	function llenartitulosmaestro()
	{
	 $this->titulos2[]=" <@ Código <,>arial,,9,155,0,0@>";
	 $this->titulos2[]=" <@ Denominacion <,>arial,,9,155,0,0@>";
	 $this->anchos2[]=40;
	 $this->anchos2[]=90;
	 $this->align3[]="C";
	 $this->align3[]="C";
	 $this->align4[]="C";
	 $this->align4[]="L";
	 $this->titulos[]="Fecha";
	 $this->titulos[]="Tipo";
	 $this->titulos[]="Referencia";
	 $this->titulos[]="Descripcion";
	 $this->titulos[]="Previsto";
	 $this->titulos[]="Por Recibir";
	 $this->anchos[]=20;
	 $this->anchos[]=20;
	 $this->anchos[]=25;
	 $this->anchos[]=70;
	 $this->anchos[]=25;
	 $this->anchos[]=25;
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align2[]="C";
	 $this->align2[]="C";
	 $this->align2[]="C";
	 $this->align2[]="L";
	 $this->align2[]="R";
	 $this->align2[]="R";
	}

	function Header()
	{
	 $this->cab->poner_cabecera($this,$this->titulo,"p","s","n");
	 $this->setFont("Arial","B",8);
	 $this->cell(190,5,'Período:  Del  '.$this->perdes.'  Al  '.$this->perhas,0,0,'C');
	 $this->ln(5);
	 $this->line(10,$this->GetY(),200,$this->GetY());
	 $this->setWidths($this->anchos2);
	 $this->setAligns($this->align3);
	 $this->row($this->titulos2);
	 $this->ln(-5);
	 $this->setWidths($this->anchos);
	 $this->setAligns($this->align);
	 $this->row($this->titulos);
	 $this->line(10,$this->GetY(),200,$this->GetY());
	 $this->ln(2);
	 if($this->vr=="M")
	 {
	 	$this->setWidths($this->anchos2);
	 	$this->setAligns($this->align4);
	 }
	 else
	 {
	 	$this->setWidths($this->anchos);
	 	$this->setAligns($this->align2);
	 }

	}

	function Cuerpo()
	{
  	 $this->setFont("Arial","",8);
	 $this->setWidths($this->anchos2);
	 $this->setAligns($this->align3);
	 $this->row(array(" <@ ".$this->arrp[0]["codpre"]."<,>arial,,9,155,0,0@>"," <@ ".$this->arrp[0]["nompre"]."<,>arial,,9,155,0,0@>"));
	 $ref=$this->arrp[0]["codpre"];
	 $this->ln(-4);
	 $tot_pre=0;
	 $tot_prec=0;
	 $tot_gen_pre=0;
	 $tot_gen_prec=0;

	 foreach ($this->arrp as $arr)
	 {
		if($ref!=$arr["codpre"])
		{$this->vr="M";
			//Totales
			$this->ln(4);
			$this->setAutoPageBreak(false);
			$this->line(140,$this->GetY(),200,$this->GetY());
			$this->setX(120);
			$this->MCplus(155,5," <@ TOTAL:    $this->codpre     ".H::FormatoMonto($tot_pre).'<,>arial,,9,155,0,0 @>');
			$tot_pre=0;
			$tot_prec=0;
			$this->setAutoPageBreak(true,25);
			////////
			$this->ln(4);
			$this->setWidths($this->anchos2);
	 		$this->setAligns($this->align4);
			$this->row(array(" <@ ".$arr["codpre"]."<,>arial,,9,155,0,0@>"," <@ ".$arr["nompre"]."<,>arial,,9,155,0,0@>"));
		}
		$this->vr="D";
		//detalle
		$this->ln(1);
		$this->setWidths($this->anchos);
	 	$this->setAligns($this->align2);
	 	$this->setX(10);
	 	$disponible=$arr["porrecibir"];
	 	if($arr["afedis"]<>'N')
	 		if($arr["afedis"]=='R')
	 			$disponible=$arr["porrecibir"]-$arr["monmov"];
	 		else
	 			$disponible=$arr["porrecibir"]+$arr["monmov"];

		$this->rowM(array($arr["fecmov"],$arr["tipmov"],$arr["refprc"],trim($arr["desmov"]),H::FormatoMonto($arr["monmov"]),H::FormatoMonto($disponible)));
		$this->setX(10);
		$tot_pre+=$arr["monmov"];
		$tot_prec+=$arr["porrecibir"];
		$tot_gen_pre=$arr["monmov"];
		$tot_gen_prec=$arr["porrecibir"];
		$ref=$arr["codpre"];
		$this->codpre=$arr["codpre"];
	 }
	 //Totales
	$this->ln(4);
	$this->setAutoPageBreak(false);
	$this->line(140,$this->GetY(),200,$this->GetY());
	$this->setX(120);
	$this->MCplus(155,5," <@ TOTAL:    $this->codpre     ".H::FormatoMonto($tot_pre).'<,>arial,,9,155,0,0 @>');
	$tot_liq=0;
	$this->setAutoPageBreak(true,25);
	////////
	/**TOTAL GENERAL**/
	$this->ln(4);
	$this->setAutoPageBreak(false);
	$this->line(140,$this->GetY(),200,$this->GetY());
	$this->setX(120);
	$this->MCplus(155,5," <@ TOTAL  INGRESO     ".H::FormatoMonto($tot_gen_pre).'<,>arial,,9,155,0,0 @>');


   }
}
?>