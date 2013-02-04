<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
        require_once("../../lib/general/funciones.php");
	require_once("../../lib/modelo/sqls/ingresos/Inrdecliq.class.php");    

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $ancho;
		var $campos;
		var $sql1;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $reftra1;
		var $reftra2;
		var $fectra1;
		var $fectra2;
		var $pertra1;
		var $pertra2;
		var $stacom;
		var $codpre1;
		var $codpre2;
		var $tipo;
		var $comodin;
		var $secretaria;
		var $acum_mon;

		function pdfreporte()
		{
			$this->fpdf("p","mm","legal");
			$this->bd=new basedatosAdo();
			$this->arrp=array('no-vacio');
			$this->titulo = H::GetPost("titulo");
			$this->concepto = H::GetPost("concepto");
			$this->dirpre = H::GetPost("dirpre");
			$this->jefpre = H::GetPost("jefpre");
			$this->codplades=H::GetPost("numplades");
			$this->iniciales=H::GetPost("iniciales");
			$this->mensaje=H::GetPost("mensaje");
                        $this->fechades=H::GetPost("fechades");
                        $this->anofed=H::GetPost("anofed");
                        $this->anoind=H::GetPost("anoind");

                        $this->objInrdecliq = new Inrdecliq();
			$this->SetMargins(25,25,25);
			$this->setautopagebreak(true,20);
			$this->sql="select a.refliq,a.fecliq,to_char(a.fecliq,'dd/mm/yyyy') as fechaliq,a.desliq,sum(moning) as monto from ciliqing a,cidetliq b, cireging c  
                                where a.refliq='$this->codplades' 
                                and a.refliq=b.refliq and b.refing=c.refing 
                                group by a.refliq,a.fecliq,a.desliq,to_char(a.fecliq,'dd/mm/yyyy')";
                        //print $this->sql;exit;
                        $this->arrp=$this->bd->select($this->sql);
		}
      function footer()
        {
            $this->Line(10,325,200,325);
            $this->Image('../../img/PiedePagina_SIGRE.png', 20, 330, 160);
            //$this->SetXY(10,265);
            //$this->multicell(180,5,$this->mensaje,0,"C");
        }

	function Header()
	{
		$this->setFont('arial', "B", 14);
		$this->setXY(25, 30);
		$this->multicell(86,5,"G-__________",0,'L');
                $this->setXY(31, 30);
                //$this->multicell(86,5,$this->codplades,0,'L');
		$this->Image('../../img/Encabezados_SIGRE.png', 20, 10, 160);
                $this->Line(10,25,200,25);
		$this->setXY(25, 44);
		//$this->multicell(80,5, 'GOBERNACION',0,'C');
		//$this->multicell(95,5, 'DIRECCION GENERAL DE FINANZAS PÚBLICAS',0,'C');
		///$this->multicell(86,5, 'CONCEPTO',0,'C');
		$this->setFont('arial', "B", 12);
		$this->multicell(160,5,'JOSE GREGORIO BRICEÑO TORREALBA',0,"C");
                $this->multicell(160,5,'GOBERNADOR DEL ESTADO MONAGAS',0,"C");
		$this->ln(8);
	 }

	

	function Cuerpo()
	{

		$this->setFont('arial','', 10);
		$this->Multicell(160,4,"CONSIDERANDO: ",0,'C');
		$this->setFont('arial', '', 10);
		$this->ln(4);
		$auxfecha=split("-",$this->arrp->fields["fecliq"]);
	 	//$rs = $this->bd->select("select nomcue from tsdefban where trim(numcue)='".trim($this->arrp->fields["ctaori"])."'");
	 	
	 	$this->MCPLUS(160,9,'Que el Ejecutivo del Estado Monagas, registró Ingresos Extraordinarios, por la cantidad de ' .
	 	'<@' .strtoupper(H::ObtenerMontoEscrito($this->arrp->fields["monto"])).' CTS.(Bs.F '.H::FormatoMonto($this->arrp->fields["monto"]).')'.	'<,>arial,B,10@>, ' .
	 	'por concepto de <@ ' . trim($this->arrp->fields["desliq"]).' <,>arial,B,10 @>, de los Bancos:'.$this->objInrdecliq->sqlcuentas($this->arrp->fields["refliq"]).' según Planilla(s) de Liquidación' . 
                ' Nro(s). '.$this->objInrdecliq->sqlplanillas($this->arrp->fields["refliq"]).' de fecha: '.$this->objInrdecliq->sqlfechas($this->arrp->fields["refliq"]).'; Los cuales pueden ser Decretados Reservas del Tesoro.' .        
                ' ',0,'J');

		$this->ln(3);
                $this->multicell(167,9,"En uso de sus atribuciones legales .-",0,'J');
	 	$this->ln(3);
                $this->multicell(167,9,"D E C R E T A",0,'C');
	 	$this->ln(6);     
                $this->cell(30,9,"Articulo 1.- ",0,'L');
	 	$this->MCPLUS(130,9,'Se declara Reservas del Tesoro, la cantidad de' .
	 	'<@ ' .strtoupper(H::ObtenerMontoEscrito($this->arrp->fields["monto"])).' CTS.(Bs.F '.H::FormatoMonto($this->arrp->fields["monto"]).')'.	'<,>arial,B,10@>, ' .
	 	//'por concepto de <@ ' . trim($this->arrp->fields["desing"]).' <,>arial,B,10 @>, '.
                'correspondiente a lo señalado anteriormente.' . 
                ' ',0,'J');
                
                $this->cell(30,9,"Articulo 2.- ",0,'L');
	 	$this->MCPLUS(130,9,'El Ciudadano Secretario General de Gobierno y la Secretaría de Administracion, Hacienda y Finanzas, ' .
	 	'cuidaran de la ejecucion del presente Decreto. ' .
                ' ',0,'J');
                $this->multicell(130,9,"                               Comuníquese y Publíquese: ",0,'J');                
                $this->multicell(130,9,"Dado, firmado, sellado y refrendado en el Palacio del Poder Ejecutivo del Estado Monagas,".
                                        " en Maturin a los ". substr($this->fechades,0,2)." días del mes de ".  mesenletras(substr($this->fechades,3,2))." del año ".substr($this->fechades,6,4)." -Años  $this->anoind de la Independencia y $this->anofed de la Federacion.-" .
                                        " ",0,'J');
                $this->ln(10);
                $this->setFont('arial','B', 10);
	        $this->multicell(160,9,"Gobernador del Estado Monagas",0,'C');
                $this->ln(15);
                $this->multicell(160,9,"JOSE GREGORIO BRICEÑO TORREALBA",0,'C');
                $this->ln(10);
                $this->setFont('arial','B', 10);
      	        $this->Cell(160,4,"         Refrendado:                                                                                        Refrendado:       ",0,'C');
                $this->ln(15);
	        $this->Cell(160,4,"         Darwin Agreda                                                                                   Ysmania Fernández Yendez       ",0,'C');
                $this->ln();
                $this->Cell(160,4,"         Secretario Gral. de Gobierno                                                            Secretaria de Hacienda Administracion",0,'C');
                $this->ln();
                $this->setx(141);
                $this->Cell(160,4,"y Finanzas",0,'C');
		$this->ln(8);
		$this->setFont('arial','',10);
		$this->ln();
		



  }
}
?>
