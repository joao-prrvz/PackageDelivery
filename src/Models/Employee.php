<?php
namespace PackageDelivery\Models;

use PHPTools\ORM\Attributes as DB;

#[DB\Table("Employe")]
class Employee {
    #[DB\Block]
    public int $id;
    #[DB\Column("nom")]
    public string $lastName;
    #[DB\Column("prenom")]
    public string $firstName;
    #[DB\Column("email")]
    public string $email;
    #[DB\Column("motDePasse")]
    public string $password;
    #[DB\Column("estLivreur"), DB\Block]
    public bool $isDeliveryPerson;
}
