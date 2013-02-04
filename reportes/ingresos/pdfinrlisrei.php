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
	 $this->refdes=H::GetPost("refdes");
	 $this->refhas=H::GetPost("refhas");
	 $this->fecmin=H::GetPost("fecmin");
	 $this->fecmax=H::GetPost("fecmax");
	 $this->sql="select
				a.refrei,
				a.codtipgas,
				case when upper(c.destipgas)='FUNCIONAMIENTO' then 'PRESUPUESTO ORDINARIO' when upper(c.destipgas)='INVERSION' then 'PRESUPUESTO COORDINADO' end as destipgas,
				to_char(a.feclib,'dd/mm/yyyy') as feclib,
				a.cedrif,
				d.nomben,
				a.monmov,
				a.deslib,
				a.reflib,
				e.nomcue,
				e.desenl,
				a.numcue,
				f.codpre,
				f.monto
				from
				tsmovlib a
				left outer join
				nptipgas c
				on (trim(a.codtipgas)=trim(c.codtipgas))
				left outer join
				opbenefi d
				on (trim(a.cedrif)=trim(d.cedrif))
				left outer join
				tsdefban e
				on (trim(a.numcue)=trim(e.numcue))
				left outer join
				tsdetrei f
				on(a.refrei=f.refrei and trim(a.reflib)=trim(f.reflib)),
				tstipmov b
				where
				trim(a.refrei)>=trim('".$this->refdes."') and
				trim(a.refrei)<=trim('".$this->refhas."') and
				a.fecing>=to_date('".$this->fecmin."','dd/mm/yyyy') and
				a.fecing<=to_date('".$this->fecmax."','dd/mm/yyyy') and
				trim(a.tipmov)=trim(b.codtip) and
				b.starei = 'S'
				order by a.refrei";
				#	print $this->sql;exit;
/*
	 $this->sql="SELECT a.refliq,to_char(a.fecliq,'dd/mm/yyyy') as fecliq,a.desliq,A.refing as refing, to_char(A.fecing,'dd/mm/yyyy') as fecing, c.destip,
				trim(b.desenl) as desenl, trim(a.reflib) as reflib,A.montot as moning FROM
				CIREGING A left outer join citiping c on (a.codtip=c.codtip),
				tsdefban b
				WHERE
				A.REFLIQ>='".$this->refdes."'  AND
				A.REFLIQ<='".$this->refhas."'  AND
				A.FECLIQ>=to_date('".$this->fecmin."','dd/mm/yyyy') AND
				A.FECLIQ<=to_date('".$this->fecmax."','dd/mm/yyyy') AND
				a.ctaban=b.numcue
				ORDER BY A.REFLIQ,A.FECLIQ,a.refing";
*/
	 $this->llenartitulosmaestro();
	 $this->cab=new cabecera();
	 $arrp=$this->bd->select($this->sql);
	 $this->arrp = $arrp->getArray();
	 $this->setAutoPageBreak(true,25);
	 $this->vr="M";
	}

	function llenartitulosmaestro()
	{
	 $this->titulos2[]=" <@ REINTEGRO<,>arial,,9,155,0,0@>";
	 $this->titulos2[]=" <@ FECHA <,>arial,,9,155,0,0@>";
	 $this->titulos2[]=" <@ DESCRIPCION REINTEGRO<,>arial,,9,155,0,0@>";
	 $this->anchos2[]=30;
	 $this->anchos2[]=30;
	 $this->anchos2[]=120;
	 $this->align3[]="C";
	 $this->align3[]="C";
	 $this->align3[]="C";
	 $this->align4[]="C";
	 $this->align4[]="C";
	 $this->align4[]="L";
	 $this->titulos[]="REF. REINTEGRO";
	 $this->titulos[]="FECHA";
	 $this->titulos[]="TIPO";
	 $this->titulos[]="BANCO";
	 $this->titulos[]="DEPOSITO";
	 $this->titulos[]="MONTO";
	 $this->anchos[]=25;
	 $this->anchos[]=25;
	 $this->anchos[]=45;
	 $this->anchos[]=45;
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
	 $this->align2[]="C";
	 $this->align2[]="C";
	 $this->align2[]="R";
	}

	function Header()
	{
	 $this->cab->poner_cabecera($this,$_POST["titulo"],"p","s","n");
	 $this->setFont("Arial","B",8);
	 $this->cell(190,5,'Del '.$this->fecmin.' Al '.$this->fecmax,0,0,'C');
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
	 $this->row(array(" <@ ".$this->arrp[0]["refrei"]."<,>arial,,9,155,0,0@>"," <@ ".$this->arrp[0]["feclib"]."<,>arial,,9,155,0,0@>",
	 " <@ ".trim($this->arrp[0]["destipgas"])."<,>arial,,9,155,0,0@>"));
	 $ref=$this->arrp[0]["refrei"];
	 $this->ln(-4);
	 $tot_liq=0;
	 $tot_gen=0;
	 foreach ($this->arrp as $arr)
	 {
		if($ref!=$arr["refrei"])
		{$this->vr="M";
			//Totales
			$this->ln(4);
			$this->setAutoPageBreak(false);
			$this->line(140,$this->GetY(),200,$this->GetY());
			$this->setX(120);
			$this->MCplus(80,5,' <@ TOTAL POR REINTEGRO:         '.H::FormatoMonto($tot_liq).'<,>arial,,9,155,0,0 @>');
			$tot_liq=0;
			$this->setAutoPageBreak(true,25);
			////////
			$this->ln(4);
			$this->setWidths($this->anchos2);
	 		$this->setAligns($this->align4);
			$this->row(array(" <@ ".$arr["refrei"]."<,>arial,,9,155,0,0@>"," <@ ".$arr["feclib"]."<,>arial,,9,155,0,0@>",
	 		" <@ ".trim($arr["deslib"])."<,>arial,,9,155,0,0@>"));
		}
		$this->vr="D";
		//detalle
		$this->ln(1);
		$this->setWidths($this->anchos);
	 	$this->setAligns($this->align2);
		$this->rowM(array($arr["reflib"],$arr["feclib"],$arr["destipgas"],trim($arr["desenl"]),$arr["reflib"],H::FormatoMonto($arr["monto"])));
		$tot_liq+=$arr["monto"];
		$tot_gen+=$arr["monto"];
		$ref=$arr["refrei"];
	 }
	 //Totales
	$this->ln(4);
	$this->setAutoPageBreak(false);
	$this->line(140,$this->GetY(),200,$this->GetY());
	$this->setX(120);
	$this->MCplus(80,5,' <@ TOTAL POR REINTEGRO:         '.H::FormatoMonto($tot_liq).'<,>arial,,9,155,0,0 @>');
	$tot_liq=0;
	$this->setAutoPageBreak(true,25);
	////////
	/**TOTAL GENERAL**/
	$this->ln(4);
	$this->setAutoPageBreak(false);
	$this->line(140,$this->GetY(),200,$this->GetY());
	$this->setX(120);
	$this->MCplus(80,5,' <@ TOTAL GENERAL:         '.H::FormatoMonto($tot_gen).'<,>arial,B,9,155,0,0 @>');


   }
}
?>