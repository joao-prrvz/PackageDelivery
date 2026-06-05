<?php
namespace PackageDelivery\Models;

use DateTime;
use PHPTools\ORM\Attributes as DB;

#[DB\Table("RouteLivraison")]
class DeliveryRoute {
    #[DB\Block]
    public int $id;
    #[DB\Column("dateRoute"), DB\Date("Y-m-d")]
    public DateTime $dateDelivery;
    #[DB\Column("createurId")]
    public int $creatorId;

    public static function new(int $creatorId, DateTime $dateDelivery): DeliveryRoute {
        $route = new DeliveryRoute;
        $route->creatorId = $creatorId;
        $route->dateDelivery = $dateDelivery;
        return $route;
    }
}