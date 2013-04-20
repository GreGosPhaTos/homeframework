<?php
namespace HomeFramework\app;

class FrontDispatcher {

    /**
     * Dispath the route and returns the controller
     *
     * @param Application $app
     * @return mixed
     */
    static public function dispatch(\HomeFramework\app\Application $app) {
        $container = $app->getContainer();
        $router = $container->get('Router');
        try {
            $route = $router->getRoute();
            $controllerClass = 'apps\\'.$app->name().'\\Modules\\'.$route->module().'\\'.$route->module().'Controller';
            return new $controllerClass($route->module(), $router->action());
        } catch (\Exception $e) {
            // @todo implementer un service de log
            $container->get('HTTPResponse')
                ->setResponseCode(404);
            return null;
        }
    }
}