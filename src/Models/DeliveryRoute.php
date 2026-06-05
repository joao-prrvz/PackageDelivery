<?php
namespace PackageDelivery\Models;

use DateTime;
use PHPTools\ORM\Attributes as DB;

class DeliveryRoute {
    #[DB\Block]
    public int $id;
    #[DB\Date("Y-m-d")]
    public DateTime $dateDelivery;
    public int $creatorId;

    public static function new(int $creatorId, DateTime $dateDelivery): DeliveryRoute {
        $route = new DeliveryRoute;
        $route->creatorId = $creatorId;
        $route->dateDelivery = $dateDelivery;
        return $route;
    }
}