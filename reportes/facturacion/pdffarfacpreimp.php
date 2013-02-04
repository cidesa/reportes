<?

require_once("../../lib/general/fpdf/fpdf.php");
require_once("../../lib/general/Herramientas.class.php");
require_once("../../lib/bd/basedatosAdo.php");
require_once("../../lib/general/cabecera.php");
require_once("../../lib/modelo/sqls/facturacion/Farfacpreimp.class.php");

class pdfreporte extends fpdf {

    var $bd;
    var $forma;
    var $entregado;
    var $recibido;
    var $h;
    var $reg;
    var $recargo;

    function pdfreporte() {
        $this->conf = "p";
        //$this->fpdf($this->conf,"mm",array(200,150));
        $this->fpdf($this->conf, 'mm', letter);
        $this->arrp = array("no_vacio");
        $this->arrref = array("no_vacio");
        $this->cab = new cabecera();
        $this->bd = new basedatosAdo();
        $this->condes = H::GetPost("codfacdes");
        $this->conhas = H::GetPost("codfachas");
        $this->ela = H::GetPost("ela");
        $this->rev = H::GetPost("rev");
        $this->apr = H::GetPost("apr");
        $this->farfacpreimp = new Farfacpreimp();
        $this->arrp = $this->farfacpreimp->sqlp($this->condes, $this->conhas);
        //H::PrintR($this->arrp);exit;
        $this->reg = 0;
    }

    function Formato($x, $y) {
        $this->SetXY($x + 130, $y + 22);
        $this->SetFont("ARIAL", "", 8);
        $this->SetWidths(array(18, 22));
        $this->SetAligns(array('L', 'L'));
        // $this->RowM(array('Nro de Control:',$this->arrp[$this->reg]['numcontrol']));
        $this->SetWidths(array(18, 22));
        $this->SetAligns(array('L', 'L'));
        $this->SetX($x + 132);
        $this->RowM(array('FACTURA:', $this->arrp[$this->reg]['reffac']));
        $this->SetX($x + 132);
        $this->RowM(array('FECHA:', $this->arrp[$this->reg]['fecha']));

        $this->SetFont("ARIAL", "", 8);
        $this->SetWidths(array(16, 114, 25, 19));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Nombre:', $this->arrp[$this->reg]['cliente'], '   Código Cliente:', $this->arrp[$this->reg]['codcli']));

        $this->SetWidths(array(16, 135));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('RIF:', $this->arrp[$this->reg]['rif']));

        $this->SetXY($x + 132, $this->GetY() - 4);
        $this->SetWidths(array(22, 32));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Cond. de Pago:', $this->arrp[$this->reg]['pago']));

        $this->SetWidths(array(16, 32));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Estado:', $this->arrp[$this->reg]['estado']));

        $this->SetWidths(array(16, 131));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Dirección:', $this->arrp[$this->reg]['direccion']));
        
        $this->SetWidths(array(19, 150));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Descripción:', $this->arrp[$this->reg]['observacion']));

        $this->SetWidths(array(21, 131));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Teléfono(s):', $this->arrp[$this->reg]['telefono']));

        $this->SetWidths(array(22, 100));
        $this->SetAligns(array('L', 'L'));

        $this->arrref = $this->farfacpreimp->sqlrefencias($this->arrp[$this->reg]['reffac']);

        $referencias = "";
        foreach ($this->arrref as $refere) {
            if ($referencias == "") {
                $referencias = $referencias . $refere['codref'];
            } else {
                $referencias = $referencias . ", " . $refere['codref'];
            }
        }

        if ($this->arrp[$this->reg]['tipref'] == 'D') {
            $this->RowM(array('Despacho Nro: ', $referencias));
        } else {
            $this->RowM(array('Pedido Nro: ', $referencias));
        }


        $this->SetWidths(array(25, 170));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Centro de Acopio:', $this->arrp[$this->reg]['centroacopio']));

