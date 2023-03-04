<?php 
include_once "BaseDatos.php";

class Inscripcion{

	//atributos
    private $id_inscripcion;
	private $fechaInscripcion;
	private $costoFinal;
    private $obj_Ingresante;
    private $mensajeOperacion;

	//metodos
	public function __construct(){
        $this->id_inscripcion = 0;
		$this->fechaInscripcion= "";
		$this->costoFinal= "";
        $this->obj_Ingresante = null;
	}

	public function cargar($id_inscripcion, $fechaInscripcion,$costoFinal, $obj_Ingresante){
        $this->setId_inscripcion($id_inscripcion);
		$this->setFechaInscripcion($fechaInscripcion);
		$this->setCostoFinal($costoFinal);
        $this->setObj_Ingresante($obj_Ingresante);
	}

    public function getId_inscripcion(){
		return $this->id_inscripcion;
	}
	public function setId_inscripcion($id_inscripcion){
		return $this->id_inscripcion=$id_inscripcion;
	}

	public function getFechaInscripcion(){
		return $this->fechaInscripcion;
	}
	public function setFechaInscripcion($fechaInscripcion){
		return $this->fechaInscripcion=$fechaInscripcion;
	}

	public function getCostoFinal(){
		return $this->costoFinal;
	}
	public function setCostoFinal($costoFinal){
		return $this->costoFinal=$costoFinal;
	}

    public function getObj_Ingresante(){
		return $this->obj_Ingresante;
	}
	public function setObj_Ingresante($obj_Ingresante){
		return $this->obj_Ingresante=$obj_Ingresante;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}
	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function buscar($id_inscripcion){
        $respuesta = null;
		$base=new BaseDatos();
		$consultainscripcion="Select * from inscripcion where id_inscripcion=".$id_inscripcion;
		if($base->Iniciar()){
			if($base->Ejecutar($consultainscripcion)){
				if($row2=$base->Registro()){
                    $this->setId_inscripcion($id_inscripcion);
					$this->setFechaInscripcion($row2['fecha_inscripcion']);
					$this->setCostoFinal($row2['costo_final']);
                    $obj_Ingresante = new Ingresante();
					$obj_Ingresante->buscar($row2['id_ingresante']);
                    if ($obj_Ingresante){    
                        $this->setObj_Ingresante($obj_Ingresante); //Setea el objeto Ingresante al objeto inscripcion
                        $respuesta = $this; //Devuelve el objeto inscripcion
                    }else{
                        $this->setMensajeOperacion($obj_Ingresante->getMensajeOperacion()); //Error al encontrar el objeto Ingresante correspondiente
						$respuesta = false;
                    }
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
		$arregloinscripciones= array();
		$base=new BaseDatos(); 
		$consultainscripciones="Select * from inscripcion ";
		if ($condicion!=""){
			$consultainscripciones.=' where '.$condicion;
		}
		$consultainscripciones.=" order by id_inscripcion ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultainscripciones)){
				while($row2=$base->Registro()){
					$id_inscripcion =   $row2['id_inscripcion'];
					$fechaInscripcion = $row2['fecha_inscripcion'];
                    $costoFinal = $row2['costo_final'];
                    $obj_Ingresante = new Ingresante();
					$obj_Ingresante->buscar($row2['id_ingresante']);
                    if ($obj_Ingresante){    
                        $unaInscripcion = new Inscripcion();
                        $unaInscripcion->cargar($id_inscripcion, $fechaInscripcion, $costoFinal, $obj_Ingresante);//Aqui se setea el objeto Ingresante a la inscripcion
                        array_push($arregloinscripciones,$unaInscripcion);
                        $respuesta = $arregloinscripciones; 
                    }else{
                        $respuesta = $obj_Ingresante->getMensajeOperacion(); //Error al encontrar el objeto Ingresante correspondiente
                    }
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
        $respuesta = false;
		$base=new BaseDatos();
        $id_Ingresante = $this->getObj_Ingresante()->getId_ingresante();
		$consultaInsertar="INSERT INTO inscripcion( fecha_inscripcion, costo_final, id_ingresante) 
				VALUES ('".$this->getFechaInscripcion()."' , '".$this->getCostoFinal()."' , '".$id_Ingresante."')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId_inscripcion($id);
				$respuesta = true;
			}else {
				$this->setMensajeOperacion($base->getError());//Error Insercion
			}
		} else {
			$this->setMensajeOperacion($base->getError());//Error Iniciar
		}
        $base->Cerrar();
        return $respuesta;
	}

	public function modificar(){
        $respuesta = false;
		$base=new BaseDatos();
        $id_Ingresante = $this->getObj_Ingresante()->getId_ingresante();// <-----------
		$consultaModifica="UPDATE inscripcion SET fecha_inscripcion='".$this->getFechaInscripcion()."', costo_final='".$this->getCostoFinal()."', id_ingresante='".$id_Ingresante."' WHERE id_inscripcion=". $this->getId_inscripcion();
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
			$consultaBorra="DELETE FROM inscripcion  WHERE id_inscripcion=". $this->getId_inscripcion();
			if($base->Ejecutar($consultaBorra)){
				$respuesta = true;
			}else{
				$this->setMensajeOperacion($base->getError());				
			}
		}else{
			$this->setMensajeOperacion($base->getError());			
		}
        $base->Cerrar();
        return $respuesta;
	}


	public function __toString(){
        $cadena = "Inscripcion:\n".
                "Fecha :".$this->getFechaInscripcion()."\n".
                "Costo Final: ".$this->getCostoFinal()."\n".
                "Ingresante(Legajo): ".$this->getObj_Ingresante()->getLegajo()."\n";// <--------
        return $cadena;
	}
}
?>