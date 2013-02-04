<?
session_start();
//   require_once("../../../lib/genegociocatalogo.php");
   require_once('../../lib/bd/basedatosAdo.php');
   require_once('../../lib/general/funciones.php');
   require_once('../../lib/general/funciones2.php');
   $obj=new negociocatalogo2();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><? echo $_GET["titulo"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK media=all href="../../lib/css/base.css" type=text/css rel=stylesheet>
<link href="../../lib/css/siga.css" rel="stylesheet" type="text/css">

</head>

<style type="text/css">
.distabla tr:hover {	background-color: #DFE7F2;	color: #000000;}
.distabla tr.resaltar {	background-color: #DFE7F2;	color: #000000;}
.distabla td {	border: 1px solid #CCCCCC;}
.distabla th {	border: 1px solid #CCCCCC;
                background-color: #CCCCCC;}


</style>

<body>


    <?
    function transf(&$sql)
    {
    	  	 //sacamos el campo
		  	 $pvacio = stripos(strtoupper($sql),strtoupper(' '));
		  	 $sqlnew=trim(substr($sql,$pvacio));
		  	 $pcorte = stripos(strtoupper($sqlnew),strtoupper(','));
		  	 if ($pcorte === false)
		  	 {
		  	 	$pcorte = stripos(strtoupper($sqlnew),strtoupper('from'));
		  	 }
		  	 $campo=substr($sql,$pvacio,$pcorte+1);

		  	 //revisamos si se le aplica funcion
		  	 $pparen1 = stripos(strtoupper($campo),strtoupper('('));

		  	 if ($pparen1 !== false)
		  	 {
		  	 	$pparen1++;
		  	 	$pparen2 = stripos(strtoupper($campo),strtoupper(')'));
		  	 	$hasta=$pparen2-$pparen1;
		  	 	$campo=substr($campo,$pparen1,$hasta);
		  	 }else
		  	 {
		  	 	$pfunc = stripos(strtoupper($campo),strtoupper('distinct'));
		  	 	if ($pfunc)
		  	 	{
					$campo=substr($campo,strlen('distinct')+1);

		  	 	}
		  	 	//else
		  	 	    //aqui van las posibles funciones que se le apliquen a los campos

		  	 	//BUSCAMOS SI TIENEN ALIAS
		  	 	$palias =  stripos(strtoupper($campo),strtoupper('as'));
		  	 	if ($palias)
		  	 	{
					$campo=trim(substr(trim($campo),0,$palias-1));
		  	 	}
		  	 }
		  	 ///////////////////

		  	 //chequeamos si hay order y/o group by
		  	 $porder = stripos(strtoupper($sql),strtoupper('order'));
		 	 $pgroup = stripos(strtoupper($sql),strtoupper('group'));
		     if ( $porder === false && $pgroup === false ) // no hay ni order ni group
		     {
		     	$donde=strlen($sql);
		     }
		     else
		     {
		    	 if ( $porder !== false && $pgroup !== false )// hay order y group
		    	 {
		    		$donde=$pgroup;
		    	 }
				 else // hay solo uno de los 2
				 {
					 if ($porder !== false) // hay order
					 {
				 		$donde=$porder;
					 }
					 else // hay group
					 {
				 		$donde=$pgroup;
					 }
				 }
		     }
			 ////////////////////////////////////////

		  	 //busquemos si hay where
		  	 $pwhere = stripos(strtoupper($sql),strtoupper('where'));
		  	 if ($pwhere === false) // no hay where
		  	 {
				$sql1=substr($sql,0,$donde);
		  	    $cadena=' where upper('.$campo.') like upper(¿%¿) ';
		  	    $sql2=substr($sql,$donde);
		  	 }
		  	 else // si hay where
		  	 {
				$sql1=substr($sql,0,$donde);
		  	    $cadena=' and upper('.$campo.') like upper(¿%¿) ';
		  	    $sql2=substr($sql,$donde);
		  	 }
		  	 $sql=$sql1.$cadena.$sql2;
    }



   $aux1=obtenerget("campo");
   $aux2=obtenerget("campo2");
   $aux3=obtenerget("foco");
   $aux4=obtenerget("tipo");

   if (!empty($aux1))
   {
     $_SESSION["c"]=$aux1;
    $campo=$_SESSION["c"];
   }
   else
   {
       $campo=$_SESSION["c"];
   }
   if (!empty($aux2))
   {
     $_SESSION["d"]=$aux2;
    $campo2=$_SESSION["d"];
   }
   else
   {
       $campo2=$_SESSION["d"];
   }
   if (!empty($aux3))
   {
     $_SESSION["f"]=$aux3;
    $foco=$_SESSION["f"];
   }
   else
   {
       $foco=$_SESSION["f"];
   }
    if (!empty($aux4))
   {
     $_SESSION["t"]=$aux4;
    $tipo=$_SESSION["t"];
   }
   else
   {
       $tipo=$_SESSION["t"];
   }
   echo $sw;
   if (obtenerget("campo"))
   {
     $campo=obtenerget("campo");
     $campo2=obtenerget("campo2");
     $sql=obtenerget("sql");
     $foco=obtenerget("foco");
     $tipo=obtenerget("tipo");
     $filtro=obtenerget("filtro");
     $sw=1;
   }else{
      if (obtenerpost("sw")=='2')   //Filtrado
    {
       $filtro     = obtenerpost("filtro");
       $filtro2    = obtenerpost("filtro2");
       $sqlant     = obtenerpost("sqlant");
       $condicion  = " like upper(¿%¿) ";
       $condicion2 = " like upper(¿%".$filtro2."%¿) ";
       transf($sqlant);

       $sql =  str_replace($condicion,$condicion2,$sqlant);
       //echo $sql." <br>";
       $sw  =2;
    }else{
         $filtro=obtenerpost("filtro");
         $filtro2=obtenerpost("filtro2");
         $sql=obtenerpost("sql");
         $sqlant=obtenerpost("sql");
         $condicion="like upper(¿%¿)";
       $condicion2=" like upper(¿%".$filtro2."%¿)";
       $sql=str_replace($condicion,$condicion2,$sql);
     $sw=2;
    }
   }
  $i=1;
?>
<form name="form1" method="post" action="../../lib/general/catalogoobj.php">
    <input name="filtro" type="hidden" id="filtro" value="<?print $filtro;?>">
  <input name="sqlant" type="hidden" id="sqlant" value="<?print $sqlant;?>">
  <input name="sql" type="hidden" id="sql" value="<?print $sql;?>">
  <input name="sw" type="hidden" id="sw" value="<?print $sw;?>">

  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
    <tr>
      <td><table width="80%" align="center">
  <tr>
    <td align="center" class="tpButtons">Opciones de B&uacute;squeda </td>
    </tr>
  <tr valign="middle">
   <td height="32" class="recuadro"><font face="verdana">&nbsp;&nbsp;&nbsp;Filtrar por Descripci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
       <input name="filtro2" type="text" id="filtro2" value="<?print $filtro2;?>" size="30" maxlength="200" class="imagenInicio" onMouseOver="this.className='imagenFoco'" onMouseOut="this.className='imagenInicio'">
    <input type="button" name="Button" value="Filtrar" onClick="enviar();">	  </td>
    </tr>
  </table></td>
    </tr>
    <tr>
      <td align="center">
    <div class="div_catalogo">
      <table width="100%" height="100" border="0" bordercolor="#000000" id="TablaCatalogo"  class="recuadro" align="center">
      <td align="center"><tr align="center">
      <?
  if ($sql!="")
  {
     $obj->mostrar($sql,$filtro);
  }
  $cuantasfilas = $obj->numerofilas();
  $arreglo      = $obj->devuelve_arreglo();
  $numcampos    = $obj->numerocampos();
  ?>
    </table>
     </div>
      </td>
    </tr>
  </table>

  <p>&nbsp;  </p>
  <p>&nbsp;</p>
  <!--input type="hidden" name="aux"-->
  <input type="hidden" name="valor" value="<?print $i;?>">
  </tr></td>
</form>
</body>

<script language="JavaScript">

   function enviar()
   {
     f=document.form1;
   //f.action="catalogo2.php";
   //document.getElementById("filtro2").value

   f.submit();
   }
</script>

<script language="JavaScript">

   function aceptar(c,d)
   {
   f=opener.document.form1;
   <?
   if ($campo=="")
   {
   ?>
   f.<?print $campoint; ?>.value=c;
   <?
   }
   else
   {
   ?>
   f.<?print $campo; ?>.value=c;
   <?
   }
   ?>
   close();
   }

   function mostrarreferencia(letra)
  {
     var rows = document.getElementsByTagName("tr");
     for(i in rows)
     {
       rows[i].className = null;
     }
     f=document.form1;
     cuantos=f.buscarref.value.length+1; //validar error de longitud
     maximo=<?print $cuantasfilas;?>;
     referencia="";
     f.aux.value=f.buscarref.value+letra;
     for (i=0;i<maximo;i++)
     {
        valor=f.elements["r"+(i+1)].value.substr(0,cuantos);

        if (valor==f.aux.value.toUpperCase())
      {
         rows[i+1].className = "resaltar";
         referencia=f.elements["r"+(i+1)].value;
       f.elements["p"+(i+1)].focus();
       f.buscarref.focus();
       break;
      }
     }
  }

  function enterbuscar()
  {
     f=document.form1;
     cuantos=f.buscarref.value.length;
     maximo=<?print $cuantasfilas;?>;
     referencia="";
     for (i=0;i<maximo;i++)
     {
        if (f.elements["r"+(i+1)].value.substr(0,cuantos)==f.buscarref.value.toUpperCase())
      {
         referencia=f.elements["r"+(i+1)].value;
       f.elements["p"+(i+1)].focus();
       f.buscarref.focus();
       break;
      }
     }
     aceptar(f.elements["c"+(i+1)].value);
  }

  function tecla(e)
  {
     f=document.form1;
     letra = String.fromCharCode(e.keyCode);
     if (e.keyCode!=13)
     {
        //f.buscarref.value=letra;
        mostrarreferencia(letra);
     }
     else
     {
        enterbuscar();
     }
  }

  function ColorFila()
  {
     var rows = document.getElementsByTagName("tr");
     for(var i in rows)
     {
        rows[i].onmouseover = function() {			rows.className = "resaltar";		}
      rows[i].onmouseout = function() {			rows.className = null;		}
      }
   }

</script>
</html>