        $this->SetWidths(array(25, 65, 20, 20, 20, 20, 20));
        $this->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C'));
        $this->SetBorder(true);
        $this->RowM(array('CÓDIGO', 'DESCRIPCIÓN', 'CANTIDAD', 'PRESENT.', 'PRECIO', 'DESCUENTO', 'IMPORTE'));
    }

    function Header() {
        // print "<pre>".$this->GetY();exit;

        if ($this->arrp[$this->reg]["status"] == 'N') {
            $this->SetLineWidth(1);
            $this->SetDrawColor(100, 1, 1);
            $this->SetFont("Courier", "", 55);
            $this->SetTextColor(100, 1, 1);
            //$this->SetAlpha(0.5);
            $this->Rotate(45, 40, 160);
//            $this->RoundedRect(58, 160, 110, 25, 2.5, 'D');
            $this->Text(90, 150, 'ANULADA');
            $this->Rotate(0);
            $this->SetDrawColor(0);
            $this->SetTextColor(0);
            //$this->SetAlpha(1);
            $this->SetLineWidth(0);
        }

        $x = $this->GetX();
        $y = $this->GetY();
        $this->Formato($x, $y);
    }

    function Footer() {
        $this->SetFont("ARIAL", "", 7);
        $this->SetXY(10, 230);
        $this->SetX(160);
        $this->SetWidths(array(20, 20));
        $this->SetAligns(array('R', 'R'));
        $this->RowM(array('Sub-Total', H::FormatoMonto($this->subtotal)));

        # Total Descuento
        $this->SetX(160);
        $this->SetWidths(array(20, 20));
        $this->SetAligns(array('R', 'R'));
        $this->RowM(array('Descuento', H::FormatoMonto($this->totaldcto[0]['totaldcto'])));

        # Iva
        $this->SetFont("ARIAL", "B", 7);
        $this->SetXY(10, 240);
        $this->SetWidths(array(10, 140));
        $this->SetAligns(array('L', 'L'));
        $this->RowM(array('Son:', H::obtenermontoescrito($this->total[0]['total'])));
        $this->SetXY(145, $this->GetY() - 4);
        $this->SetFont("ARIAL", "", 7);

        // Si no existe recargo de IVA
        if (($this->recargo[0]['nomrgo'] == null && $this->recargo[1]['nomrgo'] == null) || count($this->recargo) == 0) {

            //REGARGO 0,0
            $this->SetWidths(array(35, 20));
            $this->SetAligns(array('R', 'R'));
            $this->RowM(array('IVA', H::FormatoMonto(0)));
        } else {
            // Si existe al menos un tipo de IVA
            //BI PARA IVA 12%
            if ($this->recargo[0]['nomrgo'] != NULL) {
                $ti1 = 'Base Imponible ';
            } else {
                $ti1 = '';
            }
            if ($this->recargo[0]['nomrgo'] != NULL) {
                $this->SetWidths(array(35, 20));
                $this->SetAligns(array('R', 'R'));
                $this->RowM(array($ti1 . $this->recargo[0]['nomrgo'], H::FormatoMonto((isset($this->base1[0]['baseimponible']) ? $this->base1[0]['baseimponible'] : $this->base2[0]['baseimponible']))));
            }
            //BI PARA IVA 8%
            if ($this->recargo[1]['nomrgo'] != NULL) {
                $ti2 = 'Base Imponible ';
            } else {
                $ti2 = '';
            }
            $this->SetX(145);
            if ($this->recargo[1]['nomrgo'] != NULL) {
                $this->SetWidths(array(35, 20));
                $this->SetAligns(array('R', 'R'));
                $this->RowM(array($ti2 . $this->recargo[1]['nomrgo'], H::FormatoMonto($this->base2[0]['baseimponible'])));
            }
            // $this->SetX(160);
            // $this->SetWidths(array(20,20));
            // $this->SetAligns(array('R','R'));
            // $this->RowM(array('Sub-Total',H::FormatoMonto($this->subtotal)));
            //REGARGO PARA IVA 12%
            if ($this->recargo[0]['nomrgo'] != NULL) {
                $this->SetX(160);
                $this->SetWidths(array(20, 20));
                $this->SetAligns(array('R', 'R'));
                $this->RowM(array($this->recargo[0]['nomrgo'], H::FormatoMonto($this->recargo[0]['montorecargo'])));
            }
            //RECARGO PARA IVA 8%
            if ($this->recargo[1]['nomrgo'] != NULL) {
                $this->SetX(160);
                $this->SetWidths(array(20, 20));
                $this->SetAligns(array('R', 'R'));
                $this->RowM(array($this->recargo[1]['nomrgo'], H::FormatoMonto($this->recargo[1]['montorecargo'])));
            }
        }

        $this->SetX(160);
        $this->SetWidths(array(20, 20));
        $this->SetAligns(array('R', 'R'));
        $this->RowM(array('Total Exento', H::FormatoMonto($this->totalexnto[0]['totalexento'])));

        $this->SetFont("ARIAL", "B", 7);
        $this->SetX(155);
        $this->SetWidths(array(25, 20));
        $this->SetAligns(array('R', 'R'));
        $this->RowM(array('TOTAL A PAGAR.', H::FormatoMonto($this->total[0]['total'])));
        $this->SetFont("ARIAL", "", 8);
//                    $this->MultiCell(190, 3, 'Todos los pagos deben ser realizados únicamente a través de depositos, en las cuentas de: Productos Y Distribución Venezolana de Alimentos, S.A.(PDVAL), en los Bancos: Mercantil (0105-0699-95-1699061548), Mi casa (0425-0033-00-0200009925) (0425-0002-00-0200024968), Industrial (0003-0095-15-000100099-1), Banfoandes (0007-0044-46-000002509)', 0, 'J');
        /*
          $this->SetWidths(array(65, 65, 60));
          $this->SetAligns(array('C', 'C', 'C'));
          $this->SetBorder(true);
          $this->SetJump(15);
          $this->RowM(array('', '', ''));

          $this->SetY($this->GetY() - 15);
          $this->SetWidths(array(65, 65, 60));
          $this->SetAligns(array('L', 'L', 'L'));
          $this->SetJump(5);
          $this->RowM(array('Preparado por:', 'Revisado por:', 'Aprobado por:'));

          $this->SetWidths(array(65, 65, 60));
          $this->SetAligns(array('L', 'L', 'L'));
          $this->SetJump(5);
          $this->RowM(array('Nombre: ' . $this->ela, 'Nombre: ' . $this->rev, 'Nombre: ' . $this->apr));

          $this->SetWidths(array(65, 65, 60));
          $this->SetAligns(array('L', 'L', 'L'));
          $this->SetJump(5);
          $this->RowM(array('Firma:', 'Firma:', 'Firma:'));
         */
    }

    function Cuerpo() {


        $reffac = $this->arrp[0]['reffac'];
        $this->subtotal = 0;
        foreach ($this->arrp as $dato) {
            if ($reffac != $dato['reffac']) {
                $this->reg++;
                $this->AddPage();
                $this->subtotal = 0;
            }
            $reffac = $dato['reffac'];
            $this->arrp1 = $this->farfacpreimp->sqlp1($reffac);
            $this->total = $this->farfacpreimp->sqlmontos('T', $this->arrp[$this->reg]['reffac']);
            $this->base1 = $this->farfacpreimp->sqlmontos('BI1', $this->arrp[$this->reg]['reffac']);
            $this->base2 = $this->farfacpreimp->sqlmontos('BI2', $this->arrp[$this->reg]['reffac']);
            $this->recargo = $this->farfacpreimp->sqlmontos('R', $this->arrp[$this->reg]['reffac']);
            $this->totalexnto = $this->farfacpreimp->sqlmontos('TE', $this->arrp[$this->reg]['reffac']);
            $this->totaldcto = $this->farfacpreimp->sqlmontos('TD', $this->arrp[$this->reg]['reffac']);
            foreach ($this->arrp1 as $dato1) {
                $this->SetWidths(array(25, 65, 20, 20, 20, 20, 20));
                $this->SetAligns(array('C', 'L', 'R', 'C', 'R', 'R', 'R', 'R'));
                $this->SetFont("ARIAL", "", 7);
                //      $this->RowM(array($dato1['codart'], $dato1['articulo'], H::FormatoMonto($dato1['cantidad'], 2), $dato1['present'], 
//H::FormatoMonto($dato1['precio']).' '.$dato1['exento'], H::FormatoMonto($dato1['mondes']), H::FormatoMonto($dato1['totart'])));
                $this->RowM(array($dato1['codart'], $dato1['articulo'], H::FormatoMonto($dato1['cantidad'], 2), $dato1['present'], H::FormatoMonto($dato1['precio']) . ' ' . $dato1['exento'], H::FormatoMonto($dato1['mondes']), H::FormatoMonto($dato1['cantidad'] * $dato1['precio'])));

                $this->subtotal+=$dato1['cantidad'] * $dato1['precio'];
                if ($this->GetY() > 220) {
                    $this->AddPage();
                }
            }
        }
        /* 	     $reg=1;
          $reffac="";
          $codart="";
          $reg1=1;
          $monto=0;
          $registro=count($this->arrp);
          $y=11;
          $x=20;
          foreach($this->arrp as $dato)
          {

          $reg++;
          if($dato["reffac"]!=$reffac)
          {

          //$this->SetXY(120,10);
          //$this->setFont("Arial","",7);
          //$this->Multicell(40,4,'Correlativo: '.$dato["reffac"]);
          $this->SetXY(35,4+$y);
          $this->setFont("Arial","",8);
          $this->Multicell(120,4,$dato["cliente"]);

          $this->SetXY(17,9+$y);
          $this->Multicell(120,6,$dato["direccion"]);

          $this->SetXY(10,21+$y);
          $this->setFont("Arial","",7);
          $this->cell(23,5,$dato["telefono"]);
          $this->SetXY(53,21+$y);
          $this->cell(25,5,$dato["rif"]);

          $fechadia=substr($dato["fecha"],0,2);
          $fechames=substr($dato["fecha"],3,2);
          $fechaanio=substr($dato["fecha"],6,4);

          $this->SetXY(120,23+$y);
          $this->cell(20,5,$fechadia.'      '.$fechames.'         '.$fechaanio);

          if ($dato["forma"]!='CREDITO')
          {
          $this->SetXY(96,28+$y);
          $this->cell(20,5,'CONTADO');
          }
          else
          {
          $this->SetXY(145,28+$y);
          $this->cell(20,5,'CREDITO');
          }
          $reffac=$dato["reffac"];
          $this->arrp1 = $this->farfacpreimp->sqlp1($reffac);
          $total_bruto=0;
          $total_recargos=0;
          $total_bruto_acumulado=0;
          $total_pagar=0;
          $this->SetXY(5,44+$y);
          $yy=$this->Gety();
          $total_recargo=0;
          $codart="";
          $band=true;
          $subtotal=0;
          $i=0;

          foreach($this->arrp1 as $dato1)
          {
          // H::PrintR($dato1);exit;

          $tipo=substr($dato1["codart"],0,7);
          $tipox=$tipo.';';
          // echo $tipox;


          if($tipox!='00-0001;' and $tipox!='00-0002;')  //SI SON FACTURAS TIPO1
          {
          if($dato1["codart"]!=$codart)
          {
          $tiposub=substr($dato1["codart"],0,7);
          $this->setFont("Arial","",7);
          $total_bruto=$dato1["cantidad"]*$dato1["precio"];
          $total_bruto_acumulado+=$total_bruto;


          if((substr($dato1["codart"],0,7)!=substr($codart,0,7)) and $codart!="")
          {
          $this->arrp10 = $this->farfacpreimp->sqlpdes($reffac);
          $subtotal=0;
          $this->SetXY(15,$this->Gety());
          $this->setFont("Arial","B",7);
          $this->cell(120,5,'SUBTOTAL '.substr($codart,0,7).': '.$this->arrp10[$i]["articulo"]);
          $i++;
          $this->SetX(130);
          $this->cell(15,5,H::FormatoMonto($subtotal_acum),0,0,'R');
          $this->setFont("Arial","",7);
          $this->line(128,$this->Gety(),148,$this->Gety());
          $this->ln(10);
          $subtotal_acum=0;
          //echo $subtotal;
          }
          $this->Ln(1);
          $this->SetX(5);
          $this->SetWidths(array(70,20,25,25));
          $this->SetAligns(array("L","R","R","R"));
          $this->setBorder(0);
          $this->RowM(array($dato1["codart"].' - '.$dato1["articulo"],$dato1["cantidad"],H::FormatoMonto($dato1["precio"]),H::FormatoMonto($total_bruto)));
          $codart=$dato1["codart"];
          $total_recargo+=$dato1["recargo"];
          $subtotal=$dato1["cantidad"]*$dato1["precio"];
          $subtotal_acum+=$subtotal;
          }
          }
          else  //SI SON FACTURAS DE TRANSPORTE
          {
          if($band==true)
          {
          $this->setFont("Arial","",6);
          $this->Ln(1);
          $this->SetX(5);
          $this->SetWidths(array(10,10,15,50,20,20,20));
          $this->SetAligns(array("C","C","C","C","C","C","C"));
          $this->setBorder(0);
          $this->RowM(array('O/D','N/E','Guia','Destinos','Contenedores','B-L','Bs.'));
          $y=$this->GetY();
          $this->Line(5,$y,148,$y);
          $band=false;
          }

          $tiposub2=substr($dato1["codart"],0,7);
          $total_bruto=$dato1["cantidad"]*$dato1["precio"];
          $total_bruto_acumulado+=$total_bruto;
          if((substr($dato1["codart"],0,7)!=substr($codart,0,7)) and $codart!="")
          {
          $this->arrp10 = $this->farfacpreimp->sqlpdes($reffac);
          $subtotal=0;
          $this->SetXY(15,$this->Gety());
          $this->setFont("Arial","B",6);
          $this->cell(120,5,'SUBTOTAL '.substr($codart,0,7).': '.$this->arrp10[$i]["articulo"]);
          $i++;
          $this->SetX(125);
          $this->cell(15,5,H::FormatoMonto($subtotal_acum),0,0,'R');
          $this->setFont("Arial","",6);
          $this->line(123,$this->Gety(),143,$this->Gety());
          $this->ln(10);
          $subtotal_acum=0;
          //echo $subtotal;
          }



          $this->Ln(1);
          $this->SetX(5);
          $this->SetWidths(array(10,10,15,50,18,18,20));
          $this->SetAligns(array("C","C","C","L","C","C","R"));
          $this->setBorder(0);
          $this->RowM(array($dato1["orddespacho"],$dato1["nronot"],$dato1["guia"],$dato1["articulo"],$dato1["contenedores"],$dato1["billleading"],H::FormatoMonto($dato1["precio"])));
          $codart=$dato1["codart"];
          $total_recargo+=$dato1["recargo"];
          $subtotal=$dato1["cantidad"]*$dato1["precio"];
          $subtotal_acum+=$subtotal;


          }

          }

          $tipo=substr($dato1["codart"],0,7);
          $tipox=$tipo.';';
          // echo $tipox;


          if($tipox!='00-0001;' and $tipox!='00-0002;')
          {
          $this->arrp10 = $this->farfacpreimp->sqlpdes($reffac);
          $this->SetXY(15,$this->Gety());
          $this->setFont("Arial","B",7);
          $this->cell(120,5,'SUBTOTAL '.substr($codart,0,7).': '.$this->arrp10[$i]["articulo"]);
          $this->SetX(130);
          $this->cell(15,5,H::FormatoMonto($subtotal_acum),0,0,'R');
          $this->setFont("Arial","",7);
          $this->line(128,$this->Gety(),148,$this->Gety());
          }
          else
          {
          $this->arrp10 = $this->farfacpreimp->sqlpdes($reffac);
          $this->SetXY(15,$this->Gety());
          $this->setFont("Arial","B",6);
          $this->cell(120,5,'SUBTOTAL '.substr($codart,0,7).': '.$this->arrp10[$i]["articulo"]);
          $this->SetX(131);
          $this->cell(15,5,H::FormatoMonto($subtotal_acum),0,0,'R');
          $this->setFont("Arial","",6);
          $this->line(129,$this->Gety(),149,$this->Gety());

          }

          $subtotal_acum=0;
          $this->arrp2 = $this->farfacpreimp->sqlp2($reffac);
          $this->arrp3 = $this->farfacpreimp->sqlp3($reffac);
          $monto_subtototal=$subtotal_acum;
          $monto+=$this->arrp2[0]["monto"];
          $total_pagar=($total_bruto_acumulado)+$total_recargo;
          //$this->SetXY(10,59+$y);
          $this->SetXY(10,168);
          $this->SetWidths(array(110,20));
          $this->SetAligns(array("C","R"));
          $this->setBorder(0);
          $this->SetFont("Arial","",7);
          $this->Row(array("",H::FormatoMonto($total_bruto_acumulado)));
          $this->Ln(-0.2);



          $this->SetWidths(array(80,30,20));
          $this->SetAligns(array("C","C","R"));
          $this->setBorder(0);
          $this->Row(array("",H::FormatoMonto($this->arrp3[0]["recargo"]),H::FormatoMonto($total_recargo)));
          $this->Ln(-0.2);


          $this->SetWidths(array(110,20));
          $this->SetAligns(array("C","R"));
          $this->setBorder(0);
          //print  H::FormatoMonto($dato["monto"]);exit;
          $this->Row(array("",H::FormatoMonto($total_pagar)));
          $h=$this->GetY();
          $this->Ln(-10);
          $this->SetWidths(array(40));
          $this->SetAligns(array("C"));
          $this->setBorder(0);
          $this->Row(array($this->entregado));
          $this->Row(array($this->recibido));
          // $this->arrp5 = $this->farfacpreimp->sqlp5($reffac);
          //$this->SetY(11);


          /* $this->SetY($h);
          if ($dato["forma"]!='CREDITO')
          {
          $this->cell(25,6,'Forma de Pago : ');
          $banco=' ';
          $contar=0;
          foreach($this->arrp5 as $dato5)
          {
          if ($dato5["banco"]!="" and strlen($dato5["banco"])>=28)
          {
          $banco=substr($dato5["banco"],0,28).'...';
          }
          elseif ($dato5["banco"]!="" and strlen($dato5["banco"])<28)
          {
          $banco=$dato5["banco"];
          }
          elseif ($dato5["banco"]="")
          {
          $banco='';
          }
          $this->SetY($h+5+$contar);
          $this->setFont("Arial","",8);
          $this->SetWidths(array(23,23,55,30));
          $this->SetAligns(array("L","C","L","L"));
          $this->setBorder(0);
          $this->Row(array($dato5["pago"],$dato5["numero"],$banco,'Monto : '.H::FormatoMonto($dato5["monto"])));
          $contar+=3;
          }
          }
          else
          {
          $this->cell(25,6,'');
          $this->SetY($h);
          $this->setFont("Arial","",9);
          $this->SetWidths(array(40,30,30,30));
          $this->SetAligns(array("L","L","L","L"));
          $this->setBorder(0);
          $this->Row(array('',$dato["numero"],$dato["banco"],'Monto : '.H::FormatoMonto($dato["monto"])));
          $this->pos=$this->GetY();
          } */


        /*      if ($reg<=$registro)
          {
          $this->AddPage();
          $this->SetY(11);

          }

          }//if primer foreach
          } */
        ////foreach
    }

//cuerpo
}

//fin de la clase
?>
