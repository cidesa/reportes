<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/modelo/sqls/documentos/Repdoc.class.php");


  class pdfreporte extends FPDF
  {
    var $codigodes;
    var $codigohas;
    var $tipo;
    var $estado;
    var $anulado;
    var $fechades;
    var $fechahas;
    var $titulo;
    var $sql;

    function pdfreporte()
    {
      $this->fpdf('l','mm','letter');
      $this->bd=new basedatosAdo();
      $this->codigodes=$_POST["codigodes"];
      $this->codigohas=$_POST["codigohas"];
      $this->tipo=$_POST["tipo"];
      $this->estado=$_POST["estado"];
      $this->anulado=$_POST["anulado"];
      $this->fechahas=$_POST["fechahas"];
      $this->fechades=$_POST["fechades"];
      $this->fechadochas=$_POST["fechadochas"];
      $this->fechadocdes=$_POST["fechadocdes"];
      $this->fechaatehas=$_POST["fechaatehas"];
      $this->fechaatedes=$_POST["fechaatedes"];
      $this->titulo=$_POST["titulo"];

      $this->repdoc = new Repdoc();

      $this->arrp = $this->repdoc->sqlp($this->tipo, $this->fechades, $this->fechahas, $this->codigodes, $this->codigohas, $this->estado, $this->anulado, $this->fechadocdes, $this->fechadochas, $this->fechaatedes, $this->fechaatehas);

//echo $this->sql;
    }


    function Header()
    {
      $this->getCabecera('Reporte de Documentos');
      /*
      $this->Image("../../img/logo_1.jpg",10,5,22);
      $this->SetFont("arial","",9);
      $this->SetXY(200,11);
      $this->Cell(1,5,"Fecha: ".date("d/m/Y h:i:s a."));
      $this->SetXY(200,15);
      $this->Cell(1,5,"Pagina: ".$this->PageNo()." de {nb}");
      $this->SetXY(10,30);
      $this->SetFont("times","B",13);
      $this->Cell(1,5,"Sistema de Control de Documentos Financieros");
      $this->SetXY(10,37);
      $this->SetFontSize(18);
      $this->Cell(80,5,"Reporte de Documentos");
      $this->SetDrawColor(0,0,128);
      $this->SetLineWidth(0.8);
      $this->Line(10,46,270,46);
      */
      /*titulos*/
      $this->SetDrawColor(255,255,255);
      $this->SetFillColor(200,200,250);
      $this->SetLineWidth(0.2);
      $this->cuadros(10,50,32.5,13,8,1,'FD');

      $this->SetXY(9,50);
      $this->SetFont("times","B",12);
      $this->MultiCell(32,5,"
      Codigo",0,'C',0);
      $this->SetXY(41,47);
      $this->MultiCell(32,5,"
      Tipo
      Documento",0,'C',0);
      $this->SetXY(73,47);
      $this->MultiCell(32,5,"
      Unidad
      Origen",0,'C',0);
      $this->SetXY(106,47);
      $this->MultiCell(32,5,"
      Unidad
      Destino",0,'C',0);
      $this->SetXY(138,47);
      $this->MultiCell(32,5,"
      Fecha
      Elaboracion",0,'C',0);
      $this->SetXY(171,47);
      $this->MultiCell(32,5,"
      Fecha
      Recepcion",0,'C',0);
      $this->SetXY(203,47);
      $this->MultiCell(32,5,"
      Fecha
      Atencion",0,'C',0);
      $this->SetXY(235,50);
      $this->MultiCell(32,5,"
      Estado",0,'C',0);
      $this->SetDrawColor(0,0,0);
      $this->SetFillColor(0,0,0);
      $this->SetY(63);

    }

    function cuadros($x,$y,$ancho,$alto,$nocolumnas,$nofilas,$estilo)
    {
      $yv=$y;
      for($i=1;$i <= $nofilas;$i++)
      {
        $xv=$x;
        for($ii=1;$ii <= $nocolumnas;$ii++)
        {
          $this->Rect($xv,$yv,$ancho,$alto,$estilo);
          $xv+=$ancho;
        }
        $yv+=$alto;
      }
    }

    function Cuerpo()
    {
      /*se coloca en cero si no se quiere colorcar cuadros por registros y uno para lo contrario*/
      $cuadros=0;
      $this->SetFont("times","",12);
      //$tb= $this->bd->select($this->sql);
      $paginactual = $this->PageNo();
      $tipod = $this->arrp[0]["tipdoc"];
      $this->SetXY(80,38);
      $this->Cell(10,4,'Tipo de Documento '.$tipod);
      $this->SetY(63);

      foreach($this->arrp as $dato)
      {
        if($tipod != $dato["tipdoc"])
        {
          $this->AddPage();
          $tipod = $dato["tipdoc"];
        }
        #$this->cuadros(10,$this->GetY(),32.5,13,8,1,'FD');
        $doc= $dato["tipdoc"];
        $this->Cell(32.5,8,$dato["coddoc"],$cuadros,0,'C');
        $this->Cell(32.5,8,$dato["tipdoc"],$cuadros,0,'C');
        $o=$this->bd->select("select nomuni from acunidad where id = '".$dato["origen"]."'");
        $this->Cell(32.5,8,$o->fields["nomuni"],$cuadros,0,'C');
        $o=$this->bd->select("select nomuni from acunidad where id = '".$dato["destino"]."'");
        $this->Cell(32.5,8,$o->fields["nomuni"],$cuadros,0,'C');
        $fec1 = explode("-",$dato["fecdoc"]);
        $fecha = implode("/",array_reverse($fec1));
        $this->Cell(32.5,8,$fecha,$cuadros,0,'C');
        $fec1 = explode("-",$dato["fecrec"]);
        $fecha = implode("/",array_reverse($fec1));
        $this->Cell(32.5,8,$fecha,$cuadros,0,'C');
        $fec1 = explode("-",$dato["fecate"]);
        $fecha = implode("/",array_reverse($fec1));
        $this->Cell(32.5,8,$fecha,$cuadros,0,'C');
        $this->Cell(32.5,8,$dato["estado"],$cuadros,0,'C');
        $this->Ln(8);
        //$tb->MoveNext();
        $aquiy=$this->GetY();
        if($paginactual != $this->PageNo())
        {
          $paginactual = $this->PageNo();
          $this->SetXY(80,38);
          $this->Cell(10,4,'Tipo de Documento '.$dato["tipdoc"]);
          $this->SetY($aquiy);
        }

      }

    }/*final del cuerpo*/
}
?>