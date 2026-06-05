<?php
namespace PackageDelivery\Controllers;

use PackageDelivery\Models\Package;
use PackageDelivery\Repositories\EmployeeRepository;
use PackageDelivery\Repositories\PackageRepository;
use PackageDelivery\Schemas\HomeSearch;
use PackageDelivery\Schemas\PackageData;
use PackageDelivery\Services\PhotonAPI;
use PHPTools\Schemas\Validator;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PackageController extends BaseController {
    public function __construct(
        ResponseFactoryInterface $respFact,
        PhpRenderer $renderer,
        private PackageRepository $pkgRepo,
        private EmployeeRepository $emplRepo,
        private PhotonAPI $geoAPI
    ) {
        parent::__construct($respFact, $renderer);
    }

    public function showCreate(Request $req, Response $resp): Response {
        $search = new Validator(HomeSearch::class, $_GET)->tryParse();
        $employees = $this->emplRepo->searchAvailableDeliveryPersons($search->emplQuery);
        return $this->render("packageManager.phtml", [
            "errors" => [],
            "data" => new PackageData(),
            "editMode" => false,
            "search" => $search,
            "employees" => $employees
        ]);
    }

    public function create(Request $req, Response $resp): Response {
        $validator = new Validator(PackageData::class, $_POST);
        $search = new Validator(HomeSearch::class, $_GET)->tryParse();
        $employees = $this->emplRepo->searchAvailableDeliveryPersons($search->emplQuery);
        $data = $validator->tryParse();

        if (count($validator->errors) > 0)
            return $this->render("packageManager.phtml", [
                "errors" => $validator->errors,
                "data" => $data,
                "editMode" => false,
                "search" => $search,
                "employees" => $employees
            ]);

        $deliveryPerson = $this->emplRepo->selectById($data->deliveryPersonId);
        if ($deliveryPerson === null)
            return $this->render("packageManager.phtml", [
                "errors" => ["deliveryPersonId" => ["Delivery person not found"]],
                "data" => $data,
                "editMode" => false,
                "search" => $search,
                "employees" => $employees
            ]);

        $pkg = $data->apply(new Package());
        $pkg->creatorId = $_SESSION["user"]->id;
        $result = $this->geoAPI->search("{$data->recipientAddress} {$data->postalNumber}");
        $coordinates = $result["features"][0]["geometry"]["coordinates"] ?? null;

        if ($coordinates === null)
            return $this->render("packageManager.phtml", [
                "errors" => ["postalNumber" => ["Wrong address"]],
                "data" => $data,
                "editMode" => false
            ]);

        $pkg->addressLatitude = $coordinates[1];
        $pkg->addressLongitude = $coordinates[0];

        $this->pkgRepo->insert($pkg);
        return $this->redirect("/");
    }

    public function showEdit(Request $req, Response $resp, array $args): Response {
        $search = new Validator(HomeSearch::class, $_GET)->tryParse();
        $employees = $this->emplRepo->searchAvailableDeliveryPersons($search->emplQuery);
        $package = $this->pkgRepo->selectById((int)$args["id"]);

        if ($package == null)
            return $this->redirect("/");
        
        return $this->render("packageManager.phtml", [
            "errors" => [],
            "data" => PackageData::new($package),
            "editMode" => true,
            "search" => $search,
            "employees" => $employees
        ]);
    }


    public function edit(Request $req, Response $resp, array $args): Response {
        $pkg = $this->pkgRepo->selectById((int)$args["id"]);
        
        if ($pkg === null)
            return $this->redirect("/");

        $mode = $_POST["mode"] ?? null;
        if ($mode === null)
            return $this->redirect("/");

        if ($mode === "Delete") {
            $this->pkgRepo->delete($pkg);
            return $this->redirect("/");
        }

        $search = new Validator(HomeSearch::class, $_GET)->tryParse();
        $employees = $this->emplRepo->searchAvailableDeliveryPersons($search->emplQuery);
        $validator = new Validator(PackageData::class, $_POST);
        $data = $validator->tryParse();

        if (count($validator->errors) > 0)
            return $this->render("packageManager.phtml", [
                "errors" => $validator->errors,
                "data" => $data,
                "editMode" => false,
                "search" => $search,
                "employees" => $employees
            ]);

        $pkg = $data->apply($pkg);
        $deliveryPerson = $this->emplRepo->selectById($data->deliveryPersonId);

        if ($deliveryPerson === null)
            return $this->render("packageManager.phtml", [
                "errors" => ["deliveryPersonId" => ["Delivery person not found"]],
                "data" => $data,
                "editMode" => false,
                "search" => $search,
                "employees" => $employees
            ]);

        $result = $this->geoAPI->search("{$data->recipientAddress} {$data->postalNumber}");
        $coordinates = $result["features"][0]["geometry"]["coordinates"];
        $pkg->addressLatitude = $coordinates[1];
        $pkg->addressLongitude = $coordinates[0];

        $this->pkgRepo->update($pkg);
        return $this->redirect("/");
    }
}