<?php 
include_once "BaseDatos.php";

class Inscripcion{

	//atributos
    private $id_inscripcion;
	private $fechaInscripcion;
	private $costoFinal;
    private $obj_Ingresante;
	private $col_Modulos;
    private $mensajeOperacion;

	//metodos
	public function __construct(){
        $this->id_inscripcion = 0;
		$this->fechaInscripcion= "";
		$this->costoFinal= 0;
        $this->obj_Ingresante = null;
		$this->col_Modulos = [];
	}

	public function cargar($id_inscripcion, $fechaInscripcion, $obj_Ingresante, $col_Modulos){
        $this->setId_inscripcion($id_inscripcion);
		$this->setFechaInscripcion($fechaInscripcion);
        $this->setObj_Ingresante($obj_Ingresante);
		$this->setCol_Modulos($col_Modulos);
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
		$costoFinal = 0;
		$col_Modulos= $this->getCol_Modulos();
		foreach($col_Modulos as $unModulo){
			$costoFinal = $costoFinal + $unModulo->darCostoModulo();
			echo "-----------".$costoFinal."----------";
		}
		return $costoFinal;
	}
	public function setCostoFinal($costoFinal){//No se usa
		return $this->costoFinal=$costoFinal;
	}

    public function getObj_Ingresante(){
		return $this->obj_Ingresante;
	}
	public function setObj_Ingresante($obj_Ingresante){
		return $this->obj_Ingresante=$obj_Ingresante;
	}

	public function getCol_Modulos(){
		return $this->col_Modulos;
	}
	public function setCol_Modulos($col_Modulos){
		return $this->col_Modulos=$col_Modulos;
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
					//------------------------------------------------Busqueda de Ingresante perteneciente a la inscripcion
                    $obj_Ingresante = new Ingresante();
					$obj_Ingresante->buscar($row2['id_ingresante']);
					//------------------------------------------------
                    if ($obj_Ingresante){    
                        $this->setObj_Ingresante($obj_Ingresante); //Setea el objeto Ingresante al objeto inscripcion
						//--------------------------------------------------------------------------------------------
						$col_Modulos = Modulo::listar("JOIN inscripcion-modulo im ON modulo.id_modulo = im.id_modulo
														JOIN inscripcion i ON im.id_inscripcion = i.id_inscripcion
														WHERE i.id_inscripcion = ".$id_inscripcion);
						if (is_array($col_Modulos)){
							$this->setCol_Modulos($col_Modulos);//Setea la coleccion de modulos al objeto inscripcion
						}else{
							echo er."Error al listar modulos pertenecientes a una inscripcion al buscar una: ".$col_Modulos.f;
						}
						//---------------------------------------------------
                        $respuesta = $this; //Devuelve el objeto inscripcion-
						//---------------------------------------------------
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
					//------------------------------------------------- Busqueda de Ingresante perteneciente a la inscripcion
                    $obj_Ingresante = new Ingresante();
					$obj_Ingresante->buscar($row2['id_ingresante']);
					//-------------------------------------------------
                    if ($obj_Ingresante){//                                                                     --- Busqueda de la coleccion de Modulos
						$col_Modulos = Modulo::listar("JOIN `inscripcion-modulo` im ON modulo.id_modulo = im.id_modulo
						JOIN inscripcion i ON im.id_inscripcion = i.id_inscripcion
						WHERE i.id_inscripcion = ".$id_inscripcion);
						if (is_array($col_Modulos)){
							$unaInscripcion = new Inscripcion();
							$unaInscripcion->cargar($id_inscripcion, $fechaInscripcion, $obj_Ingresante, $col_Modulos);//Aqui se setea el objeto Ingresante a la inscripcion
							array_push($arregloinscripciones,$unaInscripcion);
							//-------------------------------------------------------------------------
							$respuesta = $arregloinscripciones;// Devuelve el arreglo de Inscripciones-
							//-------------------------------------------------------------------------
						}else{
							echo er."Error al listar modulos pertenecientes a una inscripcion a listar inscripciones: ".$col_Modulos.f;
						}
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
		$consultaInsertar="INSERT INTO inscripcion( fecha_inscripcion, id_ingresante) 
				VALUES ('".$this->getFechaInscripcion()."' , '".$id_Ingresante."')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId_inscripcion($id);
				$consultaInsertarModulos = "INSERT INTO `inscripcion-modulo` (`id_modulo`, `id_inscripcion`) VALUES ";
				$col_Modulos = $this->getCol_Modulos();//Para este examen, nos aseguramos por interface que haya una coleccion de modulos antes de insertar la inscripcion.
				foreach ($col_Modulos as $unModulo){
					$consultaInsertarModulos.= "('".$unModulo->getId_Modulo()."', '".$this->getId_inscripcion()."'),";
				}
				$consultaInsertarModulos = substr($consultaInsertarModulos, 0, -1);//Quito la ultima coma
				if($base->Ejecutar($consultaInsertarModulos)){
					//--------------------
					$respuesta = true;//--
					//--------------------
				}else{
					$this->setMensajeOperacion("Error al insertar Modulos en Inscripcion: ".$base->getError());//Error insercion de modulos
					//Si obtengo un error en esta ultima insercion. Se insertaran datos en la tabla inscripcion que estaran sin modulos deseados en la tabla inscripcion-modulo.
					//En un proyecto profesional se debe tener en cuenta para revertir esta insercion
				}
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
		$consultaModifica="UPDATE inscripcion SET fecha_inscripcion='".$this->getFechaInscripcion()."', id_ingresante='".$id_Ingresante."' WHERE id_inscripcion=". $this->getId_inscripcion();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
				$consultaBorrarModulos = "DELETE FROM `inscripcion-modulo` WHERE `id_inscripcion` = ".$this->getId_inscripcion().";";
				$consultaModificarModulos = "INSERT INTO `inscripcion-modulo` (`id_modulo`, `id_inscripcion`) VALUES ";
				$col_Modulos = $this->getCol_Modulos();//Para este examen, nos aseguramos por interface que haya una coleccion de modulos antes de insertar la inscripcion.
				foreach ($col_Modulos as $unModulo){
					$consultaModificarModulos.= "('".$unModulo->getId_Modulo()."', '".$this->getId_inscripcion()."'),";
				}
				$consultaModificarModulos = substr($consultaModificarModulos, 0, -1);//Quito la ultima coma
				if($base->Ejecutar($consultaBorrarModulos)){
					if($base->Ejecutar($consultaModificarModulos)){
						//--------------------
						$respuesta = true;//--
						//--------------------
					}else{
						$this->setMensajeOperacion("Error al insertar nuevos Modulos en Modificar Inscripcion: ".$base->getError());//Error insercion de modulos
					}
				}else{
					echo "--------------".$consultaModificarModulos."---------------";
					$this->setMensajeOperacion("Error al borrar Modulos en Modificar Inscripcion: ".$base->getError());//Error borrado de modulos
				}


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
			$consultaBorrarModulos = "DELETE FROM `inscripcion-modulo` WHERE `id_inscripcion` = ".$this->getId_inscripcion().";";
			if($base->Ejecutar($consultaBorrarModulos)){
				$consultaBorra="DELETE FROM inscripcion  WHERE id_inscripcion=". $this->getId_inscripcion();
				if($base->Ejecutar($consultaBorra)){
					$respuesta = true;
				}else{
					$this->setMensajeOperacion($base->getError());
				}				
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