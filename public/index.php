<?php
declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\SiteController;

$router = require dirname(__DIR__) . '/app/bootstrap.php';

$router->get('/', [SiteController::class, 'home']);
$router->post('/contact', [SiteController::class, 'contact']);
$router->get('/api/services', [SiteController::class, 'apiServices']);

$router->get('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/login', [AuthController::class, 'authenticate']);
$router->post('/admin/logout', [AuthController::class, 'logout']);
$router->get('/admin', [AdminController::class, 'dashboard']);

foreach (['services', 'projects', 'categories', 'testimonials', 'gallery', 'settings', 'messages'] as $resource) {
    $router->get('/admin/' . $resource, [AdminController::class, 'index']);
    if ($resource !== 'messages') {
        $router->post('/admin/' . $resource . '/store', [AdminController::class, 'store']);
        $router->post('/admin/' . $resource . '/update', [AdminController::class, 'update']);
        $router->post('/admin/' . $resource . '/delete', [AdminController::class, 'delete']);
    }
}

$router->dispatch();
