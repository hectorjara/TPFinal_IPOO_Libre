<?php
include_once 'Test_Actividad.php';
include_once 'Test_Modulo.php';
include_once  'Test_Inscripcion.php';
include_once 'Test_MenuIngresantes.php';
include_once '../Control/Borrar.php';

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
		echo " 3 - ABM Inscripcion \n";
		echo " 4 - Menu Ingresantes \n";
		echo " 5 - Llenar Datos por defecto \n"; 
		echo " 6 - Limpiar la Base de Datos \n";
		echo " 8 - Salir \n";
		$op = trim(fgets(STDIN));
		
		if ($op==1){
			mostrarAbmActividad();	
		}

		if ($op==2){
			mostrarAbmModulo();
		}	
		
		if ($op==3){
			mostrarAbmInscripcion();
		}

		if ($op==4){
			mostrarMenuIngresantes();
		}
		if ($op==5){
			llenarDatos();
		}
		if ($op==6){
			borrarBD();
		}
		if ($op==8){
			exit;
		}
		echo o." Desea realizar otra operacion? S/s ".f."\n";
		$sigue = trim(fgets(STDIN));				
	}		
}

function llenarDatos(){
	$abmActividad = new AbmActividad();
	$obj_Picnic = $abmActividad->insertaActividad("Picnic","Salida de Picnic");
	$obj_Caminata = $abmActividad->insertaActividad("Caminata","Caminata a la Barda");
	$obj_Museo = $abmActividad->insertaActividad("Museo","Visita al Museo");

	$abmModulo = new AbmModulo();//($descripcion,$tope_inscripcion, $costo, $fechaInicio, $fechaFin, $horaInicio, $horaCierre, $obj_Actividad, $enLinea, $link, $bonificacion)
	$picnicModuloTemprano = $abmModulo->insertaModulo("Picnic matutino",20, 250, "2023-04-01", "2023-04-01", "09:00", "11:00", $obj_Picnic, false, null, null);
	$picnicModuloTarde = $abmModulo->insertaModulo("Picnic Tarde",20, 350, "2023-04-01", "2023-04-01", "19:00", "21:00", $obj_Picnic, false, null, null);
	$caminataTemprano = $abmModulo->insertaModulo("Caminata Temprano",12, 550, "2023-04-08", "2023-04-08", "07:00", "10:30", $obj_Caminata, false, null, null);
	$museoTarde = $abmModulo->insertaModulo("Tarde de Museo",15, 1200, "2023-04-07", "2023-04-07", "16:00", "18:30", $obj_Museo, false, null, null);
	$museoOnLineCuadros = $abmModulo->insertaModulo("Museo en linea Cuadros",50, 1200, "2023-04-03", "2023-04-07", "00:00", "23:59", $obj_Museo, true, "museocuadros@museo", 50);
	$museoOnLineHistoria = $abmModulo->insertaModulo("Museo en linea Historia",50, 1200, "2023-04-03", "2023-04-07", "00:00", "23:59", $obj_Museo, true, "museohistoria@museo", 50);

	$abmIngresante = new AbmIngresante();//($mail, $legajo, $dni, $nombre, $apellido);
	$juan = $abmIngresante->insertaIngresante("JuanGarcia@correo.com", 15200, 13123456, "Juan", "Garcia");
	$miguel = $abmIngresante->insertaIngresante("miguelGonzales@correo.com", 32432, 2342423, "Miguel", "Gonzales");
}

function borrarBD(){
	$borra = new Borrar();
	$borra->eliminarInscripcionModulo();
	$borra->eliminarInscripcion();
	$borra->eliminarIngresante();
	$borra->eliminarModuloEnLinea();
	$borra->EliminarModulo();
	$borra->eliminaractividad();
}


mostrarMenu();
?>