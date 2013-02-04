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
		var $cta1;
		var $cta2;
		var $fecha1;
		var $fecha2;
		var $com1;
		var $com2;
		var $estado;
		var $auxd=0;
		var $auxc=0;
		var $cont=0;
		var $auxdg=0;
		var $auxcg=0;

		function pdfreporte()
		{
                        $this->arrp = array(1);
			$this->fpdf("p","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->fecha1=H::GetPost("fecha1");
			$this->fecha2=H::GetPost("fecha2");
			$this->estado=H::GetPost("estado");
			$this->com1=H::GetPost("com1");
			$this->com2=H::GetPost("com2");
			$this->estado=strtoupper(H::GetPost("estado"));
			$this->actualizado=H::GetPost("actualizado");
			$this->diferido=H::GetPost("diferido");
			$this->anulado=H::GetPost("anulado");
			$this->reservado=H::GetPost("reservado");
			$this->usuario="";
                        
                        $ruta = $_SERVER['HTTP_REFERER'];
                        
                        if(strstr($ruta, 'confincom')){
                          $this->sql="select a.numcom as comp, a.descom as descom, to_char(A.FECCOM,'dd/mm/yyyy') as fecha, a.stacom as estado,
                          b.codcta as cta, b.desasi as bdesasi, b.refasi as brefasi, b.debcre as bdebcre, b.monasi as bmonasi,
                          coalesce((select nomuse from \"SIMA_USER\".USUARIOS Where loguse=a.loguse),' ') as usuario
                          from contabc a,contabc1 b
                          where a.numcom=b.numcom and a.feccom=b.feccom and
                          a.numcom >= ('".$this->com1."') and a.numcom <= ('".$this->com2."')
                          order by a.feccom,a.numcom asc,b.debcre desc";
                          
                        }else{
                          if (strtoupper($this->estado)=="T")
                          {
                          $this->sql="select a.numcom as comp, a.descom as descom, to_char(A.FECCOM,'dd/mm/yyyy') as fecha, a.stacom as estado,
                          b.codcta as cta, b.desasi as bdesasi, b.refasi as brefasi, b.debcre as bdebcre, b.monasi as bmonasi,
                          coalesce((select nomuse from \"SIMA_USER\".USUARIOS Where loguse=a.loguse),' ') as usuario
                          from contabc a,contabc1 b
                          where a.numcom=b.numcom and a.feccom=b.feccom and
                          a.numcom >= RPAD('".$this->com1."',8,' ') and a.numcom <= RPAD('".$this->com2."',8,' ') and
                          a.feccom>=to_date('".$this->fecha1."','dd/mm/yyyy') and a.feccom<=to_date('".$this->fecha2."','dd/mm/yyyy')
                          order by a.feccom,a.numcom asc,b.debcre desc";
                          }
                          else
                          {
                          $this->sql="select a.numcom as comp, a.descom as descom, to_char(A.FECCOM,'dd/mm/yyyy') as fecha, a.stacom as estado,
                          b.codcta as cta, b.desasi as bdesasi, b.refasi as brefasi, b.debcre as bdebcre, b.monasi as bmonasi,
                          coalesce((select nomuse from \"SIMA_USER\".USUARIOS Where loguse=a.loguse),' ') as usuario
                          from contabc a,contabc1 b
                          where a.numcom=b.numcom and a.feccom=b.feccom and
                          a.numcom >= RPAD('".$this->com1."',8,' ') and a.numcom <= RPAD('".$this->com2."',8,' ') and
                          a.feccom>=to_date('".$this->fecha1."','dd/mm/yyyy') and a.feccom<=to_date('".$this->fecha2."','dd/mm/yyyy') and
                          (a.stacom like '".$this->estado."')
                          order by a.feccom,a.numcom asc,b.debcre desc";
                          }                          
                        }
                        

			//print $this->sql;

			//$this->llenartitulosmaestro();
			//$this->llenartitulosdetalle();
			$this->cab=new cabecera();

		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]="COMPROBANTE";
				$this->titulos[1]="DESCRIPCION";
				$this->titulos[2]="FECHA";
				$this->titulos[3]="ESTATUS";
		}
		function llenartitulosdetalle()
		{
				$this->titulos2[0]="Cuenta";
				$this->titulos2[1]="Descripcion del Asiento";
				$this->titulos2[2]="Referencia";
				$this->titulos2[3]="Debitos";
				$this->titulos2[4]="Creditos";
		}

		function Header()
		{
			$this->cab->poner_cabecera_f($this,"COMPROBANTES CONTABLES","p","s","s","s");
			//$this->cab->poner_cabecera_f($this,$_POST["titulo"],"p","s");
			/*
			$this->setFont("Arial","B",9);
			$ncampos=count($this->titulos);
			$ncampos2=count($this->titulos2);
			for($i=0;$i<$ncampos;$i++)
			{
				$this->cell($this->anchos[$i],7,$this->titulos[$i]);
			}
			$this->ln();
			for($i=0;$i<$ncampos2;$i++)
			{
				$this->cell($this->anchos2[$i],7,$this->titulos2[$i]);
			}
			$this->ln();
			$this->Line(10,55,200,55);
			$this->ln(); */
		}
		function Cuerpo()
		{

		    $tb=$this->bd->select($this->sql);
			$tb2=$tb;
			$this->setFont("Arial","B",8);
			$ncampos=count($this->titulos);

			if(!$tb2->EOF)
			{
				$ref=$tb2->fields["comp"];
				$this->usuario=$tb2->fields["usuario"];
				$this->Line(10,$this->GetY()-2,200,$this->GetY()-2);
				$this->cell(20,7,"Comprobante:  ");
				$this->setFont("Arial","",8);
				$this->cell(130,7,$tb->fields["comp"]);
				$this->setFont("Arial","B",8);
				$this->cell(12,7,"Fecha:  ");
				$this->setFont("Arial","",8);
				$this->cell(10,7,$tb->fields["fecha"]);
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->cell(20,7,"Descripcion:  ");
				$this->setFont("Arial","",8);
				$this->cell(130,7,substr($tb->fields["descom"],0,45));
				$this->setFont("Arial","B",8);
				$this->cell(15,7,"Estatus:  ");
				if (strtoupper($tb->fields["estado"])=='A'){$aux="Actualizado";}
				if (strtoupper($tb->fields["estado"])=='D'){$aux="Diferido";}
				if (strtoupper($tb->fields["estado"])=='N'){$aux="Anulado";}
				if (strtoupper($tb->fields["estado"])=='R'){$aux="Reversado";}
				$this->setFont("Arial","",8);
				$this->cell(10,7,$aux);
				$this->ln();
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->setFont("Arial","B",8);
				$this->cell(12,7,"Nro.");
				$this->cell(25,7,"Cuenta");
				$this->cell(70,7,"Descripcion de la Cuenta.");
				$this->cell(32,7,"Referencia");
				$this->cell(29,7,"Debito");
				$this->cell(25,7,"Credito");
				$this->ln();
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->ln(2);

			}
			while(!$tb->EOF)
			{
				if($tb->fields["comp"]!=$ref)
				{
				$this->cont=0;
				$this->setFont("Arial","B",8);
				$this->ln();
				$this->cell(133,5,"");
				$this->cell(25,5,"                                                                                                                                           Totales:                   ".number_format($this->auxd,2,'.',','),0,0,"R");
				$this->cell(30,5,"                                                                                                                                                                                        ".number_format($this->auxc,2,'.',','),0,0,"R");
				$this->ln();
				$this->ln();
				$this->ln();
				$this->ln();
				$this->cell(120,7,"                                                  Revisado por ");
				$this->cell(20,7,"Supervisado por  ");
				$this->Line(30,$this->GetY(),90,$this->GetY());
				$this->Line(110,$this->GetY(),170,$this->GetY());
				$this->auxd=0;
				$this->auxc=0;
				$this->Line(10,$this->GetY()-22,200,$this->GetY()-22);
				$this->setFont("Arial","B",15);
				$this->setFont("Arial","B",8);
//cuadro
				$this->Line(8,35,202,35);
				$this->Line(8,$this->GetY()+10,202,$this->GetY()+10);
				$this->Line(8,35,8,$this->GetY()+10);
				$this->Line(202,35,202,$this->GetY()+10);

				$this->ln(10);
				$this->cell(95,7,$this->usuario,0,0,'L');
				$this->ln();
				$this->ln(200);
				$this->cell(1,7,"");

				$this->cell(20,7,"Comprobante:  ");
				$this->setFont("Arial","",8);
				$this->cell(130,7,$tb->fields["comp"]);
				$this->setFont("Arial","B",8);
				$this->cell(12,7,"Fecha:  ");
				$this->setFont("Arial","",8);
				$this->cell(10,7,$tb->fields["fecha"]);
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->cell(20,7,"Descripcion:  ");
				$this->setFont("Arial","",8);
				$this->cell(130,7,substr($tb->fields["descom"],0,75));
				$this->setFont("Arial","B",8);
				$this->cell(15,7,"Estatus:  ");
				if (strtoupper($tb->fields["estado"])=='A'){$aux="Actualizado";}
				if (strtoupper($tb->fields["estado"])=='D'){$aux="Diferido";}
				if (strtoupper($tb->fields["estado"])=='N'){$aux="Anulado";}
				if (strtoupper($tb->fields["estado"])=='R'){$aux="Reversado";}
				$this->setFont("Arial","",8);
				$this->cell(10,7,$aux);
				$this->ln();
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->setFont("Arial","B",8);
				$this->cell(12,7,"Nro.");
				$this->cell(25,7,"Cuenta");
				$this->cell(70,7,"Descripcion de la Cuenta.");
				$this->cell(32,7,"Referencia");
				$this->cell(29,7,"Debito");
				$this->cell(25,7,"Credito");
				$this->ln();
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->ln(2);
		        }
				$ref=$tb->fields["comp"];
				$this->usuario=$tb2->fields["usuario"];
				$this->setFont("Arial","",8);
				//Detalle
				$this->cont=$this->cont+1;
				$this->cell(7,4," ".$this->cont);
				$this->cell(28,4,$tb->fields["cta"]);
				$this->cell(73,4,'');
				$this->cell(25,4,$tb->fields["brefasi"]);
				if (strtoupper($tb->fields["bdebcre"])=="D")
				{
				$this->auxd= $this->auxd + $tb->fields["bmonasi"];
				$this->auxdg= $this->auxdg + $tb->fields["bmonasi"];
				$this->cell(25,4,number_format($tb->fields["bmonasi"],2,'.',','),0,0,"R");
				$this->cell(30,4,"          0.00",0,0,"R");
				}
				else
				{
				$this->auxc= $this->auxc + $tb->fields["bmonasi"];
				$this->auxcg= $this->auxcg + $tb->fields["bmonasi"];
				$this->cell(25,4,"          0.00",0,0,"R");
				$this->cell(30,4,number_format($tb->fields["bmonasi"],2,'.',','),0,0,"R");
				}
				$this->setX(55);
				$this->multicell(50,4,$tb->fields["bdesasi"]);

				if($this->GetY()>230){
				$y=$this->GetY();
			$this->Line(8,35,202,35);
				$this->Line(8,$this->GetY()+10,202,$this->GetY()+10);
				$this->Line(8,35,8,$this->GetY()+10);
				$this->Line(202,35,202,$this->GetY()+10);
				$this->addpage();
				}
				//$this->ln();
				$tb->MoveNext();
			}
			$this->setFont("Arial","B",8);
			/*$this->Line(140,$this->GetY(),195,$this->GetY());
			$this->ln();
			$this->ln();
			$this->Line(10,$this->GetY(),200,$this->GetY());
			$this->cell(20,5,"                                                                                                                                           Totales:                   ".number_format($this->auxd,2,'.',','));
			*/


				$this->cont=0;
				$this->setFont("Arial","B",8);
				$this->Line(10,$this->GetY(),200,$this->GetY());

				$this->ln();
				$this->cell(138,5,"");
				$this->cell(20,5,"Totales:                   ".number_format($this->auxd,2,'.',','),0,0,"R");
				$this->cell(30,5,"".number_format($this->auxc,2,'.',','),0,0,"R");
				$y=$this->GetY();

				$this->Line(8,35,202,35);
				$this->Line(8,$this->GetY()+40,202,$this->GetY()+40);
				$this->Line(8,35,8,$this->GetY()+40);
				$this->Line(202,35,202,$this->GetY()+40);


				$this->ln();
				$this->ln();
				$this->ln();
				$this->ln();
				$this->cell(95,7,"Revisado por ",0,0,'C');
				$this->cell(95,7,"Supervisado por",0,0,'C');

				$this->Line(30,$this->GetY(),90,$this->GetY());
				$this->Line(110,$this->GetY(),170,$this->GetY());
				
				$this->auxd=0;
				$this->auxc=0;

				$this->setFont("Arial","B",15);
				$this->setFont("Arial","B",8);

				$this->ln();
				$this->ln();
				$this->ln();
				$this->cell(95,7,$this->usuario,0,0,'L');
		}
	}
?>
