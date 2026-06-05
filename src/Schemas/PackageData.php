<?php
namespace PackageDelivery\Schemas;

use DateTime;
use PackageDelivery\Models\Package;
use PHPTools\Schemas\Attributes as SA;

class PackageData {
    #[SA\Required, SA\Sanitize, SA\Validates\LengthMin(3)]
    public string $recipientFirstName = "";
    #[SA\Required, SA\Sanitize, SA\Validates\LengthMin(3)]
    public string $recipientLastName = "";
    #[SA\Required, SA\Validates\LengthMin(1)]
    public string $recipientAddress = "";
    #[SA\Required, SA\Validates\LengthMin(1)]
    public string $postalNumber = "";
    #[SA\Required]
    public int $deliveryPersonId = 0;
    #[SA\Required, SA\Validates\Date("Y-m-d")]
    public DateTime $deliveryDate;

    public function __construct() {
        $this->deliveryDate = new DateTime();
    }

    public static function new(Package $pkg): PackageData {
        $data = new PackageData();
        $data->postalNumber = $pkg->postalNumber;
        $data->recipientFirstName = $pkg->recipientFirstName;
        $data->recipientLastName = $pkg->recipientLastName;
        $data->recipientAddress = $pkg->recipientAddress;
        $data->deliveryPersonId = $pkg->deliveryPersonId;
        $data->deliveryDate = $pkg->deliveryDate;
        return $data;
    }

    public function apply(Package $pkg): Package {
        $updatedPkg = clone $pkg;
        $updatedPkg->postalNumber = $this->postalNumber;
        $updatedPkg->recipientFirstName = $this->recipientFirstName;
        $updatedPkg->recipientLastName = $this->recipientLastName;
        $updatedPkg->recipientAddress = $this->recipientAddress;
        $updatedPkg->deliveryPersonId = $this->deliveryPersonId;
        $updatedPkg->deliveryDate = $this->deliveryDate;
        return $updatedPkg;
    }
}