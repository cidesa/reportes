<?
 require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/Herramientas.class.php");

 class negociorpresupuesto
 {
    var $bd2;
	var $lonpre;
	var $loncat;
	var $nomcat;
	var $nompre;
	var $nompar;
	var $formatopre;
	function negociorpresupuesto()
	{
	  $this->bd2=new basedatosAdo();
	   $this->lonpre=32;
	   $this->loncat=32;
	   $this->nomcat="";
	   $this->nompre="";
	   $this->nompar="";
	   $tb=$this->bd2->select("select * from cpdefniv where codemp='001';");
	   $this->lonpre=$tb->fields["loncod"];
	   $tb->close();
	}

	public function nombrecodigo($codigopre)
	{
	  // $tb=$this->bd->select("select max(nompre) as nompre from cpdeftit where codpre=rpad('".$codigopre."',".$this->lonpre.",' ');");
	   $sql="select nompre as nompre from cpdeftit where rpad(codpre,".H::longitudcampo('codpre').",' ')=rpad('01',".H::longitudcampo('codpre').",' ');";
	   $tb=$this->bd2->select($sql);
	   //print "select max(nompre) as nompre from cpdeftit where codpre=rpad('".$codigopre."',".$this->lonpre.",' ');";
	   $this->nompre=$tb->fields["nompre"];
	   $tb->close();
	   return $this->nompre;
	}
 }
?>