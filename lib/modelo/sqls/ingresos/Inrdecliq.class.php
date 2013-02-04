<?php
require_once("../../lib/modelo/baseClases.class.php");

class Inrdecliq extends baseClases {


  function sqlplanillas($numliq)
  {
       $sql="select to_number(refing,'99999999') as refing from cidetliq where refliq='$numliq' order by refing";
       $arr=$this->select($sql);
       $cadena="";	
       foreach($arr as $arrliq)
       {
          $cadena=$cadena.", ".$arrliq["refing"];
       }    
       return substr($cadena,1);
  }

  function sqlfechas($numliq)
  {
       $sql="select distinct To_char(b.fecing,'dd/mm/yyyy') as lafecha,b.fecing from cidetliq a, 
        cireging b where a.refliq='$numliq' and a.refing=b.refing order by b.fecing";
       $arr=$this->select($sql);
       $cadena="";
       $cuantos=0;
       foreach($arr as $arrliq)
       {
          $cadena=$cadena.", ".$arrliq["lafecha"];
          $cuantos++;
       }
       if ($cuantos>1) 
       {
           $cadena=$cadena." respectivamente";
       }
       return substr($cadena,1);
  }

  
  
  function sqlcuentas($numliq)
  {
        $sql="select distinct nomcon from ciliqing a,cidetliq b, cireging c,ciconrep d 
              where a.refliq='$numliq' and a.refliq=b.refliq 
              and b.refing=c.refing and d.rifcon=c.rifcon";
        
       $arr=$this->select($sql);
       $cadena="";
       $cuantos=0;
       foreach($arr as $arrliq)
       {
          $cadena=$cadena.", ".$arrliq["nomcon"];
          $cuantos++;
       }

       return substr($cadena,1);
  }
}
?>
