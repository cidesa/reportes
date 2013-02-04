<?
require_once("../../lib/bd/basedatosAdo.php");
require_once("../../lib/general/Herramientas.class.php");

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=/tmp/listado_nomina".date('d/m/Y').".xls");


$bd= new basedatosAdo();

	        $codempdes=$_GET["codempdes"];
			$codemphas=$_GET["codemphas"];
			$codcardes=$_GET["codcardes"];
			$codcarhas=$_GET["codcarhas"];
			$codnivdes=$_GET["codnivdes"];
			$codnivhas=$_GET["codnivhas"];
			$codcondes=$_GET["codcondes"];
			$codconhas=$_GET["codconhas"];
			$tipnom=$_GET["tipnom"];
			$especial=$_GET["especial"];
		    $fechades=$_GET["fechades"];
			$fechahas=$_GET["fechahas"];
			$tipnomesp1=$_GET["tipnomesp1"];
		    $tipnomesp2=$_GET["tipnomesp2"];
			$elaborado=$_GET["elaborado"];
			$revisado=$_GET["revisado"];
			$autorizado=$_GET["autorizado"];

   if ($especial == 'S')
            {
                $especial = " G.especial = 'S' AND
        (G.CODNOMESP) >= TRIM('".$tipnomesp1."') AND
        (G.CODNOMESP) <= TRIM('".$tipnomesp2."') AND ";
             }
            else
            {  if ($especial == 'N')           $especial = " G.especial = 'N' AND";
            }
            if ($especial == 'T')           $especial = "";


			$sql="SELECT DISTINCT
							C.CODEMP as codemp,
							to_char(C.FECRET,'dd/mm/yyyy') as fecret,
							C.NOMEMP as nomemp,
							to_char(C.FECING,'dd/mm/yyyy') as fecing,
							C.NUMCUE as CUENTA_BANCO,
							C.CODNIV as codniv,
							C.CEDEMP as cedemp,
							LTRIM(RTRIM(g.CODCAR)) as CODCAR,
							a.NOMCAR as nomcar,
							E.DESNIV as desniv,
							(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
							G.CODCAR as codcargo, cast(REPLACE(c.cedemp,'.', '') as int )
						FROM
							NPHOJINT C,
							NPESTORG E,
							nphiscon G,
							NPDEFCPT H, npcargos a
						WHERE
							(g.CODNOM) = ('".$tipnom."') AND
							E.CODNIV=C.CODNIV AND
							g.CODEMP=C.CODEMP AND ".$especial."
							C.CODEMP>= ('".$codempdes."') AND
							C.CODEMP <= ('".$codemphas."') AND
							g.CODCAR>= ('".$codcardes."') AND
							g.CODCAR <= ('".$codcarhas."') AND
							C.CODNIV >= ('".$codnivdes."') AND
							C.CODNIV <= ('".$codnivhas."') AND
							--B.STATUS='V' AND
							G.CODCON=H.CODCON AND
							G.CODCON>='".$codcondes."' AND
							G.CODCON<='".$codconhas."' AND
							(G.CODNOM) = ('".$tipnom."') AND
						--	G.CODCAR=B.CODCAR AND
							G.CODEMP=C.CODEMP and  g.fecnom>=to_date('".$fechades."','dd/mm/yyyy') and
			                g.fecnom<=to_date('".$fechahas."','dd/mm/yyyy') and g.codcar=a.codcar
						 ORDER BY
							cast(REPLACE(c.cedemp,'.', '') as int )";

					//	print '<pre>'; print $sql;

			$rs=$bd->select("select nomnom as nombre from NPASICAREMP where codnom='".$tipnom."'");
			if(!$rs->EOF)
			{
				$nombre=$rs->fields["nombre"];
			}

		$arrp=$bd->select($sql);
		$cont=1;

        echo "<table>";
    	echo "<tr>";
    	echo "<td>"."HISTORICO ASIGNACIONES A PERSONAL"."</td>";
        echo "</tr>";
        echo "<tr>";
    	echo "<td>".'NOMINA: '.$tipnom.' - '.$nombre.'    PERIODO DEL: '. $fechades.' AL '. $fechahas ."</td>";
        echo "</tr>";
		echo "</table>";

		///cabecera
		echo "<table>";
		echo "<tr>";
        echo "<td>"."N#"."</td>";
		echo "<td>"."Cedula"."</td>";
		echo "<td>"."Nombre"."</td>";
	    echo "<td>"."Fecha de Ingreso"."</td>";
	    echo "<td>"."Cargo"."</td>";

        $sql0="select a.codcon as codcon, b.nomcon as nomcon from npconsalint a,npdefcpt b where a.codnom=('".$tipnom."') and a.codcon=b.codcon";
		$arrp0=$bd->select($sql0);
	    while(!$arrp0->EOF){
        echo "<td>".$arrp0->fields["codcon"]." - ".$arrp0->fields["nomcon"]."</td>";
        $arrp0->MoveNext();
	                       }// arrp2

        echo "<td>"."Total"."</td>";
		echo "</tr>";
		echo "</table>";
		///fin cabecera


while(!$arrp->EOF)
{

        $total=0;
		echo "<table>";
		echo "<tr>";
		echo "<td>".$cont."</td>";
        echo "<td>".$arrp->fields["codemp"]."</td>";
		echo "<td>".$arrp->fields["nomemp"]."</td>";
		echo "<td>".$arrp->fields["fecing"]."</td>";
	    echo "<td>".$arrp->fields["nomcar"]."</td>";

        $sql1="select a.codcon as codcon, b.nomcon as nomcon from npconsalint a,npdefcpt b where a.codnom=('".$tipnom."') and a.codcon=b.codcon";
		$arrp1=$bd->select($sql1);
		while(!$arrp1->EOF){
			$sql2="select sum(G.MONTO) as monto
			 from nphiscon G
			 where
			 g.fecnom>=to_date('".$fechades."','dd/mm/yyyy') and
			 g.fecnom<=to_date('".$fechahas."','dd/mm/yyyy') and
             G.CODEMP=('".$arrp->fields["codemp"]."') and G.CODCON=('".$arrp1->fields["codcon"]."') and G.codnom=('".$tipnom."')";
             //print  '<pre>' ; print $sql2;
             $arrp2=$bd->select($sql2);
             echo "<td>".H::Formatomonto($arrp2->fields["monto"])."</td>";
	         $total+=$arrp2->fields["monto"];

        $arrp1->MoveNext();
		}// arrp1
        echo "<td>".H::Formatomonto($total)."</td>";
		echo "</tr>";
		echo "</table>";

    $cont++;
    $arrp->MoveNext();

}// arrp
$bd->closed();
?>
