<?php
namespace HomeFramework\app;

use \HomeFramework\controller\BackController;

class FrontDispatcher {

    /**
     * Dispath the route and returns the controller
     *
     * @param Application $app
     * @return mixed
     *
     */
    static public function dispatch(\HomeFramework\app\Application $app) {
        $container = $app->getContainer();

        try {
            $router = $container->get('Router');
            $route  = $router->getRoute();
            $module = $route->getModule();
            $action = $route->getAction();
            $vars   = $route->getVars();

            // @todo fix it modules folder ??
            $controllerClass = '\\'.$app->getName().'\\modules\\'.$module.'\\controller\\'.ucfirst($module).'Controller';
            $controller = new $controllerClass($container, $module, $action, $vars);
            if (!$controller instanceof BackController) {
                throw new \Exception("Controller must be an BackController Object.");
            }

            $controller->execute();
        } catch (\Exception $e) {
            // @todo implementer un service de log
            $HTTPResponse = $container->get('HTTPResponse');
            $HTTPResponse->setBody("Not Found");
            $HTTPResponse->setBody($e->getMessage());
            $HTTPResponse->setStatusCode(404);
            $HTTPResponse->send();
            return null;
        }
    }
}