<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/modelo/sqls/nomina/Nprcontra.class.php");

class pdfreporte extends fpdf
{
	function pdfreporte()
	{
		 $this->fpdf("p","mm","Letter");
		 $this->codemp=H::GetPost("codemp");
		 $this->dirrec=H::GetPost("dirrec");
		 $this->concop=H::GetPost("concop");
		 $this->monces=H::GetPost("monces");
		 $this->valmes=H::GetPost("valmes");
		 $this->sueldo=H::GetPost("sueldo");
		 $this->cesta=H::GetPost("cesta");
		 $this->dirigido=H::GetPost("dirigido");
               $this->dirigido_2=H::GetPost("dirigido_2");
		 $this->pernomdes=H::GetPost("pernomdes");
		 $this->pernomhas=H::GetPost("pernomhas");
		 $this->constancia='T';

		 //
		 $this->cab = new Cabecera();
		 $this->objeto = new Nprcontra();

		 $this->arrp = $this->objeto->sqlp($this->codemp);
		 $this->arrp1 = $this->objeto->sueldointegral($this->codemp,$this->pernomdes,$this->pernomhas);
		 $this->arrp2 = $this->objeto->sqlcalulasueldo($this->codemp,$this->pernomdes,$this->pernomhas);
		  $this->arrp3 = $this->objeto->sqlcalulasueldointegral($this->codemp,$this->pernomdes,$this->pernomhas);
	}

