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

	public function verActividades($ingresanteElegido){
		$colModulos = array();
		$abmInscripcion = new AbmInscripcion();
		$condicionListarConID = " WHERE inscripcion.id_ingresante = ".$ingresanteElegido->getId_ingresante();
		$inscripcionesDelIngresante = $abmInscripcion->listarInscripciones($condicionListarConID);
		If (is_array($inscripcionesDelIngresante)){
			foreach($inscripcionesDelIngresante as $unaInscripcion){
				$colModulosDeInscripcion = $unaInscripcion->getCol_Modulos();
				if (is_array($colModulosDeInscripcion)){
					$colModulos = array_merge($colModulos, $colModulosDeInscripcion);
				}else{
					return $colModulosDeInscripcion;//Retorna un error
				}
			}
			$colActividades = array();
			foreach($colModulos as $unModulo){
				$actividadDelModulo = $unModulo->getObj_Actividad();
				array_push($colActividades, $unModulo->getObj_Actividad());
			}
			$colActividadesUnicas = array_unique($colActividades);
			//-------------------------
			return $colActividadesUnicas;//--
			//-------------------------
		}elseif(empty($inscripcionesDelIngresante)){//Si es un arreglo, pero esta vacio
			$respuesta = "NO_I";					//No tiene inscriipciones el ingresante
			return $respuesta;
		}else{
			return $inscripcionesDelIngresante;//Retorna un error
		}
	}
}
?>