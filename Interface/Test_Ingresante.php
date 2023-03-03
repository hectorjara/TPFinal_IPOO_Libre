<?php
include_once 'Test_Actividad.php';
include_once 'Test_Modulo.php';

const t = "\033[43m";//Color Titulo
const f = "\33[0m";  //Fin Color
const d = "\033[90m";//Color Deshabilitado
const n = "\033[39m";//Color Normal
const o = "\033[36m";//Color Opcion
const ok = "\033[32m";//Color Ok
const er = "\033[31m";//Color Error

function mostrarMenu(){
	$sigue = "s";
	While ($sigue=="S" || $sigue=="s" ){
		echo t." ------ Menu Principal ------ ".f."\n";
		echo o." Eliga una opcion: ".f."\n";
		echo " 1 - ABM Actividad \n";
		echo " 2 - ABM Modulo  \n";
		echo " 3 - ABM Inscripciones \n";
		echo " 4 - ............... \n";
		echo " 5 - Llenar Datos por defecto \n"; 
		echo " 6 - Limpiar la Base de Datos \n";
		echo " 7 - Salir \n";
		$op = trim(fgets(STDIN));
		
		if ($op==1){
			mostrarAbmActividad();	
		}

		if ($op==2){
			mostrarAbmModulo();
		}	
		
		if ($op==3){
			mostrarAbmInscripciones();
		}

		if ($op==4){
			nada();
		}
		if ($op==5){
			llenarDatos();
		}
		if ($op==6){
			borrarBD();
		}
		if ($op==7){
			exit;
		}
		echo o." Desea realizar otra operacion? S/s ".f."\n";
		$sigue = trim(fgets(STDIN));				
	}		
}

mostrarMenu();
?>