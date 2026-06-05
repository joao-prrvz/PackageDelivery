<?php
namespace PackageDelivery\Services;

use PackageDelivery\Models\DeliveryRoute;
use PackageDelivery\Models\Employee;
use PackageDelivery\Models\Package;
use PHPTools\ORM\DBCollection;
use PHPTools\ORM\DBContext;

class PackageDB extends DBContext {
    /** @var DBCollection<Employee> */
    public DBCollection $employees;
    /** @var DBCollection<Package> */
    public DBCollection $packages;
    /** @var DBCollection<DeliveryRoute> */
    public DBCollection $deliveryRoutes;


    public function __construct(string $dsn, string $username, string $password) {
        parent::__construct($dsn, $username, $password);
        $this->employees = new DBCollection(Employee::class, $this);
        $this->packages = new DBCollection(Package::class, $this);
        $this->deliveryRoutes = new DBCollection(DeliveryRoute::class, $this);
    }
}