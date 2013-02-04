<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	
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
		var $codsitemp1;
		var $codsitemp2;
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
			$this->codsitemp1=$_POST["codsitemp1"];
			$this->codsitemp2=$_POST["codsitemp2"];
			$this->sql="select codsitemp,dessitemp,
							  (CASE WHEN trim(calnom)='S' THEN 'SI' WHEN trim(calnom)='N' THEN 'NO' END) as calnom 
							  from npsitemp  
						      WHERE 
							        (codsitemp Between  '".$this->codsitemp1."' AND '".$this->codsitemp2."')
							  ORDER BY 
							  dessitemp asc";			
			$this->llenartitulosmaestro();
			
		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]="C�digo";
				$this->titulos[1]="Descripci�n";
				$this->titulos[2]="Calculo de Nomina";
				$this->anchos[0]=40;
				$this->anchos[1]=80;
				$this->anchos[2]=80;
		}

		function Header()
		{
			$dir = parse_url($_SERVER["HTTP_REFERER"]);
			$parte = explode("/",$dir["path"]);
			$ubica = count($parte)-2;
			$this->cab->poner_cabecera($this,$_POST["titulo"],$this->conf,"s",$parte[$ubica]);
			$this->setFont("Arial","B",7);
			$ncampos=count($this->titulos);
			for($i=0;$i<$ncampos;$i++)
			{
				$this->cell($this->anchos[$i],10,$this->titulos[$i]);
			}
			$this->ln(4); 
			$this->Line(10,45,200,45);
			//$this->MultiCell(2000,10,$this->sql);
			$this->ln(5); 
		}
		function Cuerpo()
		{
			$this->setFont("Arial","B",7);
		    $tb=$this->bd->select($this->sql);
			$ref="";
			while(!$tb->EOF)
			{
				 $this->setFont("Arial","",7); 
				 $this->cell($this->anchos[0],10,$tb->fields["codsitemp"]);
				 $this->cell($this->anchos[1],10,$tb->fields["dessitemp"]);
				 $this->cell($this->anchos[2],10,$tb->fields["calnom"]);
				 $tb->MoveNext();
			     $this->ln(3);
			}	
		}
	}
?>