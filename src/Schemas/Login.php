<?php
namespace PackageDelivery\Schemas;

use PHPTools\Schemas\Attributes\Validates\Filters;
use PHPTools\Schemas\Attributes as SA;

class Login {
    #[Filters\Email]
    public string $email = "";
    #[SA\Validates\LengthMin(5)]
    public string $password = "";

    public static function new(string $email, string $password): Login {
        $login = new Login();
        $login->email = $email;
        $login->password = $password;
        return $login;
    } 
}