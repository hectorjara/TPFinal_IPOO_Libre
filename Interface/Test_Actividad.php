<?php
include_once '../Control/AbmActividad.php';

function insertarActividad(){
	$abmActividad = new AbmActividad();
	echo " Ingrese una descripcion corta: ";
	$descripcion_corta = trim(fgets(STDIN));
	echo " Ingrese una descripcion mas detallada: ";
	$descripcion_larga = trim(fgets(STDIN));
	$sePudoInsertar = $abmActividad->insertaActividad($descripcion_corta, $descripcion_larga);
	if ($sePudoInsertar == "OK"){
        echo ok."La actividad fue ingresada con exito".f."\n";
    }else{
        echo er."Error al insertar: ".$sePudoInsertar.f."\n";
    }
}

function listaActividades(){
    $abmActividad = new AbmActividad();
    $col_Actividades = $abmActividad->listarActividades();
    if (is_array($col_Actividades)){
        $numero = 0;
        foreach($col_Actividades as $unaActividad){
            $numero = $numero +1;
            echo o.$numero.f." ".$unaActividad;// Elegir Actividad por numero
        }
        echo o." Ingrese el numero que corresponde a la actividad: ".f;
        $op = trim(fgets(STDIN));
        $actividadElegida = $col_Actividades[$op-1];// Eligo la actividad en el arreglo por el indice
        return $actividadElegida;
    }else{
        echo er."Error al listar Actividades en AbmActividad: ".$col_Actividades.f."\n";
    }
}

function modificarActividad(){
	$abmActividad = new AbmActividad();
    $actividadElegida = listaActividades();
    echo "Ha elegido ". $actividadElegida;// Muestro la actividad elegida para orientacion del usuario
    echo o." Ingrese una nueva descripcion corta: ".f;
    $descripcion_corta = trim(fgets(STDIN));
    echo o." Ingrese una nueva descripcion mas detallada: ".f;
    $descripcion_larga = trim(fgets(STDIN));
    $sePudoModificar = $abmActividad->modificarActividad($actividadElegida, $descripcion_corta, $descripcion_larga);
    if ($sePudoModificar == "OK"){
        echo ok." La actividad fue modificada con exito".f."\n";
        echo $actividadElegida;
    }else{
        echo er."Error al modificar Actividad: ".$sePudoModificar.f."\n";// Es un error
    }
}

function eliminarActividad(){
	$abmActividad = new AbmActividad();
    $actividadElegida = listaActividades();
    echo "Ha elegido ". $actividadElegida;// Muestro la actividad elegida para orientacion del usuario
    $sePudoEliminar = $abmActividad->eliminarActividad($actividadElegida);
    if ($sePudoEliminar == "OK"){
        echo ok." La actividad fue eliminada con exito".f."\n";
    }else{
        echo er."Error al eliminar Actividad: ".$sePudoEliminar.f."\n";
    }
}

function mostrarAbmActividad(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------- ABM Actividad -------- ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - Ingresar nueva Actividad \n";
		echo " 2 - Modificar una Actividad \n";
        echo " 3 - Eliminar una Actividad \n";
		echo " 5 - Volver al menu principal \n";
		echo " 7 - Salir \n";
		$op = trim(fgets(STDIN));	
		if ($op==1){
			insertarActividad();	
		}		
		if ($op==2){
			modificarActividad();
        }
        if ($op==3){
			eliminarActividad();
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