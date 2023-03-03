<?php
include_once '../Control/AbmModulo.php';

function insertarModulo(){
	$abmModulo = new AbmModulo();//descripcion,$tope_inscripcion, $costo, $obj_Actividad
	echo o." Ingrese una descripcion: ".f;
	$descripcion = trim(fgets(STDIN));
	echo o." Ingrese el tope de inscripciones al modulo: ".f;
	$tope_inscripcion = trim(fgets(STDIN));
    echo o." Ingrese el costo: ".f;
	$costo = trim(fgets(STDIN));
	echo o." Ingrese la Actividad del Modulo de la siguiente lista: \n".f;
    $actividadElegida = listaActividades();
	$sePudoInsertar = $abmModulo->insertaModulo($descripcion, $tope_inscripcion, $costo, $actividadElegida);
	if ($sePudoInsertar == "OK"){
        echo ok."El Modulo fue ingresada con exito".f."\n";
    }else{
        echo er."Error al insertar modulo: ".$sePudoInsertar.f."\n";
    }
}

function listaModulos(){
    $abmModulo = new AbmModulo();
    $col_Modulos = $abmModulo->listarModulos();
    if (is_array($col_Modulos)){
        $numero = 0;
        foreach($col_Modulos as $unModulo){
            $numero = $numero +1;
            echo o.$numero.f." ".$unModulo;// Elegir Actividad por numero
        }
        echo o." Ingrese el numero que corresponde al Modulo: ".f;
        $op = trim(fgets(STDIN));
        $moduloElegido = $col_Modulos[$op-1];// Eligo el Modulo en el arreglo por el indice
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
    echo o." Ingrese la Actividad del Modulo de la siguiente lista: \n".f;
    $actividadElegida = listaActividades();
    $sePudoModificar = $abmModulo->modificarModulo($moduloElegido, $descripcion, $tope_inscripcion, $costo, $actividadElegida);
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
        echo "Ha elegido ". $moduloElegido;// Muestro la actividad elegida para orientacion del usuario
        $sePudoEliminar = $abmModulo->eliminarModulo($moduloElegido);
        if ($sePudoEliminar == "OK"){
            echo ok." El modulo fue eliminado con exito".f."\n";
        }else{
            echo er."Error al eliminar: ".$sePudoEliminar.f."\n";
        }
}

function mostrarAbmModulo(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------- ABM Modulo -------- ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - Ingresar nuevo Modulo \n";
		echo " 2 - Modificar una Modulo \n";
        echo " 3 - Eliminar una Modulo \n";
		echo " 5 - Volver al menu principal \n";
		echo " 7 - Salir \n";
		$op = trim(fgets(STDIN));	
		if ($op==1){
			insertarModulo();	
		}		
		if ($op==2){
			modificarModulo();
        }
        if ($op==3){
			eliminarModulo();
        }
		if ($op==5){
			mostrarMenu();
		}
		if ($op==7){
			exit;
		}
		echo o." Desea realizar otra operacion? S/s ".f."\n";
		$sigue = trim(fgets(STDIN));				
	}		
}
?>