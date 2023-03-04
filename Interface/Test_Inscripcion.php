<?php
include_once '../Control/AbmInscripcion.php';

function insertarInscripcion(){
    $obj_Ingresante = AbmInscripcion::$ingresanteLogueado;
    if (is_null($obj_Ingresante)){
        echo er."No estas logueado o no has elegido Ingresante.\nVe al Menu Ingresantes.\n".f;
    }else{
        $abmInscripcion = new AbmInscripcion();
        echo " Ingrese una Fecha-test: ";
        $fechaInscripcion = trim(fgets(STDIN));
        echo " Ingrese Costo-test: ";
        $costoFinal = trim(fgets(STDIN));
        $sePudoInsertar = $abmInscripcion->insertaInscripcion($fechaInscripcion, $costoFinal, $obj_Ingresante);
        if ($sePudoInsertar == "OK"){
            echo ok."La Inscripcion fue ingresada con exito".f."\n";
        }else{
            echo er."Error al insertar: ".$sePudoInsertar.f."\n";
        }
    }
}

function listaInscripciones(){
    $abmInscripcion = new AbmInscripcion();
    $col_Inscripciones = $abmInscripcion->listarActividades();
    if (is_array($col_Inscripciones)){
        $numero = 0;
        foreach($col_Inscripciones as $unaInscripcion){
            $numero = $numero +1;
            echo o.$numero.f." ".$unaInscripcion;// Elegir incripcion por numero
        }
        echo o." Ingrese el numero que corresponde a la incripcion: ".f;
        $op = trim(fgets(STDIN));
        $inscripcionElegida = $col_Inscripciones[$op-1];// Eligo la incripcion en el arreglo por el indice
        return $inscripcionElegida;
    }else{
        echo er."Error al listar Inscripciones en AbmInscripcion: ".$col_Inscripciones.f."\n";
    }
}

function modificarInscripcion(){
	$abmInscripcion = new AbmInscripcion();
    $inscripcionElegida = listaInscripciones();
    echo "Ha elegido ". $inscripcionElegida;// Muestro la inscripcion elegida para orientacion del usuario
    echo o." Ingrese una nueva descripcion corta: ".f;
    $descripcion_corta = trim(fgets(STDIN));
    echo o." Ingrese una nueva descripcion mas detallada: ".f;
    $descripcion_larga = trim(fgets(STDIN));
    $sePudoModificar = $abmInscripcion->modificarInscripcion($inscripcionElegida, $descripcion_corta, $descripcion_larga);
    if ($sePudoModificar == "OK"){
        echo ok." La inscripcion fue modificada con exito".f."\n";
        echo $inscripcionElegida;
    }else{
        echo er."Error al modificar inscripcion: ".$sePudoModificar.f."\n";// Es un error
    }
}

function eliminarInscripcion(){
	$abmInscripcion = new AbmInscripcion();
    $inscripcionElegida = listaInscripciones();
    echo "Ha elegido ". $inscripcionElegida;// Muestro la inscripcion elegida para orientacion del usuario
    $sePudoEliminar = $abmInscripcion->eliminarInscripcion($inscripcionElegida);
    if ($sePudoEliminar == "OK"){
        echo ok." La inscripcion fue eliminada con exito".f."\n";
    }else{
        echo er."Error al eliminar inscripcion: ".$sePudoEliminar.f."\n";
    }
}

function mostrarAbmInscripcion(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------- ABM Inscripcion -------- ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - Ingresar nueva Inscripcion \n";
		echo " 2 - Modificar una Inscripcion \n";
        echo " 3 - Eliminar una Inscripcion \n";
		echo " 5 - Volver al menu principal \n";
		echo " 7 - Salir \n";
		$op = trim(fgets(STDIN));	
		if ($op==1){
			insertarInscripcion();	
		}		
		if ($op==2){
			modificarInscripcion();
        }
        if ($op==3){
			eliminarInscripcion();
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