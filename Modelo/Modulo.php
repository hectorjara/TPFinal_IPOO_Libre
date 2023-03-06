<?php 
include_once "BaseDatos.php"; 
include_once "Actividad.php";

class Modulo{

	//atributos
    private $id_modulo;
	private $descripcion;
	private $tope_inscripcion;
    private $mensajeOperacion;
    private $costo;
    private $obj_Actividad;
	private $col_Inscripciones;

	//metodos
	public function __construct(){
        $this->id_modulo = 0;
		$this->descripcion= "";
		$this->tope_inscripcion= "";
        $this->costo= 0;
        $this->obj_Actividad = null;
		$this->col_Inscripciones = [];
	}

	public function cargar($id_modulo, $descripcion,$tope_inscripcion, $costo, $obj_Actividad){
        $this->setId_Modulo($id_modulo);
		$this->setDescripcion($descripcion);
		$this->setTope_Inscripcion($tope_inscripcion);
        $this->setCosto($costo);
        $this->setObj_Actividad($obj_Actividad);
	}

    public function getId_Modulo(){
		return $this->id_modulo;
	}
	public function setId_Modulo($id_modulo){
		return $this->id_modulo=$id_modulo;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}
	public function setDescripcion($descripcion){
		return $this->descripcion=$descripcion;
	}

	public function getTope_Inscripcion(){
		return $this->tope_inscripcion;
	}
	public function setTope_Inscripcion($tope_inscripcion){
		return $this->tope_inscripcion=$tope_inscripcion;
	}

    public function getCosto(){
		return $this->costo;
	}
	public function setCosto($costo){
		return $this->costo=$costo;
	}

    public function getObj_Actividad(){
		return $this->obj_Actividad;
	}
	public function setObj_Actividad($obj_Actividad){
		return $this->obj_Actividad=$obj_Actividad;
	}

	public function getCol_Inscripciones(){
		$colInscripciones = Inscripcion::listar("JOIN `inscripcion-modulo` im ON inscripcion.id_inscripcion = im.id_inscripcion
						JOIN modulo m ON im.id_modulo = m.id_modulo
						WHERE m.id_modulo = ".$this->getId_Modulo());
		return $colInscripciones;//Retorna o el arreglo o el error.
	}
	public function setCol_Inscripciones($col_Inscripciones){
		return $this->col_Inscripciones=$col_Inscripciones;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}
	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function buscar($id_modulo){
        $respuesta = null;
		$base=new BaseDatos();
		$consultaModulo="Select * from modulo where id_modulo=".$id_modulo;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModulo)){
				if($row2=$base->Registro()){
                    $this->setId_Modulo($id_modulo);
					$this->setDescripcion($row2['descripcion']);
					$this->setTope_Inscripcion($row2['tope_inscripcion']);
                    $this->setCosto($row2['costo']);
                    $obj_Actividad = new Actividad();
					$obj_Actividad->buscar($row2['id_actividad']);
                    if ($obj_Actividad){    
                        $this->setObj_Actividad($obj_Actividad); //Setea el objeto Actividad al objeto Modulo
                        $respuesta = $this; //Devuelve el objeto Modulo
                    }else{
                        $this->setMensajeOperacion($obj_Actividad->getMensajeOperacion()); //Error al encontrar el objeto Actividad correspondiente
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
		$arregloModulos= array();
		$base=new BaseDatos(); 
		$consultaModulos="Select * from modulo ";
		if ($condicion!=""){
			$consultaModulos.= $condicion;
		}
		$consultaModulos.=" order by modulo.id_modulo ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModulos)){
				while($row2=$base->Registro()){
					$id_modulo =   $row2['id_modulo'];
					$descripcion = $row2['descripcion'];
                    $tope_inscripcion = $row2['tope_inscripcion'];
                    $costo = $row2['costo'];
                    $obj_Actividad = new Actividad();
					$obj_Actividad->buscar($row2['id_actividad']);
                    if ($obj_Actividad){    
                        $unModulo = new Modulo();
                        $unModulo->cargar($id_modulo, $descripcion, $tope_inscripcion, $costo, $obj_Actividad);//Aqui se setea el objeto Actividad al Modulo
                        array_push($arregloModulos,$unModulo);
                        $respuesta = $arregloModulos; 
                    }else{
                        $respuesta = $obj_Actividad->getMensajeOperacion(); //Error al encontrar el objeto Actividad correspondiente
                    }
				}
		 	}else{
                $respuesta = $base->getError();//Error Ejecutar	
			}
		}else {
            $respuesta = $base->getError();//Error Iniciar
		}
        $base->Cerrar();
		if ($respuesta == null){
			$respuesta = array();//Retorna un arreglo vacio
		}
		return $respuesta;
	}


	public function insertar(){
        $respuesta = false;
		$base=new BaseDatos();
        $id_actividad = $this->getObj_Actividad()->getId_Actividad();
		$consultaInsertar="INSERT INTO modulo( descripcion, tope_inscripcion, costo, id_actividad) 
				VALUES ('".$this->getDescripcion()."' , '".$this->getTope_Inscripcion()."' , '".$this->getCosto()."' , '".$id_actividad."')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId_Modulo($id);
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
        $id_actividad = $this->getObj_Actividad()->getId_Actividad();// <-----------
		$consultaModifica="UPDATE modulo SET descripcion='".$this->getDescripcion()."', tope_inscripcion='".$this->getTope_Inscripcion()."', costo='".$this->getCosto()."', id_actividad='".$id_actividad."' WHERE id_modulo=". $this->getId_Modulo();
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
		//Debo eliminar de la tabla intermedia la relacion y si la inscripcion tenia un solo modulo, proceder a borrar la inscripcion.
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM modulo  WHERE id_modulo=". $this->getId_Modulo();
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

	public function darCostoModulo(){
		return $this->getCosto();
	}


	public function __toString(){
        $cadena = "Modulo:\n".
                "Descripcion:".$this->getDescripcion()."\n".
                "Tope: ".$this->getTope_Inscripcion()."\n".
                "Costo: ".$this->getCosto()."\n".
                "Actividad: ".$this->getObj_Actividad()->getDescripcion_corta()."\n";// <--------
        return $cadena;
	}
}
?>