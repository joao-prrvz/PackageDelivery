<?php
namespace PackageDelivery\Schemas;

use PHPTools\Schemas\Attributes as SA;

class CreateRoute {
    /** @var PackageRoute[] */
    #[SA\ArrayType([PackageRoute::class])]
    public array $packages = [];
}