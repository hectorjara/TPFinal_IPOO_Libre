<?php
include_once '../Modelo/Actividad.php';

class AbmActividad{

	public function insertaActividad($descripcion_corta,$descripcion_larga){
        $respuesta = null;
		$unaActividad = new Actividad();
        $unaActividad->cargar(null, $descripcion_corta, $descripcion_larga);// null va a cambiar por el $id que devuelva la insercion
		$sePudoInsertar = $unaActividad->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unaActividad->getMensajeOperacion();
		}
        return $respuesta;
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
        $respuesta = null;
		$sePudoEliminar = $obj_Actividad->eliminar();
		if ($sePudoEliminar){
			$respuesta = "OK";
		}else{
            $respuesta = $obj_Actividad->getmensajeoperacion();
		}
        return $respuesta;
	}

    public function listarActividades($condicion=""){
		$col_Actividades = Actividad::listar($condicion);
		return $col_Actividades;
    }
}
?>