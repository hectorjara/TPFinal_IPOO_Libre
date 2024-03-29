<?php
include_once '../Modelo/Modulo.php';
include_once '../Modelo/ModuloEnLinea.php';

class AbmModulo{

	public function insertaModulo($descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $enLinea, $link, $bonificacion){
		if ($enLinea){
			$unModulo = new ModuloEnLinea();
			$unModulo->cargarEnLinea(null, $descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $link, $bonificacion);// null va a cambiar por el $id que devuelva la insercion
		}else{
			$unModulo = new Modulo();
			$unModulo->cargar(null, $descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad);// null va a cambiar por el $id que devuelva la insercion
		}
		if ($unModulo->insertar()){
			return $unModulo;
		}else{
            return $unModulo->getMensajeOperacion();
		}
	}

	public function modificarModulo($obj_Modulo, $descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $enLinea, $link, $bonificacion){
        $respuesta = null;
		$obj_Modulo->setDescripcion($descripcion);
        $obj_Modulo->setTope_Inscripcion($tope_inscripcion);
        $obj_Modulo->setCosto($costo);
		$obj_Modulo->setFechaInicio($fechaInicio);
		$obj_Modulo->setFechaFin($fechaFin);
		$obj_Modulo->setHoraInicio($horaInicio);
		$obj_Modulo->setHoraCierre($horaCierre);
        $obj_Modulo->setObj_Actividad($obj_Actividad);
		if ($enLinea){
			$obj_Modulo->setLink($link);
			$obj_Modulo->setBonificacion($bonificacion);
		}
		$sePudoModificar = $obj_Modulo->modificar();
		if ($sePudoModificar) {
			$respuesta = "OK";
		}else{
			$respuesta = $obj_Modulo->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function eliminarModulo($obj_Modulo){
		$borradaInscripcion = false;
		$respuesta = null;
		$inscripcionesDelModulo = $this->getInscripciones($obj_Modulo);
		if (empty($inscripcionesDelModulo)){ //Si no hay inscripciones, procedo a borrar el modulo
			$sePudoEliminar = $obj_Modulo->eliminar();
			if ($sePudoEliminar){
				$respuesta = "OK";
			}else{
				$respuesta = $obj_Modulo->getmensajeoperacion();
			}
		}else{
			$respuesta = "HAY_INS"; //Si hay inscripciones, devuelvo esta respuesta
		}
        return $respuesta;
	}

	public function getInscripciones($moduloElegido){
		$colInscripciones = $moduloElegido->getCol_Inscripciones();
		return $colInscripciones;
	}

	public function getInscripcionesDNI($moduloElegido, $ingresanteElegido){
		$colInscripcionesDNI = array();
		$colInscripciones = $moduloElegido->getCol_Inscripciones();
		if (is_array($colInscripciones)){
			$cant = 0;
			foreach($colInscripciones as $unaInscripcion){
				if ($unaInscripcion->getObj_Ingresante() == $ingresanteElegido){
					array_push($colInscripcionesDNI, $unaInscripcion);
					$cant = $cant +1;
				}
			}
			if ($cant >= 2){
			//------------------------------
			return $colInscripcionesDNI;//---
			//------------------------------
			}else{
				$respuesta = "NO";//Encontro solo 1 o nada
				return $respuesta;
			}
		}else{
			return $colInscripciones;//Retorna un error
		}
	}

    public function listarModulos($condicion=" WHERE id_modulo NOT IN (SELECT id_modulo FROM modulo_en_linea) "){
		$col_Modulos = Modulo::listar($condicion);
		return $col_Modulos;
    }
	public function listarModulosEnLinea($condicion=""){
		$col_ModulosEnLinea = ModuloEnLinea::listar($condicion);
		return $col_ModulosEnLinea;
    }

	public function superaTopeInscripcion($moduloElegido){
		$seAlcanzoElTope = false;
		$cantInscripcionesAlModulo = count($this->getInscripciones($moduloElegido));
		$topeInscripcionesAlModulo = $moduloElegido->getTope_Inscripcion();
		if($cantInscripcionesAlModulo == $topeInscripcionesAlModulo){
			$seAlcanzoElTope = true;
		}else{
			$seAlcanzoElTope = false;
		}
		return $seAlcanzoElTope;
	}
}
?>