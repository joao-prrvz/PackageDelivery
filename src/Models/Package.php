<?php
namespace PackageDelivery\Models;

use DateTime;
use PackageDelivery\Enums\PackageStatus;
use PHPTools\ORM\Attributes as DB;


class Package {
    #[DB\Block]
    public int $id;
    public string $postalNumber;

    public string $recipientFirstName;
    public string $recipientLastName;
    public string $recipientAddress;
    public float $addressLatitude;
    public float $addressLongitude;

    #[DB\Block(DB\Block::INSERT)]
    public ?int $routeIndex;
    #[DB\Block(DB\Block::INSERT)]
    public PackageStatus $status;

    public int $creatorId;

    public int $deliveryPersonId;
    #[DB\Block(DB\Block::INSERT)]
    public ?int $deliveryRouteId;

    #[DB\Date("Y-m-d")]
    public DateTime $deliveryDate;
}