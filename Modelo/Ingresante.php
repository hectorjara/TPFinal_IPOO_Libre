<?php 
include_once "BaseDatos.php"; 

class Ingresante{

	//atributos
    private $id_ingresante;
	private $mail;
	private $legajo;
    private $dni;
	private $nombre;
	private $apellido;
    private $mensajeOperacion;

	//metodos
	public function __construct(){
        $this->id_ingresante = 0;
		$this->mail= "";
		$this->legajo= "";
        $this->dni= 0;
        $this->nombre= "";
        $this->apellido= "";
	}

	public function cargar($id_ingresante, $mail, $legajo, $dni, $nombre, $apellido){
        $this->setId_ingresante($id_ingresante);
		$this->setmail($mail);
		$this->setlegajo($legajo);
        $this->setDni($dni);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
	}

    public function getId_ingresante(){
		return $this->id_ingresante;
	}
	public function setId_ingresante($id_ingresante){
		return $this->id_ingresante=$id_ingresante;
	}

	public function getMail(){
		return $this->mail;
	}
	public function setMail($mail){
		return $this->mail=$mail;
	}

	public function getLegajo(){
		return $this->legajo;
	}
	public function setLegajo($legajo){
		return $this->legajo=$legajo;
	}

    public function getDni(){
		return $this->dni;
	}
	public function setDni($dni){
		return $this->dni=$dni;
	}

    public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		return $this->nombre=$nombre;
	}

    public function getApellido(){
		return $this->apellido;
	}
	public function setApellido($apellido){
		return $this->apellido=$apellido;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}
	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function buscar($id_ingresante){
        $respuesta = null;
		$base=new BaseDatos();
		$consultaingresante="Select * from ingresante where id_ingresante=".$id_ingresante;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaingresante)){
				if($row2=$base->Registro()){
                    $this->setId_ingresante($id_ingresante);
					$this->setmail($row2['mail']);
					$this->setlegajo($row2['legajo']);
                    $this->setDni($row2['dni']);
                    $this->setNombre($row2['nombre']);
                    $this->setApellido($row2['apellido']);
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
		$arregloingresantes= array();
		$base=new BaseDatos(); 
		$consultaingresantes="Select * from ingresante ";
		if ($condicion!=""){
			$consultaingresantes.=' where '.$condicion;
		}
		$consultaingresantes.=" order by id_ingresante ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaingresantes)){				
				$arregloIngresantes= array();
				while($row2=$base->Registro()){
					$id_ingresante = $row2['id_ingresante'];
					$mail = $row2['mail'];
                    $legajo = $row2['legajo'];
                    $dni = $row2['dni'];
                    $nombre = $row2['nombre'];
                    $apellido = $row2['apellido'];
					$unIngresante = new Ingresante();
					$unIngresante->cargar($id_ingresante, $mail, $legajo, $dni, $nombre, $apellido);
					array_push($arregloIngresantes,$unIngresante);
                    $respuesta = $arregloIngresantes;
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
		$consultaInsertar="INSERT INTO ingresante( mail, legajo, dni, nombre, apellido) 
				VALUES ('".$this->getmail()."' , '".$this->getLegajo()."' , '".$this->getDni()."' , '".$this->getNombre()."' , '".$this->getApellido()."')";
		if($base->Iniciar()){	
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
				$base->Cerrar();
                $this->setId_ingresante($id);
				return $this;
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
		$consultaModifica="UPDATE ingresante SET mail='".$this->getmail()."', legajo='".$this->getmail()."', dni='".$this->getDni()."', nombre='".$this->getNombre()."', apellido='".$this->getApellido()."' WHERE id_ingresante=". $this->getId_ingresante();
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
			$consultaBorra="DELETE FROM ingresante  WHERE id_ingresante=". $this->getId_ingresante();
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


	public function __toString(){
        $cadena = "__________\ningresante:\n".
                "Mail:".$this->getmail()."\n".
                "Legajo:".$this->getLegajo()."\n".
                "Dni:".$this->getDni()."\n".
                "Nombre:".$this->getNombre()."\n".
                "Apellido: ".$this->getApellido()."\n";
        return $cadena;
	}
}
?>