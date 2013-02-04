<?
  require_once("../../lib/general/fpdf/fpdf.php");
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
    var $auxd=0;
    var $car;
    var $acumsalant=0;
    var $acumdeb=0;
    var $acumlib=0;
    var $acumban=0;
    var $acumlib2=0;
    var $acumban2=0;
    var $sal=0;
    var $fecha;

    function pdfreporte()
    {
      $this->fpdf("p","mm","Letter");
      $this->bd=new basedatosAdo();
      $this->cab=new cabecera();
      $this->titulos=array();
      $this->titulos2=array();
      $this->campos=array();
      $this->anchos=array();
      $this->anchos2=array();


        $this->che1=str_replace('*',' ',H::GetPost("numchedes"));
        $this->che2=str_replace('*',' ',H::GetPost("numchehas"));
        $this->ben=str_replace('*',' ',H::GetPost("ben"));
        $this->prepor = str_replace('*',' ',H::GetPost("prepor"));
		$this->revpor=H::GetPost("revpor");

        $this->sql="select distinct rtrim(a.numche) as numche,a.fecemi,--rtrim(c.nomben) as nomben,
        a.numcue,a.monche,
        to_char(a.fecemi,'dd') as dia,
        to_char(a.fecemi,'mm') as mes,
        to_char(a.fecemi,'yyyy') as ano,
        A.CODMON,
        Z.NOMMON,
        a.monche as monchestr,
        CASE WHEN   A.NOMBENSUS='' THEN c.nomben ELSE A.nombensus end AS nombensus,
        c.cedrif,b.nomcue,d.deslib as descon,d.numcom,a.codemi
        from tsdefban b, opbenefi c, tsmovlib d, tscheemi a LEFT OUTER JOIN TSDESMON Z ON A.CODMON=Z.CODMON
        left join opordpag e on rtrim(a.numche)=rtrim(e.numche)
        where
        rtrim(a.numcue)=rtrim(b.numcue) and rtrim(a.numche)=rtrim(d.reflib) and
        rtrim(a.numcue)=rtrim(d.numcue) and rtrim(a.cedrif)=rtrim(c.cedrif) and
        rtrim(a.numche)>=rtrim('".$this->che1."') and rtrim(a.numche)<=rtrim('".$this->che2."')
        order by rtrim(a.numche)";
      //  print "<pre>"; print  $this->sql; exit;
      //}
//A.NOMBENSUS is null  or
      $this->llenartitulosmaestro();
      $this->arrp=$this->bd->select($this->sql);


    }
    function llenartitulosmaestro()
    {
        $this->titulos[0]="";
        $this->titulos[1]="Cuenta";
        $this->titulos[2]="Uso";
        $this->titulos[3]="Saldo Anterior";
        $this->titulos[4]="Dbitos";
        $this->titulos[5]="Crditos";
        $this->titulos[6]="Saldo Segun Libros";

    }

    function Header()
    {
      //$this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
       $this->SetFont("Arial","B",11);
      $ncampos=count($this->titulos);
      $ncampos2=count($this->titulos2);
          //  $this->ln(4);

    }
    function Cuerpo()
    {
       $this->SetFont("Arial","B",11);
      $tb=$this->arrp;


      //------------------------------------------------------------------------------------------------
      while (!$tb->EOF)//while
      {
        $moneda = $tb->fields["nommon"];
        //$this->ln();

        $this->numcom=$tb->fields["numcom"];

         $this->SetFont("Arial","B",12);
        $this->SetXY(140,2);
        if($tb->fields["monche"]<1)
          $this->cell(40,2,'**'.H::FormatoMonto($tb->fields["monche"]).'**');
        else
          $this->cell(40,2,'**'.H::Formatomonto($tb->fields["monchestr"]).'**');
        $this->SetFont("Arial","B",10);
        $this->SetXY(30,19);
        if( $this->ben==NULL)
        	$this->cell(130,5,strtoupper($tb->fields["nombensus"]));
        else
        {
    	   //	$this->cell(130,5,strtoupper($this->ben));//////OJOOOOOOOOOOOOOOOO
    	   		$this->sqlben="select nomben  from opbenefi  where cedrif='".strtoupper($this->ben)."'";
    	   		//print '<pre>'; print $this->sqlben; exit;
			$tbben=$this->bd->select($this->sqlben);

		   	 $nomb=$tbben->fields["nomben"];
		   	 	$this->cell(130,5,strtoupper( $nomb));

        }
        $this->SetXY(35,24);
         $this->SetFont("Arial","B",10);
       // $this->MultiCell(120,5,H::obtenermontoescrito($tb->fields["monche"]));
         $this->SetFont("Arial","B",10);
        $this->SetXY(10,37);
        $this->cell(20,5,"Caracas,    ");
        $this->SetXY(30,37);
        $this->cell(15,5,$tb->fields["dia"]."  de  ");
        if ($tb->fields["mes"]=='01'){$this->cell(25,5,"ENERO");}
        if ($tb->fields["mes"]=='02'){$this->cell(25,5,"FEBRERO");}
        if ($tb->fields["mes"]=='03'){$this->cell(25,5,"MARZO");}
        if ($tb->fields["mes"]=='04'){$this->cell(25,5,"ABRIL");}
        if ($tb->fields["mes"]=='05'){$this->cell(25,5,"MAYO");}
        if ($tb->fields["mes"]=='06'){$this->cell(25,5,"JUNIO");}
        if ($tb->fields["mes"]=='07'){$this->cell(25,5,"JULIO");}
        if ($tb->fields["mes"]=='08'){$this->cell(25,5,"AGOSTO");}
        if ($tb->fields["mes"]=='09'){$this->cell(25,5,"SEPTIEMBRE");}
        if ($tb->fields["mes"]=='10'){$this->cell(25,5,"OCTUBRE");}
        if ($tb->fields["mes"]=='11'){$this->cell(25,5,"NOVIEMBRE");}
        if ($tb->fields["mes"]=='12'){$this->cell(25,5,"DICIEMBRE");}
        $this->cell(20,5,"  de  ".$tb->fields["ano"]);
        $this->SetXY(115,62);
        $this->cell(10,5,'NO ENDOSABLE');
        $this->SetXY(5,102);
        //$this->cell(10,5,$tb->fields["numord"]);
        $this->SetX(23);
        $this->SetFont("Arial","B",8);

        $this->sql = "select   numord from   opordche      where  trim(numche) = '".trim($tb->fields["numche"])."' ";
        $tbdesord = $this->bd->select($this->sql);
        $tbdesordarray = $tbdesord->getArray();

		$ordenes=array();
        $this->i=0;
        $x=$this->GetX();
        $y=$this->GetY();
        foreach($tbdesordarray as $desor)
        {
             $ordenes[]=$desor["numord"]; //VECTOR DE LOS NUMEROS DE ORDENES
             $this->i++;
              $this->sqlret="select b.destip , a.monret from opretord a join optipret b on a.codtip=b.codtip where numord='".$desor["numord"]."'";
        // print '<pre>'; print $this->sqlret; exit;
        $tbdret = $this->bd->select($this->sqlret);
        $this->SetWidths(array(40,30));
		$this->setaligns(array("L","R"));
		$this->SetXY(110,118);
		$this->SetFont("Arial","B",8);
        foreach($tbdret as $ret)
        {
           $this->SetX(110);
           $this->Rowm(array($ret["destip"],$ret["monret"]));
           $this->ln(1);

      	}

      	}
      	$this->SetXY($x,$y);
      	////HOLA LEO AQUI ES DONDE TENGO EL PROBLEMA COMO HAGO PARA QUE ME MUESTRE LAS RETENCIONES DE TODAS LAS ORDENES QUE SE PAGAN EN ESE VOUCHER
      	//EN ESTE CASO YO TENGO LOS NUMEROS DE ORDENES EN UN VECTOR QUE SE LLAMA  $ordenes[]

        //$this->sqlret="select b.destip , a.monret from opretord a join optipret b on a.codtip=b.codtip where numord='".$ordenes[$this->i-1]."'";
        // print '<pre>'; print $this->sqlret; exit;
        //$tbdret = $this->bd->select($this->sqlret);

         //select b.destip , a.monret from opretord a join optipret b on a.codtip=b.codtip where numord='00000012'
          $this->SetFont("Arial","B",9);
		  $this->MultiCell(115,5,"Nro. Orden:  ".strtoupper(implode("   -   ",$ordenes))." \n ".$tb->fields["descon"]);
		  $this->SetWidths(array(40,30));
		  $this->setaligns(array("L","R"));
		  $this->SetXY(110,125);
		  $this->SetFont("Arial","B",8);
 /*foreach($tbdret as $ret)
        {
        	 $this->SetX(110);
           $this->Rowm(array($ret["destip"],$ret["monret"]));
           $this->ln(1);

      	}*/
          $this->SetXY(110,133);//165,169
           $this->cell(15,5,'MONTO NETO');
           $this->SetFont("Arial","B",14);

          $this->SetXY(150,133);//165,169
          $this->cell(30,5,'**'.H::Formatomonto($tb->fields["monchestr"]).'**');
           $this->SetFont("Arial","B",9);
          $this->SetXY(17,138);//20,153
          $this->MultiCell(20,5,$tb->fields["numche"]);
          $this->SetXY(37,138);//20,153
          $this->MultiCell(40,5,$tb->fields["nomcue"]);
           $this->SetXY(12,90);//20,153
          $this->MultiCell(100,5,$tb->fields["numcue"]);
          //numcue
         // $this->SetXY(15,169);

          if(empty($this->prepor))
	        	$this->elapor=$tb->fields["codemi"];
		  else
		  		$this->elapor=$this->prepor;
		  $revpor="";
		  if (!empty($this->revpor))
          	$revpor=($this->revpor);
          	 $this->SetXY(10,169);
          $this->MultiCell(25,5,strtoupper($this->elapor));
           $this->SetXY(45,169);
          $this->MultiCell(22,5,strtoupper($revpor));





      $tb->MoveNext();
      if(!$tb->EOF)
      {
        $this->AddPage();
      }
      }


    }
  }
?>
