<?php
include_once '../Control/AbmModulo.php';

function insertarModulo($enLinea){
	$abmModulo = new AbmModulo();//descripcion,$tope_inscripcion, $costo, $obj_Actividad
	echo o." Ingrese una descripcion: ".f;
	$descripcion = trim(fgets(STDIN));
	echo o." Ingrese el tope de inscripciones al modulo: ".f;
	$tope_inscripcion = trim(fgets(STDIN));
    echo o." Ingrese el costo: ".f;
	$costo = trim(fgets(STDIN));
    echo o." Ingrese la Fecha de Inicio (YYYY-MM-DD): ".f;
	$fechaInicio = trim(fgets(STDIN));
    echo o." Ingrese la Fecha de finalizacion (YYYY-MM-DD): ".f;
	$fechaFin = trim(fgets(STDIN));
    echo o." Ingrese el horario de inicio (HH:MM): ".f;
	$horaInicio = trim(fgets(STDIN));
    echo o." Ingrese el horario de cierre (HH:MM): ".f;
	$horaCierre = trim(fgets(STDIN));
	echo o." Ingrese la Actividad del Modulo de la siguiente lista: \n".f;
    $actividadElegida = listaActividades();
    //Consulto si es un Modulo en Linea o no---
    if ($enLinea){
        echo o." Ingrese el link del Modulo: ".f;
        $link = trim(fgets(STDIN));
        echo o." Ingrese la bonificacion que va a otorgar: ".f;
        $bonificacion = trim(fgets(STDIN));
        $moduloInsertado = $abmModulo->insertaModulo($descripcion, $tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $actividadElegida, $enLinea, $link, $bonificacion);
    }else{
        $moduloInsertado = $abmModulo->insertaModulo($descripcion, $tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $actividadElegida, $enLinea, null, null );
    }
    //------------------------------------------
	if ($moduloInsertado instanceof Modulo || $moduloInsertado instanceof ModuloEnLinea){
        echo $moduloInsertado;
        echo ok."El Modulo fue ingresado con exito".f."\n";
    }else{
        echo er."Error al insertar modulo: ".$moduloInsertado.f."\n";
    }
}

function listaModulos(){
    $abmModulo = new AbmModulo();
    $col_Modulos = $abmModulo->listarModulos();
    $col_ModulosEnLinea = $abmModulo->listarModulosEnLinea();
    if (is_array($col_Modulos)){
        $numero = 0;
        $numerosEnLinea = array();//Array de numeros que son de ModulosEnLinea
        foreach($col_Modulos as $unModulo){
            $numero = $numero +1;
            echo o.$numero.f." ".$unModulo;// Elegir Modulo por numero
        }
        if(is_array($col_ModulosEnLinea)){
            foreach($col_ModulosEnLinea as $unModulo){
                $numero = $numero +1;
                array_push($numerosEnLinea, $numero);
            echo o."\n".$numero.f." ".$unModulo;// Elegir Modulo En Linea por numero
            }            
        }else{
            echo er."Error al listar Modulos En Linea: ".$col_ModulosEnLinea.f."\n";
        }
        echo o." Ingrese el numero que corresponde al Modulo: ".f;
        $op = trim(fgets(STDIN));
        if (in_array($op, $numerosEnLinea)) {
            $cantEnPresencial = count($col_Modulos);//Funcionalidad para elegir correctamente el tipo de Modulo al ingresar un numero
            $moduloElegido = $col_ModulosEnLinea[$op-1-$cantEnPresencial];// Eligo el Modulo en el arreglo por el indice
        } else {
            $moduloElegido = $col_Modulos[$op-1];// Eligo el Modulo en el arreglo por el indice
        }        
        return $moduloElegido;
    }else{
        echo er."Error al listar Modulos: ".$col_Modulos.f."\n";
    }
}

