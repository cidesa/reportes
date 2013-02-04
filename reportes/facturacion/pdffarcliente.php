<?
    require_once("../../lib/general/fpdf/fpdf.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/bd/basedatosAdo.php");
    require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/facturacion/Farcliente.class.php");

  class pdfreporte extends fpdf
  {

    var $bd;


    function pdfreporte()
    {
      $this->conf="l";
      $this->fpdf($this->conf,"mm","Letter");

      $this->arrp=array("no_vacio");
      $this->cab=new cabecera();
      $this->bd=new basedatosAdo();

      $this->coddes=H::GetPost("coddes");
      $this->codhas=H::GetPost("codhas");

      $this->rifdes=H::GetPost("rifdes");
      $this->rifhas=H::GetPost("rifhas");

      $this->nomdes=H::GetPost("nomdes");
      $this->nomhas=H::GetPost("nomhas");
      
      $this->estades=H::GetPost("estades");
      $this->estahas=H::GetPost("estahas");   
         
      $this->farcliente = new Farcliente();
      $this->arrp = $this->farcliente->sqlp($this->coddes,$this->codhas,$this->rifdes,$this->rifhas,$this->estades,$this->estahas);

      $this->llenartitulosmaestro();
      $this->llenaranchos();



    }

  function llenartitulosmaestro()
    {
      //$this->titulosm=array();
        $this->titulosm[0]="Código";
        $this->titulosm[1]="Rif";
        $this->titulosm[2]="Nombre o Razón Social";
        $this->titulosm[3]="Tipo";
        $this->titulosm[4]="Dirección";
        $this->titulosm[5]="Teléfono";
        $this->titulosm[6]="Cta. Contable";
        $this->titulosm[7]="Estado";
    }

function llenaranchos()
  {
    $this->anchos=array();
    $this->anchos[0]=24;
    $this->anchos[1]=24;
    $this->anchos[2]=54;
    $this->anchos[3]=27;
    $this->anchos[4]=55;
    $this->anchos[5]=23;
    $this->anchos[6]=31;
    $this->anchos[7]=22;
    // 260 ancho maximo
  }

function Header()
    {
          $this->cab->poner_cabecera($this,H::GetPost(""),$this->conf,"s","n");
          $this->setY(25);
          $this->cell(240,10,H::GetPost("titulo"),0,0,'C');
          $this->setFont("Arial","",9);

          $this->Ln(15);

          $this->SetWidths(array($this->anchos[0],$this->anchos[1],$this->anchos[2],$this->anchos[3],$this->anchos[4],$this->anchos[5],$this->anchos[6],$this->anchos[7]));
              $this->SetAligns(array("C","C","C","C","C","C","C","C"));
              $this->setFont("Arial","B",8);
              $this->setBorder(1);
 $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7]));
              $this->line(10,$this->getY(),270,$this->getY());
	  $this->ln();
$this->setBorder(0);
$this->SetAligns(array("C","C","L","C","L","C","C","C"));

    }

function Cuerpo()

    {

      $reg=1;
    $codpro="";
    $registro=count($this->arrp);
    foreach($this->arrp as $dato)

            {

             $reg++;
             if($dato["codpro"]!=$codpro)
                 {
	      $this->setBorder(1);
              $this->SetWidths(array($this->anchos[0],$this->anchos[1],$this->anchos[2],$this->anchos[3],$this->anchos[4],$this->anchos[5],$this->anchos[6], $this->anchos[7]));
              $this->SetAligns(array("C","C","L","C","L","C","C","C"));
              $this->RowM(array($dato["codpro"],$dato["rifpro"],$dato["nompro"],$dato["tippro"],$dato["dirpro"],$dato["telpro"],$dato["codcta"],$dato["nomedo"]));

                 }
            }
    if ($reg<=$registro)
            {
              $this->addpage();
          }

    }

}//fin de la clase
?>
