<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Fadefalm.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql1;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $codalm1;
		var $codalm2;
		var $conf;

		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->codalm1=$_POST["codalm1"];
			$this->codalm2=$_POST["codalm2"];
			$this->p= new Fadefalm();
			$this->arrp = $this->p->sqlp($this->codalm1,$this->codalm2);
			$this->llenartitulosmaestro();

		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]="Codigo Almacen";
				$this->titulos[1]="Descripción Almacen";
				//$this->titulos[2]="Categoria";
				$this->anchos[0]=40;
				$this->anchos[1]=100;
				$this->anchos[2]=40;
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,$_POST["titulo"],$this->conf,"s","s");
			$this->ln(2);
			$this->setFont("Arial","B",9);
			$ncampos=count($this->titulos);
			for($i=0;$i<$ncampos;$i++)
			{
				$this->cell($this->anchos[$i],5,$this->titulos[$i]);
			}
			$this->ln(2);
			$this->Line(10,46,200,46);
			$this->ln(3);
		}
		function Cuerpo()
		{
			$this->setFont("Arial","B",8);
			$ref="";
			foreach($this->arrp as $dato)
			{

				$this->setFont("Arial","",8);
				 $this->cell($this->anchos[0],10,$dato["codigo"]);
				 $x=$this->GetX();
				 $this->MultiCell($this->anchos[1],10,$dato["nombre"]);
 			    $this->ln(1);
			    $y=$this->GetY();
			    if($y>=170)
			    {
			    	$this->AddPage();
			    }
			}
		}
	}
?>