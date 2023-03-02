<?php
 class BaseDatos {
     private $HOSTNAME;
     private $BASEDATOS;
     private $USUARIO;
     private $CLAVE;
     private $CONEXION;
     private $QUERY;
     private $RESULT;
     private $ERROR;
     /**
      * Constructor de la clase que inicia ls variables instancias de la clase
      * vinculadas a la coneccion con el Servidor de BD
      */
     public function __construct(){
         $this->HOSTNAME = "localhost";
         $this->BASEDATOS = "ingresante";
         $this->USUARIO = "";
         $this->CLAVE="";
         $this->RESULT=0;
         $this->QUERY="";
         $this->ERROR="";
    }
     /**
      * Funcion que retorna una cadena
      * con una pequenia descripcion del error si lo hubiera
      *
      * @return string
      */
     public function getError(){
         return "\n".$this->ERROR;
         
     }
    
    /**
     * Inicia la coneccion con el Servidor y la  Base Datos Mysql.
     * Retorna true si la coneccion con el servidor se pudo establecer y false en caso contrario
     *
     * @return boolean
     */
    public  function Iniciar(){
        $respuesta=false;
        $conexion = mysqli_connect($this->HOSTNAME,$this->USUARIO,$this->CLAVE);
        if ($conexion){
            if (mysqli_select_db($conexion,$this->BASEDATOS)){
                $this->CONEXION = $conexion;
                unset($this->QUERY);
                unset($this->ERROR);
                $respuesta= true;
            }  else {
                $this->ERROR = mysqli_errno($conexion) . ": " .mysqli_error($conexion);
            }
        }else{
            $this->ERROR =  mysqli_errno($conexion) . ": " .mysqli_error($conexion);
        }
        return  $respuesta;
    }
    
    /**
-     * Ejecuta una consulta en la Base de Datos.
-     * Recibe la consulta en una cadena enviada por parametro.
-     *
-     * @param string $consulta
-     * @return boolean
-     */
    public function Ejecutar($consulta){
        $respuesta=false;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if(  $this->RESULT = mysqli_query( $this->CONEXION,$consulta)){
            $respuesta= true;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION).": ". mysqli_error( $this->CONEXION);
        }
        return $respuesta;
    }
    
    /**
     * Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se despleza al siguiente registro de la consulta
     *
     * @return boolean
     */
    public function Registro() {
        $respuesta=false;
        if ($this->RESULT){
            unset($this->ERROR);
            if($temp = mysqli_fetch_assoc($this->RESULT)){
                $respuesta= $temp;
            }else{
                mysqli_free_result($this->RESULT);
            }
        }else{
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $respuesta;
    }
    
    /**
-     * Devuelve el id de un campo autoincrement utilizado como clave de una tabla
-     * Retorna el id numerico del registro insertado, devuelve null en caso que la ejecucion de la consulta falle
-     *
-     * @param string $consulta
-     * @return int id de la tupla insertada
-     */
    public function devuelveIDInsercion($consulta){
        $respuesta=null;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if ($this->RESULT = mysqli_query($this->CONEXION,$consulta)){
            $id = mysqli_insert_id($this->CONEXION);
            $respuesta= $id;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION) . ": " . mysqli_error( $this->CONEXION);
        }
        return $respuesta;
    }
    public function Cerrar(){
        mysqli_close($this->CONEXION);
    }
}


?> 