	function Header()
	{
	 #$this->Image("../../img/orla_gobierno.jpg",10,240,200);
	 $rs=$this->arrp[0];
	 $sh=$this->arrp1[0];//sueldo con primas
	 $sa=$this->arrp2[0];//sueldo de npconsueldo
	 $si=$this->arrp3[0];//sueldo de npconsalint

	 $this->cab->poner_cabecera($this,"","p","n","n");
	  $this->setFont(arial,"",10);
	  $this->ln(5);
	  if ( $this->dirigido<>''){
	  	$valor=strtoupper($this->dirigido);
              $valor=''.$valor.'';

          if ( $this->dirigido_2<>''){
	  	$valor_2=strtoupper($this->dirigido_2);
              $valor_2='"'.$valor_2.'"';}


	  	$this->setx(20);
	 	 $this->multicell(170,5,"Sres. ".$valor."  ".$valor_2);}

	 $this->ln(5);
	  $this->setFont(arial,"B",12);
	  if ($this->constancia=='T')
	  {
	  	$tipo=' presta ';
	  	$this->multicell(0,10,H::GetPost("titulo"),0,'C');
	  }
	 else
	 {
	 	$tipo=' presto ';
	 	$this->multicell(0,10,H::GetPost("titulo").' DE EGRESO',0,'C');
	 	$hasta=" hasta el <@ ".$rs["fecret"].", <,>arial,B,10@>";
	 }

	 $this->ln(10);
	 $this->setFont(arial,"",12);
	   $this->setx(20);
	   $car=strtoupper($rs["nomcar"]);
	 if ( $this->sueldo=='B') {
	 	$sueldo=($sh["sueldo"]);
	 $this->MCPLUS(170,8,"Quien suscribe<@ Director(a) de Recursos Humanos de la CONTRALORIA MUNICIPAL DE CHACAO del Estado Miranda,<,>arial,B,10@>  hace constar por medio de la presente, que  el (la) ciudadano(a) <@ ".
	 strtoupper($rs["nomemp"]).",<,>arial,B,10 @> titular de la cédula de Identidad N°<@ ".$rs["cedemp"].", <,>arial,B,10@>".
	 " $tipo sus servicios en este Órgano Contralor desde el <@ ".$rs["fecing"].",<,>arial,B,10@> $hasta " .
	 "desempeñando  el cargo de<@ ".$car.",<,>arial,B,10@> adscrito(a)  a la:  " .
	 " <@ ".$rs["desniv"].", <,>arial,B,10@> devengando un sueldo mensual de:  <@ ".H::Obtenermontoescrito($sueldo)." (Bs. ".H::Formatomonto($sueldo)."). <,>arial,B,10@>");
	 }
	 	 if ( $this->sueldo=='S') {
	 	$sueldo=($sa["sueldo"]);
	 $this->MCPLUS(170,8,"Quien suscribe<@ Director(a) de Recursos Humanos de la CONTRALORIA MUNICIPAL DE CHACAO del Estado Miranda,<,>arial,B,10@>  hace constar por medio de la presente, que  el (la)  ciudadano(a) <@ ".
	 strtoupper($rs["nomemp"]).",<,>arial,B,10 @> titular de la cédula de Identidad N°<@ ".$rs["cedemp"].", <,>arial,B,10@>".
	 " $tipo sus servicios en este  Órgano Contralor desde el <@ ".$rs["fecing"].",<,>arial,B,10@>  $hasta" .
	 "desempeñando  el cargo de<@ ".$car.",<,>arial,B,10@> adscrito(a)  a la:  " .
	 "<@ ".$rs["desniv"].", <,>arial,B,10@> devengando un sueldo básico de:  <@ ".H::Obtenermontoescrito($sueldo)." (Bs. ".H::Formatomonto($sueldo)."). <,>arial,B,10@>");
	 }
	  if ( $this->sueldo=='N') {
	 	 $this->MCPLUS(170,8,"Quien suscribe<@ Director(a) de Recursos Humanos de la CONTRALORIA MUNICIPAL DE CHACAO del Estado Miranda,<,>arial,B,10@> se hace  constar por medio de la presente, que  el (la) ciudadano(a) <@ ".
	 strtoupper($rs["nomemp"]).",<,>arial,B,10 @> titular de la cédula de Identidad N°<@ ".$rs["cedemp"].", <,>arial,B,10@>".
	 " $tipo sus servicios en este  Órgano Contralor desde el <@ ".$rs["fecing"].",<,>arial,B,10@>  $hasta" .
	 "desempeñando  el cargo de<@ ".$rs["nomcar"].",<,>arial,B,10@> adscrito(a)  a la: " .
	 "<@ ".$rs["desniv"].". <,>arial,B,10@>");
	 }
	   if ( $this->sueldo=='P') {
	   	$sueldo=(($sh["sueldo"])*36)/23;

        $this->MCPLUS(170,8,"Quien suscribe<@ Director(a) de Recursos Humanos de la CONTRALORIA MUNICIPAL DE CHACAO del Estado Miranda,<,>arial,B,10@> se hace  constar por medio de la presente, que  el (la) ciudadano(a) <@ ".
	 strtoupper($rs["nomemp"]).",<,>arial,B,10 @> titular de la cédula de Identidad N° <@ ".$rs["cedemp"].", <,>arial,B,10@>".
	 " $tipo sus servicios en este  órgano contralor desde el<@ ".$rs["fecing"].",<,>arial,B,10@> $hasta " .
	 "  desempeñando  el cargo de<@ ".$rs["nomcar"].",<,>arial,B,10@> adscrito(a)  a la: " .
	 "<@ ".$rs["desniv"].", <,>arial,B,10@>devengando un  sueldo promedio de: <@ ".H::Obtenermontoescrito($sueldo)." (Bs. ".H::Formatomonto($sueldo)."). <,>arial,B,10@>.");
	 }
	 $this->ln();
	   $this->setx(20);
	 if ($this->cesta=='S') {

        $this->MCPLUS(170,8,"Así mismo, se le cancela  Ticket  Alimentación, el cual es equivalente a la jornada efectivamente laborada, habiendo devengado la última Tickera por la cantidad de: <@".H::Obtenermontoescrito($this->monces)." (Bs. ".H::FormatoMonto($this->monces)."). <,>arial,B,10@>");


//. " por concepto de Ticket Alimentación.  Dividido entre jornadas efectivamente laboradas");
	 }
	 $this->ln();
	 $arrp = $this->objeto->sqlempresa();
	 $dated=date("d");
	 if(intval($dated)<=10)
	 {
	 	if(intval($dated)==1)
	 	{
			$nomnum='UN';
	 	}else
	 	{
	 		$num = $this->objeto->sqlnumeros(strlen(intval($dated)),intval($dated));
	 		$nomnum=$num[0]["numeros"];
	 	}
	 }elseif(intval($dated)<=15)
	 {
	 	if(intval($dated)==11)
	 		$nomnum='ONCE';
	 	elseif(intval($dated)==12)
	 		$nomnum='DOCE';
	 	elseif(intval($dated)==13)
	 		$nomnum='TRECE';
	 	elseif(intval($dated)==14)
	 		$nomnum='CATORCE';
	 	else
	 		$nomnum='QUINCE';
	 }elseif(intval($dated)<=19)
	 {
	 	$num = $this->objeto->sqlnumeros(1,substr(intval($dated),1,1));
	 	$nomnum='DIECI'.strtoupper($num[0]["numeros"]);
	 }else
	 {
	 	$num = $this->objeto->sqlnumeros(strlen(intval($dated)),substr(intval($dated),0,1));
	 	$num2 = $this->objeto->sqlnumeros(1,substr(intval($dated),1,1));
	 	$nomnum=$num[0]["numeros"].' Y '.$num2[0]["numeros"];
	 	if(substr(intval($dated),1,1)==0)
	 		$nomnum=$num[0]["numeros"];

	 }
  $this->setx(20);
	 $this->MCPLUS(170,8,"Constancia que se expide a petición  de la parte interesada en Chacao, " .
	 "a los ".ucfirst(strtolower($nomnum))." ($dated) días del mes de ".ucfirst(strtolower(H::Obtenermesenletras(date('m'))))." del año  ".date('Y').".");
	 $this->ln(10);
	 $this->multicell(0,4,"Atentamente,",0,'C');
	 $this->ln(20);
	 $this->setFont(arial,"B",10);
	 $this->multicell(0,4,$this->dirrec."\nDirector(a)",0,'C');
	 $this->ln(20);
	 $this->setFont(arial,"",7);
	 $this->multicell(180,4,$this->concop);
	 $this->setFont(arial,"B",7);
	 $num = $this->objeto->sqlnumeros(strlen(intval($this->valmes)),intval($this->valmes));
	 $nmes=intval($this->valmes);
	 if(intval($this->valmes)<=9)
	 	$nmes='0'.$this->valmes;
	 $m="meses";
	 if(intval($this->valmes)==1)
	 	$m="mes";

         $this->setx(21);


	 //$this->multicell(180,4,"Válida por ".ucfirst(strtolower($num[0]["numeros"]))." ($nmes) $m, a partir de su fecha de expedición");
        $this->multicell(180,4,"Nota: Se emite sin enmienda, cualquier alteracion anula su contenido.");
        $this->multicell(180,4," ");
        $this->multicell(180,4," ");
        $this->multicell(180,4," ");
$this->multicell(180,4," ");
$this->multicell(180,4," ");
$this->multicell(180,4," ");


         $this->setFont(arial,"",7);
        $this->multicell(180,4,"                        Av. Francisco de Miranda. Centro Plaza. Torre 'C'. Piso 20. Telf: (0212) 2851966 - 2854271. Fax 2855260. Caracas-Venezuela",0,'C');



	}
	function Cuerpo()
	{

    }
}
?>