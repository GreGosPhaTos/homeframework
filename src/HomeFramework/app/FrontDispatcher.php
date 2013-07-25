<?php
namespace HomeFramework\app;

use \HomeFramework\controller\BackController,
    \HomeFramework\container\IContainer;

class FrontDispatcher {

    /**
     * Dispath the route and returns the controller
     *
     * @param \HomeFramework\container\IContainer $container
     * @return void
     */
    static public function dispatch(IContainer $container) {
        try {
            $appName = $container
                ->get('defaultConfiguration')
                ->get('applicationName');

            $router  = $container->get('Router');
            $route   = $router->getRoute();
            $module  = $route->getModule();
            $action  = $route->getAction();
            $vars    = $route->getVars();

            // @todo fix it modules folder ??
            $controllerClass = '\\'.$appName.'\\modules\\'.$module.'\\controller\\'.ucfirst($module).'Controller';
            $controller = new $controllerClass($container, $module, $action, $vars);
            if (!$controller instanceof BackController) {
                throw new \Exception("Controller must be an BackController Object.");
            }

            $controller->execute();
        } catch (\Exception $e) {
            $container
                ->get('logger')
                ->warn("FrontDispatcher ".$e->getMessage());
            $HTTPResponse = $container->get('HTTPResponse');
            $HTTPResponse->setBody("Not Found");
            $HTTPResponse->setBody($e->getMessage());
            $HTTPResponse->setStatusCode(404);
            $HTTPResponse->send();
            return;
        }
    }
}