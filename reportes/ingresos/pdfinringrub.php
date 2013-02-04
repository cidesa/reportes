<?php
//MODIFICADO POR ODUBER V�SQUEZ BRITO DESDE 14/01/2011
require_once("anchoinringrub.php");
  $objrep=new mysreportes();
  for($i=0;$i<count($obj->titulos);$i++)
  {
    $this->anchos[$i]=$objrep->getAncho($i);
  }
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
    var $sql;
    var $codpredes;
    var $codprehas;
    var $conf;

    function pdfreporte()
    {
      $this->conf="l";
      $this->fpdf($this->conf,"mm","oficio");
      $this->bd=new basedatosAdo();
      $this->titulos=array();
      $this->titulos2=array();
      $this->campos=array();
      $this->anchos=array();
      $this->totales=array();
      $this->totalesplanillas=array();
      $this->codpredes=$_POST["codpredes"];
      $this->codprehas=$_POST["codprehas"];
      $this->mesdes=intval($_POST["perdesde"]);
      $this->meshas=intval($_POST["perhasta"]);

      $this->sql="select ciimping.codpre, cideftit.nompre
      		from cireging inner join ciimping on ciimping.refing=cireging.refing inner join cideftit on
      		ciimping.codpre=cideftit.codpre inner join tsdefban on cireging.ctaban=tsdefban.numcue
      		where rtrim(ciimping.codpre)>=rtrim('".$this->codpredes."')
      		and rtrim(ciimping.codpre)<=rtrim('".$this->codprehas."')
      		group by ciimping.codpre, cideftit.nompre order by ciimping.codpre"; //print $this->sql; exit;

      //select ciimping.codpre, cideftit.nompre, cireging.fecing, cireging.desing, cireging.refing, cireging.moning from cireGing inner join ciimping on ciimping.refing=cireging.refing inner join cideftit on ciimping.codpre=cideftit.codpre inner join tsdefban on cireging.ctaban=tsdefban.numcue and rtrim(ciimping.codpre)>=rtrim('3-01-03-33-00 ') and rtrim(ciimping.codpre)<=rtrim('9-01-01-01-01 ') group by ciimping.codpre, cideftit.nompre, cireging.fecing, cireging.desing, cireging.refing, cireging.moning order by ciimping.codpre, cireging.fecing, cireging.refing



      $this->llenartitulosmaestro();
      $this->cab=new cabecera();
    }

    function llenartitulosmaestro()
    {
        $this->titulos[0]="CODIGO";
        $this->titulos[1]="DENOMINACION";
        $this->titulos[2]="ENERO";
        //$this->titulos[3]="PLAN";
        $this->titulos[3]="FEBRERO";
        $this->titulos[4]="MARZO";
        $this->titulos[5]="ABRIL";
        $this->titulos[6]="MAYO";
        $this->titulos[7]="JUNIO";
        $this->titulos[8]="JULIO";
        $this->titulos[9]="AGOSTO";
        $this->titulos[10]="SEPTIEMBRE";
        $this->titulos[11]="OCTUBRE";
        $this->titulos[12]="NOVIEMBRE";
        $this->titulos[13]="DICIEMBRE";
        $this->titulos[14]="TOTAL ANUAL";


    }


    function Header()
    {
      $rs=$this->bd->select("select to_char(feccie,'yyyy') as anofis from contaba");
      $this->fecha=$rs->fields["anofis"];//date("Y");
      //$this->cab->poner_cabecera($this,$_POST["titulo"],"l","s");

      $this->Image("../../img/admin_ha_fi.jpg",10,8,120);
      //fecha actual
      $fecha=date("d/m/Y");
      $this->setX(290);
      $this->setFont("Arial","B",8);
      $this->Cell(40,5,'Fecha: '.$fecha,0,0,'L');
      $this->ln(5);
      //Paginas
      $this->setX(290);
      $this->Cell(40,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'L');
        //Titulo Descripcion de la Empresa
         $tab = 45;
      $this->setFont("Arial","B",12);
      $this->Ln(-8);
      $this->setX($tab);
      //$this->Cell(270,5,'República Bolivariana de Venezuela',0,0,'L');
      $this->Ln(3);


	  $tb3=$this->bd->select("select * from empresa where codemp='001'");
   	  if(!$tb3->EOF)
	  {
		$nombre=$tb3->fields["nomemp"];
	  }

      $this->Ln(3);
      $this->setX($tab);
      $this->Cell(270,5,'',0,0,'L');
      $this->Ln(10);
      $this->setFont("Arial","B",12);
      $this->Cell(320,10,"INGRESOS PERCIBIDOS POR RUBROS Y MESES",0,0,'C',0);
      $this->ln(10);
      $this->Line(10,35,330,35);

      $ncampos=count($this->titulos);
      $this->setFont("Arial","B",5.5);
      $y=38;
      $this->SetY($y);
      for ($i=0;$i<$ncampos;$i++){
        $x=$this->GetX();
        $this->Multicell($this->anchos[$i],3,$this->titulos[$i],0,'C',0);
        $this->SetXY($x+$this->anchos[$i]+5.4,$y);
      }
      $this->Line(10,45,330,45);
      $this->ln(10);

    }


    function Cuerpo()
    {
      $tb=$this->bd->select($this->sql);

      $this->SetFont("Arial","",6);
      $this->ln();
      while(!$tb->EOF){

        $total=0;
        $totalplanillas=0;
        $y=$this->getY();
        $this->cell($this->anchos[0],5,$tb->fields["codpre"],0,0,"L");
        $this->setXY($this->anchos[0]+17,$y);
        $this->Multicell($this->anchos[1]+2,5,$tb->fields["nompre"],0,"L");
        $y2=$this->GetY();
        $this->setXY($this->anchos[0]+5+$this->anchos[1]+12,$y);
        for ($i=1;$i<=12;$i++){
          if ($i<10)
            $mes='0'.$i;
          else
            $mes=$i;
          $sqlsum=" SELECT coalesce(SUM(suma),0) AS SUMA, coalesce(count(planilla),0) as PLANILLA FROM (
		  			select  ciimping.montot as suma,ciimping.refing as planilla
           				from cireGing inner join ciimping
          				on (ciimping.refing=cireging.refing and ciimping.fecing=cireging.fecing)
          				inner join cideftit on ciimping.codpre=cideftit.codpre
          			where
						rtrim(ciimping.codpre)=rtrim('".$tb->fields["codpre"]."')
          				and to_char(cireging.fecing,'mm/yyyy')='".$mes."/".$this->fecha."'
					and (ciimping.staimp='A')
					)a"; //print $sqlsum; exit;
/*
          $sqlsum=" SELECT SUM(suma) AS SUMA, count(planilla) as PLANILLA FROM (
		  			select  ciimping.montot as suma,ciimping.refing as planilla
           				from cireGing inner join ciimping
          				on (ciimping.refing=cireging.refing and ciimping.fecing=cireging.fecing)
          				inner join cideftit on ciimping.codpre=cideftit.codpre
          			where
						rtrim(ciimping.codpre)=rtrim('".$tb->fields["codpre"]."')
          				and to_char(cireging.fecing,'mm/yyyy')='".$mes."/".$this->fecha."'
					and (ciimping.staimp='A' or
          				(ciimping.staimp='N' and to_char(cireging.fecanu,'mm/yyyy')='".$mes."/".$this->fecha."'))
					)a";// print $sqlsum; exit;

*/
		  $suma=0;
		  if($i>=$this->mesdes && $i<=$this->meshas)
		  {
		  	$tbsum=$this->bd->select($sqlsum);
		  	$suma=$tbsum->fields["suma"];
                        $totalplani=$tbsum->fields["planilla"];
                  }
                  else
                  {
                      $suma=0;
                      $totalplani=0;
		  }
          $this->cell($this->anchos[1+$i]-1.2,5,number_format($suma,'2',',','.'),0,0,'R');
          $this->cell(7,5,$totalplani,0,0,'C');

          $totalplanillas = $totalplanillas+$totalplani;
          $total=$total+$suma;
          $this->totales[$i-1]=$this->totales[$i-1]+$suma;
          $this->totalesplanillas[$i-1]=$this->totalesplanillas[$i-1]+$totalplani;
          //$this->totalestip[$i-1]=$this->totalestip[$i-1]+$tbsum->fields["suma"];

        }
        $this->cell($this->anchos[14],5,number_format($total,'2',',','.'),0,0,'R');
        $this->cell(7,5,$totalplanillas,0,0,'C');
        $this->SetY($y2);

        //$this->ln();
        if ($this->GetY()>=170){
           $this->AddPage();
        }
        //$ref=$tb->fields["codtip"];
        $tb->MoveNext();
    }

    $this->Line(10,$this->GetY(),340,$this->GetY());
    $this->SetX($this->anchos[0]);
    $this->SetFont("Arial","B",6);
    $this->cell($this->anchos[1]+2,5,"TOTAL             ",0,0,'R');
    $totalgeneral=0;
    for ($i=0;$i<12;$i++){
      $this->cell($this->anchos[$i+1]-0.9,5,number_format($this->totales[$i],'2',',','.'),0,0,'R');
      $this->cell(7,5,$this->totalesplanillas[$i],0,0,'C');
      $totalgeneral=$totalgeneral+$this->totales[$i];
    }
    $this->cell($this->anchos[14],5,number_format($totalgeneral,'2',',','.'),0,0,'R');
  }

}
?>
