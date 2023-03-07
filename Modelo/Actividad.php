<?php 
include_once "BaseDatos.php"; 

class Actividad{

	//atributos
    private $id_actividad;
	private $descripcion_corta;
	private $descripcion_larga;
	private $colModulos;
    private $mensajeOperacion;

	//metodos
	public function __construct(){
        $this->id_actividad = 0;
		$this->descripcion_corta= "";
		$this->descripcion_larga= "";
		$this->colModulos = [];
	}

	public function cargar($id_actividad, $descripcion_corta,$descripcion_larga){
        $this->setId_Actividad($id_actividad);
		$this->setDescripcion_corta($descripcion_corta);
		$this->setDescripcion_larga($descripcion_larga);
	}

    public function getId_Actividad(){
		return $this->id_actividad;
	}
	public function setId_Actividad($id_actividad){
		return $this->id_actividad=$id_actividad;
	}

	public function getDescripcion_corta(){
		return $this->descripcion_corta;
	}
	public function setDescripcion_corta($descripcion_corta){
		return $this->descripcion_corta=$descripcion_corta;
	}

	public function getDescripcion_larga(){
		return $this->descripcion_larga;
	}
	public function setDescripcion_larga($descripcion_larga){
		return $this->descripcion_larga=$descripcion_larga;
	}

	public function getColModulos(){
		return $this->colModulos;
	}
	public function setColModulos($colModulos){
		return $this->colModulos=$colModulos;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion;
	}
	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function buscar($id_actividad){
        $respuesta = null;
		$base=new BaseDatos();
		$consultaActividad="Select * from actividad where id_actividad=".$id_actividad;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaActividad)){
				if($row2=$base->Registro()){
                    $this->setId_Actividad($id_actividad);
					$this->setDescripcion_corta($row2['descripcion_corta']);
					$this->setDescripcion_larga($row2['descripcion_larga']);
                    $respuesta = $this; //Devuelve un objeto
				}	
		 	}else{
                $this->setMensajeOperacion($base->getError());//Error Ejecutar
		 		$respuesta = false;		 		
			}
		}else{
            $this->setMensajeOperacion($base->getError());//Error Iniciar
		 	$respuesta = false;		 	
		}
        $base->Cerrar();
        return $respuesta;
	}

	public static function listar($condicion=""){
        $respuesta = null;
		$arregloActividades= array();
		$base=new BaseDatos(); 
		$consultaActividades="Select * from actividad ";
		if ($condicion!=""){
			$consultaActividades.=' where '.$condicion;
		}
		$consultaActividades.=" order by id_actividad ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaActividades)){				
				$arregloActividades= array();
				while($row2=$base->Registro()){
					$id_actividad =      $row2['id_actividad'];
					$descripcion_corta = $row2['descripcion_corta'];
                    $descripcion_larga = $row2['descripcion_larga'];
					$unaActividad = new Actividad();
					$unaActividad->cargar($id_actividad, $descripcion_corta, $descripcion_larga);
					array_push($arregloActividades,$unaActividad);
                    $respuesta = $arregloActividades;
				}			
		 	}else{
                $respuesta = $base->getError();//Error Ejecutar
			}
		}else {
            $respuesta = $base->getError();//Error Iniciar
		}
        $base->Cerrar();
		return $respuesta;
	}


	public function insertar(){
		$base=new BaseDatos();
		$consultaInsertar="INSERT INTO actividad( descripcion_corta, descripcion_larga) 
				VALUES ('".$this->getDescripcion_corta()."' , '".$this->getDescripcion_larga()."')";
		if($base->Iniciar()){	
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId_Actividad($id);
				$base->Cerrar();
				//---------------------
				return $this;//--
				//---------------------
			}else {
				$this->setMensajeOperacion($base->getError());//Error Insercion
			}
		} else {
			$this->setMensajeOperacion($base->getError());//Error Iniciar
		}
	}

	public function modificar(){
        $respuesta = false;
		$base=new BaseDatos();
		$consultaModifica="UPDATE actividad SET descripcion_corta='".$this->getDescripcion_corta()."', descripcion_larga='".$this->getDescripcion_larga()."' WHERE id_actividad=". $this->getId_Actividad();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
				$respuesta = true;				
			}else{
				$this->setMensajeOperacion($base->getError());//Error Ejecutar
			}
		}else{
			$this->setMensajeOperacion($base->getError());//Error Iniciar
		}
		$base->Cerrar();
        return $respuesta;
	}
	
	public function eliminar(){	
        $respuesta = false;
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM actividad  WHERE id_actividad=". $this->getId_Actividad();
			if($base->Ejecutar($consultaBorra)){
				$respuesta = true;
			}else{
				$this->setMensajeOperacion($base->getError());//Error Ejecutar
			}
		}else{
			$this->setMensajeOperacion($base->getError());//Error Iniciar
		}
        $base->Cerrar();
        return $respuesta;
	}

	public function getColModulosBaseDatos(){
		$colModulos = Modulo::listar(" WHERE modulo.id_actividad = ".$this->getId_Actividad());
		if(is_array($colModulos)){
			return $colModulos;
		}else{
			$this->setMensajeOperacion($colModulos);
		}
	}


	public function __toString(){
        $cadena = "________\nActividad:\n".
                "Descripcion:".$this->getDescripcion_corta()."\n".
                "Descripcion Detallada: ".$this->getDescripcion_larga()."\n";
        return $cadena;
	}
}
?>