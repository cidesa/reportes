<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/Cabecera.php");
  require_once("../../lib/general/Herramientas.class.php");
  require_once("../../lib/modelo/sqls/nomina/Prueba2.class.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
      $this->fpdf("l","mm","Letter");
      $this->ced1=H::GetPost("ced1");
      $this->ced2=H::GetPost("ced2");
      $this->prueba2= new Prueba2();
      $this->cabecera = new Cabecera ();
      $this->arrp=$this->prueba2->sqlp($this->ced1,$this->ced2);
        }// fin del pdf


    function Header()
    {
      $this->cabecera->poner_cabecera($this,H::GetPost("titulo"),"p","S","");
    }

    function Cuerpo()
    {

     foreach($this->arrp as $dato)
    {

    }

  /*
  $this->SetWidths(array(30,150,40,40));
  $this->SetAligns(array("L","L","C","R"));
  $this->SetBorder(1);
  $this->Row(array($dato["cedula"],$dato["nombre"],$dato["fecha"],$dato["edad"]));
 */
  }//fin del cuerpo
 }
?>
