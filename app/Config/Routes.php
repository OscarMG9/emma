<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 * $routes->get('nombreRuta', 'Controlador::funcion' , ['as' => 'indentificador']);
 * 
 * $routes->post('nombreRuta', 'Controlador::funcion' , ['as' => 'indentificador']);
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('cheetos', 'Home::ejemplo');

//login
$routes->get('acceso', 'Usuario\Login::index',['as'=> 'acceso']);
$routes->get('salir', 'Usuario\Logout::index',['as'=> 'salir']);
$routes->post('validar_usuario','Usuario\Login::validar',['as'=> 'validar_usuario']);

//administracion
$routes->get('administracion_dashboard', 'Panel\Dashboard::index',['as'=> 'administracion_dashboard']);
$routes->get('administracion_usuarios', 'Panel\Usuario\Usuarios::index',['as'=> 'administracion_usuarios']);
$routes->get('administracion_materias', 'Panel\Materia\Materias::index',['as'=> 'administracion_materias']);
$routes->get('administracion_periodos', 'Panel\Periodo\Periodos::index',['as'=> 'administracion_periodos']);
$routes->get('administracion_docentes', 'Panel\Docente\Docentes::index',['as'=> 'administracion_docentes']);
$routes->get('administracion_asignacionmats', 'Panel\AsigMat\AsigMats::index',['as'=> 'administracion_asignacionmats']);
$routes->get('administracion_asignacionalums', 'Panel\AsigAlum\AsigAlums::index',['as'=> 'administracion_asignacionalums']);

//operador
$routes->get('operador_porcentajes', 'Panel\Porcentaje\Porcentajes::index',['as'=> 'operador_porcentajes']);
$routes->get('operador_calificacion', 'Panel\Calificacion\Calificaciones::index',['as'=> 'operador_calificacion']);
$routes->get('operador_alumnos', 'Panel\Alumno\Alumnos::index',['as'=> 'operador_alumnos']);
$routes->get('operador_asistencias', 'Panel\Asistencia\Asistencias::index',['as'=> 'operador_asistencias']);

//usuarios
$routes->get('nuevo_usuario', 'Panel\Usuario\Nuevo_usuario::index',['as'=> 'nuevo_usuario']);
$routes->post('registrar_usuario', 'Panel\Usuario\Nuevo_usuario::registrar',['as'=> 'registrar_usuario']);
$routes->get('detalles_usuario/(:num)', 'Panel\Usuario\Detalles_usuario::index/$1',['as'=> 'detalles_usuario']);
$routes->post('actualizar_usuario/(:num)', 'Panel\Usuario\Detalles_usuario::actualizar/$1',['as'=> 'actualizar_usuario']);
$routes->get('eliminar_usuario/(:num)', 'Panel\Usuario\Nuevo_usuario::eliminar/$1',['as'=> 'eliminar_usuario']);

//Materias
$routes->get('nuevo_materia', 'Panel\Materia\Nuevo_materia::index',['as'=> 'nuevo_materia']);
$routes->post('registrar_materia', 'Panel\Materia\Nuevo_materia::registrar',['as'=> 'registrar_materia']);
$routes->get('detalles_materia/(:num)', 'Panel\Materia\Detalles_materia::index/$1',['as'=> 'detalles_materia']);
$routes->post('actualizar_materia/(:num)', 'Panel\Materia\Detalles_materia::actualizar/$1',['as'=> 'actualizar_materia']);
$routes->get('eliminar_materia/(:num)', 'Panel\Materia\Nuevo_materia::eliminar/$1',['as'=> 'eliminar_materia']);

//Periodos
$routes->get('nuevo_periodo', 'Panel\Periodo\Nuevo_periodo::index',['as'=> 'nuevo_periodo']);
$routes->post('registrar_periodo', 'Panel\Periodo\Nuevo_periodo::registrar',['as'=> 'registrar_periodo']);
$routes->get('detalles_periodo/(:num)', 'Panel\Periodo\Detalles_periodo::index/$1',['as'=> 'detalles_periodo']);
$routes->post('actualizar_periodo/(:num)', 'Panel\Periodo\Detalles_periodo::actualizar/$1',['as'=> 'actualizar_periodo']);
$routes->get('eliminar_periodo/(:num)', 'Panel\Periodo\Nuevo_periodo::eliminar/$1',['as'=> 'eliminar_periodo']);
$routes->get('estatus_periodo/(:num)/(:num)', 'Panel\Periodo\Periodos::estatus/$1/$2',['as'=> 'estatus_periodo']);

