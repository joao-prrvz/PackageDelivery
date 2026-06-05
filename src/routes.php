<?php

use PackageDelivery\Controllers\DeliveryRouteController;
use PackageDelivery\Controllers\EmployeeController;
use PackageDelivery\Controllers\PackageController;
use PackageDelivery\Middlewares\Auth;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as RouteCollectorProxy;

return (function(App $app) {
    $app->group("", function(RouteCollectorProxy $group) {
        $group->get("/", [EmployeeController::class, "showHome"]);
        $group->post("/logout", [EmployeeController::class, "logout"]);

        $group->get("/package", [PackageController::class, "showCreate"]);
        $group->post("/package", [PackageController::class, "create"]);
        $group->get("/package/{id}", [PackageController::class, "showEdit"]);
        $group->post("/package/{id}", [PackageController::class, "edit"]);

        $group->post("/route", [DeliveryRouteController::class, "create"]);
    })->add(Auth::class);

    $app->get("/login", [EmployeeController::class, "showLogin"]);
    $app->post("/login", [EmployeeController::class, "login"]);
});