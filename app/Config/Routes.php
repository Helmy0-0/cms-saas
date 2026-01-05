<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
*/
// $routes->get('/', 'Home::index');

// Public Route
$routes->get('/', 'PublicArticleController::index');
$routes->get('articles', 'PublicArticleController::index');
$routes->get('articles/(:segment)', 'PublicArticleController::show/$1');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attempt');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');

    $routes->group('articles', ['filter' => 'auth'], function ($routes) {
        $routes->post('create', 'ArticleController::store');
        $routes->post('submit/(:num)', 'ArticleController::submit/$1');
    });

    $routes->group('', ['filter' => 'role:admin,editor'], function ($routes) {
        $routes->post('approve/(:num)', 'ArticleController::approve/$1');
        $routes->post('reject/(:num)', 'ArticleController::reject/$1');
    });
});

// test api
$routes->group('api', function($routes) {
    $routes->get('articles', 'Api\ArticleApiController::index');
    $routes->get('articles/(:segment)', 'Api\ArticleApiController::show/$1');
});
