<?php
include_once '../Modelo/Modulo.php';
include_once '../Modelo/ModuloEnLinea.php';

class AbmModulo{

	public function insertaModulo($descripcion,$tope_inscripcion, $costo, $obj_Actividad, $enLinea, $link, $bonificacion){
        $respuesta = null;
		if ($enLinea){
			$unModulo = new ModuloEnLinea();
			$unModulo->cargarEnLinea(null, $descripcion,$tope_inscripcion, $costo, $obj_Actividad, $link, $bonificacion);// null va a cambiar por el $id que devuelva la insercion
		}else{
			$unModulo = new Modulo();
			$unModulo->cargar(null, $descripcion,$tope_inscripcion, $costo, $obj_Actividad);// null va a cambiar por el $id que devuelva la insercion
		}
		$sePudoInsertar = $unModulo->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unModulo->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function modificarModulo($obj_Modulo, $descripcion,$tope_inscripcion, $costo, $obj_Actividad, $enLinea, $link, $bonificacion){
        $respuesta = null;
		$obj_Modulo->setDescripcion($descripcion);
        $obj_Modulo->setTope_Inscripcion($tope_inscripcion);
        $obj_Modulo->setCosto($costo);
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
        $respuesta = null;
		$sePudoEliminar = $obj_Modulo->eliminar();
		if ($sePudoEliminar){
			$respuesta = "OK";
		}else{
            $respuesta = $obj_Modulo->getmensajeoperacion();
		}
        return $respuesta;
	}

	public function getInscripciones($moduloElegido){
		$colInscripciones = $moduloElegido->getCol_Inscripciones();
		return $colInscripciones;
	}

    public function listarModulos($condicion=" WHERE id_modulo NOT IN (SELECT id_modulo FROM modulo_en_linea) "){
		$col_Modulos = Modulo::listar($condicion);
		return $col_Modulos;
    }
	public function listarModulosEnLinea($condicion=""){
		$col_ModulosEnLinea = ModuloEnLinea::listar($condicion);
		return $col_ModulosEnLinea;
    }
}
?>