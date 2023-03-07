<?php 
include_once '../Modelo/BaseDatos.php';

class Borrar{	

	public function eliminarInscripcionModulo(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from `inscripcion-modulo` ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{				
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}

		public function eliminarInscripcion(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from inscripcion ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{				
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}

		public function eliminarIngresante(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from ingresante ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{				
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}

	public function eliminarModuloEnLinea(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from modulo_en_linea ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{				
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}

	public function EliminarModulo(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from modulo ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{				
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}

	public function eliminarActividad(){
		$base=new BaseDatos();
		if($base->Iniciar()){
			$consultaBorra=" delete from actividad ";
			if($base->Ejecutar($consultaBorra)){
				return true;
			}else{
				echo $base->getError();					
			}
		}else{
			echo $base->getError();				
		}
	}
}
/*
$borra = new Borrar();
	$borra->eliminarInscripcionModulo();
	$borra->eliminarInscripcion();
	$borra->eliminarIngresante();
	$borra->eliminarModuloEnLinea();
	$borra->EliminarModulo();
	$borra->eliminaractividad();
*/
?>