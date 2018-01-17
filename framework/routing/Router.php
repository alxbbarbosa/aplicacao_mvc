<?php
namespace Framework\Routing;

use Exception;
use Framework\Routing\Route;
use Framework\Routing\RouteCollection;
use Framework\Routing\Dispatcher;
use Framework\Routing\Request;
use Framework\Core\SystemController;

/**
 * Classe Router - Roteadora:  responsável  por  receber  um
 * objeto de requisição (request), ler a Uri  encapsulada  e
 * procurar por uma rota em sua (Classe RouteCollection).
 * Encontrando uma Rota, encaminha para um objeto Dispatcher
 * tratá-la, expedindo conforme dados encapsulados.
 * 
 * @author Alexandre Bezerra Barbosa
 */
class Router
{

    /**
     * Recebe objeto de requisição (request) e com base nele
     * invoca um método para procurar e obter a rota na  Uri
     * encapsulada. Se encontrar, invoca o  método  dispatch
     * passando o objeto de rota como argumento.
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        try {
            $route = $this->findAnGetRoute($request);

            $this->dispatch($route);
            
        } catch (Exception $e) {

            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }

    /**
     * Obtém um objeto de Rota na Collection com base nos dados
     * encapsulados no objeto de requisição.
     * 
     * @param Request $request
     * @return Route
     */
    private function findAnGetRoute(Request $request): Route
    {
        $route = RouteCollection::get($request->getMethod(), $request->getUri());

        if (!is_null($route)) {
            return $route;
        } else {
            /*
             * Se não encontrar a rota, invoca o método index do 
             * controller SystemController que  apresentará  uma
             * página com erro 404.
             */
            $c = new SystemController();
            $c->index();
        }
    }

    /**
     * Recebe um objeto de rota e repassa para um objeto  Dispatcher
     * para despachar para uma action de um controller. Estas etapas
     * serão tratadas pelo objeto Despatcher
     * 
     * @param Route $route
     * @return type bool / Exception
     */
    private function dispatch(Route $route)
    {
        try {
            /**
             * Instanciar um Dispatcher passando um objeto de rota como
             * argumento.
             */
            $dispatcher = new Dispatcher($route);

            // Dispatcher retornará True ou false
            return $dispatcher->dispatch();
        } catch (Exception $e) {

            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }
}
