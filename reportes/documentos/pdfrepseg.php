<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  //require_once("../../lib/general/cabecera.php");
  require_once("../../lib/modelo/sqls/documentos/Repseg.class.php");
  require_once("../../lib/modelo/business/documentos.class.php");


  class pdfreporte extends fpdf
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
      $this->codigodes=H::GetPost("codigodes");
      $this->codigohas=H::GetPost("codigohas");
      $this->tipo=H::GetPost("tipo");
      $this->estado=H::GetPost("estado");
      $this->anulado=H::GetPost("anulado");
      $this->fechahas=H::GetPost("fechahas");
      $this->fechades=H::GetPost("fechades");
      $this->fechadochas=H::GetPost("fechadochas");
      $this->fechadocdes=H::GetPost("fechadocdes");
      $this->fechaatehas=H::GetPost("fechaatehas");
      $this->fechaatedes=H::GetPost("fechaatedes");
      $this->titulo=H::GetPost("titulo");

      $this->repseg = new Repseg();

      $this->arrp = $this->repseg->sqlp($this->tipo, $this->fechades, $this->fechahas, $this->codigodes, $this->codigohas, $this->estado, $this->anulado, $this->fechaatedes, $this->fechaatehas);


/*
      $this->sql=("select a.tipdoc, b.coddoc,
          (case when b.staate= 0 then 'Pendiente' else (case when b.staate= 1 then 'Atendido' end) end) as estado,
          b.fecdoc, c.fecrec, c.id_acunidad_ori as origen, c.id_acunidad_des as destino,
          c.fecate, d.diadoc
          from
          dftabtip a, dfatendoc b, dfatendocdet c, dfrutadoc d
          where
          a.id like ('".$this->tipo."')
          and c.fecrec >= to_date('".$this->fechades."','DD-MM-YYYY')
          and c.fecrec <= to_date('".$this->fechahas."','DD-MM-YYYY')
          and b.coddoc >= '".$this->codigodes."'
          and b.coddoc <= '".$this->codigohas."'
          and b.staate like ('".$this->estado."')
          and b.anuate like ('".$this->anulado."')
          and a.id = b.id_dftabtip
          and b.id = c.id_dfatendoc
          and c.id_dfrutadoc = d.id");
*/



//ECHO $this->sql;


    }


    function Header()
    {
      $this->getCabecera('Seguimiento de Documentos');
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
      $this->MultiCell(35,5,"
      Dias
      Permanencia",0,'C',0);
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
        $o = 'xx';
        #$this->cuadros(10,$this->GetY(),32.5,13,8,1,'FD');
        $this->Cell(32.5,8,$dato["coddoc"],$cuadros,0,'C');
        $this->Cell(32.5,8,$dato["tipdoc"],$cuadros,0,'C');
        $o=Documentos::getNomuni($dato["origen"]);
        $this->Cell(32.5,8,$o[0],$cuadros,0,'C');
        $o=Documentos::getNomuni($dato["destino"]);;
        $this->Cell(32.5,8,$o[0],$cuadros,0,'C');
        $this->Cell(32.5,8,$dato["diadoc"],$cuadros,0,'C');
        $fec1 = explode("-",$dato["fecrec"]);
        $fecha = implode("/",array_reverse($fec1));
        $this->Cell(32.5,8,$fecha,$cuadros,0,'C');
        $fec1 = explode("-",$dato["fecate"]);
        $fecha = implode("/",array_reverse($fec1));
        $this->Cell(32.5,8,$fecha,$cuadros,0,'C');
        $this->Cell(32.5,8,$dato["estado"],$cuadros,0,'C');
        $this->Ln(8);
        //$tb->MoveNext();
        if($tipod != $dato["tipdoc"])
        {
          $this->AddPage();
          $tipod = $dato["tipdoc"];
        }
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