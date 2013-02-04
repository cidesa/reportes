<?php session_start();
include_once("../../lib/general/headhtml.php");
require_once("../../lib/modelo/business/presupuesto.class.php");
include_once("../../lib/general/funciones.php");
require_once("../../lib/bd/basedatosAdo.php");
$bd=new basedatosAdo();

//AQUI SE CONFIGURAN LOS CATALOGOS PREGUNTAR A CARLOS
//OBJETO CODIGO EMPLEADO
$catalogo[] = presupuesto::catalogo_cpcomproext('refcomdes');
$catalogo[] = presupuesto::catalogo_cpcomproext('refcomhas');

$_SESSION['cprcompromisoext'] = $catalogo;

$catalogo1[] = presupuesto::catalogo_cptipmonext('codmondes');
$catalogo1[] = presupuesto::catalogo_cptipmonext('codmonhas');

$_SESSION['cptipmon'] = $catalogo1;

$titulo='Comprobante de Compromiso en Moneda Extranjera';
$orientacion='VERTICAL';
$tipopagina='CARTA';

?>
<?php include_once("../../lib/general/formtop.php")?>

            <!--AQUI SE COPIAN LAS CAJITAS DE TEXTO PERTENECIENTES AL REPORTE-->
            <tr bordercolor="#6699CC">
              <td class="form_label_01"><strong>Referencia: </strong></td>
              <td>
			<input name="refcomdes" type="text" class="breadcrumb" id="refcomdes"
                   value="<?$sql="select min(refcomext) as cod from cpcomext";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cprcompromisoext',0); "></a>
		      </td>
              <td>
			<input name="refcomhas" type="text" class="breadcrumb" id="refcomhas"
                   value="<?$sql="select max(refcomext) as cod from cpcomext";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cprcompromisoext',1); "></a>
		      </td>
            </tr>
            <tr bordercolor="#6699CC">
              <td class="form_label_01"><strong>Tipo de Moneda: </strong></td>
              <td>
			<input name="codmondes" type="text" class="breadcrumb" id="codmondes"
                   value="<?$sql="select min(a.codmon) as cod from tsdefmon a,opdefemp b where a.codmon<>b.codmon";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cptipmon',0); "></a>
		      </td>
              <td>
			<input name="codmonhas" type="text" class="breadcrumb" id="codmonhas"
                   value="<?$sql="select max(a.codmon) as cod from tsdefmon a,opdefemp b where a.codmon<>b.codmon";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cptipmon',1); "></a>
		      </td>
            </tr>
            <tr bordercolor="#6699CC">
              <td class="form_label_01"><strong>Presupuesto: </strong></td>
              <td colspan="2">
			<input name="diradm" type="text" class="breadcrumb" id="diradm"
                   value="<?$sql="SELECT DIRPRE AS COD FROM EMPRESA";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="30">
           <!--
            <input type="button" name="Button3" value="..." onClick=" catalogo('dirpre');">
            -->
		      </td>
            </tr>
            <tr bordercolor="#6699CC">
              <td class="form_label_01"><strong>ANALISTA: </strong></td>
              <td colspan="2">
			<input name="anapre" type="text" class="breadcrumb" id="anapre"
                   value="<?$sql="SELECT ANAPRE AS COD FROM EMPRESA";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="30">
           <!--
            <input type="button" name="Button3" value="..." onClick=" catalogo('dirfin');">
            -->
		      </td>
            </tr>



            <tr bordercolor="#6699CC">
              <td class="form_label_01"><strong>GERENTE: </strong></td>
              <td colspan="2">
			<input name="dirgen" type="text" class="breadcrumb" id="dirgen"
                   value="<?$sql="SELECT DIRGEN AS COD FROM EMPRESA";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="30">
           <!--
            <input type="button" name="Button3" value="..." onClick=" catalogo('dirfin');">
            -->
		      </td>
            </tr>
            <!-- HASTA AQUI SE COPIAN LAS CAJITAS DEL REPORTE -->


<?php include_once("../../lib/general/formbottom.php")?>
