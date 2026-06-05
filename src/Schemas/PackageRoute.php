<?php
namespace PackageDelivery\Schemas;

use PackageDelivery\Models\Package;
use PHPTools\Schemas\Attributes as SA;

class PackageRoute {
    #[SA\Required, SA\Validates\Min(1)]
    public int $id;
    #[SA\Required, SA\Validates\Min(0), SA\Validates\Max(9)]
    public int $routeIndex;

    public function apply(Package $package): Package {
        $pkg = clone $package;
        $pkg->routeIndex = $this->routeIndex;
        return $pkg;
    }
}