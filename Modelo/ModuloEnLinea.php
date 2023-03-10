<?php 
include_once "BaseDatos.php";
include_once "Modulo.php";

class ModuloEnLinea extends Modulo{

	//atributos
    private $link;
	private $bonificacion;

	//metodos
	public function __construct(){
        parent::__construct();
        $this->link = "";
		$this->bonificacion= 20;
	}

	public function cargarEnLinea($id_modulo, $descripcion,$tope_inscripcion, $costo , $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $link, $bonificacion){// O tambien $bonificacion = 20, Pero ya esta por defecto en el constructor.
        parent::cargar($id_modulo, $descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad);
        $this->setLink($link);
		$this->setBonificacion($bonificacion);
	}

    public function getLink(){
		return $this->link;
	}
	public function setLink($link){
		return $this->link=$link;
	}

	public function getBonificacion(){
		return $this->bonificacion;
	}
	public function setBonificacion($bonificacion){
		return $this->bonificacion=$bonificacion;
	}
    
    public function buscar($id_modulo){
        $respuesta = null;
		$base=new BaseDatos();
		$consultaModuloOL="Select * from modulo_en_linea where id_modulo=".$id_modulo;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModuloOL)){
				if($row2=$base->Registro()){
                    parent::buscar($id_modulo);
					$this->setLink($row2['link']);
					$this->setBonificacion($row2['bonificacion']);
                    $respuesta = $this;
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
		$arregloModulosOL= array();
		$base=new BaseDatos(); 
		$consultaModulosOL="Select * from modulo_en_linea ";
		if ($condicion!=""){
			$consultaModulosOL.=$condicion;
		}
		$consultaModulosOL.=" order by modulo_en_linea.id_modulo ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModulosOL)){
				while($row2=$base->Registro()){
					$id_modulo =   $row2['id_modulo'];
					$link = $row2['link'];
                    $bonificacion = $row2['bonificacion'];
                    $obj_Modulo = new Modulo();
					$obj_Modulo->buscar($id_modulo); //Devuelve el objeto o false
                    if ($obj_Modulo){
                        $descripcion = $obj_Modulo->getDescripcion();
                        $tope_inscripcion = $obj_Modulo->getTope_Inscripcion();
                        $costo = $obj_Modulo->getCosto();
                        $fechaInicio = $obj_Modulo->getFechaInicio();
                        $fechaFin = $obj_Modulo->getFechaFin();
                        $horaInicio = $obj_Modulo->getHoraInicio();
                        $horaCierre = $obj_Modulo->getHoraCierre();
                        $obj_Actividad = $obj_Modulo->getObj_Actividad();
                        $unModuloEnLinea = new ModuloEnLinea();
                        $unModuloEnLinea->cargarEnLinea($id_modulo, $descripcion, $tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $link, $bonificacion);
                        array_push($arregloModulosOL,$unModuloEnLinea);
                        $respuesta = $arregloModulosOL; 
                    }else{
                        $respuesta = $obj_Modulo->getMensajeOperacion(); //Error al encontrar el objeto Modulo correspondiente
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
			$respuesta = array();//Retorna el arreglo vacio
		}
		return $respuesta;
	}

	public function insertar(){
        $respuesta = false;
		$base=new BaseDatos();
        if (parent::insertar()){
            $consultaInsertar="INSERT INTO modulo_en_linea( id_modulo, link, bonificacion) 
				VALUES ('".parent::getId_Modulo()."' , '".$this->getLink()."' , '".$this->getBonificacion()."')";
            if($base->Iniciar()){
                if($base->Ejecutar($consultaInsertar)){
                    $respuesta = true;
                }else {
                    $this->setMensajeOperacion($base->getError());//Error Insercion
                }
            }else {
                $this->setMensajeOperacion($base->getError());//Error Iniciar
            }
        }else{
            //Respuesta ya es false y mensajeOperacion ya tiene el error. Se puede obtener con getMensajeOperacion()
        }
        $base->Cerrar();
        return $respuesta;
	}

	public function modificar(){
        $respuesta = false;
		$base=new BaseDatos();
        if(parent::modificar()){
            $consultaModifica="UPDATE modulo_en_linea SET link='".$this->getLink()."', bonificacion='".$this->getBonificacion()."' WHERE id_modulo=". parent::getId_Modulo();
            if($base->Iniciar()){
                if($base->Ejecutar($consultaModifica)){
                    $respuesta = true;				
                }else{
                    $this->setMensajeOperacion($base->getError());//Error Ejecutar
                }
            }else{
                $this->setMensajeOperacion($base->getError());//Error Iniciar
            }
        }else{
            //Respuesta ya es false y mensajeOperacion ya tiene el error. Se puede obtener con getMensajeOperacion()
        }
		$base->Cerrar();
        return $respuesta;
	}
	
	public function eliminar(){	
        $respuesta = false;
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM modulo_en_linea  WHERE id_modulo=". parent::getId_Modulo();
			if($base->Ejecutar($consultaBorra)){
                if(parent::eliminar()){
                    $respuesta = true;
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

    public function darCostoModulo(){
		$costoModulo = $this->getCosto();
        $costoModulo = $costoModulo - $costoModulo * $this->getBonificacion()/100;
        return $costoModulo;
	}

	public function __toString(){
        $cadena = "Modulo en linea:\n".
                parent::__toString().
                "Link:".$this->getLink()."\n".
                "Bonificacion: ".$this->getBonificacion()."\n";
        return $cadena;
	}
}
?>