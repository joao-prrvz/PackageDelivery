<?php
namespace PackageDelivery\Models;

use PHPTools\ORM\Attributes as DB;

class Employee {
    #[DB\Block]
    public int $id;
    public string $lastName;
    public string $firstName;
    public string $email;
    public string $password;
    #[DB\Block]
    public bool $isDeliveryPerson;
}