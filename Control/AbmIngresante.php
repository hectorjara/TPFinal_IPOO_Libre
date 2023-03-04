<?php
include_once '../Modelo/Ingresante.php';

class AbmIngresante{

	public function insertaIngresante($mail, $legajo, $dni, $nombre, $apellido){
        $respuesta = null;
		$unIngresante = new Ingresante();
        $unIngresante->cargar(null, $mail, $legajo, $dni, $nombre, $apellido);// null va a cambiar por el $id que devuelva la insercion
		$sePudoInsertar = $unIngresante->insertar();
		if ($sePudoInsertar){
			$respuesta = "OK";	
		}else{
            $respuesta = $unIngresante->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function modificarIngresante($obj_Ingresante, $mail, $legajo, $dni, $nombre, $apellido){
        $respuesta = null;
		$obj_Ingresante->setmail($mail);
        $obj_Ingresante->setlegajo($legajo);
        $obj_Ingresante->setDni($dni);
        $obj_Ingresante->setNombre($nombre);
        $obj_Ingresante->setApellido($apellido);
		$sePudoModificar = $obj_Ingresante->modificar();
		if ($sePudoModificar) {
			$respuesta = "OK";
		}else{
			$respuesta = $obj_Ingresante->getMensajeOperacion();
		}
        return $respuesta;
	}

	public function eliminarIngresante($obj_Ingresante){
        $respuesta = null;
		$sePudoEliminar = $obj_Ingresante->eliminar();
		if ($sePudoEliminar){
			$respuesta = "OK";
		}else{
            $respuesta = $obj_Ingresante->getmensajeoperacion();
		}
        return $respuesta;
	}

    public function listarIngresantes($condicion=""){
		$col_Ingresantes = Ingresante::listar($condicion);
		return $col_Ingresantes;
    }
}
?>