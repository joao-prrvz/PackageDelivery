<?php
namespace PackageDelivery\Controllers;

use DateTime;
use Override;
use PackageDelivery\Models\DeliveryRoute;
use PackageDelivery\Repositories\DeliveryRouteRespository;
use PackageDelivery\Repositories\PackageRepository;
use PackageDelivery\Schemas\CreateRoute;
use PHPTools\Schemas\Validator;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class DeliveryRouteController extends BaseController {

    public function __construct(
        ResponseFactoryInterface $respFact,
        PhpRenderer $renderer,
        private DeliveryRouteRespository $delRouteRep,
        private PackageRepository $pkgRep,
    ) {
        parent::__construct($respFact, $renderer);
    }

    public function create(Request $req, Response $resp): Response {
        $body = $this->getBody($req);
        $validator = new Validator(CreateRoute::class, $body);
        $data = $validator->tryParse();
        if (count($validator->errors) > 0)
            return $this->sendErrors($validator->errors);
        $route = DeliveryRoute::new($_SESSION["user"]->id, new DateTime());
        $id = $this->delRouteRep->insert($route);
        foreach ($data->packages as $pkgRoute) {
            $pkg = $pkgRoute->apply($this->pkgRep->selectById($pkgRoute->id));
            $pkg->deliveryRouteId = $id;
            $this->pkgRep->update($pkg);
        }
        return $resp;
    }
}