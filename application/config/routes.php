<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['auth/register'] = 'auth/register';
$route['auth/process_register'] = 'auth/process_register';
$route['auth/process_login'] = 'auth/process_login';
$route['auth/logout'] = 'auth/logout';
$route['auth/welcome'] = 'auth/welcome';
$route['repositorio'] = 'repositorio/index';
$route['repositorio/publico'] = 'repositorio/publico';
$route['repositorio/privado'] = 'repositorio/privado';
$route['repositorio/soporte'] = 'repositorio/soporte';
$route['repositorio/enviar_mensaje'] = 'repositorio/enviar_mensaje';
$route['repositorio/crear_curso'] = 'repositorio/crear_curso';
$route['repositorio/guardar_curso'] = 'repositorio/guardar_curso';
$route['repositorio/gestionar_documentos/(:num)'] = 'repositorio/gestionar_documentos/$1';
$route['repositorio/guardar_documento/(:num)'] = 'repositorio/guardar_documento/$1';
$route['soporte/mensajes'] = 'repositorio/ver_mensajes';
// Rutas de administración
$route['admin'] = 'admin/dashboard';
// Puedes definir más rutas de administración aquí
// Rutas para la API
$route['api/mensajes']['GET'] = 'api/mensajes_get';
$route['api/mensajes']['POST'] = 'api/mensajes_post';
$route['api/mensajes/(:num)']['PUT'] = 'api/mensajes_put/$1';
$route['api/mensajes/(:num)']['DELETE'] = 'api/mensajes_delete/$1';