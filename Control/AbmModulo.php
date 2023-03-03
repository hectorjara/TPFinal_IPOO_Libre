<?php
include_once '../Modelo/Modulo.php';

class AbmModulo{

	public function insertaModulo($descripcion,$tope_inscripcion, $costo, $obj_Actividad){
        $respuesta = null;
		$unModulo = new Modulo();
        $unModulo->cargar(null, $descripcion,$tope_inscripcion, $costo, $obj_Actividad);// null va a cambiar por el $id que devuelva la insercion
		$sePudoInsertar = $unModulo->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unModulo->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function modificarModulo($obj_Modulo, $descripcion,$tope_inscripcion, $costo, $obj_Actividad){
        $respuesta = null;
		$obj_Modulo->setDescripcion($descripcion);
        $obj_Modulo->setTope_Inscripcion($tope_inscripcion);
        $obj_Modulo->setCosto($costo);
        $obj_Modulo->setObj_Actividad($obj_Actividad);
		$sePudoModificar = $obj_Modulo->modificar();
		if ($sePudoModificar) {
			$respuesta = "OK";
		}else{
			$respuesta = $obj_Modulo->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function eliminarModulo($obj_Modulo){
        $respuesta = null;
		$sePudoEliminar = $obj_Modulo->eliminar();
		if ($sePudoEliminar){
			$respuesta = "OK";
		}else{
            $respuesta = $obj_Modulo->getmensajeoperacion();
		}
        return $respuesta;
	}

    public function listarModulos($condicion=""){
		$col_Modulos = Modulo::listar($condicion);
		return $col_Modulos;
    }
}
?>