//Docentes
$routes->get('nuevo_docente', 'Panel\Docente\Nuevo_docente::index',['as'=> 'nuevo_docente']);
$routes->post('registrar_docente', 'Panel\Docente\Nuevo_docente::registrar',['as'=> 'registrar_docente']);
$routes->get('detalles_docente/(:num)', 'Panel\Docente\Detalles_docente::index/$1',['as'=> 'detalles_docente']);
$routes->post('actualizar_docente/(:num)', 'Panel\Docente\Detalles_docente::actualizar/$1',['as'=> 'actualizar_docente']);
$routes->get('eliminar_docente/(:num)', 'Panel\Docente\Nuevo_docente::eliminar/$1',['as'=> 'eliminar_docente']);

//Asignación de materias
$routes->get('nuevo_asigmat', 'Panel\AsigMat\Nuevo_asigmat::index',['as'=> 'nuevo_asigmat']);
$routes->post('registrar_asigmat', 'Panel\AsigMat\Nuevo_asigmat::registrar',['as'=> 'registrar_asigmat']);
$routes->get('detalles_asigmat/(:num)', 'Panel\AsigMat\Detalles_asigmat::index/$1',['as'=> 'detalles_asigmat']);
$routes->post('actualizar_asigmat/(:num)', 'Panel\AsigMat\Detalles_asigmat::actualizar/$1',['as'=> 'actualizar_asigmat']);
$routes->get('eliminar_asigmat/(:num)', 'Panel\AsigMat\Nuevo_asigmat::eliminar/$1',['as'=> 'eliminar_asigmat']);

//Asignación de alumnos
$routes->get('nuevo_asigalum', 'Panel\AsigAlum\Nuevo_asigalum::index',['as'=> 'nuevo_asigalum']);
$routes->get('nuevo_alumno', 'Panel\AsigAlum\Nuevo_alumno::index',['as'=> 'nuevo_alumno']);
$routes->post('registrar_alumno', 'Panel\AsigAlum\Nuevo_alumno::registrar',['as'=> 'registrar_alumno']);
$routes->post('registrar_asigalum', 'Panel\AsigAlum\Nuevo_asigalum::registrar',['as'=> 'registrar_asigalum']);
$routes->get('detalles_asigalum/(:num)', 'Panel\AsigAlum\Detalles_asigalum::index/$1',['as'=> 'detalles_asigalum']);
$routes->post('actualizar_asigalum/(:num)', 'Panel\AsigAlum\Detalles_asigalum::actualizar/$1',['as'=> 'actualizar_asigalum']);
$routes->get('eliminar_asigalum/(:num)', 'Panel\AsigAlum\Nuevo_asigalum::eliminar/$1',['as'=> 'eliminar_asigalum']);

//Asignación de porcentajes
$routes->get('detalles_porcentaje/(:num)', 'Panel\Porcentaje\Detalles_porcentaje::index/$1',['as'=> 'detalles_porcentaje']);
$routes->post('actualizar_porcentaje/(:num)', 'Panel\Porcentaje\Detalles_porcentaje::actualizar/$1',['as'=> 'actualizar_porcentaje']);

//Lista alumnos
$routes->get('detalles_alumno/(:num)', 'Panel\Alumno\Detalles_alumno::index/$1',['as'=> 'detalles_alumno']);
$routes->post('actualizar_alumno/(:num)', 'Panel\Alumno\Detalles_alumno::actualizar/$1',['as'=> 'actualizar_alumno']);

//Lista calificacion
$routes->get('detalles_calificacion/(:num)', 'Panel\Calificacion\Detalles_calificacion::index/$1',['as'=> 'detalles_calificacion']);
$routes->post('actualizar_calificacion/(:num)', 'Panel\Calificacion\Detalles_calificacion::actualizar/$1',['as'=> 'actualizar_calificacion']);

//asistencia
$routes->get('detalles_asistencia/(:num)', 'Panel\Asistencia\Detalles_asistencia::index/$1',['as'=> 'detalles_asistencia']);
$routes->post('actualizar_asistencia/(:num)', 'Panel\Asistencia\Detalles_asistencia::actualizar/$1',['as'=> 'actualizar_asistencia']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
