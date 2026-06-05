<?php
namespace PackageDelivery\Schemas;

use PHPTools\Schemas\Attributes as SA;

class HomeSearch {
    #[SA\Sanitize]
    public string $emplQuery = "";
    #[SA\Sanitize]
    public string $pkgQuery = "";
}