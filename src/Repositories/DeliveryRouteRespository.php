<?php
namespace PackageDelivery\Repositories;

use DateTime;
use PackageDelivery\Models\DeliveryRoute;
use PackageDelivery\Models\Employee;
use PackageDelivery\Services\PackageDB;

class DeliveryRouteRespository {
    public function __construct(private PackageDB $ctx)
    { }

    public function insert(DeliveryRoute $route): int {
        $this->ctx->deliveryRoutes->add($route);
        return $this->ctx->db->lastInsertId();
    }

    public function selectById(int $id): DeliveryRoute {
        return $this->ctx->deliveryRoutes
            ->where(fn($d) => $d->id == $id)->first();
    }
}