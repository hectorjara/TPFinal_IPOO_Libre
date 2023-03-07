<?php
include_once '../Modelo/Actividad.php';

class AbmActividad{

	public function insertaActividad($descripcion_corta,$descripcion_larga){
		$unaActividad = new Actividad();
        $unaActividad->cargar(null, $descripcion_corta, $descripcion_larga);// null va a cambiar por el $id que devuelva la insercion
		if ($unaActividad->insertar()){
			return $unaActividad;
		}else{
            return $unaActividad->getMensajeOperacion();
		}

	}

	public function modificarActividad($obj_Actividad, $descripcion_corta, $descripcion_larga){
        $respuesta = null;
		$obj_Actividad->setDescripcion_corta($descripcion_corta);
        $obj_Actividad->setdescripcion_larga($descripcion_larga);
		$sePudoModificar = $obj_Actividad->modificar();
		if ($sePudoModificar) {
			$respuesta = "OK";
		}else{
			$respuesta = $obj_Actividad->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function eliminarActividad($obj_Actividad){
		$borradoModuloEInscripcion = false;
		$borradoModulo = false;
		$respuesta = null;
		$colModulosDeActividad = $obj_Actividad->getColModulosBaseDatos();
		if(!empty($colModulosDeActividad)){
			$abmModulo = new AbmModulo();
			foreach($colModulosDeActividad as $moduloABorrar){
				$borradoOk = $abmModulo->eliminarModulo($moduloABorrar);
				if($borradoOk == "OK"){
					$borradoModulo = true;
				}elseif($borradoOk == "OK_I"){
					$borradoModuloEInscripcion = true;
				}
			}
		}
		$sePudoEliminar = $obj_Actividad->eliminar();
		if ($sePudoEliminar){
			if($borradoModuloEInscripcion){
				$respuesta = "OK_I";
			}elseif($borradoModulo){
				$respuesta = "OK_M";
			}else{
				$respuesta = "OK";
			}			
		}else{
            $respuesta = $obj_Actividad->getmensajeoperacion();
		}
        return $respuesta;
	}

    public function listarActividades($condicion=""){
		$col_Actividades = Actividad::listar($condicion);
		return $col_Actividades;
    }

	public function getInscripciones($actividadElegida){
		$colInscripciones = array();
		$col_Ins_UnModulo =  array();
		$abmModulo = new AbmModulo();
		$modulosP = $abmModulo->listarModulos();
		$modulosEL = $abmModulo->listarModulosEnLinea();
		$colModulos = array_merge($modulosP, $modulosEL);
		if (is_array($colModulos)){		
			foreach($colModulos as $unModulo){
				if ($unModulo->getObj_Actividad() == $actividadElegida){
					$col_Ins_UnModulo = $abmModulo->getInscripciones($unModulo);
					$colInscripciones = array_merge($colInscripciones, $col_Ins_UnModulo);
				}
			}
			//---------------------------
			return $colInscripciones;//--
			//---------------------------
		}else{
			return $colModulos;//Retorna el error y no un array.
		} 
		
	}
}
?>