<?php
namespace PackageDelivery\Controllers;

use DateTime;
use PackageDelivery\Models\Employee;
use PackageDelivery\Models\Package;
use Psr\Http\Message\ResponseFactoryInterface;
use PackageDelivery\Repositories\EmployeeRepository;
use PackageDelivery\Repositories\PackageRepository;
use PackageDelivery\Schemas\HomeSearch;
use PackageDelivery\Schemas\Login;
use PHPTools\Core\Collection;
use PHPTools\Schemas\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class EmployeeController extends BaseController {
    
    public function __construct(
        ResponseFactoryInterface $respFact,
        PhpRenderer $renderer,
        private EmployeeRepository $emplRepo,
        private PackageRepository $pkgRepo,
    ) {
        parent::__construct($respFact, $renderer);
    }

    public function showHome(Request $req, Response $resp): Response {
        /** @var Employee */    
        $user = $_SESSION["user"];
        if ($user->isDeliveryPerson)
            return $this->showDeliveryHome();
        return $this->showAdminHome();
    }

    private function showAdminHome(): Response {
        $search = new Validator(HomeSearch::class, $_GET)->tryParse(); 
        $employees = $this->emplRepo->searchAvailableDeliveryPersons($search->emplQuery);
        $packages = $this->pkgRepo->search($search->pkgQuery);
        return $this->render("adminHome.phtml", [
            "employees" => $employees,
            "packages" => $packages,
            "search" => $search
        ]);
    }

    private function showDeliveryHome(): Response {
        $date = $_GET["date"] ?? "";
        $date = DateTime::createFromFormat("Y-m-d", $date) ?: new DateTime();
        $packages = $this->pkgRepo->selectByDeliveryPersonAndDate($_SESSION["user"], $date);
        $infos = new Collection(Package::class);
        $infos->add(... $packages);
        $infos = $infos->select(fn($p) => [
            "id" => $p->id,
            "latitude" => $p->addressLatitude,
            "longitude" => $p->addressLongitude,
            "routeIndex" => $p->routeIndex,
            "status" => $p->status,
        ])->toArray();
        return $this->render("deliveryHome.phtml", [
            "packages" => $packages,
            "date" => $date,
            "infos" => $infos
        ]);
    }

    public function showLogin(Request $req, Response $resp): Response {
        return $this->render("login.phtml", [
            "errors" => [],
            "data" => new Login()
        ]);
    }

    public function login(Request $req, Response $resp): Response {
        $validator = new Validator(Login::class, $_POST);
        $login = $validator->tryParse();
        if (count($validator->errors) > 0)
            return $this->render("login.phtml", [
                "errors" => $validator->errors,
                "data" => $login
            ]);

        $employee = $this->emplRepo->selectByEmail($login->email);
        if ($employee === null)
            return $this->render("login.phtml", [
                "errors" => ["email" => ["User not found"]],
                "data" => $login
            ]);
        if (!password_verify($login->password, $employee->password))
            return $this->render("login.phtml", [
                "errors" => ["password" => ["Wrong password"]],
                "data" => $login
            ]);
        $_SESSION["user"] = $employee;
        return $this->redirect("/");
    }

    public function logout(): Response {
        unset($_SESSION["user"]);
        return $this->redirect("/");
    }
}