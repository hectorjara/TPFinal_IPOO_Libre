<?php
include_once '../Modelo/Inscripcion.php';

class AbmInscripcion{

    public static $ingresanteLogueado = null;

	public function insertaInscripcion($fechaInscripcion, $obj_Ingresante, $col_Modulos){
        $respuesta = null;
		$unaInscripcion = new Inscripcion();
        $unaInscripcion->cargar(null, $fechaInscripcion, $obj_Ingresante, $col_Modulos);// null va a cambiar por el $id que devuelva la insercion
		$sePudoInsertar = $unaInscripcion->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unaInscripcion->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function modificarInscripcion($obj_Inscripcion, $fechaInscripcion, $obj_Ingresante, $col_Modulos){
        $respuesta = null;
		$obj_Inscripcion->setFechaInscripcion($fechaInscripcion);
        $obj_Inscripcion->setObj_Ingresante($obj_Ingresante);
		$obj_Inscripcion->setCol_Modulos($col_Modulos);
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