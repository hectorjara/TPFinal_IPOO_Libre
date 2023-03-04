<?php
include_once '../Control/AbmIngresante.php';

function registroIngresante(){
	$abmIngresante = new AbmIngresante();
	echo o." Ingresa una direccion de Correo Electronico: ".f;
	$mail = trim(fgets(STDIN));
	echo o." Ingresa tu numero de Legajo: ".f;
	$legajo = trim(fgets(STDIN));
    echo o." Ingresa tu numero de DNI: ".f;
	$dni = trim(fgets(STDIN));
    echo o." Ingresa tu Nombre: ".f;
	$nombre = trim(fgets(STDIN));
    echo o." Ingresa tu Apellido: ".f;
	$apellido = trim(fgets(STDIN));
	$sePudoInsertar = $abmIngresante->insertaIngresante($mail, $legajo, $dni, $nombre, $apellido);
	if ($sePudoInsertar == "OK"){
        echo ok."Tu registro fue exitoso".f."\n";
    }else{
        echo er."Error al insertar: ".$sePudoInsertar.f."\n";
    }
}

function listaIngresantes(){
    $abmIngresante = new AbmIngresante();
    $col_Ingresantes = $abmIngresante->listarIngresantes();
    if (is_array($col_Ingresantes)){
        $numero = 0;
        foreach($col_Ingresantes as $unIngresante){
            $numero = $numero +1;
            echo o.$numero.f." ".$unIngresante;// Elegir Ingresante por numero
        }
        echo o." Ingrese el numero que corresponde a tu persona: ".f;
        $op = trim(fgets(STDIN));
        $IngresanteActual = $col_Ingresantes[$op-1];// Eligo Ingresante en el arreglo por el indice
        return $IngresanteActual;
    }else{
        echo er."Error al listar Ingresantes en AbmIngresante: ".$col_Ingresantes.f."\n";
    }
}

function loginIngresante(){
    $IngresanteActual = listaIngresantes();
    AbmInscripcion::$ingresanteLogueado = $IngresanteActual;
    echo ok."Ya te encuentras logueado\n".f;
}

function modificarIngresante(){
	$abmIngresante = new AbmIngresante();
    $IngresanteActual = listaIngresantes();
    echo "Ha elegido ". $IngresanteActual;// Muestro Ingresante para orientacion del usuario
	echo o." Ingresa una direccion de Correo Electronico: ".f;
	$mail = trim(fgets(STDIN));
	echo o." Ingresa tu numero de Legajo: ".f;
	$legajo = trim(fgets(STDIN));
    echo o." Ingresa tu numero de DNI: ".f;
	$dni = trim(fgets(STDIN));
    echo o." Ingresa tu Nombre: ".f;
	$nombre = trim(fgets(STDIN));
    echo o." Ingresa tu Apellido: ".f;
	$apellido = trim(fgets(STDIN));
    $sePudoModificar = $abmIngresante->modificarIngresante($IngresanteActual, $mail, $legajo, $dni, $nombre, $apellido);
    if ($sePudoModificar == "OK"){
        echo ok." Tus datos fueron modificados con exito".f."\n";
        echo $IngresanteActual;
    }else{
        echo er."Error al modificar Ingresante: ".$sePudoModificar.f."\n";// $sePudoModificar es un error
    }
}

function eliminarIngresante(){
	$abmIngresante = new AbmIngresante();
    $IngresanteAEliminar = listaIngresantes();
    echo "Ha elegido ". $IngresanteAEliminar;// Muestro Ingresante para orientacion del usuario
    $sePudoEliminar = $abmIngresante->eliminarIngresante($IngresanteAEliminar);
    if ($sePudoEliminar == "OK"){
        echo ok." Ingresante ya no esta en el registro".f."\n";
    }else{
        echo er."Error al eliminar Ingresante: ".$sePudoEliminar.f."\n";
    }
}

function mostrarMenuIngresantes(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------- Ingresantes -------- ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - Login Ingresante \n";
		echo " 2 - Registro Nuevo Ingresante \n";
        echo " 3 - Ver.... \n";
		echo " 5 - Volver al menu principal \n";
		echo " 7 - Salir \n";
		$op = trim(fgets(STDIN));	
		if ($op==1){
			loginIngresante();	
		}		
		if ($op==2){
			registroIngresante();
        }
        if ($op==3){
			nada();
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