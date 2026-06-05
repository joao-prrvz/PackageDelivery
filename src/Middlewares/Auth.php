<?php
namespace PackageDelivery\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;

use PackageDelivery\Enums\HTTPStatus;


class Auth implements MiddlewareInterface {

    public function __construct(private ResponseFactory $respFact) { }

    public function process(Request $request, RequestHandler $handler): Response {
        if (!isset($_SESSION["user"])) {
            return $this->respFact
                ->createResponse(HTTPStatus::MOVED_PERMANENTLY->value)
                ->withHeader("Location", "/login");
        }
        $response = $handler->handle($request);
        return $response;
    }
}