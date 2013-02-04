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
	 $this->fpdf("l","mm","Letter");
	 $this->bd=new basedatosAdo();
	 $this->titulos=array();
	 $this->titulos2=array();
	 $this->campos=array();
	 $this->anchos=array();
	 $this->anchos2=array();
	 $this->refdes=H::GetPost("refdes");
	 $this->refhas=H::GetPost("refhas");
	 $this->rifcondes=H::GetPost("rifcondes");
	 $this->rifconhas=H::GetPost("rifconhas");
	 $this->fecmin=H::GetPost("fecmin");
	 $this->fecmax=H::GetPost("fecmax");
	 $this->tipdes=H::GetPost("tipdes");
	 $this->tiphas=H::GetPost("tiphas");
	 $this->ctabandes=H::GetPost("ctabandes");
	 $this->ctabanhas=H::GetPost("ctabanhas");
         $this->statusdes=H::GetPost("statusdes");
	 $this->vartotgen="moning";
         if ($this->statusdes=='A')
         {
           $this->cadena="(A.staing='A' OR (A.StaIng='N' And A.FecAnu>to_date('".$this->fecmax."','dd/mm/yyyy'))) And ";       
         }  
         else
         {
          $this->cadena="A.staing='N' And ";      
         }    
	 $this->sql="SELECT A.refing as refing, to_char(A.fecing,'dd/mm/yyyy') as fecing,  b.nomcue as nomcue,b.numcue,
		            a.numdep as reflib,d.nomcon, formatonum(sum(g.moning)) as moning ,A.desing as desing, c.destiprub as destiprub
                                FROM CIREGING A left outer join citiprub c on (a.codtip=c.codtiprub) left outer join  CICONREP D  on (a.rifcon=d.rifcon),
				tsdefban b,ciimping g
				WHERE
				trim(A.REFING)>=trim('".$this->refdes."')  AND
				trim(A.REFING)<=trim('".$this->refhas."')  AND
				A.FECING>=to_date('".$this->fecmin."','dd/mm/yyyy') AND
				A.FECING<=to_date('".$this->fecmax."','dd/mm/yyyy') AND
				trim(D.RIFCON)>=trim('".$this->rifcondes."') AND
				trim(D.RIFCON)<=trim('".$this->rifconhas."') AND
				g.CODTIPrub >= '".$this->tipdes."' AND
				g.CODTIPrub <= '".$this->tiphas."' AND
				a.ctaban>='".$this->ctabandes."' and
				a.ctaban<='".$this->ctabanhas."' and 
                                ".$this->cadena."
				a.ctaban=b.numcue and
                                a.refing=g.refing
                                GROUP BY A.refing, A.fecing,b.nomcue,b.numcue,a.numdep,d.nomcon,A.desing,c.destiprub
				ORDER BY A.FECING,a.refing";

//print($this->sql);exit;
	 $this->llenartitulosmaestro();
	 $this->cab=new cabecera();
	 $arrp=$this->bd->select($this->sql);
	 $this->arrp = $arrp->getArray();
	 $this->setAutoPageBreak(true,25);
	}

	function llenartitulosmaestro()
	{
	 $this->titulos[]="PLANILLA";
	 $this->titulos[]="FECHA";
	 $this->titulos[]="BANCO";
	 $this->titulos[]="CUENTA";
	 $this->titulos[]="DEPOSITO";
	 $this->titulos[]="BENEFICIARIO";
         $this->titulos[]="CONCEPTO";
	 $this->titulos[]="VALOR";
	 $this->anchos[]=15;
	 $this->anchos[]=15;
	 $this->anchos[]=20;
	 $this->anchos[]=30;
	 $this->anchos[]=15;
	 $this->anchos[]=60;
         $this->anchos[]=90;
	 $this->anchos[]=20;
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
	 $this->align[]="C";
         $this->align[]="C";
	 $this->align2[]="L";
	 $this->align2[]="L";
	 $this->align2[]="L";
	 $this->align2[]="L";
	 $this->align2[]="L";
	 $this->align2[]="L";
         $this->align2[]="L";
	 $this->align2[]="R";
	}

	function Header()
	{
          if ($this->statusdes=='A')
         {
           $aux="";       
         }  
         else
         {
          $aux=" (ANULADAS) ";      
         }           
	 $this->cab->poner_cabecera($this,$_POST["titulo"]. $aux,"l","s","n");
	 $this->setFont("Arial","B",8);
        // oduber
        //$this->cell(10,5,'AQUI');  
       //
	 $this->cell(270,5,'Del '.$this->fecmin.' Al '.$this->fecmax,0,0,'C');
	 $this->ln(5);
	 $this->setWidths($this->anchos);
	 $this->setAligns($this->align);
	 $this->setBorder(true);
	 $this->row($this->titulos);
	 $this->setAligns($this->align2);
	}

	function Cuerpo()
	{
  	 $this->setFont("Arial","",7);
	 $vartotgen=0;
         $cuantos=0;
	 foreach ($this->arrp as $arr)
	 {		//Detalle
		$this->rowM(array($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[7],$arr[6]));
		$vartotgen+=H::FormatoNum($arr[$this->vartotgen]);
                $cuantos+=1;
	 }
	 //totales
	 $this->setAutoPageBreak(false);
	 $auxtot = implode("+",$this->anchos);
	 eval('$ancho = '.$auxtot.';');
	 $this->setFont("Arial","B",9);
	 $this->multicell($ancho,5,"TOTAL GENERAL :  ".H::FormatoMonto($vartotgen),0,"R");
         $this->ln();
         $this->multicell($ancho,5,"Nro PLANILLAS :  ".H::FormatoMonto($cuantos),0,"R");


   }
}
?>
