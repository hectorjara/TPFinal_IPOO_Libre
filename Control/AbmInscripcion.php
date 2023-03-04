<?php
include_once '../Modelo/Inscripcion.php';

class AbmInscripcion{

    public static $ingresanteLogueado = null;

	public function insertaInscripcion($fechaInscripcion, $costoFinal, $obj_Ingresante){
        $respuesta = null;
		$unaInscripcion = new Inscripcion();
        $unaInscripcion->cargar(null, $fechaInscripcion, $costoFinal, $obj_Ingresante);// null va a cambiar por el $id que devuelva la insercion
		$sePudoInsertar = $unaInscripcion->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unaInscripcion->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function modificarInscripcion($obj_Inscripcion, $fechaInscripcion, $costoFinal, $obj_Ingresante){
        $respuesta = null;
		$obj_Inscripcion->setFechaInscripcion($fechaInscripcion);
        $obj_Inscripcion->setCostoFinal($costoFinal);
        $obj_Inscripcion->setObj_Ingresante($obj_Ingresante);
		$sePudoModificar = $obj_Inscripcion->modificar();
		if ($sePudoModificar) {
			$respuesta = "OK";
		}else{
			$respuesta = $obj_Inscripcion->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function eliminarInscripcion($obj_Inscripcion){
        $respuesta = null;
		$sePudoEliminar = $obj_Inscripcion->eliminar();
		if ($sePudoEliminar){
			$respuesta = "OK";
		}else{
            $respuesta = $obj_Inscripcion->getmensajeoperacion();
		}
        return $respuesta;
	}

    public function listarInscripciones($condicion=""){
		$col_Inscripciones = Inscripcion::listar($condicion);
		return $col_Inscripciones;
    }
}
?>