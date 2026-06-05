<?php
namespace PackageDelivery\Models;

use DateTime;
use PackageDelivery\Enums\PackageStatus;
use PHPTools\ORM\Attributes as DB;

#[DB\Table("Paquet")]
class Package {
    #[DB\Block]
    public int $id;

    #[DB\Column("numeroPostal")]
    public string $postalNumber;

    #[DB\Column("prenomDestinataire")]
    public string $recipientFirstName;

    #[DB\Column("nomDestinataire")]
    public string $recipientLastName;

    #[DB\Column("adresseDestinataire")]
    public string $recipientAddress;

    #[DB\Column("latitudeAdresse")]
    public float $addressLatitude;

    #[DB\Column("longitudeAdresse")]
    public float $addressLongitude;

    #[DB\Column("ordreRouteLivraison"), DB\Block(DB\Block::INSERT)]
    public ?int $routeIndex;

    #[DB\Column("statutLivraison"), DB\Block(DB\Block::INSERT)]
    public PackageStatus $status;

    #[DB\Column("createurId")]
    public int $creatorId;

    #[DB\Column("livreurId")]
    public int $deliveryPersonId;

    #[DB\Column("routeLivraisonId"), DB\Block(DB\Block::INSERT)]
    public ?int $deliveryRouteId;

    #[DB\Column("dateLivraison"), DB\Date("Y-m-d")]
    public DateTime $deliveryDate;
}
