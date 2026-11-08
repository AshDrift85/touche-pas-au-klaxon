<?php

use Buki\Router\Router;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router([
    'paths' => ['controllers' => __DIR__ . '/../App/Controller'],
    'namespaces' => ['controllers' => 'App\Controller'],
]);

// Une ligne par page : adresse => Contrôleur@méthode
$router->get('/', 'TripController@home');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@check');
$router->get('/logout', 'AuthController@logout');

$router->get('/trips/create', 'TripController@create');
$router->post('/trips/create', 'TripController@store');
$router->get('/trips/:id/edit', 'TripController@edit');
$router->post('/trips/:id/edit', 'TripController@update');
$router->post('/trips/:id/delete', 'TripController@delete');

$router->get('/admin', 'AdminController@index');
$router->post('/admin/agencies/save', 'AdminController@saveAgency');
$router->post('/admin/agencies/delete', 'AdminController@deleteAgency');
$router->post('/admin/trips/delete', 'AdminController@deleteTrip');

$router->run();
