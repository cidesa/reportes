<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
  require_once('../../adodb/adodb.inc.php');
  require_once("conexionAdo.php");
  require_once("../../lib/yaml/Yaml.class.php");

  class basedatosAdo
  {
    private $conn;
    private $bd;
    private $confbd;
    private $schema;
    private $empresa;

    function basedatosAdo()
    {
      $this->bd=new conexionAdo();
      $opciones = Yaml::load("../../lib/bd/databases.yml");

      $confbd = $opciones['database']['name'];


      $sf_config_dir = '';
      $sf_config_dir = $_SESSION['sf_config_dir'];

      $driver="postgres";
      if($sf_config_dir!=''){
        $opcbd = Yaml::load($sf_config_dir."/databases.yml");
        $opcbd = $opcbd['all']['propel']['param'];

        $opciones[$confbd]['host']     = $opcbd['hostspec'];
        $opciones[$confbd]['usuario']  = $opcbd['username'];
        $opciones[$confbd]['password'] = $opcbd['password'];
        $opciones[$confbd]['bd']       = $opcbd['database'];
      }else{
        $hostname = "192.168.5.231";
        $user     = "postgres";
        $password = "postgres";
        $dbname   = "SIMA";
      }

      if(isset($_GET['schema'])) $getschema = $_GET['schema'];
      elseif(isset($_POST['schema'])) $getschema = $_POST['schema'];
      else $getschema = '';

      if(isset($_SESSION['schema']))
      {
        if($_SESSION['schema']!=$getschema && $getschema!=''){
          $this->schema = $getschema;
          $_SESSION['schema'] = $getschema;
        }else $this->schema = $_SESSION['schema'];
      }
      else{
        if($getschema!=''){
          $this->schema = $getschema;
          $_SESSION['schema'] = $getschema;
        }else {
          $this->schema = $opciones[$confbd]['schema'];
          $_SESSION['schema'] = $this->schema;
        }
      }

      $hostname=$opciones[$confbd]['host'];
      $user=$opciones[$confbd]['usuario'];
      $password=$opciones[$confbd]['password'];
      $dbname=$opciones[$confbd]['bd'];
      //$this->schema=$opciones[$confbd]['schema'];
      $port=$opciones[$confbd]['port'];
      $this->empresa=$opciones[$confbd]['empresa'];
//print $hostname;
      $this->conn=$this->bd->conectar("postgres",$hostname,$user,$password,$port,$dbname);

      // Configuración de la codificación por defecto
      //$this->conn->Execute('SET CLIENT_ENCODING TO "UTF8"');

    }

    function select($sql, $schema = '')
    {//print $this->schema;
        if($schema=='') $this->conn->Execute('SET search_path TO "'.$this->schema.'"');
        else $this->conn->Execute('SET search_path TO "'.strtoupper($schema).'"');
        $rs=$this->conn->Execute($sql);
      return $rs;
    }

    function selectu($sql)
    {
      $this->conn->Execute('SET search_path TO "SIMA_USER"');
      $rs=$this->conn->Execute($sql);
      return $rs;
    }

    function actualizar($sql)
    {
      $this->conn->Execute('SET search_path TO "'.$this->schema.'"');
      $this->conn->Execute($sql);
    }

    function closed()
    {
      $this->conn->Close();
    }

    function getSchema()
    {return $this->schema;}

    function getEmpresa()
    {return $this->empresa;}

    function Validar()
    {
      return true;
    }

  }
?>
