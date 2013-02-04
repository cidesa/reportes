<?

require_once("../../lib/general/fpdf/fpdf.php");
require_once("../../lib/bd/basedatosAdo.php");
require_once("../../lib/general/Cabecera.php");
require_once("../../lib/general/funciones.php");
require_once("../../lib/general/Herramientas.class.php");
require_once("../../lib/modelo/sqls/tesoreria/Tsrvoucher_cc.class.php");

class pdfreporte extends fpdf {

   var $bd;
   var $titulos;
   var $titulos2;
   var $anchos;
   var $anchos2;
   var $campos;
   var $sql;
   var $sql1;
   var $sql1b;
   var $sql1c;
   var $sql2;
   var $sql3;
   var $sqlb;
   var $che1;
   var $che2;
   var $hecho;
   var $revi;
   var $conta;
   var $audi;
   var $mes;
   var $ano;
   var $apro;
   var $ela;
   var $cod1;
   var $cod2;
   var $deb;
   var $cre;
   var $status;
   var $auxd = 0;
   var $car;
   var $acumsalant = 0;
   var $acumdeb = 0;
   var $acumlib = 0;
   var $acumban = 0;
   var $acumlib2 = 0;
   var $acumban2 = 0;
   var $sal = 0;
   var $fecha;

   function pdfreporte() {
      $this->fpdf("p", "mm", "Legal");
      //$this->bd=new basedatosAdo();
      $this->bd = new Tsrvoucher_cc();
      $this->titulos = array();
      $this->titulos2 = array();
      $this->campos = array();
      $this->anchos = array();
      $this->anchos2 = array();
      $this->numchedes = str_replace('*', ' ', H::GetPost("numchedes"));
      $this->numcue = str_replace('*', ' ', H::GetPost("numcuedes"));
      $this->hecho = str_replace('*', ' ', H::GetPost("hecho"));
      $this->revi = str_replace('*', ' ', H::GetPost("revi"));
      $this->apro = str_replace('*', ' ', H::GetPost("apro"));
      $this->conta = str_replace('*', ' ', H::GetPost("conta"));
      $this->audi = str_replace('*', ' ', H::GetPost("audi"));
      $this->arrp = $this->bd->sqlp($this->numchedes, $this->numcue);
      $this->arrp2 = $this->bd->sqlp2($this->numchedes, $this->numcue);
      $this->arrp3 = $this->bd->sqlpx($this->numchedes, $this->numcue);
      $this->arrp4 = $this->bd->sqlpz($this->numchedes, $this->numcue);
      $this->llenartitulosmaestro();
   }

   function llenartitulosmaestro() {
      $this->titulos[0] = "";
      $this->titulos[1] = "Cuenta";
      $this->titulos[2] = "Uso";
      $this->titulos[3] = "Saldo Anterior";
      $this->titulos[4] = "Débitos";
      $this->titulos[5] = "Créditos";
      $this->titulos[6] = "Saldo Segun Libros";
   }

   function Header() {
      $this->setFont("Arial", "B", 11);
      $ncampos = count($this->titulos);
      $ncampos2 = count($this->titulos2);

      $this->setFont("Arial", "B", 11);
   }

