<? 
./../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/general/funciones.php");
  require_once("../../lib/general/Herramientas.class.php");
//echo "222222";
  require_once("../../lib/modelo/sqls/compras/Carordser.class.php");
//echo "3333333";

  class pdfreporte extends FPDF
  {

    var $i=0;
    var $bd;
    var $arrp=array();
    var $cab;
    var $titulo;
    var $ordcomdes;
    var $ordcomhas;
    var $codprodes;
    var $codprohas;
    var $codartdes;
    var $codarthas;
    var $fecorddes;
    var $fecordhas;
    var $status;
    var $tipcom;
    var $despacho;
    var $condicion;
    var $conf;
    var $gerfin;
    var $diradm;
    var $cont;
    var $subtotal2;

    function pdfreporte()
    {
      $this->conf="p";
      $this->fpdf($this->conf,"mm","Letter");
      //$empresa = H::getEmpresa();
     // $this->bd=new basedatosAdo();
      $this->ordcomdes=str_replace('*',' ',H::GetPost("ordcomdes"));
      $this->ordcomhas=str_replace('*',' ',H::GetPost("ordcomhas"));
      $this->codprodes=str_replace('*',' ',H::GetPost("codprodes"));
      $this->codprohas=str_replace('*',' ',H::GetPost("codprohas"));
      $this->codartdes=str_replace('*',' ',H::GetPost("codartdes"));
      $this->codarthas=str_replace('*',' ',H::GetPost("codarthas"));
      $this->fecorddes=str_replace('*',' ',H::GetPost("fecorddes"));
      $this->fecordhas=str_replace('*',' ',H::GetPost("fecordhas"));
      $this->status=str_replace('*',' ',H::GetPost("status"));
      $this->tipcom=str_replace('*',' ',H::GetPost("tipcom"));
      $this->despacho=str_replace('*',' ',H::GetPost("despacho"));
      $this->coorcom=str_replace('*',' ',H::GetPost("coorcom"));
      $this->jefecom=str_replace('*',' ',H::GetPost("jefecom"));
      $this->diradm=str_replace('*',' ',H::GetPost("diradm"));
      $this->dirgeneje=str_replace('*',' ',H::GetPost("dirgeneje"));
      $this->cont=str_replace('*',' ',H::GetPost("cont"));

      $this->bd = new Carordser();

      $this->arrp = $this->bd->sqlp($this->ordcomdes,$this->ordcomhas,$this->codprodes,$this->codprohas,$this->codartdes,$this->codarthas,$this->fecorddes,$this->fecordhas,$this->status,$this->despacho);
    }


    function Header()
    {
      $this->SetAutoPageBreak(true,0.5);
      $this->SetFont("Arial","B",9);
      $this->formato();
      if ($this->arrp[$this->i]["staord"]=='Anulado')
      {
        $this->SetLineWidth(1);
        $this->SetDrawColor(100,1,1);
        $this->SetFont("Arial","B",84);
        $this->SetTextColor(100,1,1);
        //$this->SetAlpha(0.5);
        $this->Rotate(45,40,160);
        $this->RoundedRect(40, 160, 150, 25, 2.5, 'D');
        $this->Text(42,183,'ANULADA');
        $this->Rotate(0);
        $this->SetDrawColor(0);
        $this->SetTextColor(0);
        //$this->SetAlpha(1);
        $this->SetLineWidth(0);
      }

      //////fecha y numero de orden///////////////////////////////////

      $this->SetXY(165,36);
      $this->SetFont("Arial","",9);
      $this->Cell(20,4,$this->arrp[$this->i]["ordcom"]);
       $this->SetX(185);
       $this->Cell(20,4,$this->arrp[$this->i]["fecord"]);
      $ano= substr($this->arrp[$this->i]["fecord"],6,4);

      /*$uni=$this->bd->sql_unidad($this->arrp[$this->i]["ordcom"]);
      $this->SetFont("Arial","",7);
      $this->SetXY(67,46);
      //$this->Cell(40,3,$uni[0]["desubi"]);


      $this->SetFont("Arial","",11);
      $codarray=explode("-",trim($this->arrp[$this->i]["codcat"]));
      $numarray=count($codarray);
      $descat=$this->bd->sql_cpniveles();
      $indcat=0;
      $this->SetY(41);
      $this->SetFont("Arial","",7);
      $arrcod=array();
      foreach($descat as $cat)
      {
      $this->SetX(32);
      array_push($arrcod,$codarray[$indcat]);
      if($indcat<$numarray)
      {
        $arrdes=$this->bd->sql_nompre(implode("-",$arrcod));
        //$this->Cell(1,3,$cat["nomext"].": ".$codarray[$indcat]." - ".$arrdes[0]["nombre"]);
      //  $this->Cell(1,3,$arrdes[0]["nombre"]);
      }
      else
      {
        $this->Cell(1,3,$cat["nomext"].": No Aplica");
        continue;
      }
      $this->Ln(5);
      $indcat++;
      }*/


      $this->SetFont("Arial","",7);
    //  $this->SetXY(33,66);
    //  $this->MultiCell(170,3,$this->arrp[$this->i]["desord"]);
      $this->SetFont("Arial","",8);
      $this->SetXY(35,46);
      $this->MultiCell(100,3,$this->arrp[$this->i]["nompro"]);
      $this->SetXY(170,46);
      $this->Cell(12,3,$this->arrp[$this->i]["codpro"]);
      $this->SetXY(33,51);
      $this->SetFont("Arial","",7);
      $this->Cell(160,3,$this->arrp[$this->i]["dirpro"]);
      $this->SetFont("Arial","",8);
    //  $this->SetXY(22,56);
      //$this->Cell(12,3,$this->arrp[$this->i]["nrocei"]); // RNC
      $this->SetXY(33,56);
      $this->Cell(12,3,$this->arrp[$this->i]["telpro"]);
      $this->SetXY(140,56);
      $this->Cell(12,3,$this->arrp[$this->i]["faxpro"]);
      //Vamos a buscar la requisicion
      $req=$this->bd->sql_req($this->arrp[$this->i]["ordcom"]);

      if($req[0]["req"]!='') $nroreq = $req[0]["req"]; else $nroreq='N/A';
      if($req[0]["fecha"]!='') $fecreq = $req[0]["fecha"]; else $fecreq='N/A';

       $this->SetXY(10,36);
      $this->Cell(10,4,$nroreq);
        $this->SetXY(30,36);
      $this->Cell(10,4,$fecreq);


      $moneda = (isset($this->arrp[0])) ? $this->arrp[0]['nommon'] : 'SIN MONEDA';
      $this->SetXY(55, 36);
      $this->Cell(10, 4, $moneda);
	  /*
      //Vamosa buscar la Forma de Entrega
      $ent=$this->bd->sql_ent($this->arrp[$this->i]["ordcom"]);
      $this->SetXY(50,77);
      $this->Cell(10,3,$ent[0]["desforent"]);
      //Vamosa buscar la Condicion de Pago(efectivo / cheque/ otro)
      $cond=$this->bd->sql_conpag($this->arrp[$this->i]["ordcom"]);
      $this->SetXY(180,77);
      $this->Cell(10,3,$cond[0]["desconpag"]);
      //Vamosa buscar la unidad solicitante

      $this->SetXY(50,73);
      $this->Cell(180,3,$uni[0]["desubi"]);
      $this->SetY(135);*/
    }



    function formato()
    {
      $this->Rect(10,45,195,210);//Rectangulo grande

      $this->SetFont("Arial","B",8);
	  $this->Image("../../img/logo_1.jpg",87,10,28,23);
	  $this->SetXY(10,25);
	  $this->cell(25,4,'SOLICITUD DE COTIZACION');
	  $this->Rect(165,30,40,10);//Rectangulo superior izquierdo
	  $this->Rect(10,30,65,10);//Rectangulo superior derecho


	   $this->SetXY(10,31);
	  $this->cell(25,4,'Nro.');
    $this->cell(20, 4, 'FECHA');
    $this->cell(25, 4, 'MONEDA');
	    $this->SetXY(165,31);
	  $this->cell(25,4,'Nro. ORDEN');
	  $this->cell(20,4,'FECHA');
	  $this->line(30,30,30,40);//LINEAS VERTICALES
    $this->line(50, 30, 50, 40);
	  $this->line(185,30,185,40);



      $this->SetXY(10,35);
      $this->SetFont("Arial","B",12);
      if ($this->arrp[$this->i]["tipord"]=='S'){
          $this->Cell(180,5,"ORDEN DE SERVICIO",0,0,'C');
      }elseif ($this->arrp[$this->i]["tipord"]=='T') {
          $this->Cell(180,5,"CONTRATO",0,0,'C');
      }else {
          $this->Cell(180,5,"ORDEN DE COMPRA",0,0,'C');
      }
      $this->SetFont("Arial","",8);

      $this->Line(10,45,205,45);
      $this->Line(10,50,205,50);
      $this->Line(150,45,150,50);
      $this->Line(10,60,205,60);
      $this->Line(70,76,70,80);
      $this->Line(130,60,130,80);
	  $this->Line(165,60,165,76);
      $this->Line(10,80,205,80);


      $this->SetFont("Arial","",9);
      $this->SetXY(12,46);
      $this->Cell(55,3,'PROVEEDOR:',0,0,'L');
	  $this->SetXY(150,46);
      $this->Cell(10,3,'RIF / C.I:');
      $this->SetXY(12,51);
      $this->Cell(10,3,'DIRECCIÓN:');
      $this->SetXY(12,56);
      $this->Cell(10,3,'TELEFONO:');
        $this->SetXY(130,56);
      $this->Cell(10,3,'FAX:');
      $this->SetXY(12,61);
      $this->Cell(10,3,'LUGAR DE ENTREGA:');
	  $this->SetFont("Arial","B",7);
	  $this->SetXY(40,64);
	  $this->Cell(10,3,'LA NUEVA TELEVISION DEL SUR C.A.        RIF G-20004500-0');
	  $this->ln();
	  $this->SetFont("Arial","",7);
	  $this->Cell(10,3,'');
	  $this->Cell(60,3,'Calle Vargas con Santa Clara, Edif. Telesur, piso 1, Urbanización Boleita Norte, Zona Postal 1070');
	  $this->ln();
	  $this->Cell(20,3,'');
	  $this->Cell(60,3,'Edo. Miranda',0,0,'C');
	  $this->ln();
	  $this->Cell(20,3,'');
	  $this->Cell(60,3,'',0,0,'C');//telefono
	  $this->SetFont("Arial","",7);
      $this->SetXY(130,61);
      $this->Cell(10,3,'FORMA DE PAGO');
	  $this->SetXY(132,66);
	  $this->Cell(3,2,'',1,0,'C');
	  $this->SetFont("Arial","",7);
	  $this->Cell(15,3,'Efectivo');
	  $this->SetXY(132,71);
	  $this->Cell(3,2,'',1,0,'C');
	  $this->Cell(15,3,'Cheque');
      $this->SetXY(170,61);
      $this->Cell(10,3,'PLAZO DE ENTREGA');
	  $this->SetXY(168,66);
      $this->Cell(10,3,'________ DIAS CONTINUOS');
	  $this->SetXY(170,71);
	  $this->Cell(3,2,'',1,0,'C');
	  $this->Cell(15,3,'Anticipo');
	  $this->Line(130,64,205,64);
	  $this->SetFont("Arial","",9);
      $this->Line(10,76,205,76);
      $this->SetXY(12,77);
      $this->Cell(20,3,'SEGURO:');
	  $this->Cell(3,2,'',1,0,'C');
	  $this->SetFont("Arial","",7);
	  $this->Cell(15,3,'SI');
	  $this->Cell(3,2,'',1,0,'C');
	  $this->SetFont("Arial","",7);
	  $this->Cell(5,3,'NO');
	  $this->SetFont("Arial","",9);
	  $this->SetXY(70,77);
      $this->Cell(50,3,'COBERTURA:');
      $this->SetXY(130,77);
      $this->Cell(50,3,'MONTO');
      $this->SetXY(12,100);
//////////////////DETALLE

      $this->Line(10,85,205,85);
      $this->SetFont("Arial","",6);
	  $this->SetXY(9.25,81);
      $this->Cell(83,3,'REN');
      $this->Line(15,80,15,189);
	  $this->SetFont("Arial","",9);
	  $this->SetXY(20,81);
      $this->Cell(90,3,'CODIGO');
      $this->Line(49,80,49,189);
      $this->SetXY(53,81);
      $this->Cell(90,3,'DESCRIPCION DEL ARTICULO');
        $this->Line(105,80,105,189);
	  $this->SetFont("Arial","",6);
      $this->SetXY(105,81);
      $this->Cell(90,3,'UNIDAD DE MEDIDA');
      $this->Line(127,80,127,189);
	  $this->SetFont("Arial","",9);
      $this->SetXY(128,81);
      $this->Cell(90,3,'CANTIDAD');
      $this->Line(147,80,147,189);
      $this->SetXY(149,81);
	  $this->SetFont("Arial","",7);
      $this->Cell(90,3,'PRECIO UNITARIO');
	  $this->SetFont("Arial","",9);
      $this->Line(178,80,178,189);
      $this->SetXY(182,81);
      $this->Cell(90,3,'TOTAL');

      $this->Line(10,189,205,189);
	  $this->SetFont("Arial","",8);
      $this->SetXY(10,191);
      $this->Cell(90,3,'MONTO TOTAL EN LETRAS:');
	  $this->Line(147,189,147,194);
      $this->SetXY(148,191);
      $this->Cell(90,3,'TOTAL:');
      $this->Line(10,195,205,195);
      $this->SetXY(10,196);
      $this->Cell(90,3,'DESCRIPCION DE LA ORDEN:');
	  $this->SetFont("Arial","",9);

	  $this->Line(10,212,205,212);
      $this->Line(10,215,205,215);

     //  $this->Line(10,231,205,231);

      $this->Line(75,212,75,238);
      $this->Line(150,212,150,238);
      $this->SetFont("Arial","B",7);
	  $this->SetXY(11,212);
      $this->MultiCell(51,3,'FIANZA DE FIEL CUMPLIMIENTO');
	  $this->SetXY(78,212);
      $this->MultiCell(51,3,'CLAUSULA PENAL');
	  $this->SetXY(153,212);
      $this->MultiCell(51,3,'CLAUSULA ESPECIAL');
 $this->SetFont("Arial","",7);
      $this->SetXY(11,216);
      $this->MultiCell(60,3,'AL APROBARSE ESTA ORDEN AL BENEFICIARIO FIANZA DE FIEL CUMPLIMIENTO EQUIVALENTE AL ___% DEL MONTO DE LA ORDEN OTORGADA POR BANCO O COMPAÑIA DE SEGUROS, AUTENTICADA Y VIGENTE HASTA LA TOTAL RECEPCION DE LO SOLICITADO');
      $this->SetXY(78,216);
      $this->MultiCell(65,3,'QUEDA ESTABLECIDO QUE EL PROVEEDOR PAGARA EN CALIDAD DE CLAUSULA PENAL UN ___% DEL MONTO DE LA PRESENTE ORDEN DE COMPRA POR CADA DIA HABIL DE RETRASO EN LA ENTREGA DE LO SOLICITADO');
      $this->SetXY(153,216);
      $this->MultiCell(51,3,'EL ORGANISMO SE RESERVA EL DERECHO DE ANULAR UNILATERALMENTE LA PRESENTE ORDEN DE COMPRA, SIN INDEMNIZACIÓN ALGUNA ');
      
    //$this->line(10,230, 205, 230);
    //$this->line(10,234, 205, 234);
    $this->Cell(60,4,'',0,0,'C');

    $this->line(10,238, 205, 238);//DEBAJO DE OBSERVACIONES

    //FIRMAS ///////////////////////////////////////////////////////////////////
    $this->SetXY(10,238);
    $this->SetFont("Arial","B",6);
    $this->Cell(90,4,'UNIDAD DE COMPRAS',0,0,'C');
    $this->line(10,241, 100, 241);
    
    //LINEAS QUE SEPARAN LAS FIRMAS
    $this->line(40,241,40,255);//la primera
    $this->line(70,241,70,255);
    $this->line(100,238,100,255);
    $this->line(130,238,130,255);
    $this->line(160,238,160,255);//la ultima

    $this->SetXY(10,241);
    $this->setFont("Arial","B",5);
    $this->Cell(30,4,'ANALISTA ',0,0,'C');
    $this->Cell(30,4,'JEFE (A)',0,0,'C');
    $this->Cell(30,4,'DIR. ADMON. Y FINANZAS',0,0,'C');
    $this->SetXY(10,244);
    $this->setFont("Arial","",6);
    $this->Cell(30,4,$_SESSION["usuario"],0,0,'C');
    $this->Cell(30,4,$this->coorcom,0,0,'C');
    $this->Cell(30,4,$this->jefecom,0,0,'C');

    $this->SetXY(100,238);
    $this->setFont("Arial","B",5);
    $this->Cell(30,4,'DIR. GRAL. EJECUTIVO (A) ',0,0,'C');
    $this->Cell(30,4,'PRESIDENCIA ',0,0,'C');
    $this->Cell(40,4,'PROVEEDOR',0,0,'C');
    $this->SetXY(100,241);
    $this->setFont("Arial","",6);
    $this->Cell(30,4,$this->diradm,0,0,'C');
    $this->Cell(30,4,$this->dirgeneje,0,0,'C');
    ////////////////////////////////////////////////////////////////////////////

    $this->SetXY(10,257);
    $this->Cell(68,3,"FORMA 030",0,0,'L');
    //$this->Cell(128,3,"JR /RR /LVF /LVR /FT /CO /LR ",0,0,'R');

    $this->SetFont("Arial","B",4);

    }



    function Cuerpo()
    {
      $eof=count($this->arrp);
      $ref=$this->arrp[$this->i]["ordcom"];
      $moneda = $this->arrp[$this->i]["nommon"];
      $contador=1;
      $primeravez=true;
      $subtotal=0;
      $subtotal2=0;
      $iva=0;
      $total=0;
      $fecha=explode("/",$this->arrp[$this->i]["fecord"]);
      $detcat=false;
      $aun=false;
      $touch=false;
      $this->SetXY(11,86);
     while($this->i < $eof and $ref==$this->arrp[$this->i]["ordcom"])
      {
        $x=$this->GetX();
        $y=$this->GetY();
        if(!$detcat)
        {
          if(!$touch)
            $this->SetY(176);
          if(!$aun)
          {
            $this->SetY(176);
            $imput=$this->bd->sql_imp($this->arrp[$this->i]["ordcom"]);
            $indimp=0;
            $numimp=count($imput);
          }
          while($indimp<$numimp and !$touch)
          {
            $this->SetWidths(array(24,24,24,24,24,24,12,25));
            $this->SetAligns(array('C','C','C','C','C','C','C','R'));
            $codpre=explode("-",trim($imput[$indimp]["codigo"]));
            array_pad($codpre,9,'');
          //  $this->Row(array($codpre[0],$codpre[1],$codpre[2],$codpre[3],$codpre[4],$codpre[5],$imput[$indimp]["coduni"],H::FormatoMonto($imput[$indimp]["monto"])));

            $indimp++;
            if($indimp>=$numimp)
            {
              $detcat=true;
            }
            elseif($this->GetY() > 215)
            {
              $aun=true;
              $touch=true;
            }
          }

        }

        $this->SetXY($x,$y);

        $ancho = 55;
        $lineas = $this->NbLines($ancho,rtrim($this->arrp[$this->i]["desres"]));
        $lineasrestante = (170-$this->GetY())/4;

        //print $lineas.'<=>'.$lineasrestante.'<br>';

        if($lineas>$lineasrestante){

          $this->SetFont("Arial","B",8);
          $this->SetXY(152,174);
          $this->Cell(10,3,$nb.'Total Parcial: ');
          $this->SetX(164);
          $this->Cell(31,3,H::FormatoMonto($subtotal2),0,0,"R");
          $this->SetXY(20,176);
          $this->MultiCell(130,4,H::obtenermontoescrito($subtotal2,true,$moneda));
		  $this->SetFont("Arial","",8);
          $this->AddPage();
          //mando a imprimir la imputación para varias hojas cuando la orden tiene mas de una hoja
          $this->SetY(176);
          $this->SetY(176);
          $imput2=$this->bd->sql_imp($this->arrp[$this->i]["ordcom"]);
          $indimp2=0;
          $numimp2=count($imput2);

          while($indimp2<$numimp2)
          {
            $this->SetWidths(array(24,24,24,24,24,24,12,25));
            $this->SetAligns(array('C','C','C','C','C','C','C','R'));
            $codpre2=explode("-",trim($imput2[$indimp2]["codigo"]));
            array_pad($codpre2,9,'');
          //  $this->Row(array($codpre2[0],$codpre2[1],$codpre2[2],$codpre2[3],$codpre2[4],$codpre2[5],$imput2[$indimp]["coduni"],H::FormatoMonto($imput2[$indimp2]["monto"])));
            $indimp2++;
          }
          //fin de imputación
          $this->i--;
          $contador--;

          $subtotal-=($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]);
          $descuentos-=$this->arrp[$this->i]["dcto"];

          $this->SetXY(10,86);
        }else{

          $this->SetFont("Arial","",8);
          $this->SetWidths(array(3,36,51,30,13,30,31));
          $this->SetAligns(array('C','L','J','C','R','R','R'));
          $paginaantes=$this->PageNo();
          //if(strlen(rtrim($this->arrp[$this->i]["desres"]))>95) $this->SetFont("Arial","",6);
          $this->Row(array((string)$contador,substr( $this->arrp[$this->i]["codcat"],6,2).'-'.$this->arrp[$this->i]["codpar1"],rtrim($this->arrp[$this->i]["desres"]),$this->arrp[$this->i]["unimed"],H::FormatoMonto($this->arrp[$this->i]["cantot"]),H::FormatoMonto($this->arrp[$this->i]["preart"]),H::FormatoMonto(($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]))));
          //print '  ('.$this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"].')  ';
          $subtotal2+=($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]);
          $observ=$this->arrp[$this->i]["desord"];

        }

        if($paginaantes<$this->PageNo()) $touch=false;

        $subtotal=$subtotal+($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]);
        $descuentos+=$this->arrp[$this->i]["dcto"];

        $this->i++;
        $contador++;

        if($ref!=$this->arrp[$this->i]["ordcom"])
        {
          $ref=$this->arrp[$this->i]["ordcom"];
          $this->bdm=new basedatosAdo();
          $this->sql= "select a.monrgo as porcentaje,(CASE WHEN x.VALMON=0.0 THEN b.monrgo ELSE b.monrgo/x.valmon END) as suma, b.* from carecarg a,cargosol b inner join caordcom x on b.reqart=x.ordcom where b.reqart='".$this->arrp[$this->i-1]["ordcom"]."' and a.codrgo=b.codrgo";
          //print '<pre>'; print $this->sql; exit;

          $tb1=$this->bdm->select($this->sql);
          $eof2=count($tb1);
          $this->j=0;

          //$iva=$tb1->fields["suma"];

          //$this->Line(178,148+1,205,148+1);
          $this->SetFont("Arial","",7);
          $this->SetXY(150,180);
          $this->Cell(10,3,'SUB TOTAL:');
          $this->SetX(174);
          $this->Cell(31,3,H::FormatoMonto($subtotal),0,0,"R");
          if ($tb1->fields["monrgo"]!='')
          {
            $this->SetXY(150,$this->GetY()+3);
            $this->Cell(10,3,'DESCUENTO:');
            $this->SetX(174);
            $this->Cell(31,3,H::FormatoMonto(-1*$this->arrp[$this->i-1]["dtoord"]),0,0,"R");
            $subtotal=$subtotal-$this->arrp[$this->i-1]["dtoord"];
          }
          if ($descuentos!=""){
            $this->SetXY(150,$this->GetY()+3);
            $this->Cell(10,3,'DESCUENTO:');
            $this->SetX(174);
            $this->Cell(31,3,H::FormatoMonto($descuentos),0,0,"R");
            $subtotal=$subtotal-$descuentos;
            $descuentos=0;
          }

//          $this->sql= "SELECT sum(rgoart) as suma FROM caartord where ordcom='".$this->arrp[$this->i]["ordcom"]."'";
//              $tb1=$this->bd->select($this->sql);
     
          while(!$tb1->EOF ){
            $this->SetXY(150,$this->GetY()+3);
////////////////////////  IVA

            $iva=$tb1->fields["suma"];
            $ivaacum+=$iva;
            $this->Cell(10,3,'I.V.A. ('.(int)$tb1->fields["porcentaje"].'%):');
            $this->SetX(174);

////////////// IVA
            $this->Cell(31,3,H::FormatoMonto($iva),0,0,"R");
            $tb1->MoveNext();
          }

          while($indimp<$numimp and !$touch)
          {
            $this->SetWidths(array(24,24,24,24,24,24,12,25));
            $this->SetAligns(array('C','C','C','C','C','C','C','R'));
            $codpre=explode("-",trim($imput[$indimp]["codigo"]));
            array_pad($codpre,9,'');
           // $this->Row(array($codpre[0],$codpre[1],$codpre[2],$codpre[3],$codpre[4],$codpre[5],$imput[$indimp]["coduni"],H::FormatoMonto($imput[$indimp]["monto"])));

            $indimp++;
            if($indimp>=$numimp)
            {
              $detcat=true;
            }
            elseif($this->GetY() > 215)
            {
              $aun=true;
              $touch=true;
            }
          }

         // $this->Line(178,$this->GetY()+3,205,$this->GetY()+3);
          $this->SetXY(150,$this->GetY()+3);
         // $this->Cell(10,5,'TOTAL:');
	  $this->SetFont("Arial","",8);
          $this->SetXY(174,191);
///////////IVA
          $this->Cell(31,3,H::FormatoMonto($subtotal+$iva),0,0,"R");
          $this->SetXY(48,189);
		  $this->SetFont("Arial","",7);
          $this->MultiCell(95,3,H::obtenermontoescrito($subtotal+$iva,true,$moneda),0,'J',0);
          $this->SetXY(174,153);
          $this->SetFont("Arial","",5);
          $this->SetXY(55,196);
          $this->multiCell(150,2,$observ);
          $this->SetFont("Arial","",7);
          $subtotal2=0;
          //$this->Cell(31,5,H::FormatoMonto($subtotal+$iva),0,0,"R");

          if($this->i < $eof)
          {
            $this->AddPage();
            $detcat=false;
            $aun=false;
          }
          $contador=1;
          $subtotal=0;
          $this->SetXY(11,86);
        }
      }
    }
  }
?>