function modificarModulo(){
	$abmModulo = new AbmModulo();
    echo o." Ingrese el Modulo a modificar de la siguiente lista: \n".f;
    $moduloElegido = listaModulos();
    echo "Ha elegido ". $moduloElegido;// Muestro el modulo elegido para orientacion del usuario
    echo o." Ingrese una Nueva Descripcion : ".f;
    $descripcion = trim(fgets(STDIN));
    echo o." Ingrese el tope de inscripciones al modulo: ".f;
    $tope_inscripcion = trim(fgets(STDIN));
    echo o." Ingrese el costo : ".f;
    $costo = trim(fgets(STDIN));
    echo o." Ingrese la Fecha de Inicio (YYYY-MM-DD): ".f;
	$fechaInicio = trim(fgets(STDIN));
    echo o." Ingrese la Fecha de finalizacion (YYYY-MM-DD): ".f;
	$fechaFin = trim(fgets(STDIN));
    echo o." Ingrese el horario de inicio (HH:MM): ".f;
	$horaInicio = trim(fgets(STDIN));
    echo o." Ingrese el horario de cierre (HH:MM): ".f;
	$horaCierre = trim(fgets(STDIN));
    echo o." Ingrese la Actividad del Modulo de la siguiente lista: \n".f;
    $actividadElegida = listaActividades();
    if ($moduloElegido instanceof ModuloEnLinea){// Modifico Modulo En Linea
        echo o." Ingrese el link del Modulo: ".f;
        $link = trim(fgets(STDIN));
        echo o." Ingrese la bonificacion que va a otorgar: ".f;
        $bonificacion = trim(fgets(STDIN));
        $sePudoModificar = $abmModulo->modificarModulo($moduloElegido, $descripcion, $tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $actividadElegida, true, $link, $bonificacion);
    }elseif($moduloElegido instanceof Modulo){
        $sePudoModificar = $abmModulo->modificarModulo($moduloElegido, $descripcion, $tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $actividadElegida, false, null, null);
    }
    if ($sePudoModificar == "OK"){
        echo ok." El modulo fue modificado con exito".f."\n";
        echo $moduloElegido;
    }else{
        echo er."Error al modificar: ".$sePudoModificar.f."\n";// Es un error
    }
}

function eliminarModulo(){
	$abmModulo = new AbmModulo();
    $moduloElegido = listaModulos();
    echo "Ha elegido ". $moduloElegido;// Muestro el modulo elegido para orientacion del usuario
    $sePudoEliminar = $abmModulo->eliminarModulo($moduloElegido);
    if ($sePudoEliminar == "OK"){
        echo ok." El modulo fue eliminado con exito".f."\n";
    }elseif($sePudoEliminar == "OK_I"){
        echo ok." Se ha eliminado el modulo y la inscripcion con exito".f."\n";
    } else{
        echo er."Error al eliminar: ".$sePudoEliminar.f."\n";
    }
}

function verInscripcionesAlModulo(){
    $abmModulo = new AbmModulo();
    $moduloElegido = listaModulos();
    $colInscripciones = $abmModulo->getInscripciones($moduloElegido);
    if (is_array($colInscripciones)){
        foreach($colInscripciones as $unaInscripcion){
            echo $unaInscripcion;
        }
        if(empty($colInscripciones)){
            echo d."No existen inscripciones a este Modulo".f."\n";
        }
    }else{
        echo er."Error al obtener la coleccion de inscripciones: ".$colInscripciones.f."\n";
    }
}

function verInscripcionesAlModuloDNI(){
    $abmModulo = new AbmModulo();
    $moduloElegido = listaModulos();
    $ingresanteElegido = listaIngresantes();
    $colInscripcionesDni = $abmModulo->getInscripcionesDNI($moduloElegido, $ingresanteElegido);
    if (is_array($colInscripcionesDni)){
        foreach($colInscripcionesDni as $unaInscripcion){
            echo $unaInscripcion;
        }
    }elseif($colInscripcionesDni == "NO"){
        echo n."No existen inscripciones a este modulo con el ingresante elegido mas de una vez".f."\n";
    }else{
        echo er."Error al obtener la coleccion de inscripciones segun Dni: ".$colInscripcionesDni.f."\n";
    }
}

function mostrarAbmModulo(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------- ABM Modulo -------- ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - Ingresar nuevo Modulo \n";
		echo " 2 - Ingresar nuevo Modulo en Linea \n";
        echo " 3 - Modificar un Modulo \n";
        echo " 4 - Eliminar un Modulo \n";
		echo " 5 - Ver Inscripciones a un Modulo \n";
        echo " 6 - Ver 2 o mas Inscripciones a un Modulo con mismo DNI \n";
        echo " 7 - Volver al menu principal \n";
		echo " 8 - Salir \n";
		$op = trim(fgets(STDIN));	
		if ($op==1){
			insertarModulo(false);//No en linea
		}		
		if ($op==2){
			insertarModulo(true);//En linea
        }
        if ($op==3){
			modificarModulo();
        }
        if ($op==4){
			eliminarModulo();
        }
        if ($op==5){
			verInscripcionesAlModulo();
        }
        if ($op==6){
			verInscripcionesAlModuloDNI();
        }
		if ($op==7){
			mostrarMenu();
		}
		if ($op==8){
			exit;
		}
		echo o." Desea realizar otra operacion? S/s ".f."\n";
		$sigue = trim(fgets(STDIN));				
	}		
}
?>