   function Cuerpo() {
      $this->setFont("Arial", "B", 9);
      $i = 0;
      $a = 0;
      $b = 0;
      $cont = 0;
      $this->van = 0;
      //------------------------------------------------------------------------------------------------
      foreach ($this->arrp as $cheque) {//while
         $this->numcom = $cheque["numcom"];
         $moneda = $cheque["nommon"];
         $this->setFont("Arial", "B", 12);


         //------------- BANCO VENEZUELA ---------------------

         $this->SetXY(155, 36);
         $this->cell(30, 2, str_pad($cheque["monchestr"], 8, "*", STR_PAD_LEFT));
         //--------------------------------------------------------------------------
         $this->setFont("Arial", "B", 12);
         $this->SetXY(32, 57);
         $this->cell(130, 5, '**************' . strtoupper($cheque["nomben"]) . '***');
         $this->SetXY(35, 64);
         $this->MultiCell(130, 6, (str_pad(H::obtenermontoescrito($cheque["monche"],true,$moneda), 75, "*", STR_PAD_RIGHT)));
         $this->setFont("Arial", "B", 12);
         $this->SetXY(22, 79);
         $this->cell(29, 5, "CARACAS,   ");
         //$this->cell(30, 5, $cheque["dia"] . "/" . $cheque["mes"]);
		 //$this->cell(30, 5, $cheque["dia"] ." de " . (str_pad(H::ObtenerMesenLetras($cheque["mes"],true,$mes), 0, "*", STR_PAD_RIGHT)) ." de " .  $cheque["ano"]);
		 $this->cell(36, 5, $cheque["dia"] ." de " . (str_pad(H::ObtenerMesenLetras($cheque["mes"],true,$mes), 0, "*", STR_PAD_RIGHT)));
		 //$this->MultiCell(30, 5, (str_pad(H::ObtenerMesenLetras($cheque["mes"],true,$mes), 0, "*", STR_PAD_RIGHT)));
         $this->cell(10, 5, "  " . $cheque["ano"]);


         //-----------BANCO VENEZUELA ------------------------
         $this->SetXY(87, 104);
		 $this->cell(10, 5, '"NO ENDOSABLE"');
         $this->cell(20, 15, 'Caduca a los 90 Dias', 0, 0, 'C');
		 

         //--------------------------------------------------------------------

         $this->SetXY(45, 65);
         //$this->MultiCell(130,5,strtoupper($cheque["desord"]),0,'',0);
         //$y1=$this->GetY();
         $cheques["numcom"] = $cheque["numcom"];


         $y1 = 129;
         $cont = 0;
         $y2 = $this->GetY();
         $this->setFont("Arial", "B", 8);
         $this->SetXY(116, $y1 + 7);
         //	$this->cell(50,5,'Datos del Cheque',0,0,'C');
         $this->ln();
         $this->ln();
         $this->setFont("Arial", "", 12);
         $this->SetX(18);
         //	$this->cell(50,5,'BANCO: ');
         //	$this->line(20,$this->GetY()+9,60,$this->GetY()+9);
         //	$this->cell(70,5,'CTA. CORRIENTE Nro: ');
         //	$this->line(70,$this->GetY()+9,130,$this->GetY()+9);
         //	$this->cell(50,5,'CHEQUE Nro: ');
         //	$this->line(140,$this->GetY()+9,180,$this->GetY()+9);
         $this->ln();
         $this->ln(10);
         $this->cell(10, 5, '');

         //$this->SetXY(116,136);
         $this->cell(70, 5, trim($cheque["nomcue"]), 0, 0, 'C');
         $this->cell(106, 5, trim($cheque["numcue"]), 0, 0, 'R');
         
		 $this->SetXY(18,132);
		 //$fecha = date("d/m/Y");
         //$this->cell(45, 5, trim($cheque["fecemi". $fecha]), 0, 0, 'R');
		 $this->cell(45, 5, $cheque["dia"] . "/" . $cheque["mes"] . "/" . $cheque["ano"]);
         //$this->cell(45, 5, " " . $cheque["ano"]);
		 
         $this->SetXY(88,132);
         $this->cell(45, 5, trim($cheque["numche"]), 0, 0, 'R');

         //$this->SetXY(89,138);
         $this->cell(45, 5, trim($cheque["numcom"]), 0, 0, 'R');

         $op["numche"] = $cheque["numche"];

         $y3 = $y1;
         $yy = 70;
         //$this->SetXY(20,$yy+18);
         //$this->MultiCell(150,5,strtoupper($this->arrp3["descon"]),0,'J',0);
         $vv = 0;
         $contador = 0;
         foreach ($this->arrp3 as $op) {
            $contador++;
            if ($cheque["numche"] == $op["numche"]) {
               if ($vv == 0) {
                  $this->setFont("Arial", "B", 12);
                  //		  $this->Image("../../img/logo_1.jpg",22,$yy+12,20);
                  $this->SetXY(80, $yy + 12);
                  //		  $this->cell(40,5,'Comprobante de Egreso',0,0,'C');
                  $this->ln();
                  $this->ln(39);
                  $this->setFont("Arial", "", 12);
                  $this->SetX(20);
                  $this->ln(20);
                  $this->SetXY(8, 144);
                  $this->MultiCell(180, 8, H::obtenermontoescrito($cheque["monche"],true,$moneda) . '   Bs. ', 0, 'L', 0);
                  $this->SetXY(102, 152);
                  $this->cell(25, 8, str_pad($cheque["monchestr"], 0, "*", STR_PAD_LEFT));
				  
				  $this->setFont("Arial", "", 12);
				  $this->SetXY(142, 152);
				  $this->cell(25, 8, 'Cédula/RIF', 0, 0, 'C');
				  $this->setFont("Arial", "", 12);
				  $this->SetXY(142, 156);
                  $this->MultiCell(175, 8, strtoupper($cheque["cedrif"]), 0, 'J', 0);
				  $this->ln(2);
				  $this->setFont("Arial", "", 12);
				  //$this->SetXY(25, 153);
                  //$this->SetX(25);
                  $this->MultiCell(199, 5, strtoupper($op["deslib"]), 0, 'L', 0);

               }
               $yy = $this->GetY();
               $this->SetXY(20, $y3 + 35);
               $this->cell(30, 5, '');
               $this->cell(40, 5, '');
               $this->cell(40, 5, '');
               //$this->cell(30,5,trim($op["numord"]),0,0,'R');
               $b++;
               $vv++;
               $y3 = $this->GetY() - 30;
            }
         }
         if ($contador == 0) {//ojo  aqui esta el parche del monto cuando es extra presupuesto
            $this->SetXY(70, 125);
            $this->ln();
            $this->ln(40);
            $this->setFont("Arial", "", 12);
            $this->SetX(20);
            $this->MultiCell(170,5, strtoupper($cheque["descon"]), 0, 'J', 0);
            $this->SetXY(20, 144);
            $this->MultiCell(180, 8, H::obtenermontoescrito($cheque["monche"],true,$moneda) . '   Bs. ', 0, 'L', 0);
            $this->SetXY(102, 144);
            $this->cell(25, 22, str_pad($cheque["monchestr"], 0, "*", STR_PAD_LEFT));
         }//aqui termina


         $this->SetXY(10, 267);//COORDENAS DEL BENEFICIARIO
         $this->setFont("Arial", "", 11);
         $totcom = 0.0;
//         print '<pre>';
//         print_r($this->arrp2);exit;
         foreach ($this->arrp2 as $imp) {

            $this->multicell(50, 5, ''.$imp["desasi"], 0, 'L');
            $this->ln(-2);
            $this->SetX(120);
            $this->cell(40, 4, number_format($imp["monasi"], 2, ',', '.'), 0, 0, $imp["debcre"]=='D' ? 'L' : 'R');
            $this->ln(4);
            $this->SetX(10);

            $totcomdeb += ($imp["debcre"]=='D' ? $imp["monasi"] : 0.0);

         }

         $this->setFont("Arial", "B", 12);
          $this->ln(3);
          $this->SetX(10);
          $this->cell(40, 4, 'Total', 0, 0, 'R');$this->SetX(90);
 //         $this->cell(40, 4, 'otra cosa', 0, 0, 'R');$this->SetX(90);
          $this->cell(10, 4, number_format($totcomdeb, 2, ',', '.'), 0, 0, 'L');
          $this->SetX(135);
          $this->cell(30, 4, number_format($totcomdeb, 2, ',', '.'), 0, 0, 'C');
        $this->setFont("Arial", "", 8);

         //$this->SetXY(30, 214);
		 $this->SetXY(178, 132);
         // $this->cell(70,5,'');
         foreach ($this->arrp4 as $imp) {
            if ($cheque["numche"] == $imp["numche"]) {
               $this->setFont("Arial", "", 12);

               //$this->cell(20, 4, 'Doc. Nro '.$imp["numord"], 0, 0, 'L');
			  // $this->cell(20, 6, ''.$imp["numord"], 0, 0, 'L');
               //$this->cell(30, 4, number_format($imp["mon"], 2, ',', '.'), 0, 0, 'R');
               $this->van+=$imp["monord"];
               if ($this->gety() > 235) {
                  $this->SetXY(23, 265);
                  $this->cell(113, 5, "", 0, 0, 'R');
                  $this->cell(30, 5, "Van...", 0, 0, 'L');
                  $this->esta = 'Vienen...';
                  $this->cell(24, 5, number_format($this->van, 2, ',', '.'), 0, 0, 'R');
                  $this->addpage();
                  $this->SetXY(23, 202);
                  $this->cell(128, 5, "", 0, 0, 'R');
                  $this->cell(15, 5, $this->esta, 0, 0, 'L');
                  $this->cell(24, 5, number_format($this->van, 2, ',', '.'), 0, 0, 'R');
                  $this->setFont("Arial", "B", 12);
                  $this->SetXY(80, $yy + 12);
                  $this->ln();
                  $this->ln(40);
                  $this->setFont("Arial", "", 9);
                  $this->SetXY(20, 124);
                  $this->MultiCell(170, 5, strtoupper($op["deslib"]), 0, 'J', 0);
                  $this->ln(20);
                  $this->SetXY(30, 160);
                  $this->MultiCell(175, 5, H::obtenermontoescrito($cheque["monche"],true,$moneda) . '   Bs. ', 0, 'J', 0);
                  $this->SetXY(150, 169);
                  $this->MultiCell(25, 5, number_format($cheque["monche"], 2, ',', '.'), 0, 0, 'R');
                  $this->SetY(185);
                  $this->cell(10, 5, '');
                  $this->cell(50, 5, trim($cheque["nomcue"]), 0, 0, 'C');
                  $this->cell(60, 5, trim($cheque["numcue"]), 0, 0, 'R');
                  $this->cell(45, 5, trim($cheque["numche"]), 0, 0, 'R');
                  $this->SetXY(10, 202);
               }

               $total = $total + $imp["mon"];
               $this->ln();
            }
         }
         $this->sql = "select   numord from   opordche      where  trim(numche) = '" . trim($cheque["numche"]) . "' ";
         $tbdesord = $this->bd->select($this->sql);
         $this->cont = count($tbdesord);
         $ordenes = array();
         $this->numord = array();
         $this->i = 0;
         $this->SetXY(84, 199);
         foreach ($tbdesord as $desor) {
            $this->sqlret = "select b.destip , a.monret from opretord a join optipret b on a.codtip=b.codtip where numord='" . $desor["numord"] . "'";
            $tbdret = $this->bd->select($this->sqlret);
            foreach ($tbdret as $ret) {
               $this->ret+=$ret["monret"];
            }
            $this->numord = explode("-", trim($desor["numord"]));

         }
         $i++;
         $this->SetXY(23, 235);
         $this->cell(143, 5, "", 0, 0, 'C');
         $this->sqlparch = "select sum(monpag) as monto from opordpag where numche='" . $cheque["numche"] . "'  and status='I' ";
         $tbdparch = $this->bd->select($this->sqlparch);
         foreach ($tbdparch as $parch) {
            $this->parch = $parch["monto"];
         }

         $this->SetXY(9, 210);

         $this->SetXY(153, 257);
         //$this->cell(23, 5, number_format($cheque["monche"], 2, ',', '.'), 0, 0, 'R');
         $this->cell(143, 5, "", 0, 0, 'C');

 
         $total = 0;
         if ($i < count($this->arrp)) {
            $this->AddPage();
         }
      }
   }

}

?>
